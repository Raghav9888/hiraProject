<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAuthController;
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

 Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

    Route::get('/blog', [PractitionerController::class, 'blog'])->name('blog');
    Route::get('/earning', [PractitionerController::class, 'earning'])->name('earning');
    Route::get('/refund-request', [PractitionerController::class, 'refundRequest'])->name('refundRequest');
    Route::get('/calendar', [PractitionerController::class, 'showCalendar'])->name('calendar');

    Route::get('google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('redirectToGoogle');
    Route::get('google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
    Route::get('/google/events', [GoogleAuthController::class, 'getCalendarEvents'])->name('calendarEvents');
    Route::get('calendar-list', [GoogleAuthController::class, 'getCalendarList']);
//    Route::get('google/events', [GoogleAuthController::class, 'getCalendarEvents'])->name('calendarEvents');

    Route::prefix('offering')->group(function () {
        Route::get('/', [OfferingController::class, 'index'])->name('offering');
        Route::post('/', [OfferingController::class, 'store'])->name('storeOffering');
        Route::get('/{id}', [OfferingController::class, 'show'])->name('showOffering');
        Route::put('/{id}', [OfferingController::class, 'update'])->name('updateOffering');

        Route::delete('/{id}', [OfferingController::class, 'destroy']);
    });


    Route::get('/auth/google', [EventController::class, 'redirectToGoogle'])->name('google.auth');
    Route::get('/callback', [EventController::class, 'handleGoogleCallback']);
    Route::get('/fetch-events', [EventController::class, 'fetchGoogleCalendarEvents']);
    Route::post('/sync-event', [EventController::class, 'syncEventToGoogle']);
    Route::delete('/delete-event/{eventId}', [EventController::class, 'deleteGoogleCalendarEvent']);
});
