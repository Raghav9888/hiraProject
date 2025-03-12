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

        return view('practitioner.discount', compact('discounts','offerings'));
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
        return view('practitioner.add_discount', compact('user', 'userDetails', 'categories', 'PractitionerTag', 'offerings', 'IHelpWith', 'HowIHelp'));

    }

    public function store(Request $request)
    {

        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;

        $discountdata = [
            'user_id' => $user_id,
            'coupon_amount' => $input['coupon_amount'],
            'discount_type' => $input['discount_type'],
            'apply_to' => $input['apply_to'],
            'offerings' => isset($input['offerings']) && count($input['offerings']) > 0 ? json_encode($input["offerings"]): null,
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
        return view('practitioner.edit_discount', compact('discount', 'user', 'userDetails', 'categories', 'PractitionerTag', 'offerings', 'IHelpWith', 'HowIHelp'));
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;
        $discountdata = [
            'user_id' => $user_id,
            'coupon_amount' => $input['coupon_amount'],
            'discount_type' => $input['discount_type'],
            'apply_to' => $input['apply_to'],
            'offerings' => $input['apply_to'] === 'specific' && isset($input['offerings']) && count($input['offerings']) > 0  ? json_encode($input["offerings"]): null,
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
