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
//            'is_opening_hours' => $input['is_opening_hours'],
//            'is_notice' => $input['is_notice'],
//            'is_google_analytics' => $input['is_google_analytics'],
//            'privacy_policy' => $input['privacy_policy'],
//            'terms_condition' => $input['terms_condition'],
        ];

        UserDetail::where('id', $id)->update($details);

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
        return view('user.blog');
    }
    public function blogDetail()
    {
        return view('user.blog');
    }

    public function earning()
    {
        return view('user.earning');
    }

    public function refundRequest()
    {
        return view('user.refund_request');
    }


}
