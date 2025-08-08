<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\SeekerExploreController; // ⬅ استدعاء الكنترولر الجديد

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

// صفحة عرض بروفايل الـ seeker
Route::get('/employer/seekers/{id}', [EmployerController::class, 'show'])->name('seekers.profile');

// صفحة استكشاف الـ seekers مع البحث والفلاتر
Route::get('/employer/seekers-explore', [SeekerExploreController::class, 'index'])->name('seekers.explore');
