<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certifications;
use App\Models\Community;
use App\Models\Feedback;
use App\Models\Locations;
use App\Models\PractitionerTag;
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
use MailerLite\MailerLite;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $foundingPlans = [
            'Founding Members T1',
            'Founding Membership - 10 years',
            'Founding Members T2',
            'Diamond Pre-Launch Membership'
        ];
        $users = User::where('role', 1)
            ->where('status', 1)
            ->whereHas('cusSubscription', function ($query) use ($foundingPlans) {
                $query->whereHas('plan', function ($planQuery) use ($foundingPlans) {
                    $planQuery->whereIn('name', $foundingPlans);
                });
            })
            ->with('userDetail')
            ->get()->take(8);
        $categories = Category::where('status', 1)->get();
        $defaultLocations = Locations::where('status', 1)->get();
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

        $communities = Community::where('status', 1)->get();

        return view('home', [
            'users' => $users,
            'categories' => $categories,
            'defaultLocations' => $locations,
            'blogs' => $blogs,
            'offerings' => $offerings,
            'communities' => $communities
        ]);
    }

    public function comingIndex()
    {
        return view('user.coming-soon');
    }

    public function subscribe(Request $request)
    {
        try {
            $email = $request->email;
            $fName = $request->first_name;
            $groupId = env("MAILERLITE_GROUP_ID");
            $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);
            $data = [
                'email' => $email,
                "fields" => [
                    "name" => $fName,
                ],
                "groups" => [$groupId],
            ];
            $mailerLite->subscribers->create($data);
            return response()->json([
                "success" => true,
                "data" => "Subscribes successfully!"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "data" => $th->getMessage()
            ], 500);
        }
    }

    public function partitionerLists()
    {
        $practitioners = User::where('role', 1)->where('status', 1)->with('userDetail')->get();
        $categories = Category::where('status', 1)->get();
        $defaultLocations = Locations::where('status', 1)->get();
        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }
        json_encode($locations);
        return view('user.practitioners', [
            'pendingResult' => 0,
            'practitioners' => $practitioners,
            'categories' => $categories,
            'defaultLocations' => $locations
        ]);
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

        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('recaptcha_token'),
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $recaptchaResponse->json();

        if (!($recaptchaData['success'] ?? false) || ($recaptchaData['score'] ?? 0) < 0.5) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.'])->withInput();
        }

        // Get the email from .env, fallback to a default email if missing
        $email = $input['support_type'] === 'technical_support'
            ? env('TECHNICAL_SUPPORT_EMAIL', 'default_support@example.com')
            : env('BOOKING_SUPPORT_EMAIL', 'default_booking@example.com');

        // Check if the email is valid before sending
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Support email is not configured correctly.');
        }

        // Send email
        Mail::to($email)->send(new ContactUsMail($contactData));

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
        $endorsements = $userDetail && $userDetail->endorsements ? json_decode($userDetail->endorsements, true) : [];
        $endorsedUsers = User::whereIn('id', $endorsements)->get();
        $selectedTerms = explode(',', $userDetail->IHelpWith ?? '');
        $IHelpWith = IHelpWith::whereIn('id', $selectedTerms)->pluck('name')->toArray();


        $selectedHowIHelp = explode(',', $userDetail->HowIHelp ?? '');
        $HowIHelp = HowIHelp::whereIn('id', $selectedHowIHelp)->pluck('name')->toArray();

        $Certification = explode(',', $userDetail->certifications ?? '');
        $Certifications = Certifications::whereIn('id', $Certification)->pluck('name')->toArray();


        $offerings = Offering::where('user_id', $user->id)->get();
        $offeringIds = $offerings->pluck('id')->toArray();

        $profileFeedback = Feedback::where('practitioner_id', $user->id)
            ->where('feedback_type', 'practitioner');

        $averageProfileRating = $profileFeedback->get()->isNotEmpty() ? number_format($profileFeedback->get()->pluck('rating')->avg(), 1) : '0.0';

        $offeringFeedback = Feedback::where('practitioner_id', $user->id)
            ->where('feedback_type', 'offering')
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        $images = json_decode($userDetail->images, true);
        $image = isset($images['profile_image']) ? $images['profile_image'] : null;
        $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];

        $userLocations = json_decode($user->location, true);
        $locations = Locations::get();
        $users = User::where('role', 1)->where('status', 1)->with('userDetail')->get();
        $categories = Category::get();
        $storeAvailable = $userDetail?->store_availabilities ? $userDetail->store_availabilities : [];

        $ratingCounts = $profileFeedback->get()->groupBy('rating')->map->count();

        $totalReviews = $profileFeedback->get()->count();

        $ratings = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];

        foreach ($ratingCounts as $rating => $count) {
            $ratings[$rating] = $count;
        }

        $ratingPercentages = [];
        foreach ($ratings as $star => $count) {
            $ratingPercentages[$star] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }

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
            'storeAvailable' => $storeAvailable,
            'profileFeedback' => $profileFeedback->paginate(10),
            'averageProfileRating' => $averageProfileRating,
            'offeringFeedback' => $offeringFeedback,
            'ratings' => $ratings,
            'ratingPercentages' => $ratingPercentages,
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

    public function searchPractitioner(Request $request, ?string $categoryType = null)
    {
        $search = $request->get('search');
        $searchPractitioner = $request->get('searchPractitioner');
        $category = $categoryType ?? $request->get('category');
        $offeringType = $request->get('searchType');
        $locationName = $request->get('location');
        $page = $request->get('page', 1);

        $userIds = collect();

        // 1. Search by name
        if (!empty($search)) {
            $userByName = User::where('role', 1)
                ->where('status', 1)
                ->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                })
                ->pluck('id');

            $userIds = $userIds->merge($userByName);
        }

        // 2. Search in userDetails (tags, help fields, etc.)
        if (!empty($search)) {
            $tagId = PractitionerTag::where('name', 'like', $search . '%')->value('id');
            $howIHelpId = HowIHelp::where('name', 'like', $search . '%')->value('id');
            $iHelpWithId = IHelpWith::where('name', 'like', $search . '%')->value('id');
            $certificationId = Certifications::where('name', 'like', $search . '%')->value('id');
            $locationId = Locations::where('name', 'like', $search . '%')->value('id');
            $categoryIdFromSearch = Category::where('name', 'like', '%' . $search . '%')->value('id');

            if ($tagId || $howIHelpId || $iHelpWithId || $certificationId || $locationId || $categoryIdFromSearch) {
                $userByDetails = UserDetail::where(function ($q) use ($tagId, $howIHelpId, $iHelpWithId, $certificationId, $locationId, $categoryIdFromSearch) {
                    if ($tagId) $q->orWhereJsonContains('tags', (string)$tagId);
                    if ($howIHelpId) $q->orWhereJsonContains('HowIHelp', (string)$howIHelpId);
                    if ($iHelpWithId) $q->orWhereJsonContains('IHelpWith', (string)$iHelpWithId);
                    if ($certificationId) $q->orWhereJsonContains('certifications', (string)$certificationId);
                    if ($locationId) $q->orWhereJsonContains('location', (string)$locationId);
                    if ($categoryIdFromSearch) $q->orWhereJsonContains('specialities', (string)$categoryIdFromSearch);
                })->pluck('user_id');

                $userIds = $userIds->merge($userByDetails);
            }
        }

        $userIds = $userIds->unique()->values();

        // 3. Build the base query
        $query = User::where('role', 1)
            ->where('status', 1)
            ->with('userDetail')
            ->with('feedback');


        if ($userIds->isNotEmpty()) {
            $query->whereIn('id', $userIds);
        }

        // 4. Category filter (dropdown or route param)
        if (!empty($category)) {
            $formattedCategory = ucwords(str_replace('_', ' ', $category));

            $categoryId = Category::where('name', $formattedCategory)->value('id');

            if (!empty($categoryId)) {
                $query->whereHas('userDetail', function ($q) use ($categoryId) {
                    $q->whereJsonContains('specialities', (string)$categoryId);
                });
            }
        }

//         5. Practitioner type filter (from dropdown)
        if (!empty($offeringType)) {

            $types = match ($offeringType) {
                'both' => ['in_person', 'virtual'],
                default => [$offeringType]
            };
            $query->whereHas('offerings', function ($q) use ($types) {
                foreach ($types as $type) {
                    $q->orWhere('offering_type', 'like', '%' . $type . '%');
                }
            });
        }

//         6. Location filter (from dropdown)
        if (!empty($locationName)) {
            $locationId = Locations::where('name', $locationName)->value('id');

            if ($locationId) {
                $query->whereHas('userDetail', function ($q) use ($locationId) {
                    $q->whereJsonContains('location', (string)$locationId);
                });
            }

        }


        // 7. Default Locations
        $defaultLocations = Locations::where('status', 1)->pluck('name', 'id');

        // 8. Offerings (for showing event matches)
        $offeringsData = Offering::where('offering_type', $offeringType)
            ->with('event')
            ->get();

        $events = [];
        $now = now();
        foreach ($offeringsData as $offeringData) {
            if ($offeringData->event && $offeringData->event->date_and_time > $now) {
                $events[$offeringData->event->date_and_time] = $offeringData;
            }
        }
        $blogs = Blog::latest()->get();
        // 9. Build final params
        $params = [
            'pendingResult' => ceil($query->count() / 8) > $page,
            'practitioners' => $query->take($page * 8)->get(),
            'search' => $search,
            'category' => $category,
//            'location' => $location,
            'defaultLocations' => $defaultLocations,
            'offerings' => $offeringsData,
            'offeringEvents' => $events,
            'categories' => Category::where('status', 1)->get(),
            'page' => $page
        ];

//        if (!empty($searchPractitioner)) {
//            $users = User::where('role', 1)
//                ->where('status', 1)
//                ->where(function ($q) use ($searchPractitioner) {
//                    $q->where('name', 'like', '%' . $searchPractitioner . '%')
//                        ->orWhere('first_name', 'like', '%' . $searchPractitioner . '%')
//                        ->orWhere('last_name', 'like', '%' . $searchPractitioner . '%');
//                })
//                ->get();
//
//            return response()->json([
//                'success' => true,
//                'pendingResult' => ceil($users->count() / 8) > $page,
//                'html' => view('user.practitioner_list_xml_request', [
//                    'practitioners' => $users,
//                    'search' => $search,
//                    'category' => $category,
//                    'defaultLocations' => $defaultLocations,
//                    'offerings' => $offeringsData,
//                    'offeringEvents' => $events,
//                    'categories' => Category::where('status', 1)->get(),
//                    'page' => $page
//                ])->render()
//            ]);
//        }



        if ($request->isXmlHttpRequest() && $request->get('isPractitioner')) {
            return response()->json([
                'success' => true,
                'pendingResult' => ceil($query->count() / 8) > $page,
                'html' => view('user.practitioner_list_xml_request', $params)->render()
            ]);
        }

        return view('user.search_page', $params);
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

    public function getEvent(Request $request)
    {
        $userId = $request->get('userId');

        $offeringId = $request->get('offeringId');
        $currency = $request->get('currency');
        $price = $request->get('price');
        $user = User::findOrFail($userId);
        $userDetail = $user->userDetail;
        $offering = Offering::where('id', $offeringId)->with('event')->first();

        return response()->json([
            "success" => true,
            "data" => "Booking saved in session!",
            'html' => view('user.event_detail_popup', [
                'user' => $user,
                'userDetail' => $userDetail,
                'offering' => $offering,
                'currency' => $currency,
                'price' => $price
            ])->render()
        ]);

    }

    public function privacyPolicy()
    {

        return view('user.privacy_policy');

    }

    public function termsConditions()
    {
        return view('user.terms_conditions');
    }

    public function ourStory()
    {
        return view('user.our_story');
    }

    public function ourVision()
    {
        return view('user.our_vision');
    }

    public function coreValues()
    {
        return view('user.core_values');
    }

    public function newsLetter(Request $request)
    {
        $name = $request->get('name') ?? '';
        $email = $request->get('email') ?? '';
        $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);
        $data = [
            'email' => $email,
            "fields" => [
                "name" => $name,
            ],
            'groups' => [
                env('MAILERLITE_GENERAL_GROUP')
            ]
        ];
        $m = $mailerLite->subscribers->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscribed successfully',
            'data' => [
                'name' => $name,
                'email' => $email
            ],
        ]);

    }


}
