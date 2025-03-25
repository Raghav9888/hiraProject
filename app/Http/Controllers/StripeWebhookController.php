<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Stripe Webhook Received:', $payload);

        // Checkout Session Completed - Create Subscription
        if ($payload['type'] === 'checkout.session.completed') {
            $session = $payload['data']['object'];
            $customerId = $session['customer'];
            $subscriptionId = $session['subscription'];
            $priceId = $session['metadata']['price_id'] ?? null;

            $user = User::where('stripe_id', $customerId)->first();

            if ($user && $subscriptionId) {
                // Check if the subscription already exists
                $subscription = Subscription::where('stripe_id', $subscriptionId)->first();

                if (!$subscription) {
                    $subscription = $user->subscriptions()->create([
                        'plan_id' => $session['metadata']['plan_id'],
                        'type' => 'default',
                        'stripe_id' => $subscriptionId,
                        'stripe_status' => 'active',
                        'stripe_price' => $priceId,
                        'quantity' => 1,
                    ]);

                    // Save Subscription Item
                    SubscriptionItem::create([
                        'subscription_id' => $subscription->id,
                        'stripe_id' => $subscriptionId,
                        'stripe_product' => $session['metadata']['plan_id'] ?? null,
                        'stripe_price' => $priceId,
                        'quantity' => 1,
                    ]);
                }
            }
        }

        // Invoice Payment Succeeded - Update Subscription Status
        if ($payload['type'] === 'invoice.payment_succeeded') {
            $invoice = $payload['data']['object'];
            $subscriptionId = $invoice['subscription'];
            $endAt = isset($invoice['lines']['data'][0]['period']['end'])? $invoice['lines']['data'][0]['period']['end']: null;
            $subscription = Subscription::where('stripe_id', $subscriptionId)->first();

            if ($subscription) {
                $subscription->update([
                    'stripe_status' => 'active',
                    'ends_at' => $endAt,
                ]);
                Log::info("Subscription ID {$subscriptionId} renewed successfully.");
            }
        }

        // Handle Subscription Cancellation
        if ($payload['type'] === 'customer.subscription.deleted') {
            $subscriptionId = $payload['data']['object']['id'];

            $subscription = Subscription::where('stripe_id', $subscriptionId)->first();

            if ($subscription) {
                $subscription->update([
                    'stripe_status' => 'canceled',
                    'ends_at' => now(),
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

}
