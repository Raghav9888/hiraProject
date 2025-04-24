<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\GoogleAnalyticsService;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Offering;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

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


    public function index(GoogleAnalyticsService $analyticsService)
    {
        $user = Auth::user();

//        $chartData = $analyticsService->getWeeklyReport();
        $chartData = [
            'labels' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            'thisWeek' => [100, 120, 90, 130, 110, 160, 140],
            'lastWeek' => [80, 100, 70, 110, 90, 140, 120]
        ];
        $totalPractionters = User::where("role", 1)->where("status", 1)->count();
        $totalBookings = Booking::count();
        $totalPayment = Payment::where('status', 'completed')->sum("amount");
        $totalOfferings = Offering::count();
        $totalEvents = Event::count();
        return view('admin.dashboard', compact('user','chartData', 'totalPractionters', 'totalBookings', 'totalPayment', 'totalOfferings', 'totalEvents'));
    }



    public function users()
    {
        $user = Auth::user();
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
