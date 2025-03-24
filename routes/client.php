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
use App\Http\Controllers\Client\CommentController;
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
    Route::post('/remove', [CartController::class, 'removeFromCart']);
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove-selected', [CartController::class, 'removeSelectedItems']);
    Route::post('/check_voucher', [CartController::class, 'checkVoucher'])->name('cart.check_voucher');
    Route::post('/update-total', [CartController::class, 'updateTotal'])->name('cart.update_total');
});
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/store', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('vnpay/callback', [PaymentController::class, 'vnPayCallback'])->name('payment.vnpay.callback');
    Route::get('complete/{id}', [PaymentController::class, 'complete'])->name('payment.complete');
});

Route::prefix('comments')->middleware('customer')->group(function () {
    Route::post('/store/{id}', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/store-post/{id}', [CommentController::class, 'storePost'])->name('comments.store_post');
    Route::post('/{comment}/reply/{entity_id}', [CommentController::class, 'reply'])->name('comments.reply');
    Route::put('/update/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::delete('/delete/{comment}', [CommentController::class, 'delete'])->name('comments.delete');
});

Route::prefix('account')->group(function () {
    Route::get('edit_detail', [AccountController::class, 'editAccount'])->name('account.edit');
    Route::post('update', [AccountController::class, 'update'])->name('account.update');
    Route::get('order', [AccountController::class, 'order'])->name('account.order');

    Route::get('re_password', [AccountController::class, 'rePassword'])->name('account.re_password');
    Route::post('update_pass', [AccountController::class, 'updatePass'])->name('account.update_pass');

    Route::get('order_detail/{id}', [AccountController::class, 'orderDetail'])->name('account.order_detail');
    Route::post('cancel/{id}', [AccountController::class, 'cancelOrder'])->name('account.cancel');
   
    Route::post('/upload-image', [AccountController::class, 'uploadImage']);
    Route::post('/remove-image', [AccountController::class, 'removeImage']);

});

Route::get('contact_us', [AccountController::class, 'editAccount'])->name('client.contact_us');
Route::get('about_us', [AccountController::class, 'editAccount'])->name('client.about_us');

