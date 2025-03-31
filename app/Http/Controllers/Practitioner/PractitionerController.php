<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GoogleAccount;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Locations;
use App\Models\Membership;
use App\Models\MembershipModality;
use App\Models\Offering;
use App\Models\PractitionerTag;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserStripeSetting;
use App\Models\Certifications;
use App\Models\Plan;
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
        $Categories = Category::get();
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
        $users = User::where('role', 1)->with('userDetail')->get();

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
            'Categories',
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
        $user = User::where('id', Auth::id())->with('offerings.bookings')->first();
        $bookings = $user->offerings()->with('bookings')->get()->flatMap(function ($offering) {;
            return $offering->bookings;
        });

        $userDetails = $user->userDetail;

        return view('practitioner.appointment', [
            'user' => $user,
            'userDetails' => $userDetails,
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
        return view('practitioner.accounting', compact('user', 'userDetails'));
    }


    public function add_term(Request $request)
    {

        $type = $request->type;

        if (in_array($type, ['IHelpWith', 'HowIHelp', 'certifications', 'tags', 'modalityPractice'])) {
            $inputField = '<input type="text" class="' . $type . '_term" id="' . $type . '_term" name="' . $type . '_term" placeholder="Enter term">
            <button data-type="' . $type . '" class="update-btn mb-2 save_term">Add Term</button>';

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

        $slug = Str::slug($name);

        if ($type == 'IHelpWith') {
            $term = IHelpWith::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'IHelpWith term saved successfully', 'term' => $term]);
        }

        if ($type == 'HowIHelp') {
            $term = HowIHelp::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'HowIHelp term saved successfully', 'term' => $term]);
        }

        if ($type == 'certifications') {
            $term = Certifications::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'Certification  term saved successfully', 'term' => $term]);
        }

        if ($type == 'tags') {
            $term = PractitionerTag::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'Tags term saved successfully', 'term' => $term]);
        }

        if ($type == 'modalityPractice') {
            $term = MembershipModality::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'Modality Practice term saved successfully', 'term' => $term]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request']);
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

        $membershipModality = MembershipModality::all();
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
        }
        // dd($plans);
        return view('practitioner.membership', [
            'user' => $user,
            'membership' => $membership,
            'defaultLocations' => $locations,
            'mediaImages' => $images,
            'membershipModality' => $membershipModality,
            'plans' => $plans,
            'userPlan' => $userPlan
        ]);
    }

    public function membershipBuy(Request $request)
    {
        $user = auth()->user();
        $planId = $request->plan_id;
        $plan = Plan::findOrFail($planId);
        try {
            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer();
            }
            // Set Stripe API Key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Prepare line items
            $lineItem = [
                'price' => $plan->stripe_price_id,
                'quantity' => 1,
            ];

            // Only add tax_rates if it's set
            if (!empty($plan->stripe_tax_rate_id)) {
                $lineItem['tax_rates'] = [$plan->stripe_tax_rate_id];
            }

            // Create a Stripe Checkout session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'allow_promotion_codes' => true,
                'customer' => $user->stripe_id ?? null, // If user has a Stripe ID, use it
                'line_items' => [$lineItem],
                'metadata' => [
                    'user_id' => $user->id,  // Store user ID
                    'plan_id' => $plan->id,  // Store plan ID
                    'price_id' => $plan->stripe_price_id,  // Store price ID
                ],
                'success_url' => route('my_membership') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('my_membership'),
            ]);

            // Redirect to the Stripe checkout page
            return redirect()->away($session->url);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
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

        // Convert array to JSON before storing
        $membership->membership_modalities = isset($input['modality_practice']) ? json_encode($input['modality_practice']) : json_encode([]);

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
        $membership->blogs_workshops_events = $input['blogs_workshops_events'] ? json_encode($input['blogs_workshops_events']) : null;
        $membership->referral_program = $input['referral_program'];
        $membership->collaboration_interests = $input['collaboration_interests'];

        $membership->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

}
