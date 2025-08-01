<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Offering;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class  PractitionerBookingController extends Controller
{

    public function bookings(Request $request, $userId, $userType)
    {
        $user = Auth::user();

        // we get booking of practitioner clients
        if($userType == '3')
        {
            $bookings = Booking::where('user_id', $userId)
                ->with(['offering', 'user', 'shows'])
                ->get();

        }
        else{
            //  here we get bookings of practitioner
            // Get offering and show IDs owned by this user
            $offeringIds = Offering::where('user_id', $userId)->pluck('id');
            $showIds = Show::where('user_id', $userId)->pluck('id');

            // Get bookings where either offering or show is owned by the user
            $bookings = Booking::where(function ($query) use ($offeringIds, $showIds) {
                $query->whereIn('offering_id', $offeringIds)
                    ->orWhereIn('shows_id', $showIds);
            })
                ->with(['offering', 'user', 'shows'])
                ->get();
        }

        return view('admin.booking.index', [
            'userId' => $userId,
            'userType' => $userType,
            'bookings' => $bookings,
            'request' => $request,
            'user' => $user,
        ]);
    }

    public function detail(Request $request,$bookingId ,$userType)
    {
        $user = Auth::user();

        // Get booking details
        $booking = Booking::with(['offering', 'user', 'shows'])->findOrFail($bookingId);

        // Return view with booking details
        return view('admin.booking.detail', [
            'booking' => $booking,
            'request' => $request,
            'userType' => $userType,
            'user' => $user,
        ]);
    }

}
