<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;

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



    public function showCalendar(GoogleAuthController $googleAuthController)
    {
        $user = Auth::user();

        $response = $googleAuthController->getCalendarEvents();

        $events = json_decode($response->getContent(), true);

        $formattedEvents = collect($events)->map(function ($event) {
            return [
                'id' => $event['id'],
                'title' => $event['title'],
                'start' => $event['start'],
                'end' => $event['end'],
            ];
        })->toArray();

        return view('user.calendar', [
            'events' => json_encode($formattedEvents),
            'user' => $user,
        ]);
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
