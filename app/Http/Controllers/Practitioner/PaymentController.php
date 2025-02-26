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
        // Set Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Vendor's Stripe account ID (Get from your database)
        $vendorStripeAccountId = "acct_1QvE6qSGd6Vpe1yc"; // Replace with vendor's actual Stripe account ID

        try {
            // Create a PaymentIntent with application_fee_amount for admin's cut
            $paymentIntent = PaymentIntent::create([
                'amount' => 10000, // ₹100 in paisa (100 * 100)
                'currency' => 'inr',
                'payment_method' => $request->payment_method, // Get payment method ID from frontend
                'confirm' => true, // Automatically confirm the payment
                'transfer_data' => [
                    'destination' => $vendorStripeAccountId, // Send funds to vendor
                    'amount' => 7500, // ₹75 to vendor (75% of ₹100)
                ],
                'application_fee_amount' => 2500, // ₹25 admin commission (25% of ₹100)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment Successful',
                'paymentIntent' => $paymentIntent
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

