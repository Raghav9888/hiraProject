<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Offering;
use App\Models\Booking;
use App\Models\IHelpWith;
use App\Models\HowIHelp;
use App\Models\Certifications;
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
        $categories = Category::all();

        return view('home', compact('users', 'categories'));
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

        $selectedTerms = explode(',', $userDetails->IHelpWith ?? '');
        $IHelpWith = IHelpWith::whereIn('id', $selectedTerms)->pluck('name')->toArray();


        $selectedHowIHelp = explode(',', $userDetails->HowIHelp ?? '');
        $HowIHelp = HowIHelp::whereIn('id', $selectedHowIHelp)->pluck('name')->toArray();

        $Certification = explode(',', $userDetails->certifications ?? '');
        $Certifications = HowIHelp::whereIn('id', $Certification)->pluck('name')->toArray();


        $offerings = Offering::where('user_id', $user->id)->get();

        $images = json_decode($userDetails->images, true);
        $image = isset($images['profile_image']) ? $images['profile_image'] : null;
        $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];

        $locations = json_decode($user->location, true);
        $users = User::where('role', 1)->with('userDetail')->get();
        return view('user.practitioner_detail', compact('user', 'users', 'userDetails', 'offerings', 'image', 'mediaImages', 'locations', 'IHelpWith', 'HowIHelp', 'Certifications'));
    }

    public function offerDetail($id)
    {
        $user = User::findOrFail($id);
        $userDetails = $user->userDetail;
        $offerDetail = Offering::findOrFail($id);

        return view('user.offering_detail', compact('user', 'userDetails', 'offerDetail'));
    }

    public function checkout()
    {
        // $offerDetail = Offering::findOrFail($id);

        return view('checkout');
    }

    public function getTimeSlots(Request $request, $date, $id)
    {
        $timeSlots = [];
        $date = date('Y-m-d', strtotime($date));

        $offering = Offering::find($id);

        // Check if offering exists
        if (!$offering) {
            return response()->json(['error' => 'Offering not found'], 404);
        }

        // Ensure dates are valid
        if (empty($offering->from_date) || empty($offering->to_date)) {
            return response()->json(['error' => 'Invalid date range'], 400);
        }

        // Convert dates to timestamps
        $startTime = strtotime($offering->from_date);
        $endTime = strtotime($offering->to_date);

        if (!$startTime || !$endTime) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        // Validate booking duration
        $bookingDuration = is_numeric($offering->booking_duration) ? (int)$offering->booking_duration : 60;

        $allSlots = [];
        while ($startTime < $endTime) {
            $slot = date('h:i A', $startTime);
            $allSlots[] = $slot;
            $startTime += $bookingDuration * 60;
        }

        // Get booked slots
        $bookedSlots = Booking::where('offering_id', $id)
            ->whereDate('booking_date', $date)
            ->pluck('time_slot')
            ->toArray();

        // Get available slots
        $availableSlots = array_diff($allSlots, $bookedSlots);

        return response()->json(['availableSlots' => $availableSlots]);
    }

    public function searchPractitioner(Request $request)
    {

        $search = $request->input('search');
        $category = $request->input('category');
        $location = $request->input('location');

        $users = User::query();

        if ($search) {
            $users->where(function($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        $users = $users->join('user_details', 'users.id', '=', 'user_details.user_id');


        if ($category) {
            $users->where('user_details.specialities', 'like', '%' . $category . '%');
        }

        if ($location) {
            $users->where('user_details.location', 'like', '%' . $location . '%');
        }

        $practitioners = $users->select('users.*', 'user_details.*')->get();

        return response()->json([
            'practitioners' => $practitioners,
            'search' => $search,
            'category' => $category,
            'location' => $location
        ]);
    }


}
