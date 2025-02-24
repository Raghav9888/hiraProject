<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Offering;
use App\Models\Category;
use App\Models\PractitionerTag;
use App\Models\IHelpWith;
use App\Models\HowIHelp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
        $PractitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();

        return view('user.my_profile', compact('user', 'userDetails','Categories','PractitionerTag','IHelpWith','HowIHelp'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.dashboard', compact('user', 'userDetails'));
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
        $user->company = $input['company'];
        $user->bio = $input['bio'];
        $user->location = $input['location'];
        $user->save();


        $details = [
            'company' => $input['company'],
            'bio' => $input['bio'],
            'location' => $input['location'],
//            'tags' => $input['tags'],
            'about_me' => $input['about_me'],
//            'help' => $input['help'],
            'specialities' => $input['specialities'],
            'certifications' => $input['certifications'],
            'endorsements' => $input['endorsements'],
            'timezone' => $input['timezone'],
            'is_opening_hours' => isset($input['is_opening_hours']) && $input['is_opening_hours'] == 'on' ? 1 : 0,
            'is_notice' => isset($input['is_notice']) && $input['is_notice'] == 'on' ? 1 : 0,
            'is_google_analytics' => isset($input['is_google_analytics']) && $input['is_google_analytics'] == 'on' ? 1 : 0,
        ];

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $fileName = $image->getClientOriginalName();
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/practitioners/'.$id), $fileName);
            $details['images'] = json_encode($fileName);

        }
        UserDetail::where('user_id', $id)->update($details);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }


    public function addOffering()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.add_offering', compact('user', 'userDetails'));
    }

    public function discount()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.discount', compact('user', 'userDetails'));
    }

    public function addDiscount()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.add_discount', compact('user', 'userDetails'));
    }

    public function appointment ()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.appoinement', compact('user', 'userDetails'));
    }
//    public function calendar()
//    {
//        $user = Auth::user();
//        $userDetails = $user->userDetail;
//
//        return view('user.calendar', compact('user', 'userDetails'));
//    }


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


    public function practitionerDetail($id)
    {
        $user = User::findOrFail($id);
        $userDetails = $user->userDetail;
        $offerings = Offering::where('user_id', $user->id)->get();
        return view('user.practitioner_detail', compact('user', 'userDetails','offerings'));
    }

    public function offerDetail($id)
    {
        $offerDetail = Offering::findOrFail($id);

        return view('user.practitioner_detail', compact('offerDetail'));
    }

    public function add_term(Request $request){

        $type = $request->type;

        if($type == 'IHelpWith'){

            $inputField = '<input type="text" class="'.$type.'_term" id="term" name="'.$type.'_term" id="term" placeholder="Enter term"><button data-type="'.$type.'" class="update-btn mb-2 save_term">Add Term</button';
            return response()->json(['success' => true, 'inputField' => $inputField]);
        }

        if($type == 'HowIHelp'){

            $inputField = '<input type="text" class="'.$type.'_term" id="term" name="'.$type.'_term" id="term" placeholder="Enter term"><button data-type="'.$type.'" class="update-btn mb-2 save_term">Add Term</button';
            return response()->json(['success' => true, 'inputField' => $inputField]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid request']);
    }

    public function save_term(Request $request){

        $user = Auth::user();
        $type = $request->type;
        $name = $request->name;

        if (!$name) {
            return response()->json(['success' => false, 'message' => 'Name is required']);
        }

        $slug = Str::slug($name); // Generate slug from name

        if($type == 'IHelpWith'){
            $term = IHelpWith::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'IHelpWith term saved successfully','term' => $term]);
        }

        if($type == 'HowIHelp'){
            $term = HowIHelp::create([
                'name' => $name,
                'slug' => $slug,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            return response()->json(['success' => true, 'message' => 'HowIHelp term saved successfully', 'term' => $term]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request']);
    }

}
