<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\{
    AccountController,
    AddressController,
    AuthController,
    BlogController,
    CartController,
    CheckoutController,
    CommentController,
    HomeController,
    PaymentController,
    SettingController,
    ShopController,
    RefundController,
    Auth\LoginController,
    Auth\RegisterController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController,
    Auth\EmailVerificationController
};
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('client.login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('client.logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('client.register');
Route::post('/register', [RegisterController::class, 'register'])->name('client.register.submit');

// Forgot & Reset Password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/search', [HomeController::class, 'search'])->name('client.search');
Route::get('/notfound', [HomeController::class, 'notFound'])->name('client.notfound');

Route::get('/blog', [BlogController::class, 'index'])->name('client.blog');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('client.blog.detail');

Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('client.shop');
    Route::get('show/{id}', [ShopController::class, 'show'])->name('client.shop.show');
    Route::get('/filter-products', [ShopController::class, 'filterProducts'])->name('client.shop.filter');
    Route::get('/get-variant-price', [ShopController::class, 'getVariantPrice']);
});



Route::get('contact_us', [SettingController::class, 'contactUs'])->name('client.contact_us');
Route::post('contact_us/store', [SettingController::class, 'contactStore'])->name('client.contact_us.store');
Route::get('about_us', [SettingController::class, 'aboutUs'])->name('client.about_us');
Route::get('privacy', [SettingController::class, 'privacy'])->name('client.privacy');
Route::get('return-policy', [SettingController::class, 'returnPolicy'])->name('client.return-policy');

/*
|--------------------------------------------------------------------------
| Chatbot
|--------------------------------------------------------------------------
*/
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('client.chatbot.index');
Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('client.chatbot.chat');

/*
|--------------------------------------------------------------------------
| Protected Routes (Cần login và là khách hàng)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'customer'])->group(function () {

    Route::get('/dashboard', fn() => view('client.dashboard'))->name('client.dashboard');

    // Email Verification
    Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resendVerificationLink'])->middleware('throttle:6,1')->name('verification.send');

    // Checkout
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/store', [CheckoutController::class, 'store'])->name('checkout.store');
    });

    // Payments
    Route::prefix('payments')->group(function () {
        Route::post('/', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::get('vnpay/callback', [PaymentController::class, 'vnPayCallback'])->name('payment.vnpay.callback');
        Route::get('complete/{id}', [PaymentController::class, 'complete'])->name('payment.complete');
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
    // Refunds
    Route::prefix('orders')->group(function () {
        Route::get('/{id}/refund', [RefundController::class, 'create'])->name('refunds.create');
        Route::post('/{id}/refund', [RefundController::class, 'store'])->name('refunds.store');
    });

    // Comments
    Route::prefix('comments')->group(function () {
        Route::post('/store/{id}', [CommentController::class, 'store'])->name('comments.store');
        Route::post('/store-post/{id}', [CommentController::class, 'storePost'])->name('comments.store_post');
        Route::post('/{comment}/reply/{entity_id}', [CommentController::class, 'reply'])->name('comments.reply');
        Route::put('/update/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/delete/{comment}', [CommentController::class, 'delete'])->name('comments.delete');
    });

    // Account
    Route::prefix('account')->group(function () {
        Route::resource('addresses', AddressController::class);
        Route::put('addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
        
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
});

// Route xác minh email - không cần auth nhưng cần signed
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')->name('verification.verify');
Route::prefix('addresses')->resource('accounts', AccountController::class);
