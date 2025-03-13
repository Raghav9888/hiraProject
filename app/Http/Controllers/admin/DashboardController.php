<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
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
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users');
    }

    public function addUser()
    {
        $users = User::all();
        return view('admin.users');
    }
    public function editUser()
    {
        $users = User::all();
        return view('admin.users');
    }
    public function updateUser()
    {
        $users = User::all();
        return view('admin.users');
    }

    public function deleteUser()
    {
        $users = User::all();
        return view('admin.users');
    }

    public function blogs()
    {
        return view('admin.blogs');
    }


    public function addBlog()
    {
        return view('admin.blogs');
    }

    public function editBlog()
    {
        return view('admin.blogs');
    }
    public function updateBlog()
    {
        return view('admin.blogs');
    }

    public function deleteBlog()
    {
        return view('admin.blogs');
    }


}
