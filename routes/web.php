<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\ActivityLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->to('/home');
})->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::get('/email/verify/{id}/{hash}', [RegisteredUserController::class, 'verify'])->middleware(['signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verified', function () {
    return view('auth.verified');
})->middleware('auth')->name('verification.verified');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// User dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/module/{module:slug}', [DashboardController::class, 'showModule'])->middleware('rbac')->name('module.show');
    Route::view('/home', 'user.home')->name('user.home');
    Route::view('/vilo-story', 'user.story')->name('user.story');
    Route::view('/contact', 'user.contact')->name('user.contact');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/audit-logs', [ActivityLogController::class, 'index'])->name('audit-logs.index');

    Route::resource('modules', ModuleController::class);
    Route::resource('roles', RoleController::class);
    Route::get('user-roles', [UserRoleController::class, 'index'])->name('user-roles.index');
    Route::get('user-roles/{user}/edit', [UserRoleController::class, 'edit'])->name('user-roles.edit');
    Route::put('user-roles/{user}', [UserRoleController::class, 'update'])->name('user-roles.update');
    Route::post('user-roles/assign', [UserRoleController::class, 'assign'])->name('user-roles.assign');

    // Permission management (only for super admin)
    Route::middleware('super_admin')->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/{user}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{user}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::post('/permissions/{user}/clone', [PermissionController::class, 'clone'])->name('permissions.clone');

        Route::resource('users', UserController::class);


    });

    // Content management - nested modular structure
    Route::prefix('modules/{module}')->name('modules.')->group(function () {
        Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
        Route::get('/contents/create', [ContentController::class, 'create'])->name('contents.create');
        Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
        Route::get('/contents/{content}/edit', [ContentController::class, 'edit'])->name('contents.edit');
        Route::put('/contents/{content}', [ContentController::class, 'update'])->name('contents.update');
        Route::delete('/contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');
        Route::post('/contents/{content}/publish', [ContentController::class, 'publish'])->name('contents.publish');
        Route::post('/contents/{content}/draft', [ContentController::class, 'draft'])->name('contents.draft');
    });
});
