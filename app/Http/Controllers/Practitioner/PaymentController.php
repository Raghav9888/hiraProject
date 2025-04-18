<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Calender\GoogleCalendarController;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationMail;
use App\Models\Blog;
use App\Models\Event;
use App\Models\User;
use App\Models\UserStripeSetting;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Offering;
use Carbon\Carbon;
use Google_Service_Calendar_Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Charge;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function connectToStripe()
    {
        $client_id = env('STRIPE_CLIENT_ID');
        $redirect_uri = route('stripe_callback');
        $state = csrf_token();

        $stripe_url = "https://connect.stripe.com/oauth/v2/authorize?"
            . "scope=read_write"
            . "&state={$state}"
            . "&redirect_uri={$redirect_uri}"
            . "&client_id={$client_id}"
            . "&response_type=code";

        return redirect($stripe_url);
    }

    public function handleStripeCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('my_profile')->with('error', 'Stripe authorization failed.');
        }

        $authorization_code = $request->input('code');

        // Exchange authorization code for tokens
        $response = Http::asForm()->post('https://connect.stripe.com/oauth/token', [
            'client_id' => env('STRIPE_CLIENT_ID'),
            'client_secret' => env('STRIPE_SECRET'),
            'code' => $authorization_code,
            'grant_type' => 'authorization_code',
        ]);

        $stripeData = $response->json();

        if (!isset($stripeData['stripe_user_id'])) {
            return redirect()->route('my_profile')->with('error', 'Failed to retrieve Stripe account details.');
        }

        // Save data to database
        UserStripeSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'stripe_user_id' => $stripeData['stripe_user_id'],
                'stripe_access_token' => $stripeData['access_token'],
                'stripe_refresh_token' => $stripeData['refresh_token'],
                'stripe_publishable_key' => $stripeData['stripe_publishable_key'],
            ]
        );

        return redirect()->route('my_profile')->with('success', 'Stripe connected successfully!');
    }

    public function stripeSettings()
    {
        $settings = UserStripeSetting::where('user_id', Auth::id())->first();
        return view('user.my_profile', compact('settings'));
    }

    public function disconnectToStripe()
    {
        UserStripeSetting::where('user_id', Auth::id())->update([
            'stripe_access_token' => null,
            'stripe_refresh_token' => null,
            'stripe_publishable_key' => null,
        ]);

        return redirect()->route('my_profile')->with('success', 'Stripe disconnected successfully!');
    }

    public function storeCheckout(Request $request)
    {


        try {
            $user = auth()->user();

            $booking = session('booking');

            $billing = session('billing');

            if (!$booking || !$billing) {
                return response()->json([
                    "success" => false,
                    "data" => "Booking session expired.",
                ], 404);
            }
            // Save Booking
            $order = Booking::create([
                'user_id' => $user ? $user->id : null,
                'offering_id' => $booking['offering_id'],
                'booking_date' => $booking['booking_date'],
                'time_slot' => $booking['booking_time'],
                'user_timezone' => $booking['booking_user_timezone'],
                'total_amount' => $request->total_amount,
                'tax_amount' => $request->tax_amount,
                'currency' => $booking['currency'],
                'currency_symbol' => $booking['currency_symbol'],
                'price' => $booking['price'],
                'status' => 'pending',
                'first_name' => $billing['first_name'],
                'last_name' => $billing['last_name'],
                'billing_address' => $billing['billing_address'],
                'billing_address2' => $billing['billing_address2'],
                'billing_country' => $billing['billing_country'],
                'billing_city' => $billing['billing_city'],
                'billing_state' => $billing['billing_state'],
                'billing_postcode' => $billing['billing_postcode'],
                'billing_phone' => $billing['billing_phone'],
                'billing_email' => $billing['billing_email'],
            ]);

            session()->forget('booking');
            session()->forget('billing');
            $url = $this->processStripePayment($order->id);
            if (!$url) {
                return response()->json([
                    "success" => false,
                    "data" => "Practitioner does not link there stripe account",
                ], 200);
            }
            return response()->json([
                "success" => true,
                "data" => $url,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "data" => $th->getMessage(),
            ], 500);
        }
    }

    public function showPaymentPage($order_id)
    {
        $order = Booking::findOrFail($order_id);
        return view('payment', compact('order'));
    }

    public function processStripePayment($orderId)
    {
        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $order = Booking::findOrFail($orderId);
            $vendorId = $order->offering->user_id;
            $vendorStripe = UserStripeSetting::where("user_id", $vendorId)->first();
            $isVendorConnected = $vendorStripe && $vendorStripe->stripe_user_id;
            $amountInCents = intval($order->total_amount * 100);
            $platformFee = intval($amountInCents * 0.2486); // 24.86% total platform cut
            $sessionParams = [
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $order->currency,
                        'product_data' => ['name' => 'Booking Payment'],
                        'unit_amount' => $amountInCents, // in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('confirm-payment', ['order_id' => $order->id]),
                'cancel_url' => route('home', ['order_id' => $order->id]),
            ];

            if ($isVendorConnected) {
                $sessionParams['payment_intent_data'] = [
                    'application_fee_amount' => $platformFee, // 22% admin cut
                    'transfer_data' => [
                        'destination' => $vendorStripe->stripe_user_id, // 78% to vendor
                    ],
                ];
            }


            $session = StripeSession::create($sessionParams);

            // Save Payment Data
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'stripe',
                'amount' => $order->total_amount,
                'transaction_id' => $session->id,
                'response' => json_encode($session),
                'status' => 'pending', // Change to "completed" after Stripe confirmation
            ]);

            return $session->url;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function confirmPayment(Request $request)
    {

        $order = Booking::with('offering', 'offering.user')->findOrFail($request->order_id);
        $offeringId = $order->offering->id;

        $payment = Payment::where("order_id", $order->id)->firstOrFail();
        $payment->status = 'completed';
        $payment->save();

        // Update order status
        $order->update(['status' => 'paid']);

        $offering = Offering::where('id', $offeringId)->with('event')->first();

        if ($offering->offering_event_type === 'event') {
            $event = Event::where('offering_id', $offeringId)->firstOrFail();

            $totalSlots = $offering->event->sports > 0 ? $offering->event->sports - 1 : 0;
            $event->sports = "$totalSlots";
            $event->save();
        }

        // Attempt to create a Google Calendar event
        try {
            $practitionerEmailTemplate = $offering->email_template;
            $intakeForms = $offering->intake_form;
            $response = $this->createGoogleCalendarEvent($order);
            // Send confirmation email
            Mail::to($order->billing_email)->send(new BookingConfirmationMail($order, $practitionerEmailTemplate, $intakeForms,$order ,false));
            Mail::to($offering->user->email)->send(new BookingConfirmationMail($order, $practitionerEmailTemplate, $intakeForms,$order,true));
            return redirect()->route('thankyou')->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            \Log::error('Google Calendar Event Creation Failed: ' . $e->getMessage());
            return redirect()->route('thankyou')->with('error', 'Payment successful, but failed to create Google Calendar event.');
        }

    }

    /**
     * @throws \Exception
     */
    private function createGoogleCalendarEvent($order): ?array
    {
        $offering = Offering::findOrFail($order->offering_id);
        $user = User::with('userDetail')->findOrFail($offering->user_id);

        // Timezones
        $practitionerTimezone = $user->userDetail->timezone ?? 'UTC';
        $userTimezone = $order->user_timezone ?? $practitionerTimezone;

        // Booking date and time (from user input)
        $bookingDate = $order->booking_date;     // e.g., '2025-05-26'
        $bookingTime = $order->time_slot;        // e.g., '05:40 AM'


        dd("Booking Debug Log", [
            'user_timezone' => $userTimezone,
            'practitioner_timezone' => $practitionerTimezone,
            'booking_date' => $bookingDate,
            'booking_time' => $bookingTime,
        ]);

        // Convert time from user timezone to practitioner timezone
        $userTime = Carbon::createFromFormat('h:i A', $bookingTime, $userTimezone);
        $convertedTime = $userTime->copy()->setTimezone($practitionerTimezone);

        // Merge converted time with original selected date in practitioner's timezone
        $practitionerDateTime = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $bookingDate . ' ' . $convertedTime->format('H:i:s'),
            $practitionerTimezone
        );


        // Determine day of the week in practitioner's timezone
        $dayOfWeek = strtolower($practitionerDateTime->format('l'));

        // Duration logic
        if ($offering->offering_event_type === 'event') {
            $startTime = $practitionerDateTime->copy();
            $duration = (int) filter_var(optional($offering->event)->event_duration ?? '60 minutes', FILTER_SANITIZE_NUMBER_INT);
        } else {
            $storeAvailabilities = json_decode($user->userDetail->store_availabilities, true) ?? [];

            $availabilityKey = in_array($dayOfWeek, ['saturday', 'sunday'])
                ? "weekends_only_-_every_sat_&_sundays"
                : "every_{$dayOfWeek}";

            if (!isset($storeAvailabilities[$availabilityKey])) {
                \Log::warning("Availability key {$availabilityKey} not found in store availabilities.");
            }

            $startTime = $practitionerDateTime->copy();
            $duration = (int) filter_var($offering->booking_duration ?? '60 minutes', FILTER_SANITIZE_NUMBER_INT);
        }

        // Calculate end time
        $endTime = $startTime->copy()->addMinutes($duration);

        // Proper event data with timeZone fields
        $eventData = [
            'title' => 'Booking From ' . env('APP_NAME') . ': ' . trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? '')),
            'category' => 'Booking',
            'description' => 'Customer: ' . trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? '')),
            'start' => [
                'dateTime' => $startTime->toIso8601String(),
                'timeZone' => $practitionerTimezone,
            ],
            'end' => [
                'dateTime' => $endTime->toIso8601String(),
                'timeZone' => $practitionerTimezone,
            ],
            'user_id' => $offering->user_id,
            'timezone' => $practitionerTimezone,
            'email' => $order->billing_email,
            'guest_email' => $order->billing_email,
        ];

        // Google Calendar API Integration
        $googleCalendar = new GoogleCalendarController();
        $response = $googleCalendar->createGoogleEvent($eventData, $offering);

        if (!$response['success']) {
            throw new \Exception($response['error']);
        }

        return $response;
    }






    private function getStoreAvailability($availabilityKey, $storeAvailabilities): array
    {
        $from = null;
        $to = null;
        if (!empty($storeAvailabilities[$availabilityKey]) && isset($storeAvailabilities[$availabilityKey]['enabled']) && $storeAvailabilities[$availabilityKey]['enabled'] == "1") {
            $from = $storeAvailabilities[$availabilityKey]['from'] ?? 'Not Set';
            $to = $storeAvailabilities[$availabilityKey]['to'] ?? 'Not Set';
        }

        return ['from' => $from, 'to' => $to];
    }


    public function success(Request $request)
    {

        $input = $request->all();

        $blogs = Blog::where('is_active', 1)->orderBy('created_at', 'desc')->limit(3)->get();
        $offeringsData = Offering::all();

        $offerings = [];
        $now = now();
        foreach ($offeringsData as $offeringData) {
            if (isset($offeringData->event) && $offeringData?->event && $offeringData?->event?->date_and_time > $now) {
                $offerings[$offeringData->event->date_and_time] = $offeringData;
            }
        }

        return view("user.payment-success", [
            'blogs' => $blogs,
            'offerings' => $offerings,

        ]);
    }

    public function failed(Request $request)
    {

        $input = $request->all();
        echo '<pre>';
        Print_r($input);
        echo '</pre>';
        exit();
        /* return view('payment.success', [
            'payment_id' => $request->payment_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $request->status
        ]); */
    }

}

