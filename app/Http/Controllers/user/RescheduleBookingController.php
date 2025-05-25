<?php

namespace App\Http\Controllers\user;

use App\Models\{Booking, Offering, User, Wallet, Reschedule};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


class RescheduleBookingController extends Controller
{


    public function showRescheduleForm($bookingId)
    {
        $user = auth()->user();
        $booking = Booking::with(['offering'])->findOrFail($bookingId);

        // Combine booking date and time slot to get full datetime of event
        $bookingDateTime = Carbon::parse($booking->booking_date . ' ' . $booking->time_slot);
        $offering = Offering::where('id', $booking->offering_id)->first();

        $beforeCanceledValue = 0;
        $beforeCanceled = 0;
        if ($offering->offering_event_type === 'offering' && $offering->is_cancelled) {
            $beforeCanceled = $offering->cancellation_time_slot;
        } elseif ($offering->offering_event_type === 'event' && $offering->event?->is_cancelled) {
            $beforeCanceled = $offering->event->cancellation_time_slot;
        }

        if ($beforeCanceled) {
            preg_match('/\d+/', $beforeCanceled, $matches);
            $beforeCanceledValue = isset($matches[0]) ? (int) $matches[0] : null;
        }

        // Calculate cutoff datetime example (48 hours before the event)
        $cutoff = $bookingDateTime->copy()->subHours($beforeCanceledValue);

        // Current time
        $now = Carbon::now();

        if ($now->greaterThanOrEqualTo($cutoff)) {
            return redirect()->back()->with('error', 'You can only reschedule more than '.$beforeCanceledValue.' hours before the event.');
        }

        $offering = $booking->offering;
        $practitioner = User::where('id', $offering->user_id)->first();
        $userDetail = $practitioner?->userDetail;

        // Optional store availability
        $storeAvailable = $userDetail?->store_availabilities ? $userDetail->store_availabilities : null;

        // Event type for handling all-day/event bookings
        $offeringEventType = $offering?->event_type ?? 'booking';

        // Pricing
        $price = $booking->total_amount;
        $currency = $booking->currency ?? 'USD';
        $currencySymbol = $booking->currency_symbol ?? '$';

        // Timezone fallback
        $timezone = $userDetail?->timezone ?? 'UTC';
        return view('user.reschedule',[
            'storeAvailable' => $storeAvailable,
            'booking' => $booking,
            'user' => $user,
            'offering' => $offering,
            'offeringEventType' => $offeringEventType,
            'price' => $price,
            'currency' => $currency,
            'currencySymbol' => $currencySymbol,
            'timezone' => $timezone,
        ]);
    }


    public function handleReschedule(Request $request, $bookingId)
    {
        $request->validate([
            'new_date' => 'required|date|after_or_equal:today',
            'new_slot' => 'required',
        ]);

        $booking = Booking::findOrFail($bookingId);
        $offering = Offering::findOrFail($booking->offering_id);
        $user = $booking->user;

        $timezone = $booking->user_timezone ?? config('app.timezone', 'UTC');
        $eventTime = Carbon::parse($booking->booking_date . ' ' . $booking->time_slot, $timezone);
        $now = Carbon::now($timezone);
        $hoursLeft = $now->diffInHours($eventTime, false);

        if ($hoursLeft <= 48) {
            return response()->json(['message' => 'You can only reschedule more than 48 hours before the event.'], 400);
        }

        DB::beginTransaction();

        try {
            $adminFee = $booking->total_amount * 0.20;
            $stripeFee = 2.90;
            $refundToWallet = max(0, $booking->total_amount - $adminFee - $stripeFee);

            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
            $wallet->balance += $refundToWallet;
            $wallet->save();

            $newPrice = $request->new_price;
            $walletBalance = $wallet->balance;

            if ($walletBalance >= $newPrice) {
                // Deduct full price from wallet
                $wallet->balance -= $newPrice;
                $wallet->save();

                $booking->update([
                    'booking_date' => $request->new_date,
                    'time_slot' => $request->new_slot,
                    'status' => 'confirmed',
                    'reschedule_status' => 'approved',
                    'refunded_to_wallet' => $refundToWallet,
                    'rescheduled_at' => now(),
                    'pending_amount' => 0,
                    'paid_from_wallet' => $newPrice,
                ]);

                Reschedule::create([
                    'booking_id' => $booking->id,
                    'refunded_amount' => $refundToWallet,
                    'rescheduled_at' => now(),
                ]);

                DB::commit();

                return response()->json([
                    'message' => 'Booking successfully rescheduled and paid from wallet.',
                    'redirect_url' => route('userBookings'),
                ]);
            } else {
                // Not enough in wallet – use full wallet, calculate pending
                $pendingAmount = $newPrice - $walletBalance;

                // Deduct wallet balance to 0
                $wallet->balance = 0;
                $wallet->save();

                $booking->update([
                    'booking_date' => $request->new_date,
                    'time_slot' => $request->new_slot,
                    'status' => 'pending_payment',
                    'reschedule_status' => 'approved',
                    'refunded_to_wallet' => $refundToWallet,
                    'rescheduled_at' => now(),
                    'pending_amount' => $pendingAmount,
                    'paid_from_wallet' => $walletBalance,
                ]);

                Reschedule::create([
                    'booking_id' => $booking->id,
                    'refunded_amount' => $refundToWallet,
                    'rescheduled_at' => now(),
                ]);

                DB::commit();

                return response()->json([
                    'message' => 'Partial wallet amount used. Please complete payment.',
                    'redirect_url' => route('stripe.pay', ['booking' => $booking->id, 'amount' => $pendingAmount]),
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


}
