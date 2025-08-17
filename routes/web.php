<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employer;
use App\Http\Controllers\Seeker;

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');
    Route::get('/',  fn() => redirect()->route('dashboard'));

    Route::put('/dashboard', [DashboardController::class, 'updateProfile'])->name('dashboard.update');
    Route::post('/dashboard', [DashboardController::class, 'updatePassword'])->name('dashboard.update-password');

    Route::middleware('user_type')->group(function () {

        Route::get('/posts', fn() => view('placeholder'))->name('posts');
        Route::get('/post/create', fn() => view('placeholder'))->name('posts.create');
        Route::post('/post/apply', fn() => view('placeholder'))->name('post.apply');
        Route::post('/post/unapply', fn() => view('placeholder'))->name('post.unapply');

        Route::get('/applications', fn() => view('placeholder'))->name('applications');

        Route::get('/employer-profile/{uesrname}', fn() => view('placeholder'))->name('employer-profile');

        Route::get('/employer-profile', fn() => view('placeholder'))->name('employers');
        Route::get('/employers',        fn() => view('placeholder'))->name('employers');

        Route::get('/seeker-profile/{username}', fn() => view('placeholder'))->name('seeker-profile');

        Route::get('/seeker-profile',   fn() => view('placeholder'))->name('seekers');
        Route::get('/seekers',          fn() => view('placeholder'))->name('seekers');

        Route::get('/inbox', fn() => view('placeholder'))->name('inbox');
    });

    // Actual role-specific implementations (hidden from direct access)
    Route::prefix('employer')->middleware('employer')->group(function () {
        Route::get('/inbox', [Employer\InboxController::class, 'index'])->name('employer.inbox');

        Route::get('/posts', [Employer\PostsController::class, 'explore'])->name('employer.posts');
        Route::get('/post/create', [Employer\PostsController::class, 'showCreate'])->name('employer.posts.create');
        Route::post('/post/create', [Employer\PostsController::class, 'store'])->name('employer.posts.store');
        Route::delete('/post/delete/{post}', [Employer\PostsController::class, 'destroy'])->name('employer.posts.destroy');

        Route::get('/post/applications', [Employer\PostsController::class, 'explore'])->name('employer.applications');

        Route::get('/applications', [Employer\ApplicationsController::class, 'explore'])->name('employer.applications');
        Route::post('/application/accept/{application}', [Employer\ApplicationsController::class, 'accept'])->name('employer.application.accept');
        Route::post('/application/reject/{application}', [Employer\ApplicationsController::class, 'reject'])->name('employer.application.reject');

        Route::get('/seeker-profile/{username}', [Employer\SeekersController::class, 'profile'])->name('employer.seeker-profile');

        Route::get('/seeker-profile',   fn() => redirect()->route('employer.seekers'));
        Route::get('/seekers',          [Employer\SeekersController::class, 'explore'])->name('employer.seekers');

        Route::post('/send-message', [Employer\InboxController::class, 'sendMessage'])->name('employer.seeker-profile.sendMessage');
    });

    Route::prefix('seeker')->middleware('seeker')->group(function () {

        Route::get('/inbox', [Seeker\InboxController::class, 'index'])->name('seeker.inbox');

        Route::get('/applications', [Seeker\ApplicationsController::class, 'explore'])->name('seeker.applications');
        Route::delete('/application/unapply/{application}', [Seeker\ApplicationsController::class, 'unapply'])->name('seeker.application.unapply');

        Route::get('/posts', [Seeker\PostsController::class, 'explore'])->name('seeker.posts');

        Route::post('/post/apply/{post}', [Seeker\PostsController::class, 'apply'])->name('seeker.post.apply');
        Route::post('/post/unapply/{post}', [Seeker\PostsController::class, 'unapply'])->name('seeker.post.unapply');

        Route::get('/employer-profile/{uesrname}', [Seeker\EmployersController::class, 'profile'])->name('seeker.employer-profile');

        Route::get('/employer-profile', fn() => redirect()->route('seeker.employers'));
        Route::get('/employers',        [Seeker\EmployersController::class, 'explore'])->name('seeker.employers');

        Route::post('/send-message', [Seeker\InboxController::class, 'sendMessage'])->name('seeker.employer-profile.sendMessage');
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
