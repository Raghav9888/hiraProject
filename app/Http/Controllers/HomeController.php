<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Offering;
use App\Models\Booking;
use App\Models\IHelpWith;
use App\Models\HowIHelp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $users = User::where('role', 1)->with('userDetail')->get()->take(8);
        $categories = Category::all();
        $defaultLocations = Locations::get();
        $blogs = Blog::latest()->get()->take(3);
        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }
        json_encode($locations);
        $offeringsData = Offering::all();

        $offerings = [];
        $now = now();
        foreach ($offeringsData as $offeringData) {
            if (isset($offeringData->event) && $offeringData?->event && $offeringData?->event?->date_and_time > $now) {
                $offerings[$offeringData->event->date_and_time] = $offeringData;
            }
        }

        return view('home', [
            'users' => $users,
            'categories' => $categories,
            'defaultLocations' => $locations,
            'blogs' => $blogs,
            'offerings' => $offerings
        ]);
    }

    public function partitionerLists()
    {
        $users = User::where('role', 1)->with('userDetail')->get();
        $categories = Category::all();

        return view('user.practitioner_list', compact('users', 'categories'));
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
        $blogs = Blog::latest()->get();
        return view('user.blog', compact('blogs'));
    }

    public function blogDetail($slug)
    {
        $blog = Blog::where("slug", $slug)->firstOrFail();
        return view('user.blog_detail', compact('blog'));
    }

    public function practitionerDetail($id)
    {
        $user = User::findOrFail($id);
        $userDetail = $user->userDetail;
        //  $userDetails = UserDetail::where('user_id', $id)->first();
        $endorsements = $userDetail && $userDetail->endorsements
            ? json_decode($userDetail->endorsements, true)
            : [];
        $endorsedUsers = User::whereIn('id', $endorsements)->get();
        $selectedTerms = explode(',', $userDetail->IHelpWith ?? '');
        $IHelpWith = IHelpWith::whereIn('id', $selectedTerms)->pluck('name')->toArray();


        $selectedHowIHelp = explode(',', $userDetail->HowIHelp ?? '');
        $HowIHelp = HowIHelp::whereIn('id', $selectedHowIHelp)->pluck('name')->toArray();

        $Certification = explode(',', $userDetail->certifications ?? '');
        $Certifications = HowIHelp::whereIn('id', $Certification)->pluck('name')->toArray();


        $offerings = Offering::where('user_id', $user->id)->get();

        $images = json_decode($userDetail->images, true);
        $image = isset($images['profile_image']) ? $images['profile_image'] : null;
        $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];

        $userLocations = json_decode($user->location, true);
        $locations = Locations::get();
        $users = User::where('role', 1)->with('userDetail')->get();
        $categories = Category::get();
        $storeAvailable = $userDetail?->store_availabilities ? $userDetail->store_availabilities : [];
        return view('user.practitioner_detail', [
            'user' => $user,
            'userDetail' => $userDetail,
            'endorsedUsers' => $endorsedUsers,
            'IHelpWith' => $IHelpWith,
            'HowIHelp' => $HowIHelp,
            'Certifications' => $Certifications,
            'offerings' => $offerings,
            'image' => $image,
            'mediaImages' => $mediaImages,
            'userLocations' => $userLocations,
            'locations' => $locations,
            'users' => $users,
            'categories' => $categories,
            'storeAvailable' => $storeAvailable
        ]);
    }

    public function practitionerOfferingDetail($id)
    {
        $offeringDetail = Offering::findOrFail($id);
        $user = $offeringDetail->user;
        return view('user.offering_detail', compact('offeringDetail', 'user'));
    }

    public function checkout()
    {
        // $offerDetail = Offering::findOrFail($id);

        return view('checkout');
    }

    public function getTimeSlots(Request $request, $date, $id)
    {
        $timeSlots = [];

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
        $type = $request->input('practitionerType');
        $location = $request->input('location');
        $buttonHitCount = $request->input('count') ?? 1;

        $query = User::where('role', 1)->with('userDetail'); // Eager load userDetail relation

        if (isset($search) && $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        if (isset($category) && $category) {
            $query->whereHas('userDetail', function ($query) use ($category) {
                $query->where('specialities', 'like', '%' . $category . '%');
            });
        }

        if (isset($location) && $location) {
            $query->whereHas('userDetail', function ($query) use ($location) {
                $query->where('location', 'like', '%' . $location . '%');
            });
        }

        $practitioners = $query->get()->take($buttonHitCount * 8);

        return response()->json([
            'practitioners' => $practitioners,
            'search' => $search,
            'category' => $category,
            'location' => $location
        ]);
    }


    public function acknowledgement()
    {
        return view('user.acknowledgement');
    }

    public function addEndorsement(Request $request, $id)
    {
        // Find the UserDetail entry for the given user ID
        $user = Auth::user();
        $user_id = $user->id;
        $userDetail = UserDetail::where('user_id', $user_id)->first();

        // Check if user detail exists
        if (!$userDetail) {
            return response()->json(['error' => 'User detail not found'], 404);
        }

        // Decode existing endorsements (empty array if null or invalid)
        $endorsements = json_decode($userDetail->endorsements, true);
        if (!is_array($endorsements)) {
            $endorsements = [];
        }

        // Add the new endorsement
        $endorsements[] = $id;

        // Save the updated endorsements back to the user detail
        $userDetail->endorsements = json_encode($endorsements);
        if ($userDetail->save()) {
            return response()->json(['success' => 'Endorsement added successfully', 'userDetail' => $userDetail]);
        } else {
            return response()->json(['error' => 'Failed to save endorsement'], 500);
        }
    }


    public function pendingUser()
    {
        $user = Auth::user();

        if ($user->status != 2) {
            return redirect()->route('home');
        }

        return view('user.pending_user', [
            'user' => $user
        ]);
    }


}
