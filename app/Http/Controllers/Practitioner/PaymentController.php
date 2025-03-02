<?php
namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\UserStripeSetting;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        /* $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]); */

       $user = auth()->user();

        $booking = session('booking');
        if (!$booking) {
            return redirect()->route('home')->with('error', 'Booking session expired.');
        }
        
        /* $Offering = Offering::find($booking['offering_id']);
        echo '<pre>';
        Print_r($Offering->price);
        echo '</pre>';
        exit(); */
        
        // Save Booking
        $order = Booking::create([
             'user_id' => $user? $user->id : null, 
            'offering_id' => $booking['offering_id'],
            'booking_date' => $booking['booking_date'],
            'time_slot' => $booking['booking_time'],
            'total_amount' => Offering::find($booking['offering_id'])->client_price,
            'price' => Offering::find($booking['offering_id'])->client_price,
            'status' => 'pending',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'billing_company' => $request->billing_company,
            'billing_address' => $request->billing_address,
            'billing_address2' => $request->billing_address2,
            'billing_country' => $request->billing_country,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_postcode' => $request->billing_postcode,
            'billing_phone' => $request->billing_phone,
            'billing_email' => $request->billing_email,
            'notes' => $request->notes,
        ]);

        session()->forget('booking');

        return redirect()->route('payment', ['order_id' => $order->id]);
    }

    public function showPaymentPage($order_id)
    {
        $order = Booking::findOrFail($order_id);
        return view('payment', compact('order'));
    }

    public function processStripePayment(Request $request)
{
    try {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $order = Booking::findOrFail($request->order_id);
        $vendorId = $order->offering->user_id;
        $vendorStripe = UserStripeSetting::where("user_id", $vendorId)->first();
        // Stripe Checkout Session
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Booking Payment'],
                    'unit_amount' => $order->total_amount * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'payment_intent_data' => [
                'application_fee_amount' => intval($order->total_amount * 0.22 * 100), // 22% to admin
                'transfer_data' => [
                    'destination' => $vendorStripe->stripe_user_id, // 78% to vendor
                ],
            ],
            'success_url' => route('confirm-payment', ['order_id' => $order->id]),
            'cancel_url' => route('payment.cancel', ['order_id' => $order->id]),
        ]);

        

        // Save Payment Data
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'stripe',
            'amount' => $order->total_amount,
            'transaction_id' => $session->id,
            'response' => json_encode($session),
            'status' => 'pending', // Change to "completed" after Stripe confirmation
        ]);

        return redirect($session->url);
        
    } catch (\Exception $e) {
        echo '<pre>';
        Print_r($e->getMessage());
        echo '</pre>';
        exit();
        return back()->with('error', 'Payment failed: ' . $e->getMessage());
    }
}

    public function confirmPayment(Request $request)
    {
        $order = Booking::findOrFail($request->order_id);

        $payment = Payment::where("order_id", $order->id)->firstorFail();
        $payment->status = 'completed';
        $payment->save();

        // Update order status
        $order->update(['status' => 'paid']);

        return redirect()->route('thankyou')->with('success', 'Payment successful!');
    }



    public function sucess(Request $request){

        $input =$request->all();
        echo '<pre>';
        Print_r("payment sucessfull");
        echo '</pre>';
        exit();
        /* return view('payment.success', [
            'payment_id' => $request->payment_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $request->status
        ]); */
    }   

    public function failed(Request $request){

        $input =$request->all();
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

