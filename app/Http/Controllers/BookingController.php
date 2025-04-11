<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Google\Service\Dfareporting\Resource\Countries;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Offering;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemporaryPasswordMail;
use App\Models\GoogleAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MailerLite\MailerLite;

class BookingController extends Controller
{

    public function calendarBooking(Request $request)
    {

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
            'html' => view('user.billing-popup', compact('offering', 'bookingDate', 'bookingTime','bookingUserTimezone', 'price', 'currency', 'countries'))->render()
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

        $price = $booking['price'];
        $currency = $booking['currency'];
        $currencySymbol = $booking['currency_symbol'];

        if (!$booking) {
            return response()->json([
                "success" => false,
                "data" => "No booking details found.",
            ], 404);
        }

        $product = Offering::where('id',$booking['offering_id'])->with('event')->first();
        if($request->subscribe == true){
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
        $product = Offering::findOrFail($booking['offering_id']);
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


}
