<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Certifications;
use App\Models\Event;
use App\Models\GoogleAccount;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Locations;
use App\Models\Membership;
use App\Models\MembershipModality;
use App\Models\Offering;
use App\Models\Plan;
use App\Models\PractitionerTag;
use App\Models\Show;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserStripeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PractitionerController extends Controller
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
    public function index()
    {
        $user = Auth::user();

        $userDetails = $user->userDetail;
        if (!$userDetails) {
            $userDetails = new UserDetail();
            $userDetails->user_id = $user->id;
            $userDetails->save();
        }
        $categories = Category::where('status', 1)->get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $certifications = Certifications::get();
        $stripeAccount = UserStripeSetting::where('user_id', Auth::id())->first();
        $googleAccount = GoogleAccount::where('user_id', Auth::id())->first();
        $images = isset($userDetails->images) && $userDetails->images ? json_decode($userDetails->images, true) : null;
        $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];
        $image = isset($images['profile_image']) ? $images['profile_image'] : null;
        $userLocations = json_decode($userDetails->location, true);
        $locations = Locations::get();
        $tags = json_decode($userDetails->tags, true);
        $users = User::where('role', 1)->where('status', 1)->with('userDetail')->get();

        $allowedOffsets = [
            "UTC-8", "UTC-7", "UTC-6", "UTC-5", "UTC-4", "UTC-3:30"
        ];

        $timezones = [];

        foreach (timezone_identifiers_list() as $timezone) {
            $dateTimeZone = new \DateTimeZone($timezone);
            $offset = $dateTimeZone->getOffset(new \DateTime("now", new \DateTimeZone("UTC"))) / 3600;
            $offsetFormatted = "UTC" . ($offset == 0 ? "" : ($offset > 0 ? "+$offset" : $offset));

            if (in_array($offsetFormatted, $allowedOffsets)) {
                $parts = explode("/", $timezone);
                $countryName = end($parts);

                // Format the timezone data
                $timezones[] = [
                    'id' => $timezone,
                    'name' => "($offsetFormatted) $countryName",
                ];
            }
        }


        return view('practitioner.my_profile', compact(
            'user',
            'users',
            'userDetails',
            'categories',
            'practitionerTag',
            'IHelpWith',
            'HowIHelp',
            'certifications',
            'stripeAccount',
            'googleAccount',
            'mediaImages',
            'locations',
            'userLocations',
            'tags',
            'image',
            'timezones'
        ));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $defaultLocations = Locations::where('status', 1)->get();
        $users = User::get();
        $endorsements = $userDetails && $userDetails->endorsements
            ? json_decode($userDetails->endorsements, true)
            : [];

        $endorsedUsers = User::whereIn('id', $endorsements)->get();

        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }
        json_encode($locations);

        $offeringsData = Offering::where('user_id', $user->id)->get();

        $offerings = [];
        $now = now();
        foreach ($offeringsData as $offeringData) {
            if (isset($offeringData->event) && $offeringData?->event && $offeringData?->event?->date_and_time > $now) {
                $offerings[$offeringData->event->date_and_time] = $offeringData;
            }
        }


        return view('practitioner.dashboard', [
            'user' => $user,
            'users' => $users,
            'userDetails' => $userDetails,
            'defaultLocations' => $locations,
            'endorsedUsers' => $endorsedUsers,
            'offerings' => $offerings
        ]);
    }

    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
//        if (!$user) {
//            return redirect()->back()->with('error', 'User not found');
//        }

        $user = User::find($id); // Find the user with ID 1
        $user->name = ($input['first_name'] . ' ' . $input['last_name']);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        // $user->company = $input['company'];
        $user->bio = $input['bio'];
        $user->location = isset($input['location']) && $input['location'] ? json_encode($input['location']) : [];
        $user->save();
        $userDetails = $user->userDetail;

        $details = [
            'company' => $input['company'],
            'bio' => $input['bio'],
            'location' => isset($input['location']) && $input['location'] ? $input['location'] : [],
            'tags' => isset($input['tags']) && $input['tags'] ? $input['tags'] : [],
            // 'about_me' => $input['about_me'],
            'IHelpWith' => isset($input['IHelpWith']) && $input ? implode(',', $input['IHelpWith']) : [],
            'HowIHelp' => isset($input['HowIHelp']) && $input ? implode(',', $input['HowIHelp']) : [],
            'specialities' => isset($input['specialities']) && $input['specialities'] ? $input['specialities'] : [],
            'certifications' => isset($input['certifications']) && $input ? implode(',', $input['certifications']) : [],
            'timezone' => $input['timezone'],
            'is_opening_hours' => isset($input['is_opening_hours']) && $input['is_opening_hours'] == 'on' ? 1 : 0,
            'is_notice' => isset($input['is_notice']) && $input['is_notice'] == 'on' ? 1 : 0,
            'is_google_analytics' => isset($input['is_google_analytics']) && $input['is_google_analytics'] == 'on' ? 1 : 0,
            'amenities' => isset($input['amenities']) && count($input['amenities']) > 0 ? json_encode($input['amenities']) : null,
            'store_availabilities' => isset($input['store_availabilities']) && count($input['store_availabilities']) > 0 ? json_encode($input['store_availabilities']) : null
        ];

        if ($request->hasFile('media_images') || $request->hasFile('image')) {
            // Initialize existing images
            $existingImages = $userDetails->images ? json_decode($userDetails->images, true) : [];

            // Ensure 'media_images' and 'profile_image' keys exist
            if (!isset($existingImages['media_images'])) {
                $existingImages['media_images'] = [];
            }

            // Handle media images upload
            if ($request->hasFile('media_images')) {
                $images = $request->file('media_images');

                // Ensure $images is an array
                if (!is_array($images)) {
                    $images = [$images];
                }

                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $fileName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('uploads/practitioners/' . $userDetails->id . '/media/'), $fileName);
                        $existingImages['media_images'][] = $fileName;
                    }
                }
            }

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($image->isValid()) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/practitioners/' . $userDetails->id . '/profile/'), $fileName);
                    $existingImages['profile_image'] = $fileName; // Store profile image
                }
            }

            // Store updated images in the database
            $details['images'] = json_encode($existingImages);
        }

        UserDetail::where('user_id', $id)->update($details);
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function discount()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('practitioner.discount', compact('user', 'userDetails'));
    }

    public function appointment()
    {
        $user = Auth::user();

        // Get all offering IDs for the logged-in user
        $offeringIds = Offering::where('user_id', $user->id)->pluck('id');

        // Get all bookings for those offerings in a single query
        $bookings = Booking::whereIn('offering_id', $offeringIds)->get();

        return view('practitioner.appointment', [
            'user' => $user,
            'userDetails' => $user->userDetail,
            'appointments' => $bookings,
        ]);
    }



    public function earning()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('practitioner.earning', compact('user', 'userDetails'));
    }

    public function refundRequest()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('practitioner.refund_request', compact('user', 'userDetails'));
    }

    public function updateClientPolicy(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        UserDetail::where('user_id', $id)->update(
            [
                'privacy_policy' => $input['privacy_policy'],
                'terms_condition' => $input['terms_condition'],
                'cancellation_policy' => $input['cancellation_policy'],
            ]
        );
        return redirect()->back()->with('success', 'Profile updated successfully');
    }


    public function accounting(Request $request)
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        // Get start and end dates from the request, or set defaults
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Get offering IDs owned by the practitioner
        $offeringIds = Offering::where('user_id', $user->id)->pluck('id');



        // Get show IDs owned by the practitioner
        $showIds = Show::where('user_id', $user->id)->pluck('id');

        // Fetch bookings where offering, event, or show is owned by the practitioner
        $bookings = Booking::where(function ($query) use ($offeringIds, $showIds) {
            $query->whereIn('offering_id', $offeringIds)
                ->orWhereIn('shows_id', $showIds);
        })
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->with(['offering', 'user', 'shows'])
            ->paginate(10);

        // Calculate totals for the Gross Sales Report
        $totalOrders = $bookings->total();
        $totalProductsSold = $bookings->count();
        $totalEarnings = $bookings->sum('total_amount');
        $totalTax = $bookings->sum('tax_amount');

        return view('practitioner.accounting', compact(
            'user',
            'userDetails',
            'bookings',
            'startDate',
            'endDate',
            'totalOrders',
            'totalProductsSold',
            'totalEarnings',
            'totalTax'
        ));
    }

    public function exportEarnings(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Get offering, event, and show IDs
        $offeringIds = Offering::where('user_id', $user->id)->pluck('id');
        $eventIds = Event::whereIn('offering_id', $offeringIds)->pluck('id');
        $showIds = Show::where('user_id', $user->id)->pluck('id');

        // Fetch bookings
        $bookings = Booking::where(function ($query) use ($offeringIds, $eventIds, $showIds) {
            $query->whereIn('offering_id', $offeringIds)
                ->orWhereIn('event_id', $eventIds)
                ->orWhereIn('shows_id', $showIds);
        })
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->with(['offering', 'user', 'shows', 'event', 'event.offering'])
            ->get();

        // Generate CSV
        $csv = \League\Csv\Writer::createFromString();
        $csv->insertOne(['Booking ID', 'Customer', 'Item', 'Type', 'Date', 'Time Slot', 'Amount', 'Tax', 'Status']);
        foreach ($bookings as $booking) {
            $item = $booking->offering_id ? ($booking->offering->name ?? 'N/A') :
                ($booking->shows_id ? ($booking->shows->name ?? 'N/A') :
                    ($booking->event_id ? ($booking->event->offering->name ?? 'N/A') : 'N/A'));
            $type = $booking->offering_id ? 'Offering' :
                ($booking->shows_id ? 'Show' :
                    ($booking->event_id ? 'Event' : 'Unknown'));
            $csv->insertOne([
                $booking->id,
                $booking->first_name . ' ' . $booking->last_name,
                $item,
                $type,
                $booking->booking_date,
                $booking->time_slot ?? 'N/A',
                $booking->currency_symbol . number_format($booking->total_amount, 2),
                $booking->currency_symbol . number_format($booking->tax_amount, 2),
                $booking->status,
            ]);
        }

        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="earnings_report.csv"',
        ]);
    }


    public function add_term(Request $request)
    {

        $type = $request->type;

        if (in_array($type, ['IHelpWith', 'HowIHelp', 'certifications', 'tags', 'modalityPractice'])) {
            $inputField = '<input type="text" class="' . $type . '_term form-control my-2 me-3" id="' . $type . '_term" name="' . $type . '_term" placeholder="Enter term">
            <button data-type="' . $type . '" class="update-btn my-2 save_term btn btn-sm btn-primary">Add Term</button>';

            return response()->json(['success' => true, 'inputField' => $inputField]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid request']);
    }

    public function save_term(Request $request)
    {
        $user = Auth::user();
        $type = $request->type;
        $name = $request->name;

        if (!$name) {
            return response()->json(['success' => false, 'message' => 'Name is required']);
        }

        $names = array_filter(array_map('trim', explode(',', $name)));
        $createdTerms = [];
        $duplicateTerms = [];

        foreach ($names as $termName) {
            $slug = Str::slug($termName);

            $model = match ($type) {
                'IHelpWith' => new IHelpWith,
                'HowIHelp' => new HowIHelp,
                'certifications' => new Certifications,
                'tags' => new PractitionerTag,
                'modalityPractice' => new MembershipModality,
                default => null
            };

            if (!$model) {
                return response()->json(['success' => false, 'message' => 'Invalid type']);
            }

            // Check for duplicate slug
            if ($model->where('slug', $slug)->exists()) {
                $duplicateTerms[] = $termName;
                continue;
            }

            $term = $model->create([
                'name' => $termName,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            $createdTerms[] = $term;
        }

        if (empty($createdTerms)) {
            return response()->json([
                'success' => false,
                'message' => 'All terms already exist: ' . implode(', ', $duplicateTerms),
                'duplicates' => $duplicateTerms,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => count($createdTerms) . ' term(s) saved successfully',
            'terms' => $createdTerms,
            'duplicates' => $duplicateTerms,
        ]);
    }


    public function deleteImage(Request $request)
    {
        $user_id = $request->user_id;
        $image = $request->image;
        $isProfileImage = $request->isProfileImage;
        $isOfferingImage = $request->isOfferImage;
        $isCertificateImages = $request->isCertificateImages;

        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        if ($isProfileImage) {
            $userDetails = $user->userDetail;

            $images = isset($userDetails->images) && $userDetails->images ? json_decode($userDetails->images, true) : null;
            $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];
            $profileImage = isset($images['profile_image']) ? $images['profile_image'] : null;

            if ($profileImage == $image) {
                $images['profile_image'] = null;
            } else {
                $key = array_search($image, $mediaImages);
                if ($key !== false) {
                    unset($mediaImages[$key]);
                }
            }
            $images['media_images'] = $mediaImages;
            $userDetails->images = json_encode($images);
            $userDetails->save();
        }

        if ($isOfferingImage) {
            $offering = $user->offerings()->where('featured_image', $image)->first();
            if ($offering) {
                $offering->featured_image = null;
                $offering->save();
            }
        }
        if ($isCertificateImages) {
            $membership = $user->memberships()->first();

            if ($membership && $membership->certificates_images) {
                $images = json_decode($membership->certificates_images, true);

                // Ensure images is an array before proceeding
                if (is_array($images)) {
                    // Find and remove the specific image
                    if (($key = array_search($image, $images)) !== false) {
                        unset($images[$key]); // Remove the image

                        // Reindex array and update the database
                        $membership->certificates_images = empty($images) ? null : json_encode(array_values($images));
                        $membership->save();
                    }
                }
            }
        }


        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);

    }

    public function membership(Request $request)
    {
        $user = Auth::user();
        $membership = MemberShip::where('user_id', $user->id)->first();
        $defaultLocations = Locations::where('status', 1)->get();
        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }

        $images = isset($membership->certificates_images) && $membership->certificates_images ? json_decode($membership->certificates_images, true) : [];

        $modalities = MembershipModality::pluck('name', 'id')->toArray();

        $userPlan = null;
        if ($user->subscribed('default')) {
            $planId = $user->subscription('default')->plan_id;
            $userPlan = Plan::find($planId);
        }

        $plans = Plan::latest()->get();
        $addedMemberships = [
            'Founding Members T1' => [
                'AzucenaAnna@gmail.com',
                'sm.sethmohan@gmail.com',
                'sacredwombwellness@gmail.com',
                'info@vyshfitness.com',
                'sacredcoastco@gmail.com',
                'mindfullycreateddesigns@gmail.com',
                'drbrigitta@mailfence.com',
                'vitalresonance@gmail.com',
                'linda@lwara.com',
                'brigittemassage@gmail.com',
                'rainbow.vibrations4444@gmail.com',
                'annasilfawellness@gmail.com',
                'righteoussun00@gmail.com',
                'julie@balancelifewithjulie.com',
                'info@jothi.ca',
                'isabelnantaba@gmail.com',
                'trace@innatewisdom.love',
                'laurenwelchner@gmail.com',
                'joanne@consciousbirth.ca'
            ],
            // 'Founding Membership - 10 years' => [
            //     'joanne@consciousbirth.ca'
            // ],
            'Founding Members T2' => [
                'info@nutristica.com',
                'jaiti.srivastava@gmail.com',
                'sam@samcoretrainer.com',
                'sonia.plusa@gmail.com',
                'hello@lauren-best.com',
                'Sherien@sherienwellness.com',
                'dfahlman@gmail.com',
                'auralignedhealing@gmail.com',
                'tiana@tianapollari.com'
            ],
            'Diamond Pre-Launch Membership' => [
                'candice.warrior.shaman@gmail.com',
                'sarah@meb4we.ca',
                'divinebeautywithin@gmail.com',
                'mvwellsbury@gmail.com',
                'mvwellsbury@gmail.com',
                'king.oils@hotmail.com',
                'kingsley@kingskitchenmedia.com',
                'revolution9wellness@gmail.com',
                'mirb7000@gmail.com'
            ]
        ];
        $oldUsers = [
            'AzucenaAnna@gmail.com',
            'sm.sethmohan@gmail.com',
            'sacredwombwellness@gmail.com',
            'info@vyshfitness.com',
            'sacredcoastco@gmail.com',
            'mindfullycreateddesigns@gmail.com',
            'drbrigitta@mailfence.com',
            'vitalresonance@gmail.com',
            'linda@lwara.com',
            'brigittemassage@gmail.com',
            'rainbow.vibrations4444@gmail.com',
            'annasilfawellness@gmail.com',
            'righteoussun00@gmail.com',
            'julie@balancelifewithjulie.com',
            'info@jothi.ca',
            'isabelnantaba@gmail.com',
            'trace@innatewisdom.love',
            'laurenwelchner@gmail.com',
            'joanne@consciousbirth.ca',
            'info@nutristica.com',
            'jaiti.srivastava@gmail.com',
            'sam@samcoretrainer.com',
            'sonia.plusa@gmail.com',
            'hello@lauren-best.com',
            'Sherien@sherienwellness.com',
            'dfahlman@gmail.com',
            'auralignedhealing@gmail.com',
            'tiana@tianapollari.com',
            'candice.warrior.shaman@gmail.com',
            'sarah@meb4we.ca',
            'divinebeautywithin@gmail.com',
            'mvwellsbury@gmail.com',
            'mvwellsbury@gmail.com',
            'king.oils@hotmail.com',
            'kingsley@kingskitchenmedia.com',
            'revolution9wellness@gmail.com',
            'mirb7000@gmail.com'
        ];
        $userEmail = $user->email;
        $allowedPlans = [];

        // Check if the user's email is found in any membership category
        foreach ($addedMemberships as $addMembership => $emails) {
            if (in_array($userEmail, $emails)) {
                $allowedPlans[] = $addMembership; // Store the membership name
            }
        }
        // If user has specific membership, filter the plans accordingly
        if (!empty($allowedPlans)) {
            $plans = $plans->whereIn('name', $allowedPlans); // Filter based on membership type
        } else if (!in_array($userEmail, $oldUsers)) {
            $allotedPlans = $user->plans ? json_decode($user->plans) : [];
            $plans = $plans->whereIn('id', $allotedPlans);
        }
        // dd($plans);
        return view('practitioner.membership', [
            'user' => $user,
            'membership' => $membership,
            'defaultLocations' => $locations,
            'mediaImages' => $images,
            'modalities' => $modalities,
            'plans' => $plans,
            'userPlan' => $userPlan
        ]);
    }

    public function membershipBuy(Request $request)
    {
        $user = auth()->user();
        $planId = $request->plan_id;
        $plan = Plan::findOrFail($planId);

        // Check if a session is already in progress
        if (session()->has('active_checkout_session')) {
            return redirect()->back()->with('error', 'A checkout session is already in progress. Please complete it first.');
        }

        try {
            // ❗ Block users without Stripe ID
            if (!$user->hasStripeId()) {
                return redirect()->route('my_profile')->with('error', 'Please connect your Stripe account before purchasing a plan.');
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $lineItem = [
                'price' => $plan->stripe_price_id,
                'quantity' => 1,
            ];

            if (!empty($plan->stripe_tax_rate_id)) {
                $lineItem['tax_rates'] = [$plan->stripe_tax_rate_id];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'allow_promotion_codes' => true,
                'customer' => $user->stripe_id,
                'line_items' => [$lineItem],
                'metadata' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'price_id' => $plan->stripe_price_id,
                ],
                'success_url' => route('my_membership') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('my_membership'),
            ]);

            session(['active_checkout_session' => $session->id]);

            return redirect()->away($session->url);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }


    public
    function storeMembership(Request $request)
    {
        $inputs = $request->all();
        dd($inputs);
    }

    public function community()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('practitioner.community', compact('user', 'userDetails'));
    }


    public function help()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('practitioner.help', compact('user', 'userDetails'));
    }

    public function membershipPersonalInformation(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $input = $request->all();

        $id = $input['membership_id'];
        $membership = Membership::where('id', $id)->first();

        if (!$membership) {
            $membership = new Membership();
            $membership->user_id = $userId;
            $membership->created_by = $userId;
        } else {
            $membership->updated_by = $userId;
        }

        $membership->name = $input['name'];
        $membership->preferred_name = $input['preferred_name'];
        $membership->pronouns = $input['pronouns'];
        $membership->email = $input['email'];
        $membership->birthday = $input['birthday'];
        $membership->phone_number = $input['phone_number'];
        $membership->location = $input['location'];
        $membership->website_social_media_link = $input['website_social_media_link'];

        $membership->save();


        return redirect()->back()->with('success', 'Profile updated successfully');
    }


    public function professionalServiceInformation(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $input = $request->all();

        $id = $input['membership_id'] ?? null;
        $membership = Membership::find($id);

        if (!$membership) {
            $membership = new Membership();
            $membership->user_id = $userId;
            $membership->created_by = $userId;
        } else {
            $membership->updated_by = $userId;
        }

        // Ensure the business_name is not null
        $membership->business_name = $input['business_name'] ?? '';
// Step 1: Get existing modalities from DB, decode to array
        $existingModalities = $membership->membership_modalities
            ? json_decode($membership->membership_modalities, true)
            : [];

// Step 2: Get new modalities from input (or empty array)
        $newModalities = $input['modality_practice'] ?? [];

// Step 3: Merge and remove duplicates
        $mergedModalities = array_unique(array_merge($existingModalities, $newModalities));

// Step 4: Save as JSON
        $membership->membership_modalities = json_encode($mergedModalities);

        // Handle boolean values correctly
        $membership->confirm_necessary_certifications_credentials = isset($input['confirm_necessary_certifications_credentials']) ? 1 : 0;
        $membership->acknowledge_the_hira_collective_practitioner_agreement = isset($input['acknowledge_the_hira_collective_practitioner_agreement']) ? 1 : 0;
        $membership->understand_declaration_serves = isset($input['understand_declaration_serves']) ? 1 : 0;

        $membership->years_of_experience = $input['years_of_experience'] ?? 0;
        $membership->license_certification_number = $input['license_certification_number'] ?? '';

        // Handle file uploads
        $existingImages = $membership->certificates_images ? json_decode($membership->certificates_images, true) : [];

        if ($request->hasFile('certificates_images')) {
            $images = $request->file('certificates_images');

            if (!is_array($images)) {
                $images = [$images];
            }

            foreach ($images as $image) {
                if ($image->isValid()) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $path = 'uploads/practitioners/' . $user->id . '/membership_certificate/';
                    $image->move(public_path($path), $fileName);
                    $existingImages[] = $fileName;
                }
            }

            // Save back as JSON
            $membership->certificates_images = json_encode($existingImages);
        }

        $membership->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }


    public function communityEngagement(Request $request)
    {

        $user = Auth::user();
        $userId = $user->id;
        $input = $request->all();

        $id = $input['membership_id'];
        $membership = Membership::where('id', $id)->first();

        if (!$membership) {
            $membership = new Membership();
            $membership->user_id = $userId;
            $membership->created_by = $userId;
        } else {
            $membership->updated_by = $userId;
        }
        $membership->blogs_workshops_events = isset($input['blogs_workshops_events']) && $input['blogs_workshops_events'] ? json_encode($input['blogs_workshops_events']) : null;
        $membership->referral_program = $input['referral_program'] ?? null;
        $membership->collaboration_interests = $input['collaboration_interests'] ?? null;

        $membership->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }


    public function endorsementPractitioner(Request $request)
    {
        $search = $request->input('search');
        $endorsedUsers = User::where('role', 1)
            ->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->with('userDetail')
            ->get();
        $defaultLocations = Locations::where('status', 1)->get();
        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }
        json_encode($locations);
        return response()->json([
            'success' => true,
            'practitioners' => $endorsedUsers,
            'html' => view('practitioner.endorsement_practitioner_xml', [
                'endorsedUsers' => $endorsedUsers,
                'defaultLocations' => $locations,
            ])->render()
        ]);
    }

    public function removeEndorsement(Request $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $userDetail = UserDetail::where('user_id', $user_id)->first();

        if (!$userDetail) {
            return response()->json(['error' => 'User detail not found'], 404);
        }

        $endorsements = json_decode($userDetail->endorsements, true);
        if (!is_array($endorsements)) {
            $endorsements = [];
        }

        // Remove the ID from endorsements array
        $endorsements = array_filter($endorsements, function ($value) use ($id) {
            return $value != $id;
        });

        // Re-index array to avoid JSON issues
        $userDetail->endorsements = json_encode(array_values($endorsements));

        if ($userDetail->save()) {
            return response()->json(['success' => 'Endorsement removed successfully']);
        } else {
            return response()->json(['error' => 'Failed to remove endorsement'], 500);
        }
    }

    public function practitionerShows()
    {
        $user = Auth::user();
        $shows = Show::where('user_id', $user->id)->get();
        return view('practitioner.shows', ['shows' => $shows, 'user' => $user]);
    }

    public function practitionerAddShow()
    {
        $user = Auth::user();
        return view('practitioner.add_show', ['user' => $user]);
    }

    public function practitionerShowStore(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price' => 'required|string',
            'show_type' => 'nullable|string',
        ]);

        Show::create([
            'show_type' => $validated['show_type'] ?? 'offering',
            'name' => $validated['name'],
            'duration' => $validated['duration'],
            'price' => $validated['price'],
            'tax' => 13,
            'user_id' => $user->id,
        ]);

        return redirect()->route('practitionerShows')->with('success', 'Show created successfully.');
    }

    public function practitionerShowEdit($id)
    {
        $user = Auth::user();
        $show = Show::findOrFail($id);
        return view('practitioner.edit_show', ['show' => $show, 'user' => $user]);
    }

    public function practitionerShowUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price' => 'required|string',
            'show_type' => 'nullable|string',
        ]);

        $show = Show::findOrFail($id);
        $show->update([
            'show_type' => $validated['show_type'] ?? 'offering',
            'name' => $validated['name'],
            'duration' => $validated['duration'],
            'price' => $validated['price'],
            'tax' => 13,
        ]);

        return redirect()->route('practitionerShows')->with('success', 'Show updated successfully.');
    }

    public function practitionerShowDelete($id)
    {
        $show = Show::findOrFail($id);
        $show->delete();
        return redirect()->route('practitionerShows')->with('success', 'Show deleted successfully.');
    }


}

