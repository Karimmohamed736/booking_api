<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//paymob
Route::post('/credit', [PaymentController::class, 'credit'])->name('payment.credit');
Route::get('/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.failed');
