<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('user.myprofile', compact('user', 'userDetails'));
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

        UserDetail::where('user_id', $id)->update($details);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function offering()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.offering', compact('user', 'userDetails'));
    }

    public function addoffering()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.addoffering', compact('user', 'userDetails'));
    }

    public function discount()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.discount', compact('user', 'userDetails'));
    }

    public function appointment ()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.appoinement', compact('user', 'userDetails'));
    }
    public function calendar()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.calendar', compact('user', 'userDetails'));
    }


    public function blog()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.blog', compact('user', 'userDetails'));
    }
    public function blogDetail()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        return view('user.blog', compact('user', 'userDetails'));
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

}
