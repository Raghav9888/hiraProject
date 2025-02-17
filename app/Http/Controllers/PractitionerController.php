<?php

namespace App\Http\Controllers;

use App\Models\User;
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
//        $user = user::find($id);
//        if (!$user) {
//            return redirect()->back()->with('error', 'User not found');
//        }
        dd($input);
        $user = [

        ];
        $details = [

        ];
        return view('user.myprofile', compact('user', 'userDetails'));
    }

}
