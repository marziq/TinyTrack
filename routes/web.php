<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BabyController;
use App\Models\Baby;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('mainpage');

Route::get('/events', function () {
    return view('event');
})->name('event');

Route::get('/services', function () {
    return view('service');
})->name('service');

Route::get('/experts', function () {
    return view('team');
})->name('expert');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');



// Admin routes
Route::get('/login-admin', function () {
    return view('admin/login-admin');
})->name('adminlogin');

Route::get('/dashboard-admin', function () {
    return view('admin/dashboard-admin');
})->name('dashboardadmin');

Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('user/mybaby');
    })->name('dashboard');

    Route::get('/dashboard/mybaby', function () {
        return view('user/mybaby');
    })->name('mybaby');

    Route::get('/dashboard/growth', function () {
        return view('user/growth');
    })->name('growth');

    Route::get('/dashboard/tips', function () {
        return view('user/tips');
    })->name('tips');

    Route::get('/dashboard/milestone', function () {
        return view('user/milestone');
    })->name('milestone');

    Route::get('/dashboard/appointment', function () {
        return view('user/appointment');
    })->name('appointment');

    Route::get('/dashboard/settings', function () {
        return view('user/settings');
    })->name('settings');

    Route::get('/dashboard/account', function () {
        return view('user/myaccount');
    })->name('myaccount');
    // Baby resource routes
    Route::get('/babies/{id}', [BabyController::class, 'getBaby']); // Route to get baby details
    Route::resource('babies', BabyController::class);
    Route::get('dashboard/appointment', [BabyController::class, 'index'])->name('appointment');
});

Route::get('/babies/{baby}', function(Baby $baby) {
    return response()->json($baby);
})->middleware('auth');
