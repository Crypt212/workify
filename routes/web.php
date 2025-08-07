<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister']) ->name('register.page');
    Route::post('register', [AuthController::class, 'register']) ->name('register');

    Route::get('login', [AuthController::class, 'showLogin']) ->name('login.page');
    Route::post('login', [AuthController::class, 'login']) ->name('login');
});
