<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Price;
use Stripe\Product;

class PlanController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $plans = Plan::latest()->get();
        return view('admin.plans.index', compact('plans','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        return view('admin.plans.create',[
            'user' =>$user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'interval' => 'required|in:month,year,two_years',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $stripePriceId = $this->stripeService->createPlan(
            $request->name,
            $request->price,
            $request->interval
        );
        $stripeTax = null;
        if($request->tax_percentage && $request->tax_percentage > 0){
            $existingTaxRates = \Stripe\TaxRate::all(['active' => true])->data;

            foreach ($existingTaxRates as $existingTaxRate) {
                if ($existingTaxRate->percentage == $request->tax_percentage) {
                    $stripeTax = $existingTaxRate;
                    break;
                }
            }

            // If no existing tax rate found, create a new one
            if (!$stripeTax) {
                $stripeTax = $this->stripeService->createTax(
                    $request->tax_percentage
                );
            }
        }

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->interval = $request->interval;
        $plan->stripe_price_id = $stripePriceId;
        $plan->stripe_tax_rate_id = $stripeTax? $stripeTax->id: null;
        $plan->tax_percentage = $request->tax_percentage;
        $plan->save();

        return back()->with('success', 'Subscription plan created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'interval' => 'required|in:month,year,two_years',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $plan = Plan::findOrFail($id);

        // Check if no user has subscribed before allowing an update
        // if ($plan->subscriptions()->count() > 0) {
        //     return response()->json(['error' => 'Plan cannot be updated because it has active subscriptions'], 400);
        // }

        // Retrieve current Stripe price
        $currentPrice = Price::retrieve($plan->stripe_price_id);

        // Update Stripe Product Name
        $product = Product::retrieve($currentPrice->product);
        $product->name = $request->name;
        $product->save();

        // Stripe does not allow price updates; create a new price object
        $newPrice = Price::create([
            'unit_amount' => $request->price * 100, // Convert to cents
            'currency' => 'usd',
            'recurring' => [
                'interval' => $request->interval === 'two_years' ? 'year' : $request->interval,
                'interval_count' => $request->interval === 'two_years' ? 2 : 1,
            ],
            'product' => $product->id,
        ]);

        $stripeTax = null;
        if($request->tax_percentage && $request->tax_percentage > 0){
            $stripeTax = $this->stripeService->createTax(
                $request->tax_percentage
            );
        }

        // Delete old price from Stripe
        Price::update($currentPrice->id, [
            'active' => false,
        ]);


        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->interval = $request->interval;
        $plan->stripe_price_id = $newPrice->id;
        $plan->stripe_tax_rate_id = $stripeTax? $stripeTax->id: null ;
        $plan->tax_percentage = $request->tax_percentage;
        $plan->save();

        return back()->with('success', 'Subscription plan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        // Check if no user has subscribed before allowing deletion
        // if ($plan->subscriptions()->count() > 0) {
        //     return response()->json(['error' => 'Plan cannot be deleted because it has active subscriptions'], 400);
        // }

        // Retrieve current Stripe price and product
        $currentPrice = \Stripe\Price::retrieve($plan->stripe_price_id);
        $product = \Stripe\Product::retrieve($currentPrice->product);

        // Mark the price as inactive (since Stripe does not allow deletion)
        \Stripe\Price::update($currentPrice->id, [
            'active' => false,
        ]);

        // Mark the product as inactive
        \Stripe\Product::update($product->id, [
            'active' => false,
        ]);

        // Delete from Database
        $plan->delete();

        return back()->with('success', 'Subscription plan deleted successfully!');
    }
}
