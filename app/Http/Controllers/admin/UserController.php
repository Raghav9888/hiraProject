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
    public function index()
    {
        $user = Auth::user();
        $users = User::where('role', 1)->where('status', 1)->latest()->paginate(10);
        $text = 1;
        return view('admin.users.index', compact('user', 'users', 'text'));
    }


    /**
     * Display a new user listing of the resource.
     */
    public function new()
    {
        $user = Auth::user();
        $users = User::where('role', 0)->orwhere('status', 2)->latest()->paginate(10);
        $text = 2;

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

        return view('admin.users.edit', compact('user', 'userData', 'text'));
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

        $redirect = match ($text) {
            1 => 'admin.users.index',
            2 => 'admin.users.new',
            default => 'admin.users.delete',
        };
        return redirect()->route($redirect);
    }

    public function deleteUsers()
    {
        $user = Auth::user();
        $users = User::where('status', 3)->latest()->paginate(10);
        $text = 3;

        return view('admin.users.index', compact('user', 'users', 'text'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
