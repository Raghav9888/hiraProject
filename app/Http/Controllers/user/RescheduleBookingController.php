<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Calender\GoogleCalendarController;
use App\Models\{Booking, Offering, User, Wallet, Reschedule};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


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
        $user = User::with('userDetail')->findOrFail($offering->user_id);

        $practitionerTimezone = $user->userDetail->timezone ?? 'UTC';
        $userTimezone = $booking->user_timezone ?? $practitionerTimezone;

        $bookingDate = $booking->booking_date;
        $bookingTime = trim($booking->time_slot ?? '');

        try {
            if (Str::contains($bookingTime, 'AM') || Str::contains($bookingTime, 'PM')) {
                $userDateTime = Carbon::createFromFormat('Y-m-d h:i A', "$bookingDate $bookingTime", $userTimezone);
            } elseif (Str::contains($bookingTime, ':') && substr_count($bookingTime, ':') === 2) {
                $userDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $bookingTime", $userTimezone);
            } else {
                $userDateTime = Carbon::createFromFormat('Y-m-d H:i', "$bookingDate $bookingTime", $userTimezone);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid time format: ' . $bookingTime], 400);
        }

        $practitionerDateTime = $userDateTime->copy()->setTimezone($practitionerTimezone);
        $now = Carbon::now($practitionerTimezone);

        // Parse cancellation window like cancelEvent
        $cancellationWindow = 24;
        if ($booking->reschedule && $booking->reschedule_hour) {
            if (preg_match('/(\d+)/', $booking->reschedule_hour, $matches)) {
                $value = (int) $matches[1];
                if (Str::contains($booking->reschedule_hour, 'week')) {
                    $cancellationWindow = $value * 24 * 7;
                } elseif (Str::contains($booking->reschedule_hour, 'hour')) {
                    $cancellationWindow = $value;
                } else {
                    $cancellationWindow = $value;
                }
            }
        }

        $hoursUntilEvent = $now->diffInHours($practitionerDateTime, false);
        if ($hoursUntilEvent <= $cancellationWindow) {
            return response()->json(['message' => "You can only reschedule more than {$cancellationWindow} hours before the event."], 400);
        }

        DB::beginTransaction();

        try {
            // Refund
            $adminFee = $booking->total_amount * 0.20;
            $stripeFee = 2.90;
            $refundToWallet = max(0, $booking->total_amount - $adminFee - $stripeFee);

            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
            $wallet->balance += $refundToWallet;
            $wallet->save();

            // Remove from Google Calendar
            if ($booking->google_event_id) {
                $googleCalendar = new GoogleCalendarController();
                $request->merge(['event_id' => $booking->google_event_id]);
                $googleCalendar->deleteEvent($request, $user->id);
            }

            // Reschedule Logic
            $newPrice = $request->new_price;
            $walletBalance = $wallet->balance;

            if ($walletBalance >= $newPrice) {
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
            } else {
                $pendingAmount = $newPrice - $walletBalance;

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
            }

            Reschedule::create([
                'booking_id' => $booking->id,
                'refunded_amount' => $refundToWallet,
                'rescheduled_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Booking successfully rescheduled.',
                'redirect_url' => route('userBookings'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


}
