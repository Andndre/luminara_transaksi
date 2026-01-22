<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Endpoint untuk Finish Redirect dari Midtrans
Route::get('/payment-finish', function () {
    return view('payment_finish');
});

// Endpoint untuk Error/Failed Redirect dari Midtrans
Route::get('/payment-failed', function () {
    return view('payment_failed');
});

use App\Http\Controllers\BookingController;

// Rute untuk memproses form booking
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
