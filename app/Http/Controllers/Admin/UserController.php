<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Models\Waitlist;
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
            'client' => User::where('status', 1)->where('role', 3)->latest()->paginate(10),
            'new' => User::where('status', 2)->with('waitlist')->latest()->paginate(10),
            'delete' => User::where('status', 3)->latest()->paginate(10),
            default => User::where('status', 1)->where('role', 1)->latest()->paginate(10),
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
            'new' => '2',
            'delete' => '3',
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
            '2' => 'new',
            '3' => 'delete',
            default => 'all',
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

}
