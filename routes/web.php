<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

// Public Routes
Route::get('/', [BookingController::class, 'landing'])->name('home');
Route::get('/pricelist', function () {
    $packages = \App\Models\Package::with(['prices' => function($q) {
        $q->orderBy('duration_hours');
    }])->where('is_active', true)->get();
    return view('pricelist', compact('packages'));
})->name('pricelist');
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/calendar/availability', [BookingController::class, 'availability'])->name('calendar.availability');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [BookingController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
    Route::get('/bookings/{id}/edit', [BookingController::class, 'adminEdit'])->name('admin.bookings.edit');
    Route::put('/bookings/{id}', [BookingController::class, 'adminUpdate'])->name('admin.bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'adminDestroy'])->name('admin.bookings.destroy');
    Route::patch('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
    
    // Calendar Routes
    Route::get('/calendar', [BookingController::class, 'calendarIndex'])->name('admin.calendar.index');
    Route::post('/calendar/block', [BookingController::class, 'blockDate'])->name('admin.calendar.block');
    Route::delete('/calendar/{id}', [BookingController::class, 'unblockDate'])->name('admin.calendar.unblock');

    // Package Routes
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class)->names('admin.packages');
});

// Legacy Midtrans Routes
Route::get('/payment-finish', function () {
    return view('payment_finish');
});
Route::get('/payment-failed', function () {
    return view('payment_failed');
});
