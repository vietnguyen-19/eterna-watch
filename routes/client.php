<?php

use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\Auth\EmailVerificationController;
use App\Http\Controllers\Client\Auth\ForgotPasswordController;
use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\Auth\ResetPasswordController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ShopController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('client.login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('client.logout');
Route::get('/dashboard', function () {
    return view('client.dashboard');
})->name('client.dashboard');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('client.register');
Route::post('/register', [RegisterController::class, 'register'])->name('client.register.submit');


// Route để hiển thị yêu cầu xác minh email
Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationNotice'])
    ->middleware('customer')
    ->name('verification.notice');

// Route xử lý xác minh email
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

// Route để gửi lại email xác minh
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resendVerificationLink'])
    ->middleware(['customer', 'throttle:6,1'])
    ->name('verification.send');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/notfound', [HomeController::class, 'notFound'])->name('client.notfound');
Route::get('/blog', [BlogController::class, 'index'])->name('client.blog');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('client.blog.detail');
Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('client.shop');
    Route::get('show/{id}', [ShopController::class, 'show'])->name('client.shop.show');
    Route::get('/filter-products', [ShopController::class, 'filterProducts'])->name('client.shop.filter');
    Route::get('/get-variant-price', [ShopController::class, 'getVariantPrice']);
});


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove/{variantId}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/check_voucher', [CartController::class, 'checkVoucher'])->name('cart.check_voucher');
});
Route::prefix('checkout')->group(function () {
    Route::post('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/add', [CheckoutController::class, 'addToCart'])->name('checkout.add');
    Route::delete('/remove/{variantId}', [CheckoutController::class, 'removeItem'])->name('checkout.remove');
    Route::post('/update', [CheckoutController::class, 'updateCart'])->name('checkout.update');
    Route::post('/clear', [CheckoutController::class, 'clearCart'])->name('checkout.clear');
    Route::post('/check_voucher', [CheckoutController::class, 'checkVoucher'])->name('checkout.check_voucher');
});

Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('vnpay/callback', [PaymentController::class, 'vnPayCallback'])->name('payment.vnpay.callback');
    Route::get('complete/{id}', [PaymentController::class, 'complete'])->name('payment.complete');
});

Route::prefix('account')->group(function () {
    Route::get('', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('detail', [AccountController::class, 'detail'])->name('account.detail');
    Route::get('order', [AccountController::class, 'order'])->name('account.order');
    Route::get('wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
    Route::get('address', [AccountController::class, 'address'])->name('account.address');
    Route::get('order_detail/{id}', [AccountController::class, 'orderDetail'])->name('account.order_detail');
    Route::post('cancel/{id}', [AccountController::class, 'cancelOrder'])->name('account.cancel');
    Route::delete('/wishlist/remove/{id}', [AccountController::class, 'removeFromWishlist'])->name('wishlist.remove');

});

