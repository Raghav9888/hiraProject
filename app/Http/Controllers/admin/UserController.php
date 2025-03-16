<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'new' => User::where('role', 0)->orwhere('status', 2)->latest()->paginate(10),
            'delete' => User::where('status', 3)->latest()->paginate(10),
            default => User::where('role', 1)->where('status', 1)->latest()->paginate(10),
        };

        $text = match ($userType) {
            'new' => 2,
            'delete' => 3,
            default => 1,
        };
        return view('admin.users.index', compact('user', 'users', 'text'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $user = Auth::user();
        $userData = User::find($id);
        $text = (int) $request->get('text');

        $userType = match ($text) {
            2 => 'new',
            3 => 'delete',
            default => 'all',
        };

        return view('admin.users.edit', compact('user', 'userData', 'userType', 'text'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->first();
        $inputs = $request->all();
        $text = (int) $request->get('text');

        if ($user) {
            $user->update($inputs);
        }

        $userType = match ($text) {
            2 => 'new',
            3 => 'delete',
            default => 'all',
        };
        return redirect()->route('admin.users.index', ['userType' => $userType]);
    }


    public function delete(Request $request, string $id)
    {
        $text = (int)$request->get('text');
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->update(['status' => 3]);
        }

        $redirect = match ($text) {
            1 => 'admin.users.index',
            2 => 'admin.users.new',
            default => 'admin.users.delete',
        };
        return redirect()->route($redirect);
    }


}
