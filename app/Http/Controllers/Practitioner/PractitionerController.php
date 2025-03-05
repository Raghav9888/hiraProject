<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleAuthController;
use App\Models\Category;
use App\Models\GoogleAccount;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Locations;
use App\Models\Offering;
use App\Models\PractitionerTag;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserStripeSetting;
use App\Models\Certifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DateTimeZone;
use DateTime;


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

        $Categories = Category::get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $certifications = Certifications::get();
        $stripeAccount = UserStripeSetting::where('user_id', Auth::id())->first();
        $googleAccount = GoogleAccount::where('user_id', Auth::id())->first();
        $images = json_decode($userDetails->images, true);
        $mediaImages = isset($images['media_images']) && is_array($images['media_images']) ? $images['media_images'] : [];
        $image = isset($images['profile_image']) ? $images['profile_image'] : null;
        $userLocations = json_decode($userDetails->location, true);
        $locations = Locations::get();
        $tags = json_decode($userDetails->tags, true);
        $users = User::where('role', 1)->with('userDetail')->get();

        $timezones = [];

        foreach (timezone_identifiers_list() as $timezone) {
            $dateTimeZone = new DateTimeZone($timezone);
            $offset = $dateTimeZone->getOffset(new DateTime("now", new DateTimeZone("UTC"))) / 3600;
            $offsetFormatted = "UTC" . ($offset >= 0 ? "+$offset" : $offset);

            $parts = explode("/", $timezone);
            $city = end($parts);

            $timezones[] = [
                'id' => $timezone,
                'name' => "($offsetFormatted) $city"
            ];
        }


        return view('user.my_profile', compact(
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
        $defaultLocations = Locations::get();
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
        return view('user.dashboard', [
            'user' => $user,
            'users' => $users,
            'userDetails' => $userDetails,
            'defaultLocations' => $locations,
            'endorsedUsers' => $endorsedUsers
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
            // 'company' => $input['company'],
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
            'amenities' => isset($input['amenities']) && count($input['amenities']) > 0 ? json_encode($input['amenities']) : null
        ];

        if ($request->hasFile('media_images')) {
            $images = $request->file('media_images');

            // Ensure that $images is an array
            if (!is_array($images)) {
                $images = [$images];
            }

            // Initialize existing images
            $existingImages = $userDetails->images ? json_decode($userDetails->images, true) : [];

            // Initialize media_images to an empty array if it doesn't exist
            if (!isset($existingImages['media_images'])) {
                $existingImages['media_images'] = [];
            }

            // Add new media images
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/practitioners/' . $userDetails->id . '/media/'), $fileName);
                    $existingImages['media_images'][] = $fileName;
                }
            }

            // Prepare the details for storing in the database, preserving existing data
            $details['images'] = json_encode($existingImages);
        } elseif ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/practitioners/' . $userDetails->id . '/profile/'), $fileName);

                // Initialize existing images and add profile image
                $existingImages = $userDetails->images ? json_decode($userDetails->images, true) : [];
                $existingImages['profile_image'] = $fileName; // Update or add the profile image

                // Save the updated details in JSON format
                $details['images'] = json_encode($existingImages);
            }
        }


        UserDetail::where('user_id', $id)->update($details);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function discount()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.discount', compact('user', 'userDetails'));
    }

    public function appointment()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.appoinement', compact('user', 'userDetails'));
    }

    public function earning()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.earning', compact('user', 'userDetails'));
    }

    public function refundRequest()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.refund_request', compact('user', 'userDetails'));
    }

    public function updateClientPolicy(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        UserDetail::where('user_id', $id)->update(
            [
                'privacy_policy' => $input['privacy_policy'],
                'terms_condition' => $input['terms_condition'],
            ]
        );
        return redirect()->back()->with('success', 'Profile updated successfully');
    }


    public function accounting(Request $request)
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.accounting', compact('user', 'userDetails'));
    }


    public function add_term(Request $request)
    {

        $type = $request->type;

        if (in_array($type, ['IHelpWith', 'HowIHelp', 'certifications'])) {
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
            return response()->json(['success' => true, 'message' => 'HowIHelp term saved successfully', 'term' => $term]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request']);
    }

    public function deleteImage(Request $request)
    {
        $user_id = $request->user_id;
        $image = $request->image;

        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        $userDetails = $user->userDetail;

        $images = json_decode($userDetails->images, true);
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

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);

    }

    public function community()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.community', compact('user', 'userDetails'));
    }

}
