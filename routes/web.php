<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employer;
use App\Http\Controllers\Seeker;

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('user_type')->group(function () {
        Route::get('/dashboard', fn() => view('placeholder'))->name('dashboard');

        Route::get('/posts', fn() => view('placeholder'))->name('posts');
        Route::get('/post/create', fn() => view('placeholder'))->name('posts.create');
        Route::post('/post/apply', fn() => view('placeholder'))->name('post.apply');
        Route::post('/post/unapply', fn() => view('placeholder'))->name('post.unapply');

        Route::get('/applications', fn() => view('placeholder'))->name('applications');

        Route::get('/seeker-profile/', fn() => view('placeholder'))->name('seekers');
        Route::get('/employer-profile/', fn() => view('placeholder'))->name('employers');

        Route::get('/seeker-profile/{username}', [Employer\SeekersController::class, 'profile'])->name('seeker-profile');
        Route::get('/employer-profile/{username}', [Employer\SeekersController::class, 'profile'])->name('employer-profile');

        Route::get('/inbox', fn() => view('placeholder'))->name('inbox');
    });

    // Actual role-specific implementations (hidden from direct access)
    Route::prefix('employer')->middleware('employer')->group(function () {
        Route::get('/dashboard', fn() => view('employer.dashboard'))->name('employer.dashboard');

        Route::get('/inbox', [Employer\InboxController::class, 'index'])->name('employer.inbox');

        Route::get('/posts', [Employer\PostsController::class, 'explore'])->name('employer.posts');
        Route::get('/post/create', [Employer\PostsController::class, 'showCreate'])->name('employer.posts.create');
        Route::post('/post/create', [Employer\PostsController::class, 'store'])->name('employer.posts.store');
        Route::post('/post/delete', [Employer\PostsController::class, 'destroy'])->name('employer.posts.destroy');

        Route::get('/post/applications', [Employer\PostsController::class, 'explore'])->name('employer.applications');

        Route::get('/applications', [Employer\ApplicationsController::class, 'explore'])->name('employer.applications');
        Route::post('/application/accept', [Employer\ApplicationsController::class, 'accept'])->name('employer.application.accept');
        Route::post('/application/reject', [Employer\ApplicationsController::class, 'reject'])->name('employer.application.reject');

        Route::get('/seeker-profile/', [Employer\SeekersController::class, 'explore'])->name('employer.seekers');
        Route::get('/seeker-profile/{username}', [Employer\SeekersController::class, 'profile'])->name('employer.seeker-profile');
        Route::get('/seekers', [Employer\SeekersController::class, 'explore'])->name('employer.seekers');
        Route::post('/send-message-to-seeker', [Employer\SeekersController::class, 'sendMessage'])->name('employer.seeker-profile.sendMessage');
    });

    Route::prefix('seeker')->middleware('seeker')->group(function () {
        Route::get('/dashboard', fn() => view('seeker.dashboard'))->name('seeker.dashboard');

        Route::get('/inbox', [Seeker\InboxController::class, 'index'])->name('seeker.inbox');

        Route::get('/applications', [Seeker\ApplicationsController::class, 'explore'])->name('seeker.applications');
        Route::post('/application/unapply', [Seeker\ApplicationsController::class, 'unapply'])->name('seeker.application.unapply');

        Route::get('/posts', [Seeker\PostsController::class, 'explore'])->name('seeker.posts');
        Route::post('/post/apply', [Seeker\PostsController::class, 'apply'])->name('seeker.post.apply');
        Route::post('/post/unapply', [Seeker\PostsController::class, 'unapply'])->name('seeker.post.unapply');

        Route::get('/employer-profile/', [Seeker\EmployersController::class, 'explore'])->name('seeker.employers');
        Route::get('/employer-profile/{username}', [Seeker\EmployersController::class, 'profile'])->name('seeker.employer-profile');
        Route::get('/employers', [Seeker\EmployersController::class, 'explore'])->name('seeker.employers');
        Route::post('/send-message-to-employer', [Seeker\EmployersController::class, 'sendMessage'])->name('seeker.employer-profile.sendMessage');
    });
});

Route::get('/', function () {
    return Auth::guest() ?
        redirect()->route('login.page') :
        redirect()->route('dashboard');
});


Route::middleware(['auth'])->group(function () {

    /* Route::get('/seeker/profile/email/{email}', [SeekerProfileController::class, 'showByEmail'])->name('seekers.profile.byEmail'); */
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
