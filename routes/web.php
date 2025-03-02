<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Calender\CalenderController;
use App\Http\Controllers\Calender\GoogleAuthController;
use App\Http\Controllers\Calender\GoogleCalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Practitioner\DiscountController;
use App\Http\Controllers\Practitioner\OfferingController;
use App\Http\Controllers\Practitioner\PaymentController;
use App\Http\Controllers\Practitioner\PractitionerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WordpressUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContactMail'])->name('sendContactMail');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog-details', [HomeController::class, 'blogDetail'])->name('blogDetail');
Route::get('/search/practitioner',[HomeController::class,'searchPractitioner'])->name('searchPractitioner');
Route::get('/practitioners',[HomeController::class,'partitionerLists'])->name('partitionerLists');

Route::get('/practitioner/detail/{id}', [HomeController::class, 'practitionerDetail'])->name('practitioner_detail');
Route::get('/offering/{id}', [HomeController::class, 'offerDetail'])->name('offerDetail');
//Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('create.payment');
Route::post('/storeCheckout', [PaymentController::class, 'storeCheckout'])->name('storeCheckout');
Route::get('/payment/{order_id}', [PaymentController::class, 'showPaymentPage'])->name('payment');
Route::post('/stripe/payment', [PaymentController::class, 'processStripePayment'])->name('stripe.payment');
Route::get('/payment-success', [PaymentController::class, 'sucess'])->name('thankyou');
Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.cancel');
Route::get('/calendar/time-slots/{date}/{id}', [HomeController::class, 'getTimeSlots'])->name('get_time_slots');

Route::post('/storeBooking', [BookingController::class, 'storeBooking'])->name('storeBooking');
Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');



Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::namespace('Admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('admin/users', [DashboardController::class, 'Users'])->name('admin.users');
        Route::get('admin/blogs', [DashboardController::class, 'blogs'])->name('admin.blogs');
    });
});

Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/my-profile', [PractitionerController::class, 'index'])->name('my_profile');
    Route::get('/dashboard', [PractitionerController::class, 'dashboard'])->name('dashboard');
    Route::post('/term/add', [PractitionerController::class, 'add_term'])->name('add_term');
    Route::post('/term/save', [PractitionerController::class, 'save_term'])->name('save_term');
    Route::post('/profile/update', [PractitionerController::class, 'updateProfile'])->name('update_profile');
    Route::post('/client-policy/update', [PractitionerController::class, 'updateClientPolicy'])->name('update_client_policy');
    Route::post('/delete/image', [PractitionerController::class, 'deleteImage'])->name('delete_image');
    Route::get('/appointment', [PractitionerController::class, 'appointment'])->name('appointment');
    Route::get('/accounting', [PractitionerController::class, 'accounting'])->name('accounting');

    Route::get('/earning', [PractitionerController::class, 'earning'])->name('earning');
    Route::get('/refund/request', [PractitionerController::class, 'refundRequest'])->name('refund_request');

    Route::get('/calendar', [CalenderController::class, 'showCalendar'])->name('calendar');
    Route::get('/calendar/events', [CalenderController::class, 'getGoogleCalendarEvents'])->name('get_google_calendar_events');
    Route::get('/calendar/up-coming-events', [CalenderController::class, 'upComingEvents'])->name('up_coming_events');
   ;
    Route::prefix('offering')->group(function () {
        Route::get('/', [OfferingController::class, 'index'])->name('offering');
        Route::get('/add/new', [OfferingController::class, 'addOffering'])->name('add_offering');
        Route::post('/store/', [OfferingController::class, 'store'])->name('store_offering');
        Route::get('/show/{id}/', [OfferingController::class, 'show'])->name('show_offering');
        Route::get('/edit/{id}/', [OfferingController::class, 'edit'])->name('edit_offering');
//        Route::put('/update/{id}/', [OfferingController::class, 'update'])->name('update_offering');
        Route::post('/update/', [OfferingController::class, 'update'])->name('update_offering');
        Route::post('/delete/{id}/', [OfferingController::class, 'delete'])->name('delete_offering');
    });

    Route::prefix('discount')->group(function () {
        Route::get('/', [DiscountController::class, 'index'])->name('discount');
        Route::get('/add', [DiscountController::class, 'add'])->name('add_discount');
        Route::post('/store', [DiscountController::class, 'store'])->name('store_discount');
//        Route::put('/{id}', [DiscountController::class, 'update'])->name('update_discount');
//        Route::delete('/{id}', [DiscountController::class, 'destroy']);
    });

    Route::get('/import-users', [WordpressUserController::class, 'importUsers']);


    Route::get('/google/login', [GoogleAuthController::class, 'redirectToGoogle'])->name('redirect_to_google');
    Route::get('/google/disconnect', [GoogleAuthController::class, 'disconnectToGoogle'])->name('disconnect_to_google');
    Route::get('/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google_callback');
    Route::post('/calendar/create-events', [GoogleCalendarController::class, 'createEvent'])->name('calendar_create');
    Route::post('/calendar/delete', [GoogleCalendarController::class, 'deleteEvent'])->name('calendar_delete');


    /**** Stripe route */

    Route::get('/stripe/connect', [PaymentController::class, 'connectToStripe'])->name('stripe_connect');
    Route::get('/stripe/callback', [PaymentController::class, 'handleStripeCallback'])->name('stripe_callback');
    Route::get('/stripe/disconnect', [PaymentController::class, 'disconnectToStripe'])->name('disconnect_to_stripe');

});
