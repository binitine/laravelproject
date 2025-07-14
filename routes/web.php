<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $notifications = auth()->user()->unreadNotifications()->take(5);
    return view('dashboard', compact('notifications'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::resource('bookings', App\Http\Controllers\BookingController::class);
    Route::get('/admin/bookings', [App\Http\Controllers\AdminBookingController::class, 'index'])->name('admin.bookings');
    
    // User management routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Admin reports and settings routes
    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
    
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

require __DIR__.'/auth.php';
