<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeekerExploreController;

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('user_type')->group(function () {
        Route::get('/dashboard', fn() => view('placeholder'))->name('dashboard');
    });

    // Actual role-specific implementations (hidden from direct access)
    Route::prefix('employer')->middleware('employer')->group(function () {
        Route::get('/dashboard', fn() => view('employer.dashboard'))->name('employer.dashboard');

        Route::get('/posts', [PostController::class, 'index'])->name('employer.posts');
        Route::get('/posts/create', [PostController::class, 'create'])->name('employer.posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('employer.posts.store');

        Route::get('/seeker-profile/{id}', [SeekerExploreController::class, 'showProfile'])->name('seekers.profile');
        Route::get('/seekers-explore', [SeekerExploreController::class, 'exploreSeekers'])->name('seekers.explore');
    });

    Route::prefix('seeker')->middleware('seeker')->group(function () {
        Route::get('/dashboard', fn() => view('seeker.dashboard'))->name('seeker.dashboard');
    });
});

Route::get('/', function () {
    return Auth::guest() ?
        redirect()->route('login.page') :
        redirect()->route('dashboard');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
