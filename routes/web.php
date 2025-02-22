<?php

use App\Http\Controllers\Calender\CalenderController;

use App\Http\Controllers\Calender\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\OfferingController;
use Illuminate\Support\Facades\Auth;

/* Route::get('/', function () {
    return view('home');
}); */

Auth::routes();

 Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::namespace('Admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('admin/users', [DashboardController::class, 'Users'])->name('admin.users');
        Route::get('admin/blogs', [DashboardController::class, 'blogs'])->name('admin.blogs');
    });
});

Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/my-profile', [PractitionerController::class, 'index'])->name('myProfile');
    Route::get('/dashboard', [PractitionerController::class, 'dashboard'])->name('dashboard');
    Route::get('/add-offering', [PractitionerController::class, 'addOffering'])->name('addOffering');
    Route::get('/discount', [PractitionerController::class, 'discount'])->name('discount');
    Route::get('/add-discount', [PractitionerController::class, 'addDiscount'])->name('addDiscount');
    Route::post('/update-profile', [PractitionerController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-client-policy', [PractitionerController::class, 'updateClientPolicy'])->name('updateClientPolicy');
    Route::get('/appointment', [PractitionerController::class, 'appointment'])->name('appointment');
    Route::get('/accounting', [PractitionerController::class, 'accounting'])->name('accounting');
    Route::get('/practitioner-detail/{practitionerId}', [PractitionerController::class, 'practitionerDetail'])->name('practitionerDetail');

    Route::get('/blog', [PractitionerController::class, 'blog'])->name('blog');
    Route::get('/blog-details', [PractitionerController::class, 'blogDetail'])->name('blogDetail');
    Route::get('/earning', [PractitionerController::class, 'earning'])->name('earning');
    Route::get('/refund-request', [PractitionerController::class, 'refundRequest'])->name('refundRequest');
    Route::get('/contact-us', [PractitionerController::class, 'contact'])->name('contact');

    Route::get('/calendar', [CalenderController::class, 'showCalendar'])->name('calendar');
    Route::get('/calendar/events', [CalenderController::class, 'getGoogleCalendarEvents'])->name('getGoogleCalendarEvents');
    Route::get('/calendar-settings', [CalenderController::class, 'calendarSettings'])->name('calendarSettings');

    Route::prefix('offering')->group(function () {
        Route::get('/', [OfferingController::class, 'index'])->name('offering');
        Route::post('/', [OfferingController::class, 'store'])->name('storeOffering');
        Route::get('/{id}', [OfferingController::class, 'show'])->name('showOffering');
        Route::put('/{id}', [OfferingController::class, 'update'])->name('updateOffering');

        Route::delete('/{id}', [OfferingController::class, 'destroy']);
    });


    Route::get('/google/login', [GoogleAuthController::class, 'redirectToGoogle'])->name('redirectToGoogle');
    Route::get('/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

//    Route::middleware(['auth'])->group(function () {
//        Route::get('/calendar', [GoogleCalendarController::class, 'listEvents'])->name('calendar.index');
//        Route::post('/calendar/event', [GoogleCalendarController::class, 'createEvent'])->name('calendar.create');
//        Route::post('/calendar/delete', [GoogleCalendarController::class, 'deleteEvent'])->name('calendar.delete');
//    });

});
