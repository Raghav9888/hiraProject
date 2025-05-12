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

        $successBookings = Booking::where(['user_id' => $user->id ,'status' => 'paid'])->get();
        $pendingBookings = Booking::where(['user_id' => $user->id,'status' => 'pending'])->get();
        $recentBookings = Booking::with('offering.user')
        ->where(['user_id' => $user->id])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('user.comming_soon', [
            'user' => $user,
            'successBookings' => $successBookings,
            'pendingBookings' => $pendingBookings,
            'recentBookings' => $recentBookings,
        ]);

//        return view('user.dashboard', [
//            'user' => $user,
//            'successBookings' => $successBookings,
//            'pendingBookings' => $pendingBookings,
//            'recentBookings' => $recentBookings,
//        ]);
    }


    public function bookings()
    {
        $user = auth()->user();
        $bookings = Booking::with('offering.user')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.comming_soon', [
            'user' => $user,
            'successBookings' => $successBookings,
            'pendingBookings' => $pendingBookings,
            'recentBookings' => $recentBookings,
        ]);

//        return view('user.bookings', [
//            'user' => $user,
//            'bookings' => $bookings,
//        ]);

    }

    public function viewBooking($id)
    {
        $user = auth()->user();
        $booking = Booking::with('offering.user')
            ->where(['user_id' => $user->id, 'id' => $id])
            ->firstOrFail();

        return view('user.comming_soon', [
            'user' => $user,
            'successBookings' => $successBookings,
            'pendingBookings' => $pendingBookings,
            'recentBookings' => $recentBookings,
        ]);
//        return view('user.view_booking', [
//            'user' => $user,
//            'booking' => $booking,
//        ]);

    }

    public function userProfile()
    {
        $user = auth()->user();
        $bookings = Booking::with('offering.user')
            ->where(['user_id' => $user->id])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.comming_soon', [
            'user' => $user,
            'successBookings' => $successBookings,
            'pendingBookings' => $pendingBookings,
            'recentBookings' => $recentBookings,
        ]);
//        return view('user.profile', [
//            'user' => $user,
//            'bookings' => $bookings,
//        ]);
    }

    public function userFavourites()
    {


    }
}
