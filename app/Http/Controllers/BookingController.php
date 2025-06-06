<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Calender\GoogleCalendarController;
use App\Mail\TemporaryPasswordMail;
use App\Models\Booking;
use App\Models\Country;
use App\Models\GoogleAccount;
use App\Models\Offering;
use App\Models\Show;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Wallet;
use Carbon\Carbon;
use Google\Type\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use MailerLite\MailerLite;

class BookingController extends Controller
{

    public function calendarBooking(Request $request)
    {
        $user = Auth::user() ?? null;
        $request->validate([
            'offering_id' => 'required|exists:offerings,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required'
        ]);

        session([
            'booking' => [
                'offering_id' => $request->offering_id,
                'booking_date' => $request->booking_date,
                'booking_time' => $request->booking_time,
                'price' => $request->price,
                'currency' => $request->currency,
                'currency_symbol' => $request->currency_symbol,
                'booking_user_timezone' => $request->booking_user_timezone,
            ]
        ]);

        $bookingDate = $request->booking_date;
        $bookingTime = $request->booking_time;
        $bookingUserTimezone = $request->booking_user_timezone;

        $offering = Offering::find($request->offering_id);
        $price = $offering->price;
        $currency = $offering->currency;
        $countries = Country::all();
        return response()->json([
            "success" => true,
            "data" => "Booking saved in session!",
            'html' => view('user.billing-popup', compact('user', 'offering', 'bookingDate', 'bookingTime', 'bookingUserTimezone', 'price', 'currency', 'countries'))->render()
        ]);
        // return redirect()->route('checkout');
    }

    public function preCheckout(Request $request)
    {

        session([
            'billing' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'billing_address' => $request->billing_address,
                'billing_address2' => $request?->billing_address2 ?? '',
                'billing_country' => $request->billing_country,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postcode' => $request->billing_postcode,
                'billing_phone' => $request->billing_phone,
                'billing_email' => $request->billing_email,
            ]
        ]);

        $booking = session('booking');

        $price = $booking['price'];
        $currency = $booking['currency'];
        $currencySymbol = $booking['currency_symbol'];

        if (!$booking) {
            return response()->json([
                "success" => false,
                "data" => "No booking details found.",
            ], 404);
        }
        $isShow = isset($booking['isShow']) ? $booking['isShow'] : false;

        if($isShow)
        {
            $product = Show::findOrFail($booking['show_id']);

        }else{
            $product = Offering::findOrFail($booking['offering_id'])->with('event')->first();
        }

        if ($request->subscribe == true) {
            $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);
            $data = [
                'email' => $request->billing_email,
                "fields" => [
                    "name" => $request->first_name,
                ],
                'groups' => [
                    env('MAILERLITE_GROUP')
                ]
            ];
            $mailerLite->subscribers->create($data);
        }
        return response()->json([
            "success" => true,
            "data" => "Billing details saved in session!",
            'html' => view('user.checkout-popup', compact('booking', 'product', 'price', 'currency', 'currencySymbol'))->render()
        ]);
    }


    public function preCheckoutRegister(Request $request)
    {
        $tempPassword = "P@ssw0rd";
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->billing_email,
//            role 0 = pending, role 1 = practitioner, role 2 = Admin , role 3 = User
            'role' => 3,
            //  default status  0 = Inactive, status 1 = Active, status 2 = pending,
            'status' => 2,
            'password' => Hash::make($tempPassword),
        ]);
        $seekingFor = [
            "nutritional_support" => isset($request->nutritional_support) ? true : false,
            "women_wellness" => isset($request->women_wellness) ? true : false,
            "womb_healing" => isset($request->womb_healing) ? true : false,
            "mindset_coaching" => isset($request->mindset_coaching) ? true : false,
            "transformation_coachin" => isset($request->transformation_coachin) ? true : false,
            "health_practitioner" => isset($request->health_practitioner) ? true : false
        ];
        Mail::to($user->email)->send(new TemporaryPasswordMail($user, $tempPassword));
        Auth::login($user);
        UserDetail::create([
            'user_id' => $user->id,
            'seeking_for' => json_encode($seekingFor)
        ]);

        GoogleAccount::create([
                'user_id' => $user->id,
            ]
        );
        session([
            'billing' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'billing_address' => $request->billing_address,
                'billing_address2' => $request->billing_address2,
                'billing_country' => $request->billing_country,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postcode' => $request->billing_postcode,
                'billing_phone' => $request->billing_phone,
                'billing_email' => $request->billing_email,
            ]
        ]);

        $booking = session('booking');
        if (!$booking) {
            return response()->json([
                "success" => false,
                "data" => "No booking details found.",
            ], 404);
        }

        if ($request->subscribe == true) {
            $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);
            $data = [
                'email' => $request->billing_email,
                "fields" => [
                    "name" => $request->first_name,
                ],
                'groups' => [
                    env('MAILERLITE_GROUP')
                ]
            ];
            $mailerLite->subscribers->create($data);
        }
        if(isset($booking['isShow']))
        {
            $product = Show::findOrFail($booking['show_id']);

        }else{
            $product = Offering::findOrFail($booking['offering_id']);
        }

        return response()->json([
            "success" => true,
            "data" => "Billing details saved in session!",
            'html' => view('user.checkout-popup', compact('booking', 'product'))->render()
        ]);
    }

    public function checkout()
    {
        $booking = session('booking');


        if (!$booking) {
            return redirect()->route('home')->with('error', 'No booking details found.');
        }

        $product = Offering::findOrFail($booking['offering_id']);


        return view('checkout', compact('booking', 'product'));
    }

    public function cancelEvent(Request $request, $bookingId, $eventId)
    {
        $booking = Booking::findOrFail($bookingId);
        $offering = Offering::with('event')->findOrFail($booking->offering_id);
        $user = User::with('userDetail')->findOrFail($offering->user_id);

        // Timezones
        $practitionerTimezone = $user->userDetail->timezone ?? 'UTC';
        $userTimezone = $booking->user_timezone ?? $practitionerTimezone;

        $bookingDate = $booking->booking_date ?? Carbon::now()->toDateString(); // e.g., 2025-06-06

        $bookingTime = isset($booking->time_slot) && trim($booking->time_slot) !== ''
            ? trim($booking->time_slot)
            : Carbon::now()->format('H:i'); // e.g., 21:15

        if (!$bookingDate || !$bookingTime) {
            return redirect()->route('booking.index')->with('error', 'Invalid booking date or time.');
        }

        // Parse booking datetime in user timezone
        try {
            if (Str::contains($bookingTime, 'AM') || Str::contains($bookingTime, 'PM')) {
                $userDateTime = Carbon::createFromFormat('Y-m-d h:i A', "$bookingDate $bookingTime", $userTimezone);
            } elseif (Str::contains($bookingTime, ':') && substr_count($bookingTime, ':') === 2) {
                $userDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $bookingTime", $userTimezone);
            } else {
                $userDateTime = Carbon::createFromFormat('Y-m-d H:i', "$bookingDate $bookingTime", $userTimezone);
            }
        } catch (\Exception $e) {
            return redirect()->route('userBookings')->with('error', 'Invalid time format: ' . $bookingTime);
        }

        // Convert to practitioner's timezone
        $practitionerDateTime = $userDateTime->copy()->setTimezone($practitionerTimezone);
        $now = Carbon::now($practitionerTimezone);

        // Determine cancellation window in hours
        $cancellationWindow = 24; // default
        if ($booking->reschedule && $booking->reschedule_hour) {
            if (preg_match('/(\d+)/', $booking->reschedule_hour, $matches)) {
                $value = (int) $matches[1];
                if (Str::contains($booking->reschedule_hour, 'week')) {
                    $cancellationWindow = $value * 24 * 7;
                } elseif (Str::contains($booking->reschedule_hour, 'hour')) {
                    $cancellationWindow = $value;
                } else {
                    $cancellationWindow = $value; // fallback
                }
            }
        }

        // Calculate hours until event
        $hoursUntilEvent = $now->diffInHours($practitionerDateTime, false);

        if ($hoursUntilEvent > $cancellationWindow) {
            DB::beginTransaction();

            $booking->status = 'cancelled';
            $booking->cancellation = true;
            $booking->save();

            // Deduct admin + Stripe fee
            $adminFee = $booking->total_amount * 0.20;
            $stripeFee = 2.90; // fixed for example
            $refundToWallet = max(0, $booking->total_amount - $adminFee - $stripeFee);

            $wallet = Wallet::firstOrCreate(['user_id' => $booking->user_id]);
            $wallet->balance += $refundToWallet;
            $wallet->save();

            // Remove from Google Calendar
            $googleCalendar = new GoogleCalendarController();
            $request->merge(['event_id' => $eventId]);
            $googleCalendar->deleteEvent($request, $user->id);

            DB::commit();

            return redirect()->route('userBookings')->with('success', 'Booking cancelled and refund added to wallet.');
        } else {
            return redirect()->route('userBookings')->with('error', 'You can only cancel more than ' . $cancellationWindow . ' hours before the event.');
        }
    }




}
