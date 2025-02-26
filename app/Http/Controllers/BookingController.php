<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Offering;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class BookingController extends Controller
{

    public function storeBooking(Request $request)
    {       
        $request->validate([
            'product_id' => 'required|exists:offerings,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required'
        ]);

        session([
            'booking' => [
                'product_id' => $request->product_id,
                'booking_date' => $request->booking_date,
                'booking_time' => $request->booking_time,
            ]
        ]);

        

        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect()->route('home')->with('error', 'No booking details found.');
        }

        $product = Offering::findOrFail($booking['product_id']);
        

        return view('checkout', compact('booking', 'product'));
    }


}