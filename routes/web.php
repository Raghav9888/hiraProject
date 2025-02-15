<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PractitionerController;
use Illuminate\Support\Facades\Auth;

/* Route::get('/', function () {
    return view('home');
}); */

Auth::routes();

 Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::namespace('Admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    });
});

Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/myprofile', [PractitionerController::class, 'index'])->name('myprofile');
    Route::get('/Offering', [PractitionerController::class, 'index'])->name('Offering');
    Route::get('/discount', [PractitionerController::class, 'index'])->name('discount');
});