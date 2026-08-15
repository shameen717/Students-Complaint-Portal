<?php

use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'home.welcome')->name('home');

// Public complaint tracking by code (works for anonymous complaints too)
Route::get('/track', [ComplaintController::class, 'track'])->name('complaints.track');

/*
|--------------------------------------------------------------------------
| Guest-only routes (registration & login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Student routes (any authenticated user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
});

/*
|--------------------------------------------------------------------------
| Admin-only routes (RBAC via IsAdmin middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('/complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('complaints.status');
    Route::patch('/complaints/{complaint}/assign', [AdminComplaintController::class, 'assign'])->name('complaints.assign');
    Route::delete('/complaints/{complaint}', [AdminComplaintController::class, 'destroy'])->name('complaints.destroy');
});
