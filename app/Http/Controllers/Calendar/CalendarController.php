<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleAuthController;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
class CalendarController extends Controller
{
    public function showCalendar(GoogleAuthController $googleAuthController): View
    {
        $user = Auth::user();
        return view('user.calendar', [
            'user' => $user,
        ]);
    }
    public function calendarSettings(GoogleAuthController $googleAuthController): View
    {
        $user = Auth::user();
        return view('user.calendar', [
            'user' => $user,
        ]);
    }
}
