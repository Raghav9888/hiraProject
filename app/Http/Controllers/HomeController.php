<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Offering;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $users = User::where('role', 1)->with('userDetail')->get();
        return view('home', compact('users'));
    }

    public function adminHome()
    {
        return view('admin.dashboard');
    }


    public function contact()
    {

        return view('contact');
    }


    public function sendContactMail(Request $request)
    {
        $input = $request->all();
        $contactData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        // Send email to admin
        Mail::to('joshiraghav282@gmail.com')->send(new ContactUsMail($contactData));

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function blog()
    {
        return view('user.blog');
    }
    public function blogDetail()
    {
        return view('user.blog_detail');
    }

    public function practitionerDetail($id)
    {
        $user = User::findOrFail($id);
        $userDetails = $user->userDetail;
      //  $userDetails = UserDetail::where('user_id', $id)->first();

        $offerings = Offering::where('user_id', $user->id)->get();

        $images = json_decode($userDetails->images, true);
        $image = isset($images['profile_image']) ? $images['profile_image'] : null;
        $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];

        $locations = json_decode($user->location, true);
        $users = User::where('role', 1)->with('userDetail')->get();
        return view('user.practitioner_detail', compact('user','users', 'userDetails', 'offerings','image','mediaImages','locations'));
    }

    public function offerDetail($id)
    {
        $offerDetail = Offering::findOrFail($id);

        return view('user.offering_detail', compact('offerDetail'));
    }

    public function checkout()
    {
       // $offerDetail = Offering::findOrFail($id);

        return view('checkout');
    }
    public function getTimeSlots(Request $request ,$date)
    {
        $timeSlots = [];
        $date = date('Y-m-d', strtotime($date));


    }
}
