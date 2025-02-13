<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

// Route::group(['prefix' => 'admin'], function () {
    // Guest Middleware
    Route::group(['middleware' => 'guest:admin'], function () {
        Route::get('/login', [UserLoginController::class, 'index'])->name('user.login');
        Route::post('/authenticate', [UserLoginController::class, 'authenticate'])->name('user.authenticate');
    });
    // Authenticated Middleware
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');        
    });
// });