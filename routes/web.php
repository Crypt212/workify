<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employer;
use App\Http\Controllers\Seeker;
use App\Http\Controllers\SeekerInboxController;
use App\Http\Controllers\SeekerProfileController;

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('user_type')->group(function () {
        Route::get('/dashboard', fn() => view('placeholder'))->name('dashboard');
        Route::get('/posts', fn() => view('placeholder'))->name('posts');
        Route::get('/post/create', fn() => view('placeholder'))->name('posts.create');
        Route::get('/seeker-profile/{id}', fn() => view('placeholder'))->name('seeker.profile');
        Route::get('/seekers', fn() => view('placeholder'))->name('seekers');
    });

    // Actual role-specific implementations (hidden from direct access)
    Route::prefix('employer')->middleware('employer')->group(function () {
        Route::get('/dashboard', fn() => view('employer.dashboard'))->name('employer.dashboard');

        Route::get('/posts', [Employer\PostsController::class, 'explore'])->name('employer.posts');
        Route::get('/post/create', [Employer\PostsController::class, 'showCreate'])->name('employer.posts.create');
        Route::post('/post/create', [Employer\PostsController::class, 'store'])->name('employer.posts.store');

        Route::get('/seeker-profile/{id}', [Employer\SeekersController::class, 'profile'])->name('employer.seeker.profile');
        Route::get('/seekers', [Employer\SeekersController::class, 'explore'])->name('employer.seekers');
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


Route::middleware(['auth'])->group(function () {
    Route::get('/seeker/inbox', [SeekerInboxController::class, 'index'])->name('seeker.inbox');

    Route::get('/seeker/profile/email/{email}', [SeekerProfileController::class, 'showByEmail'])->name('seekers.profile.byEmail');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
