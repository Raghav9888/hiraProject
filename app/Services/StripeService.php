<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\TaxRate;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env("STRIPE_SECRET"));
    }

    public function createPlan($name, $price, $interval)
    {
       // Convert custom intervals to Stripe-compatible format
        // $stripeInterval = $interval === 'two_years' ? ['interval' => 'year', 'interval_count' => 2] : ['interval' => $interval];
        $stripeInterval = match ($interval) {
            'two_years' => ['interval' => 'year', 'interval_count' => 2], // 2 years
            'twenty_five_years' => ['interval' => 'month', 'interval_count' => 300], // 25 years (300 months)
            default => ['interval' => $interval], // 1 year or other valid intervals
        };
        // Create a Product
        $product = Product::create([
            'name' => $name,
        ]);

        // Create a Price
        $stripePrice = Price::create([
            'unit_amount' => $price * 100,
            'currency' => 'usd',
            'recurring' => $stripeInterval, 
            'product' => $product->id,
        ]);

        return $stripePrice->id; // Return the Stripe Price ID
    }

    public function createTax($taxPercentage)
    {
        // Create a tax rate in Stripe
        $taxRate = null;
        if ($taxPercentage > 0) {
            $taxRate = TaxRate::create([
                'display_name' => 'Sales Tax',
                'percentage' => $taxPercentage,
                'inclusive' => false, // Set to true if the tax is included in the price
            ]);
        }
        return $taxRate;
    }
}
