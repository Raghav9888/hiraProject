<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InterviewInviteMail;
use App\Models\GoogleAccount;
use App\Models\Plan;
use App\Models\User;
use App\Models\Waitlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // role 0 = pending, role 1 = practitioner, role 2 = Admin 3 = User
    // default status  0 = Inactive, status 1 = Active, status 2 = pending, status 3 = Deleted, status 4 = Blocked

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $userType)
    {

        $user = Auth::user();
        $users = match ($userType) {
            'client' => User::where('status', 1)->where('role', 3)->orderBy('created_at', 'desc')->paginate(10),
            'new' => User::where('status', 2)->with('waitlist')->orderBy('created_at', 'desc')->paginate(10),
            'delete' => User::where('status', 3)->orderBy('created_at', 'desc')->paginate(10),
            default => User::where('status', 1)->where('role', 1)->orderBy('created_at', 'desc')->paginate(10),
        };

        foreach ($users as $user) {
            if($user->stripeAccount) {
                $user->stripe_id = $user->stripeAccount->stripe_user_id;
            }else{
                $user->stripe_id = null;
            }
            // update user settings
            $user->save();
        }
        $type = match ($userType) {
            'delete' => '4',
            'client' => '3',
            'new' => '2',
            default => '1',
        };

        return view('admin.users.index', [
            'user' => $user,
            'users' => $users,
            'userType' => $userType,
            'type' => $type
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $type = $request->get('type');
        $userData = User::find($id);
        $plans = Plan::latest()->get();
        $userType = match ($type) {
            '4' => 'delete',
            '3' => 'user',
            '2' => 'new',
            default => 'practitioner',
        };

        return view('admin.users.edit', compact('user', 'userData', 'userType', 'type', 'id', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $inputs = $request->all();
        $type = $request->get('type');

        if ($user) {
            $user->update($inputs);
        }
        $user->plans = $request->plans ? json_encode($request->plans) : null;
        $user->save();
        $userType = match ($type) {
            '2' => 'new',
            '3' => 'delete',
            default => 'all',
        };
        return redirect()->back();
    }


    public function delete(Request $request)
    {
        Auth::user();
        $type = $request->get('type');
        $id = $request->get('id');
        $user = User::where('id', $id)->first();

        if ($user) {
            $user->update(['status' => 3]);
        }

        $userType = match ($type) {
            '2' => 'new',
            '3' => 'delete',
            default => 'all',
        };
        return redirect()->route('admin.user.index', ['userType' => $userType]);

    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $id = $request->get('id');

        $userData = User::where('id', $id)->first();

        if ($userData) {
            $userData->update(['status' => 1]);
        }

        return redirect()->back();
    }

    public function loginAs(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::where('id', $id)->first();
            $redirectRoute = match($user->role) {
                 2 => 'admin.dashboard',
                 1 => 'dashboard',
                 3 => 'userDashboard',
                 default => 'home',
             };
            Auth::loginUsingId($id);
            return response()->json([
                "success" => true,
                'redirect' => route($redirectRoute),
                "data" => "Logged in successfully!"
            ]);
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function waitlist(Request $request, $id)
    {

        $waitlist = Waitlist::where('user_id', $id)->first();

        return view('admin.users.waitlist', [
            'waitlist' => $waitlist,
            'user' => Auth::user(),
            'id' => $id
        ]);

    }

    public function sendInterviewAjax(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $admin = Auth::user();
        $practitioner = User::find($request->user_id);

        $googleAccount = GoogleAccount::where('user_id', $admin->id)->first();
        if (!$googleAccount || !$googleAccount->access_token) {
            return response()->json(['status' => 'error', 'message' => 'Google account not connected']);
        }

        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google/calendar/credential.json'));
        $client->setAccessType('offline');
        $client->setAccessToken([
            'access_token' => $googleAccount->access_token,
            'refresh_token' => $googleAccount->refresh_token,
            'expires_in' => 3600,
            'created' => strtotime($googleAccount->updated_at),
        ]);

        if ($client->isAccessTokenExpired()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $googleAccount->update([
                'access_token' => $newToken['access_token'],
                'refresh_token' => $newToken['refresh_token'] ?? $googleAccount->refresh_token,
                'expires_at' => now()->addSeconds($newToken['expires_in']),
            ]);
            $client->setAccessToken($newToken);
        }

        $calendarService = new \Google_Service_Calendar($client);

        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Interview with ' . $practitioner->name,
            'start' => [
                'dateTime' => Carbon::parse($request->start_time)->toRfc3339String(),
                'timeZone' => 'Asia/Kolkata',
            ],
            'end' => [
                'dateTime' => Carbon::parse($request->end_time)->toRfc3339String(),
                'timeZone' => 'Asia/Kolkata',
            ],
            'attendees' => [
                ['email' => $practitioner->email],
                ['email' => $admin->email],
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);

        $event = $calendarService->events->insert('primary', $event, ['conferenceDataVersion' => 1]);
        $meetLink = $event->getHangoutLink();

        // Send email
        Mail::to($practitioner->email)->send(new InterviewInviteMail($practitioner, $meetLink, $request->start_time));
        Mail::to($admin->email)->send(new InterviewInviteMail($admin, $meetLink, $request->start_time));

        return response()->json([
            'status' => 'success',
            'link' => $meetLink
        ]);
    }


}
