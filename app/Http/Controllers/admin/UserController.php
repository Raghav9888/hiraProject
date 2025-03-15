<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // role 0 = pending, role 1 = practitioner, role 2 = Admin 3 = User
    // default status  0 = Inactive, status 1 = Active, status 2 = pending,

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::where('role', 1)->where('status', 1)->latest()->paginate(10);

        return view('admin.users.index', compact('user', 'users'));
    }


    /**
     * Display a new user listing of the resource.
     */
    public function new()
    {
        $user = Auth::user();
        $users = User::where('role', 0)->where('status', 2)->latest()->paginate(10);
        $cardHeaderText = 'New Users';
        return view('admin.users.index', compact('user', 'users', 'cardHeaderText'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $userData = User::find($id);
        return view('admin.users.edit', compact('user', 'userData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
