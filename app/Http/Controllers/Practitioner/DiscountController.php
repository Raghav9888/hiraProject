<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Offering;
use App\Models\PractitionerTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{

    public function index()
    {
        $discounts = Discount::with('user')->get();
        $offerings = Offering::with('user')->get();

        return view('user.discount', compact('discounts','offerings'));
    }

    public function add()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $categories = Category::get();
        $PractitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $offerings = Offering::where('user_id', $user->id)->get();
        return view('user.add_discount', compact('user', 'userDetails', 'categories', 'PractitionerTag', 'offerings', 'IHelpWith', 'HowIHelp'));

    }

    public function store(Request $request)
    {

        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;

        $discountdata = [
            'user_id' => $user_id,
            'coupon_code' => $input['coupon_code'],
            'coupon_description' => $input['coupon_description'],
            'apply_all_services' => isset($input['apply_all_services']) && $input['apply_all_services'] == 'on' ? 1 : 0,
            'coupon_amount' => $input['coupon_amount'],
            'discount_type' => $input['discount_type'],
            'minimum_spend' => $input['minimum_spend'],
            'maximum_spend' => $input['maximum_spend'],
            'individual_use_only' => isset($input['individual_use_only']) && $input['individual_use_only'] == 'on' ? 1 : 0,
            'exclude_sale_items' => isset($input['exclude_sale_items']) && $input['exclude_sale_items'] == 'on' ? 1 : 0,
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

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $categories = Category::get();
        $PractitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $offerings = Offering::where('user_id', $user->id)->get();
        return view('user.edit_discount', compact('discount', 'user', 'userDetails', 'categories', 'PractitionerTag', 'offerings', 'IHelpWith', 'HowIHelp'));
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;

        $discountdata = [
            'user_id' => $user_id,
            'coupon_code' => $input['coupon_code'],
            'coupon_description' => $input['coupon_description'],
            'apply_all_services' => isset($input['apply_all_services']) && $input['apply_all_services'] == 'on' ? 1 : 0,
            'coupon_amount' => $input['coupon_amount'],
            'discount_type' => $input['discount_type'],
            'minimum_spend' => $input['minimum_spend'],
            'maximum_spend' => $input['maximum_spend'],
            'individual_use_only' => isset($input['individual_use_only']) && $input['individual_use_only'] == 'on' ? 1 : 0,
            'exclude_sale_items' => isset($input['exclude_sale_items']) && $input['exclude_sale_items'] == 'on' ? 1 : 0,
            'offerings' => $input['offerings'],
            'exclude_services' => $input['exclude_services'],
            'email_restrictions' => $input['email_restrictions'],
            'usage_limit_per_coupon' => $input['usage_limit_per_coupon'],
            'usage_limit_to_x_items' => $input['usage_limit_to_x_items'],
            'usage_limit_per_user' => $input['usage_limit_per_user'],
        ];

        $discount = Discount::where('id', $id)->update($discountdata);
        return redirect()->route('discount')->with('success', 'Discount updated successfully!');

    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return redirect()->route('discount')->with('success', 'Discount deleted successfully!');
    }
}
