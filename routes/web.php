<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use Illuminate\Support\Facades\Session;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('index');
});


Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
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
        
        Route::resource('designations', DesignationController::class);
    });
// });