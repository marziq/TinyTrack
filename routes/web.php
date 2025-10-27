<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\GrowthController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\AppointmentController;
use App\Models\Baby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteTipController;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('mainpage');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/services', function () {
    return view('service');
})->name('service');

Route::get('/experts', function () {
    return view('team');
})->name('expert');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Public routes end

// Favorite Tips routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/save-favorite-tip', [FavoriteTipController::class, 'store']);
    Route::delete('/favorite-tip/{id}', [FavoriteTipController::class, 'destroy']);
    Route::get('/check-favorite/{tipId}', [FavoriteTipController::class, 'checkFavorite']);
});

// Admin routes
Route::get('/login-admin', function () {
    return view('admin.login-admin');
})->name('login-admin');
Route::post('/login-admin', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        if (Auth::user()->email === 'support@tinytrack.com') {
            return redirect()->route('dashboard-admin');
        }
        Auth::logout(); // Log out the non-admin user
        return back()->withErrors(['email' => 'You are not authorized to access the admin dashboard.']);
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
})->name('admin.login.submit');

Route::get('/admin/calendar', function () {
    return view('admin/calendar');
})->name('admincalendar');

Route::get('/admin/settings', function () {
    return view('admin/settings');
})->name('adminsettings');

Route::get('admin/dashboard', [AdminController::class, 'index'])->name('dashboard-admin');
Route::get('admin/users', [AdminController::class, 'usersAdmin'])->name('users-admin');
Route::delete('admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
Route::get('/admin/messages', [NotificationsController::class, 'index'])->name('messages-admin');

//admin routes end

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [BabyController::class, 'index'])->name('dashboard'); // Use BabyController for dashboard
    Route::get('/dashboard/mybaby', [BabyController::class, 'index'])->name('mybaby'); // Use BabyController for mybaby

    Route::get('/dashboard/growth', function () {
        return view('user/growth');
    })->name('growth');

    Route::get('/dashboard/tips', function () {
        return view('user/tips');
    })->name('tips');

    Route::get('/dashboard/milestone', function () {
        return view('user/milestone');
    })->name('milestone');

    Route::get('/dashboard/appointment', [BabyController::class, 'index'])->name('appointment'); // Already using BabyController

    Route::get('/dashboard/settings', function () {
        return view('user/settings');
    })->name('settings');

    Route::get('/dashboard/account', function () {
        return view('user/myaccount');
    })->name('myaccount');

    Route::get('/dashboard/chat', function () {
        return view('user/chatbot');
    })->name('chatbot');
    Route::get('/dashboard/checkup', function () {
        return view('user/checkup');
    })->name('checkup');

    //Ai testing
    Route::get('/test', function () {
        return view('user/test');
    })->name('test');

    // Baby resource routes
    Route::get('/babies/{id}', [BabyController::class, 'getBaby']); // Route to get baby details
    Route::resource('babies', BabyController::class);
    Route::get('/growth-data/{babyId}', [GrowthController::class, 'getGrowthData']);


    Route::post('/dashboard/growths/store', [GrowthController::class, 'store'])->name('growth.store');
    Route::get('/dashboard/growth', [GrowthController::class, 'create'])->name('growth');
    Route::get('dashboard/growth/{babyId}', [GrowthController::class, 'getGrowthData'])->name('growth.data');
    Route::get('dashboard/appointment/{babyId}', [AppointmentController::class, 'getAppointmentsByBaby']);
});

Route::get('/babies/{baby}', function(Baby $baby) {
    return response()->json($baby);
})->middleware('auth');

Route::resource('notifications', NotificationsController::class);
Route::post('/notifications/{id}/mark-read', [NotificationsController::class, 'markRead'])->name('notifications.markRead');
Route::put('/notifications/{notification}', [NotificationsController::class, 'update'])->name('notifications.update');
Route::get('/notifications/{id}', [NotificationsController::class, 'getNotification']);

Route::middleware(['auth'])->group(function () {
    Route::get('/myaccount', [UserController::class, 'index'])->name('myaccount');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/babies-count', [UserController::class, 'getBabiesCount'])->name('user.babies-count');
});
