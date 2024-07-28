<?php
use App\Http\Controllers\StripeController;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buy-vegetables', [StripeController::class, 'index'])->name('buy.vegetables');

Route::get('/payment', [StripeController::class, 'showPaymentPage'])->name('show.payment.page');

Route::get('/checkout/{id}', [StripeController::class, 'checkout'])->name('checkout');
Route::post('/handle-payment', [StripeController::class, 'handlePayment'])->name('handle.payment');
Route::get('/payment-confirmation', [StripeController::class, 'paymentConfirmation'])->name('payment.confirmation');

Route::get('/shop', [StripeController::class, 'index'])->name('shop');

Route::get('/add-vegetable', [StripeController::class, 'create'])->name('vegetable.create');
Route::post('/add-vegetable', [StripeController::class, 'store'])->name('vegetable.store');
