<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class HomeController extends Controller
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

        $users = User::where('role', 1)->with('userDetail')->get();        
        return view('home', compact('users'));
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

        // Send email to admin
        Mail::to('joshiraghav282@gmail.com')->send(new ContactUsMail($contactData));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
