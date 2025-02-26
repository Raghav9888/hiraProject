<?php
namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\UserStripeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
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

        return redirect()->route('myProfile')->with('success', 'Stripe disconnected successfully!');
    }


    public function createPayment(Request $request)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $vendorStripeAccountId = "acct_1QvE6qSGd6Vpe1yc"; // Replace with actual vendor's Stripe account ID

    if (!$request->has('payment_method') || empty($request->payment_method)) {
        return redirect()->route('payment.failed', ['message' => 'Payment method is required.']);
    }

    try {
        // Customer details (required for export transactions in India)
        $customerName = $request->input('customer_name', 'John Doe'); // Default if not provided
        $customerEmail = $request->input('customer_email', 'john@example.com');
        $customerAddress = [
            'line1'       => $request->input('address_line1', '123 Export Street'),
            'line2'       => $request->input('address_line2', ''),
            'city'        => $request->input('city', 'Mumbai'),
            'state'       => $request->input('state', 'MH'),
            'postal_code' => $request->input('postal_code', '400001'),
            'country'     => $request->input('country', 'IN'),
        ];

        // Create a PaymentIntent with required export details
        $paymentIntent = PaymentIntent::create([
            'amount' => 10000, // ₹100 in paisa (100 * 100)
            'currency' => 'inr',
            'payment_method' => $request->payment_method,
            'confirm' => true,
            'transfer_data' => [
                'destination' => $vendorStripeAccountId, // Send funds to vendor
            ],
            'application_fee_amount' => 2500, // ₹25 admin commission (25% of ₹100)
            'description' => 'Export transaction for digital services', // Required for Indian exports
            'shipping' => [
                'name' => $customerName,
                'address' => $customerAddress,
            ],
            'receipt_email' => $customerEmail, // Optional, sends Stripe receipt
            'return_url' => url('/payment-success'), // Required for redirect-based payment methods
        ]);

        return redirect()->route('payment.success', [
            'payment_id' => $paymentIntent->id,
            'amount' => $paymentIntent->amount / 100,
            'currency' => strtoupper($paymentIntent->currency),
            'status' => $paymentIntent->status,
        ]);

    } catch (\Exception $e) {
        return redirect()->route('payment.failed', ['message' => $e->getMessage()]);
    }
}


    public function sucess(Request $request){

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

