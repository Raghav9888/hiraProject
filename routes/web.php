<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\ImpersonationController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Calender\CalenderController;
use App\Http\Controllers\Calender\GoogleAuthController;
use App\Http\Controllers\Calender\GoogleCalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Practitioner\DiscountController;
use App\Http\Controllers\Practitioner\OfferingController;
use App\Http\Controllers\Practitioner\PaymentController;
use App\Http\Controllers\Practitioner\PractitionerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\WordpressUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::post('/reset-password', [ForgotPasswordController::class, 'sendResetLink'])->name('send.resetLink');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/', [HomeController::class, 'comingIndex'])->name('home');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
Route::get('/pending/user', [HomeController::class, 'pendingUser'])->name('pendingUserRequest');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContactMail'])->name('sendContactMail');
//Route::get('/setEndorsement/{id}', [HomeController::class, 'setEndorsement'])->name('setEndorsement');
Route::post('/setEndorsement/{id}', [HomeController::class, 'addEndorsement']);
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetail'])->name('blogDetail');
Route::get('/search/practitioner/{categoryType?}', [HomeController::class, 'searchPractitioner'])->name('searchPractitioner');
Route::get('/practitioners', [HomeController::class, 'partitionerLists'])->name('partitionerLists');
Route::post('/getEvent', [HomeController::class, 'getEvent'])->name('getEvent');
Route::get('/land-acknowledgement', [HomeController::class, 'acknowledgement'])->name('acknowledgement');
Route::get('/our-story', [HomeController::class, 'ourStory'])->name('our_story');
Route::get('/our-vision', [HomeController::class, 'ourVision'])->name('our_vision');
Route::get('/core-values', [HomeController::class, 'coreValues'])->name('core_values');
Route::post('/getBookedSlots/{userId}', [GoogleCalendarController::class, 'getBookedSlots'])->name('getBookedSlots');
Route::post('/news-letter', [HomeController::class, 'newsLetter'])->name('newsLetter');

Route::get('/practitioner/detail/{id}', [HomeController::class, 'practitionerDetail'])->name('practitioner_detail');
Route::get('/practitioner/offering/detail/{id}', [HomeController::class, 'practitionerOfferingDetail'])->name('practitionerOfferingDetail');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy_policy');
Route::get('/terms-conditions', [HomeController::class, 'termsConditions'])->name('terms_conditions');
//Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('create.payment');
Route::post('/storeCheckout', [PaymentController::class, 'storeCheckout'])->name('storeCheckout');
Route::get('/payment/{order_id}', [PaymentController::class, 'showPaymentPage'])->name('payment');
Route::post('/stripe/payment', [PaymentController::class, 'processStripePayment'])->name('stripe.payment');
Route::get('/confirm-payment', [PaymentController::class, 'confirmPayment'])->name('confirm-payment');
Route::get('/payment-success', [PaymentController::class, 'success'])->name('thankyou');
Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.cancel');
Route::get('/calendar/time-slots/{date}/{id}', [HomeController::class, 'getTimeSlots'])->name('get_time_slots');

Route::post('/storeBooking', [BookingController::class, 'storeBooking'])->name('storeBooking');
Route::post('/pre-checkout-register', [BookingController::class, 'preCheckoutRegister'])->name('preCheckout.register');
Route::post('/pre-checkout', [BookingController::class, 'preCheckout'])->name('preCheckout');
Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');


Route::middleware(['auth', 'user-access:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/{userType}/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/delete/user/', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/approve/user/', [UserController::class, 'approve'])->name('user.approve');
    Route::post('/login/as', [UserController::class, 'loginAs'])->name('login.as');
    Route::resource('blogs', BlogController::class);
    Route::resource('plans', PlanController::class);

    Route::get('/locations', [LocationController::class, 'locations'])->name('location.index');
    Route::get('/create/location', [LocationController::class, 'createLocation'])->name('location.create');
    Route::post('/add/location', [LocationController::class, 'addLocation'])->name('location.add');
    Route::get('/edit/location/{id}', [LocationController::class, 'editLocation'])->name('location.edit');
    Route::post('/admin/location/update/{id}', [LocationController::class, 'updateLocation'])->name('location.update');
    Route::post('/delete/location/{id}', [LocationController::class, 'deleteLocation'])->name('location.delete');

    Route::resource('category', CategoryController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::get('/feedback/get-offerings/{userId}', [FeedbackController::class, 'getOfferingsByUser'])->name('getOfferingsByUser');
});

Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/my-profile', [PractitionerController::class, 'index'])->name('my_profile');
    Route::get('/help', [PractitionerController::class, 'help'])->name('help');

    Route::get('/dashboard', [PractitionerController::class, 'dashboard'])->name('dashboard');
    Route::get('/community', [PractitionerController::class, 'community'])->name('community');
    Route::get('/my-membership', [PractitionerController::class, 'membership'])->name('my_membership');
    Route::post('/membership-buy', [PractitionerController::class, 'membershipBuy'])->name('membership.buy');
    Route::get('/store/membership', [PractitionerController::class, 'storeMembership'])->name('store_membership');
    Route::post('/term/add', [PractitionerController::class, 'add_term'])->name('add_term');
    Route::post('/term/save', [PractitionerController::class, 'save_term'])->name('save_term');
    Route::post('/profile/update', [PractitionerController::class, 'updateProfile'])->name('update_profile');
    Route::post('/client-policy/update', [PractitionerController::class, 'updateClientPolicy'])->name('update_client_policy');
    Route::post('/delete/image', [PractitionerController::class, 'deleteImage'])->name('delete_image');
    Route::get('/appointment', [PractitionerController::class, 'appointment'])->name('appointment');
    Route::get('/accounting', [PractitionerController::class, 'accounting'])->name('accounting');
    Route::post('/personal/information/update', [PractitionerController::class, 'membershipPersonalInformation'])->name('membershipPersonalInformation');
    Route::post('/professional/service/information/update', [PractitionerController::class, 'professionalServiceInformation'])->name('professionalServiceInformation');
    Route::post('/community/engagement/update', [PractitionerController::class, 'communityEngagement'])->name('communityEngagement');

    Route::get('/earning', [PractitionerController::class, 'earning'])->name('earning');
    Route::get('/refund/request', [PractitionerController::class, 'refundRequest'])->name('refund_request');

    Route::get('/calendar', [CalenderController::class, 'showCalendar'])->name('calendar');
    Route::get('/calendar/events', [CalenderController::class, 'getGoogleCalendarEvents'])->name('get_google_calendar_events');
    Route::get('/calendar/up-coming-appointments', [CalenderController::class, 'upComingAppointments'])->name('up_coming_appointments');;
    Route::prefix('offering')->group(function () {
        Route::get('/', [OfferingController::class, 'index'])->name('offering');
        Route::get('/add/new', [OfferingController::class, 'addOffering'])->name('add_offering');
        Route::post('/store/', [OfferingController::class, 'store'])->name('store_offering');
        Route::get('/show/{id}/', [OfferingController::class, 'show'])->name('show_offering');
        Route::get('/edit/{id}/', [OfferingController::class, 'edit'])->name('edit_offering');
        Route::post('/duplicate/{id}/', [OfferingController::class, 'duplicate'])->name('duplicate_offering');
//        Route::put('/update/{id}/', [OfferingController::class, 'update'])->name('update_offering');
        Route::post('/update/', [OfferingController::class, 'update'])->name('update_offering');
        Route::post('/delete/{id}/', [OfferingController::class, 'delete'])->name('delete_offering');
    });
    Route::post('/save/event', [OfferingController::class, 'saveEvent'])->name('save_event');

    Route::prefix('discount')->group(function () {
        Route::get('/', [DiscountController::class, 'index'])->name('discount');
        Route::get('/add', [DiscountController::class, 'add'])->name('add_discount');
        Route::post('/store', [DiscountController::class, 'store'])->name('store_discount');
        Route::get('/{id}', [DiscountController::class, 'edit'])->name('edit_discount');
        Route::post('/{id}', [DiscountController::class, 'update'])->name('update_discount');
        Route::post('/delete/{id}', [DiscountController::class, 'destroy'])->name('delete_discount');
//        Route::put('/{id}', [DiscountController::class, 'update'])->name('update_discount');
    });

    Route::get('/import-users', [WordpressUserController::class, 'importUsers']);


    Route::get('/google/login', [GoogleAuthController::class, 'redirectToGoogle'])->name('redirect_to_google');
    Route::get('/google/disconnect', [GoogleAuthController::class, 'disconnectToGoogle'])->name('disconnect_to_google');
    Route::get('/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google_callback');
    Route::post('/calendar/create-event', [GoogleCalendarController::class, 'createEvent'])->name('calendar_create');
    Route::post('/calendar/update-event', [GoogleCalendarController::class, 'updateEvent'])->name('calendar_update');
    Route::post('/calendar/delete', [GoogleCalendarController::class, 'deleteEvent'])->name('calendar_delete');


    /**** Stripe route */

    Route::get('/stripe/connect', [PaymentController::class, 'connectToStripe'])->name('stripe_connect');
    Route::get('/stripe/callback', [PaymentController::class, 'handleStripeCallback'])->name('stripe_callback');
    Route::get('/stripe/disconnect', [PaymentController::class, 'disconnectToStripe'])->name('disconnect_to_stripe');

});
