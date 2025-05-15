<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Offering;

class UserProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = auth()->user();
        return view('user.comming_soon', [
            'user' => $user,
            'successBookings' => $successBookings,
            'pendingBookings' => $pendingBookings,
            'recentBookings' => $recentBookings,
        ]);

    }
}
