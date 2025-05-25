<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Offering;
use Carbon\Carbon;

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

        $successBookings = Booking::where('user_id', $user->id)->whereIn('status', ['paid', 'confirmed'])->get();
        $pendingBookings = Booking::where(['user_id' => $user->id,'status' => 'pending'])->get();
        $recentBookings = Booking::with('offering.user')
            ->where(['user_id' => $user->id])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('user.dashboard', [
            'user' => $user,
            'successBookings' => $successBookings,
            'pendingBookings' => $pendingBookings,
            'recentBookings' => $recentBookings,
        ]);

    }


    public function bookings()
    {
        $user = auth()->user();
        $bookings = Booking::with('offering.user')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.bookings', [
            'user' => $user,
            'bookings' => $bookings,
        ]);


    }

    public function viewBooking($id)
    {
        $user = auth()->user();
        $booking = Booking::with('offering.user')
            ->where(['user_id' => $user->id, 'id' => $id])
            ->firstOrFail();


        // Combine booking date and time slot to get full datetime of event
        $bookingDateTime = Carbon::parse($booking->booking_date . ' ' . $booking->time_slot);
        $offering = Offering::where('id', $booking->offering_id)->first();

        $beforeCanceledValue = 0;
        $beforeCanceled = 0;
        if ($offering->offering_event_type === 'offering' && $offering->is_cancelled) {
            $beforeCanceled = $offering->cancellation_time_slot;
        } elseif ($offering->offering_event_type === 'event' && $offering->event?->is_cancelled) {
            $beforeCanceled = $offering->event->cancellation_time_slot;
        }

        if ($beforeCanceled) {
            preg_match('/\d+/', $beforeCanceled, $matches);
            $beforeCanceledValue = isset($matches[0]) ? (int) $matches[0] : null;
        }

        // Calculate cutoff datetime example (48 hours before the event)
        $cutoff = $bookingDateTime->copy()->subHours($beforeCanceledValue);

        // Current time
        $now = Carbon::now();
        $isReschedule =  $now->greaterThanOrEqualTo($cutoff);
        dd($isReschedule);
        return view('user.view_booking', [
            'user' => $user,
            'booking' => $booking,
        ]);

    }

    public function userProfile()
    {
        $user = auth()->user();
        $bookings = Booking::with('offering.user')
            ->where(['user_id' => $user->id])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.profile', [
            'user' => $user,
            'bookings' => $bookings,
        ]);
    }

    public function userFavourites()
    {


    }

    public function userWallet()
    {

    }


}
