<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\GoogleAnalyticsService;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Offering;
use App\Models\Payment;
use Carbon\Carbon;
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

        // Fetch paginated bookings with related models
        $bookings = Booking::with(['user', 'offering', 'offering.user'])
            ->select(['id', 'user_id', 'offering_id', 'event_id', 'total_amount', 'booking_date', 'status'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);
        
        // Prepare chart data for bookings count and amount by month
        $chartBookings = Booking::selectRaw('
        DATE_FORMAT(booking_date, "%Y-%m") as month,
        COUNT(*) as bookingsCount,
        SUM(total_amount) as bookingsAmount
    ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartData = [
            'labels' => [],
            'bookingsCount' => [],
            'bookingsAmount' => []
        ];

        foreach ($chartBookings as $booking) {
            $chartData['labels'][] = Carbon::createFromFormat('Y-m', $booking->month)->format('M Y');
            $chartData['bookingsCount'][] = $booking->bookingsCount;
            $chartData['bookingsAmount'][] = $booking->bookingsAmount;
        }

        // Dashboard counts (all dynamic)
        $totalUsers = User::where('role', 3)->where('status', 1)->count();
        $totalPractionters = User::where('role', 1)->where('status', 1)->count();
        $totalBookings = Booking::count();
        $bookingsPaid = Booking::whereIn('status', ['paid', 'completed'])->count();
        $bookingsPending = Booking::where('status', 'pending')->count();
        $totalPayment = Payment::where('status', 'completed')->sum('amount');
        $totalOfferings = Offering::count();
        $totalEvents = Event::count();

        return view('admin.dashboard', compact(
            'user',
            'bookings',
            'totalUsers',
            'chartData',
            'totalPractionters',
            'totalBookings',
            'bookingsPaid',
            'bookingsPending',
            'totalPayment',
            'totalOfferings',
            'totalEvents'
        ));
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
