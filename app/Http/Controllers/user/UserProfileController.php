<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Request;

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
        $recentBookings = Booking::where('user_id', $user->id)
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
        $bookings = Booking::where('user_id', $user->id)
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


    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();
        $userDetail = $user->userDetail;

        $validatedData = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => ['required', 'email', Rule::unique('user_details')->ignore($userDetail->id)],
            'phone'           => 'nullable|string|max:20',
            'bio'             => 'nullable|string|max:1000',
            'address_line_1'  => 'nullable|string|max:255',
            'address_line_2'  => 'nullable|string|max:255',
            'postcode'            => 'nullable|string|max:100',
            'city'            => 'nullable|string|max:100',
            'state'           => 'nullable|string|max:100',
            'country'         => 'nullable|string|max:100',
        ]);

        // Update user table
        $user->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'] ?? null,
            'last_name' => $validatedData['last_name'],
        ]);

        // Update user_details table
        $userDetail->update([
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'bio' => $validatedData['bio'] ?? null,
            'address_line_1' => $validatedData['address_line_1'] ?? null,
            'address_line_2' => $validatedData['address_line_2'] ?? null,
            'postcode' => $validatedData['postcode'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'state' => $validatedData['state'] ?? null,
            'country' => $validatedData['country'] ?? null,
        ]);

        return redirect()->route('userProfile')->with('success', 'Profile updated successfully!');
    }


    public function userFavourites()
    {


    }

    public function userWallet()
    {

    }


}
