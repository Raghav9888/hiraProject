<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Certifications;
use App\Models\Community;
use App\Models\Country;
use App\Models\Discount;
use App\Models\Feedback;
use App\Models\GoogleAccount;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Locations;
use App\Models\Offering;
use App\Models\PractitionerTag;
use App\Models\Show;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use MailerLite\MailerLite;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
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
            ->get();
        $categories = Category::where('status', 1)->get();
        $defaultLocations = Locations::where('status', 1)->get();
        $blogs = Blog::latest()->get()->take(3);
        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }
        json_encode($locations);
        $offeringsData = Offering::where('offering_type', ['virtual', 'in_person'])
            ->with('event')
            ->with('user')
            ->get();
        $offerings = [];
        $now = now();
        foreach ($offeringsData as $offeringData) {
            if (isset($offeringData->event) && $offeringData?->event && $offeringData?->event?->date_and_time > $now) {
                $offerings[$offeringData->event->date_and_time] = $offeringData;
            }
        }
        $page = $request->get('page', 1);
        $communities = Community::where('status', 1)->get();
        $params = [
            'practitioners' => $users->take($page * 8),
            'categories' => $categories,
            'defaultLocations' => $locations,
            'blogs' => $blogs,
            'offerings' => $offerings,
            'communities' => $communities,
            'pendingResult' => ceil($users->count() / 8) > $page,
            'page' => $page,
        ];
        if ($request->isXmlHttpRequest() && $request->get('isPractitioner')) {
            return response()->json([
                'success' => true,
                'pendingResult' => ceil($users->count() / 8) > $page,
                'html' => view('user.practitioner_list_xml_request', $params)->render()
            ]);
        }
        return view('home', $params);
    }

    public function comingIndex()
    {
        return view('user.coming-soon');
    }

    public function subscribe(Request $request)
    {
        try {
            $email = $request->email;
            $groupId = env("MAILERLITE_GROUP_ID");
            $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);
            $data = [
                'email' => $email,
                "fields" => [
                    "name" => $email,
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

        foreach ($practitioners as $practitioner) {
            if (empty($practitioner->slug)) {
                $baseSlug = Str::slug($practitioner->name ?? 'user', ''); // Remove dashes
                $slug = $baseSlug;
                $counter = 2;

                // Ensure uniqueness
                while (User::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . $counter;
                    $counter++;
                }

                // Save the unique slug
                $practitioner->slug = $slug;
                $practitioner->save();
            }
        }

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

        // Determine which email to send to
        $email = $input['support_type'] === 'technical_support'
            ? 'technicalsupport@thehiracollective.com'
            : 'community@thehiracollective.com';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Support email is not configured correctly.');
        }

        // Send using default from (configured in .env: MAIL_FROM_ADDRESS)
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

    public function practitionerDetail(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $userDetail = $user->userDetail;
        //  $userDetails = UserDetail::where('user_id', $id)->first();
        $endorsements = $userDetail && $userDetail->endorsements ? json_decode($userDetail->endorsements, true) : [];
        $endorsedUsers = User::whereIn('id', $endorsements)->get();
        $selectedTerms = explode(',', $userDetail->IHelpWith ?? '');
        $IHelpWith = IHelpWith::whereIn('id', $selectedTerms)->pluck('name')->toArray();
        $defaultLocations = Locations::where('status', 1)->get();

        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }

        json_encode($locations);

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
        $dbLocations = Locations::get();
        $users = User::where('role', 1)->where('status', 1)->with('userDetail')->get();
        $categories = Category::where('status', 1)->get();
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
        $page = $request->get('page', 1);
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
            'locations' => $dbLocations,
            'users' => $users,
            'categories' => $categories,
            'storeAvailable' => $storeAvailable,
            'profileFeedback' => $profileFeedback->paginate(10),
            'averageProfileRating' => $averageProfileRating,
            'offeringFeedback' => $offeringFeedback,
            'ratings' => $ratings,
            'ratingPercentages' => $ratingPercentages,
            'defaultLocations' => $locations,
            'page' => $page,
            'pendingResult' => ceil($endorsedUsers->count() / 8) > $page,
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
        $category = $categoryType ?? $request->get('category');
        $offeringType = $request->get('searchType', 'virtual');
        $locationName = $request->get('location');
        $page = $request->get('page', 1);

        $userIds = collect();

        // 1. Search by name or userDetails (tags, help fields, etc.)
        if (!empty($search)) {
            // Search by name (first_name, last_name, full name)
            $userByName = User::where('role', 1)
                ->where('status', 1)
                ->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                })
                ->pluck('id');

            $userIds = $userIds->merge($userByName);

            // Search by related details (tags, howIHelp, certifications, etc.)
            $tagId = PractitionerTag::where('name', 'like', $search . '%')->value('id');
            $howIHelpId = HowIHelp::where('name', 'like', $search . '%')->value('id');
            $iHelpWithId = IHelpWith::where('name', 'like', $search . '%')->value('id');
            $certificationId = Certifications::where('name', 'like', $search . '%')->value('id');
            $locationId = Locations::where('name', 'like', $search . '%')->value('id');
            $categoryIdFromSearch = Category::where('name', 'like', '%' . $search . '%')->value('id');

            // If any related field found, merge user IDs
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

        // Remove duplicates and re-index
        $userIds = $userIds->unique()->values();

        // 2. Build the base query
        $query = User::where('role', 1)
            ->where('status', 1)
            ->with('userDetail')
            ->with('feedback');

        // If any users found by name or user details, apply filter
        if ($userIds->isNotEmpty()) {
            $query->whereIn('id', $userIds);
        }

        // 3. Category filter
        if (!empty($category)) {
            $formattedCategory = ucwords(str_replace('_', ' ', $category));
            $categoryId = Category::where('name', $formattedCategory)->value('id');

            if ($categoryId) {
                $query->whereHas('userDetail', function ($q) use ($categoryId) {
                    $q->whereJsonContains('specialities', (string)$categoryId);
                });
            }
        }

        // 4. Offering Type Filter
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

        // 5. Location Filter
        if (!empty($locationName)) {
            $locationId = Locations::where('name', $locationName)->value('id');
            if ($locationId) {
                $query->whereHas('userDetail', function ($q) use ($locationId) {
                    $q->whereJsonContains('location', (string)$locationId);
                });
            }
        }

        // 6. Get Offerings and Events Data
        $offeringsData = Offering::where('offering_type', $offeringType)
            ->with('event')
            ->with('user')
            ->get();

        $events = [];
        $now = now();
        foreach ($offeringsData as $offeringData) {
            if (isset($offeringData->event) && $offeringData->event && $offeringData->event->date_and_time > $now) {
                $events[$offeringData->event->date_and_time] = $offeringData;
            }
        }

        // Filter only practitioners' offerings
        $filterOfferingsData = $offeringsData->filter(function ($offeringData) {
            return $offeringData->user->role == 1;
        });

        // 7. Default Locations
        $defaultLocations = Locations::where('status', 1)->pluck('name', 'id');

        // 8. Build the response parameters
        $params = [
            'pendingResult' => ceil($query->count() / 8) > $page,
            'practitioners' => $query->take($page * 8)->get(),
            'search' => $search,
            'category' => $category,
            'defaultLocations' => $defaultLocations,
            'offerings' => $filterOfferingsData,
            'offeringEvents' => $events,
            'categories' => Category::where('status', 1)->get(),
            'page' => $page
        ];

        // 9. Return JSON for Ajax Request
        if ($request->isXmlHttpRequest() && $request->get('isPractitioner')) {
            return response()->json([
                'success' => true,
                'pendingResult' => ceil($query->count() / 8) > $page,
                'html' => view('user.practitioner_list_xml_request', $params)->render()
            ]);
        }

        // 10. Return the search page with results
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


    public function waitList(Request $request)
    {
        // Merge default empty strings for all nullable fields
        $request->merge([
            'first_name' => $request->input('first_name', ''),
            'last_name' => $request->input('last_name', ''),
            'business_name' => $request->input('business_name', ''),
            'phone' => $request->input('phone', ''),
            'website' => $request->input('website', ''),
            'current_practice' => $request->input('current_practice', ''),
            'heard_from' => $request->input('heard_from', []),
            'referral_name' => $request->input('referral_name', ''),
            'other_source' => $request->input('other_source', ''),
            'called_to_join' => $request->input('called_to_join', ''),
            'practice_values' => $request->input('practice_values', ''),
            'excitement_about_hira' => $request->input('excitement_about_hira', ''),
            'call_availability' => $request->input('call_availability', 'no'),
            'newsletter' => $request->input('newsletter', 'no'),
        ]);

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'current_practice' => 'nullable|string',
            'heard_from' => 'nullable|array',
            'referral_name' => 'nullable|string|max:255',
            'other_source' => 'nullable|string|max:255',
            'called_to_join' => 'nullable|string',
            'practice_values' => 'nullable|string',
            'excitement_about_hira' => 'nullable|string',
            'call_availability' => 'nullable|string|in:yes,no',
            'newsletter' => 'nullable|string|in:yes,no',
            'uploads.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi,doc,docx,pdf|max:20480',
        ]);


        $user = User::create([
            'name' => trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? '')),
            'first_name' => $validated['first_name'] ?? '',
            'last_name' => $validated['last_name'] ?? '',
            'email' => $validated['email'],
            'role' => 1,
            'status' => 2,
            'password' => Hash::make($validated['password']),
        ]);

        UserDetail::create(['user_id' => $user->id]);
        GoogleAccount::create(['user_id' => $user->id]);

        $uploadedFiles = [];

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/practitioners/' . $user->id . '/waitlist/'), $fileName);
                $uploadedFiles[] = $fileName;
            }
        }


        // Save to Waitlist
        Waitlist::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'business_name' => $validated['business_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'website' => $validated['website'] ?? null,
            'current_practice' => $validated['current_practice'] ?? null,
            'heard_from' => isset($validated['heard_from']) && $validated['heard_from'] ? json_encode($validated['heard_from']) : null,
            'referral_name' => $validated['referral_name'] ?? null,
            'other_source' => $validated['other_source'] ?? null,
            'called_to_join' => $validated['called_to_join'] ?? null,
            'practice_values' => $validated['practice_values'] ?? null,
            'excitement_about_hira' => $validated['excitement_about_hira'] ?? null,
            'call_availability' => $validated['call_availability'],
            'newsletter' => $validated['newsletter'] ?? null,
            'uploads' => $uploadedFiles ? json_encode($uploadedFiles) : null,
        ]);

        $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);

        $mailerLite->subscribers->create([
            'email' => $validated['email'],
            "fields" => [
                "name" => $validated['first_name'],
                "last_name" => $validated['last_name']
            ],
            'groups' => [
                env('MAILERLITE_PRACTITIONER_GROUP')
            ]
        ]);

        Auth::login($user);

        return $user;
    }

    public function updateslug()
    {
        // Users
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $baseSlug = Str::slug($user->first_name . '' . $user->last_name);
                $slug = $baseSlug;
                $count = 1;

                // Ensure user slug is unique
                while (\App\Models\User::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $user->slug = $slug;
                $user->save();

                if ($user->userDetail) {
                    $detailSlug = $slug; // start from the same slug

                    $user->userDetail->slug = $detailSlug;
                    $user->userDetail->save();
                }
            }
        });


        return response()->json(['message' => 'Slugs updated successfully']);
    }

    public function shows()
    {
        $allowedName = [
            'Daverine Jumu' => [
                ['name' => 'Inner Guidance Sessions and Oracle Readings', 'duration' => '30 minutes', 'price' => 40, 'description' => 'Mini Guidance Session'],
                ['name' => 'Inner Guidance Sessions and Oracle Readings', 'duration' => '60 minutes', 'price' => 80, 'description' => 'Mini Guidance Session w/ Energy Work'],
                ['name' => 'Inner Guidance Sessions and Oracle Readings', 'duration' => '20 minutes', 'price' => 25, 'description' => 'Mini Oracle Reading'],
            ],
            'Brigitta Ziemba' => [
                ['name' => 'Quantum Healing/CST', 'duration' => '30 minutes', 'price' => 60, 'description' => 'Mini CranioSacral Therap/Quantum Healing Sessions (nervous system resets)'],
            ],
            'Julie Brar' => null,
            'Maria Esposito' => [
                ['name' => 'Intuitive numerology reading', 'duration' => '20 minutes', 'price' => 42, 'description' => 'intuitive numerology reading'],
                ['name' => 'Intuitive numerology reading', 'duration' => '40 minutes', 'price' => 78, 'description' => 'intuitive numerology reading'],
                ['name' => 'Intuitive Numerology readings', 'duration' => '60 minutes', 'price' => 117, 'description' => 'intuitive numerology reading'],
            ],
            'Anna i. Azucena' => null,
            'Shelley King' => [
                ['name' => 'Readings (Tarot, Lenormand, Crystal)', 'duration' => '20 minutes', 'price' => 40, 'description' => 'Reading'],
            ],
            'Lauren Welchner' => [
                ['name' => 'Mini tarot readings', 'duration' => '15 minutes', 'price' => 30, 'description' => 'Mini tarot readings'],
                ['name' => 'Mini tarot readings', 'duration' => '30 minutes', 'price' => 55, 'description' => 'Mini tarot readings'],
            ],
            'Jothi Saldanha' => [
                ['name' => 'Somatic wellness sessions', 'duration' => '15 minutes', 'price' => 30, 'description' => 'Mini Somatic Touch, Movement, and Breathwork Session'],
            ],
            'Isabel Nantaba' => [
                ['name' => 'Mini energy shift sessions', 'duration' => '20 minutes', 'price' => 55, 'description' => 'Energy Healing Session'],
            ],
            'Janine Berridge-Paul' => [
                ['name' => 'Mini reiki session (will include a crystal)', 'duration' => '20 minutes', 'price' => 55, 'description' => 'Mini reiki session'],
            ],
            'Melissa Charles' => [
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '5 minutes', 'price' => 15, 'description' => 'Mini Tarot Sessions and Bone Diviniation'],
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '15 minutes', 'price' => 50, 'description' => 'General or Specific Question'],
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '15 minutes', 'price' => 30, 'description' => 'Bone/Charm Divination '],
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '1 hour', 'price' => 80, 'description' => 'Deep-Dive'],
            ],
            'Malavika' => null,
            'Biohacking' => null,
            'Intuitive' => null,
        ];

        $users = User::all();

        // Filter users who are in the allowedName list
        $practitionersWithShows = $users->filter(function ($user) use ($allowedName) {
            return array_key_exists($user->name, $allowedName);
        })->values(); // Reset keys

        // Create shows only if not already created
        foreach ($practitionersWithShows as $user) {
            $existing = Show::where('user_id', $user->id)->exists();
            if ($existing || empty($allowedName[$user->name])) {
                continue;
            }

            foreach ($allowedName[$user->name] as $entry) {
                Show::create([
                    'user_id' => $user->id,
                    'name' => $entry['name'],
                    'duration' => $entry['duration'],
                    'price' => $entry['price'],
                    'description' => $entry['description'],
                    'tax' => 13,
                    'show_type' => 'offering', // <-- Important fix
                ]);
            }
        }

        // Now attach shows to each user
        $practitionersWithShows = $practitionersWithShows->map(function ($user) {
            $user->shows_offering = Show::where('user_id', $user->id)
                ->where('show_type', 'offering')
                ->get();

            $user->shows_product = Show::where('user_id', $user->id)
                ->where('show_type', 'product')
                ->get();

            return $user;
        });

        $defaultLocations = Locations::where('status', 1)->pluck('name', 'id');

        return view('user.shows', [
            'showsOffering' => $practitionersWithShows,
            'showsProduct' => $practitionersWithShows,
            'defaultLocations' => $defaultLocations,
        ]);
    }




    public function showBooking(Request $request)
    {
        $user = Auth::user() ?? null;
        $request->validate([
            'showId' => 'required',
            'price' => 'required|string|numeric',
            'currency' => 'required|string',
            'currencySymbol' => 'required|string',
            'timezone' => 'required|string',
            'booking_user_timezone' => 'required|string',
            'practitioner_id' => 'required|integer',
        ]);
        $todayDate = Carbon::now()->toDateString();
        $todayTime = Carbon::now()->format('H:i');
        session([
            'booking' => [
                'show_id' => $request->showId,
                'price' => $request->price,
                'currency' => $request->currency,
                'currency_symbol' => $request->currencySymbol,
                'booking_date' => $todayDate,
                'booking_time' => $todayTime,
                'isShow' => true,
                'practitioner_id' => $request->practitioner_id,
                'practitioner_timezone' => $request->timezone,
                'booking_user_timezone' => $request->booking_user_timezone,
            ]
        ]);

        $id = $request->get('showId');
        $show = Show::where('id',$id)->with(['user'])->first();

        $defaultLocations = Locations::where('status', 1)->pluck('name', 'id');
        $countries = Country::all();
        return response()->json([
            "success" => true,
            "data" => "Booking saved in session!",
            'html' => view('user.show-billing-popup', [
                'user' => $user,
                'show' => $show,
                'defaultLocations' => $defaultLocations,
                'countries' => $countries,
                'currency' => $request->get('currency'),
                'price' => $request->get('price'),
                'currencySymbol' => $request->get('currencySymbol')
            ])->render()
        ]);
    }


}
