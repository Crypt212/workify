<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.page');
    Route::get('/', [AuthController::class, 'showLogin'])->name('login.page');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->identity === "seeker")
        return view("seeker.dashboard");
    elseif (Auth::user()->identity === "employer")
        return view("employer.dashboard");
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/employer/seekers', [EmployerController::class, 'searchForm'])->name('seekers.searchForm');
Route::get('/employer/seekers/search', [EmployerController::class, 'search'])->name('seekers.search');
