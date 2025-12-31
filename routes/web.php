<?php

use App\Models\Baby;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GrowthController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FavoriteTipController;
use App\Http\Controllers\OpenAIProxyController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\NotificationsController;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Schema;


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
    return view('expert');
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
        // Ensure we log out using the session (web) guard — avoid calling logout on a RequestGuard
        Auth::guard('web')->logout(); // Log out the non-admin user
        return back()->withErrors(['email' => 'You are not authorized to access the admin dashboard.']);
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
})->name('admin.login.submit');

Route::get('/admin/calendar', [AdminController::class, 'calendar'])->name('admincalendar');
Route::get('/api/admin/appointments', [AdminController::class, 'getAppointments'])->name('api.admin.appointments');

Route::get('/admin/settings', [AdminController::class, 'settings'])->name('adminsettings');
Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

Route::get('admin/dashboard', [AdminController::class, 'index'])->name('dashboard-admin');
Route::get('admin/users', [AdminController::class, 'usersAdmin'])->name('users-admin');
Route::delete('admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
Route::get('/admin/messages', [NotificationsController::class, 'index'])->name('messages-admin');

Route::post('/admin/run-reminders', function (Request $request) {
    if (! Auth::check()) {
        abort(403);
    }

    // Optional: restrict to admin email if desired
    if (Auth::user()->email !== 'support@tinytrack.com') {
        abort(403);
    }

    try {
        Artisan::call('app:send-appointment-reminders');
        return redirect()->back()->with('status', 'Appointment reminders dispatched.');
    } catch (\Throwable $e) {
        \Log::error('Run reminders failed: '.$e->getMessage());
        return redirect()->back()->with('error', 'Failed to dispatch reminders.');
    }
})->name('admin.run-reminders')->middleware('auth');

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

    // Milestones API for frontend
    Route::get('/babies/{babyId}/milestones', [MilestoneController::class, 'byBaby']);
    Route::get('/babies/{babyId}/milestones/recent', [MilestoneController::class, 'recent']);
    Route::post('/milestones/{milestone}/toggle', [MilestoneController::class, 'toggle']);

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
    // Proxy endpoints for AI (use server-side secret stored in .env)
    Route::post('/proxy/openrouter/chat', [\App\Http\Controllers\OpenAIProxyController::class, 'chat'])->name('proxy.openrouter.chat');
    Route::post('/proxy/openrouter/summarize', [\App\Http\Controllers\OpenAIProxyController::class, 'summarize'])->name('proxy.openrouter.summarize');
    Route::post('/proxy/openrouter/recommendation', [\App\Http\Controllers\OpenAIProxyController::class, 'recommendation'])->name('proxy.openrouter.recommendation');
    Route::get('/dashboard/checkup', function () {
        return view('user/checkup');
    })->name('checkup');

    // User account deletion
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');

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

// Notification API endpoints for frontend
Route::middleware(['auth'])->group(function () {
    Route::get('/api/notifications', [NotificationsController::class, 'getUserNotifications'])->name('api.notifications.all');
    Route::get('/api/notifications/unread', [NotificationsController::class, 'getUnreadNotifications'])->name('api.notifications.unread');
    Route::post('/api/notifications/{id}/mark-read', [NotificationsController::class, 'markNotificationRead'])->name('api.notifications.mark-read');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/myaccount', [UserController::class, 'index'])->name('myaccount');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/babies-count', [UserController::class, 'getBabiesCount'])->name('user.babies-count');
});

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/baby/{babyId}', [AppointmentController::class, 'getAppointmentsByBaby'])->name('appointments.by.baby');
// Vaccination routes
Route::get('/vaccinations/baby/{babyId}', [VaccinationController::class, 'getVaccinationsByBaby'])->name('vaccinations.by.baby');
Route::post('/vaccinations/{id}/toggle', [VaccinationController::class, 'toggle'])->name('vaccinations.toggle');

Route::get('/send-appointment-reminder', function () {
    if (! Auth::check()) {
        return response('Not authenticated. Please log in to send a test appointment reminder.', 401);
    }

    $user = Auth::user();

    // Build query: prefer direct appointment.user_id only if column exists, otherwise rely on baby->user_id
    $query = Appointment::with(['baby', 'user']);

    if (Schema::hasColumn('appointments', 'user_id')) {
        $query->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhereHas('baby', function ($qb) use ($user) {
                  $qb->where('user_id', $user->id);
              });
        });
    } else {
        // appointments table doesn't have user_id, match via baby relation only
        $query->whereHas('baby', function ($qb) use ($user) {
            $qb->where('user_id', $user->id);
        });
    }

    $appointment = $query->first();

    if (! $appointment) {
        return response('No appointment found for the current user', 404);
    }

    try {
        Mail::to($user->email)->send(new AppointmentReminder($appointment, $user));
        return 'Appointment reminder sent to '.$user->email;
    } catch (\Throwable $e) {
        \Log::error('Send appointment reminder failed: '.$e->getMessage());
        return response('Failed to send: '.$e->getMessage(), 500);
    }
});
