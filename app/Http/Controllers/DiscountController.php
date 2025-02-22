<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{

    public function index()
    {
        $discounts = Discount::with('user')->get();
        return view('user.offering', compact('offerings'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;

        $discountdata = [
            'user_id' => $user_id,
        ];


        $discount = Discount::create($discountdata);
        return redirect()->route('discount')->with('success', 'Discount created successfully!');


    }
}
