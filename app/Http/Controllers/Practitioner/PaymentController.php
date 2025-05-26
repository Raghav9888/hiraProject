<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Calender\GoogleCalendarController;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationMail;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Event;
use App\Models\GoogleAccount;
use App\Models\Offering;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserStripeSetting;
use Carbon\Carbon;
use Google\Service\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

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

    /**
     * @throws \Google\Exception
     * @throws Exception
     */
    public function confirmPayment(Request $request)
    {
//        try {
        // Fetch the order with related offerings and user
        $order = Booking::with('offering', 'offering.user')->findOrFail($request->order_id);
        $offeringId = $order->offering->id;

        // Update the payment status
        $payment = Payment::where("order_id", $order->id)->firstOrFail();
        $payment->status = 'completed';
        $payment->save();

        // Fetch offering and its related event
        $offering = Offering::where('id', $offeringId)->with('event')->first();
        $rescheduleMinutes = $this->parseTimeToMinutes($offering->cancellation_time_slot);
        if ($offering->offering_event_type === 'event') {
            $event = Event::where('offering_id', $offeringId)->firstOrFail();
            $totalSlots = $offering->event->sports > 0 ? $offering->event->sports - 1 : 0;
            $event->sports = "$totalSlots";
            $event->save();
        }

        // Attempt to create a Google Calendar event
        $practitionerEmailTemplate = $offering->email_template;
        $intakeForms = $offering->intake_form;

        $user = User::where('email', $order->billing_email)->first();
        if (!$user) {
            //       Booking user register and login here
            $user = User::create([
                'name' => $order->first_name . ' ' . $order->last_name,
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->billing_email,
//            role 0 = pending, role 1 = practitioner, role 2 = Admin , role 3 = User
                'role' => 3,
                //  default status  0 = Inactive, status 1 = Active, status 2 = pending,
                'status' => 1,
                'password' => Hash::make('12345678'),
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'slug' => Str::slug($user->first_name . ' ' . $user->last_name),
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $order->billing_phone,
                'address_line_1' => $order->billing_address ?? null,
                'address_line_2' => $order->billing_address2 ?? null,
                'city' => $order->billing_city ?? null,
                'state' => $order->billing_state ?? null,
                'postcode' => $order->billing_postcode ?? null,
                'country' => $order->billing_country ?? null,
            ]);

            GoogleAccount::create([
                    'user_id' => $user->id,
                ]
            );
        }



        $response = $this->createGoogleCalendarEvent($order);
        $response['order'] = $order;
        $response['bookingCancelUrl'] = (isset($offering->cancellation_time_slot) && $offering->cancellation_time_slot) ? route('bookingCancel', ['bookingId' => $order->id, 'eventId' => $response['google_event_id']]) : null;

        $response['isPractitioner'] = false;

        // Update order status
        $order->update(['reschedule' => $offering->is_cancelled,'reschedule_time' => $rescheduleMinutes, 'status' => 'paid', 'user_id' => $user->id, 'event_id' => $response['google_event_id']
        ]);
        Auth::login($user);
        // Send confirmation email to the user
        Mail::to($order->billing_email)->send(new BookingConfirmationMail($order, $practitionerEmailTemplate, $intakeForms, $response));

        $response['isPractitioner'] = true;

        // Send confirmation email to the practitioner
        Mail::to($offering->user->email)->send(new BookingConfirmationMail($order, $practitionerEmailTemplate, $intakeForms, $response));

        return redirect()->route('thankyou')->with('success', 'Payment successful!');

//        } catch (\Exception $e) {
//            \Log::error('Payment Confirmation Error: ' . $e->getMessage());
//            return redirect()->route('thankyou')->with('error', 'Payment successful, but failed to create Google Calendar event.');
//        }
    }

    /**
     * @throws Exception
     * @throws \Google\Exception
     */
    private function createGoogleCalendarEvent($order): ?array
    {
        $offering = Offering::findOrFail($order->offering_id);
        $user = User::with('userDetail')->findOrFail($offering->user_id);

        // Timezone management
        $practitionerTimezone = $user->userDetail->timezone ?? 'UTC';
        $userTimezone = $order->user_timezone ?? $practitionerTimezone;

        // Booking date and time (from user input)
        $bookingDate = $order->booking_date ?? null;
        $bookingTime = $order->time_slot ?? null;

        if (!$bookingDate || !$bookingTime) {
            throw new \Exception("Missing booking date or time.");
        }

        $bookingTime = trim($bookingTime); // Clean up spaces

        // Detect format and parse user's datetime
        if (Str::contains($bookingTime, 'AM') || Str::contains($bookingTime, 'PM')) {
            // 12-hour format
            $userDateTime = Carbon::createFromFormat('Y-m-d h:i A', "$bookingDate $bookingTime", $userTimezone);
        } else {
            // 24-hour format
            if (Str::contains($bookingTime, ':') && substr_count($bookingTime, ':') === 2) {
                // e.g., 18:30:00
                $userDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $bookingTime", $userTimezone);
            } else {
                // e.g., 18:30
                $userDateTime = Carbon::createFromFormat('Y-m-d H:i', "$bookingDate $bookingTime", $userTimezone);
            }
        }

        // Convert to practitioner's timezone
        $practitionerDateTime = $userDateTime->copy()->setTimezone($practitionerTimezone);

        // Determine day of the week in practitioner's timezone
        $dayOfWeek = strtolower($practitionerDateTime->format('l'));

        // Duration logic
        if ($offering->offering_event_type === 'event') {
            $startTime = $practitionerDateTime->copy();
            $duration = (int)filter_var(optional($offering->event)->event_duration ?? '60 minutes', FILTER_SANITIZE_NUMBER_INT);
        } else {
            $storeAvailabilities = json_decode($user->userDetail->store_availabilities, true) ?? [];

            $availabilityKey = in_array($dayOfWeek, ['saturday', 'sunday'])
                ? "weekends_only_-_every_sat_&_sundays"
                : "every_{$dayOfWeek}";

            if (!isset($storeAvailabilities[$availabilityKey])) {
                \Log::warning("Availability key {$availabilityKey} not found in store availabilities.");
            }

            $startTime = $practitionerDateTime->copy();
            $duration = (int)filter_var($offering->booking_duration ?? '60 minutes', FILTER_SANITIZE_NUMBER_INT);
        }

        // Calculate end time
        $endTime = $startTime->copy()->addMinutes($duration);

        // Prepare event data
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
            'offering_type' => $offering->offering_type,
        ];

        // Google Calendar API Integration
        $googleCalendar = new GoogleCalendarController();
        $response = $googleCalendar->createGoogleEvent($eventData);

        if (!$response['success']) {
            throw new \Exception($response['error']);
        }

        $response['practitioner_date_time'] = $practitionerDateTime->format('l, F j, Y \a\t h:i A');

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
    function parseTimeToMinutes($timeString)
    {
        if (preg_match('/(\d+)\s*hour/', $timeString, $matches)) {
            return (int)$matches[1] * 60; // convert hours to minutes
        }
        if (preg_match('/(\d+)\s*minute/', $timeString, $matches)) {
            return (int)$matches[1];
        }
        return null; // or default value
    }

}

