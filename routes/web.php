<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// Public Routes
Route::get('/', [BookingController::class, 'landing'])->name('home');
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/calendar/availability', [BookingController::class, 'availability'])->name('calendar.availability');

// Admin Routes (Should be protected by auth middleware in real app)
Route::prefix('admin')->group(function () {
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
    Route::patch('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
});

// Legacy Midtrans Routes (Preserved)
Route::get('/payment-finish', function () {
    return view('payment_finish');
});
Route::get('/payment-failed', function () {
    return view('payment_failed');
});