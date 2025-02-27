<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{

    public function index()
    {
        $discounts = Discount::with('user')->get();

        return view('user.discount', compact('discounts'));
    }

    public function add(Request $request)
    {

        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;

        $discountdata = [
            'user_id' => $user_id,
            'coupon_code' => $input['coupon_code'],
            'coupon_description' => $input['coupon_description'],
            'apply_all_services' => $input['apply_all_services'],
            'coupon_amount' => $input['coupon_amount'],
            'discount_type' => $input['discount_type'],
            'minimum_spend' => $input['minimum_spend'],
            'maximum_spend' => $input['maximum_spend'],
            'individual_use_only' => $input['individual_use_only'],
            'exclude_sale_items' => $input['exclude_sale_items'],
            'offerings' => $input['offerings'],
            'exclude_services' => $input['exclude_services'],
            'email_restrictions' => $input['email_restrictions'],
            'usage_limit_per_coupon' => $input['usage_limit_per_coupon'],
            'usage_limit_to_x_items' => $input['usage_limit_to_x_items'],
            'usage_limit_per_user' => $input['usage_limit_per_user'],
        ];

        $discount = Discount::create($discountdata);
        return redirect()->route('discount')->with('success', 'Discount created successfully!');

    }
}
