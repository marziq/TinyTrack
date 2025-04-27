<?php

use Illuminate\Support\Facades\Route;

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



//admin stuff
Route::get('/login-admin', function () {
    return view('admin/login-admin');
})->name('adminlogin');

Route::get('/dashboard-admin', function () {
    return view('admin/dashboard-admin');
})->name('dashboardadmin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


});
