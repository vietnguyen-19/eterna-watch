<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\OrderItemControlle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Middleware\AdminAuth;

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\PaymentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// phần AdminAdmin
// đăng nhập admin
Route::prefix('admin')->group(function () {


    Route::get('/login', [AdminLoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'adminLogin'])->name('login');
    Route::post('/logout', [AdminLoginController::class, 'adminLogout'])->name('logout');
    Route::get('forgot-password', [AdminLoginController::class, 'forgotPasswordForm'])
        ->name('password.forgot');
    Route::post('forgot-password', [AdminLoginController::class, 'admin.ForgotPassword'])
        ->name('password.email');
});
// chức năng adminadmin
Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/', [DashboardController::class, 'revenue'])->name('admin.dashboard.revenue');
    Route::get('report_stock', [DashboardController::class, 'stock'])->name('admin.dashboard.stock');
    Route::get('report_customer', [DashboardController::class, 'customer'])->name('admin.dashboard.customer');

    // Danh mục
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('show/{id}', [CategoryController::class, 'show'])->name('admin.categories.show');
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('{id}/update', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::get('{id}/destroy', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/dashboard/revenue', [DashboardController::class, 'revenue'])->name('admin.dashboard.revenue');
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('admin.dashboard.customer');
    Route::get('/dashboard/stock', [DashboardController::class, 'stock'])->name('admin.dashboard.stock');
    // danh mục
    Route::resource('categories', CategoryController::class)->names('admin.categories');

    // Banner
    Route::prefix('banners')->name('admin.banners.')->group(function () {
        Route::resource('/', BannerController::class)->except(['show'])->parameters(['' => 'id']);
        // Route quản lý thùng rác
        Route::prefix('trash')->group(function () {
            Route::get('/', [BannerController::class, 'trash'])->name('trash');
            Route::post('/{id}/restore', [BannerController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [BannerController::class, 'forceDelete'])->name('forceDelete');
        });
    });

    // Voucher
    Route::prefix('vouchers')->group(function () {
        Route::resource('/', VoucherController::class)->except(['show'])->names('admin.vouchers');
        Route::get('/trash', [VoucherController::class, 'trash'])->name('admin.vouchers.trash');
        Route::post('/{id}/restore', [VoucherController::class, 'restore'])->name('admin.vouchers.restore');
        Route::delete('/{id}/force-delete', [VoucherController::class, 'forceDelete'])->name('admin.vouchers.forceDelete');
    });

    // người dùng
    Route::resource('users', UserController::class)->names('admin.users');

    // thuộc tính sản phẩm
    Route::prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('admin.attributes.index');
        Route::get('create', [AttributeController::class, 'create'])->name('admin.attributes.create');
        Route::post('store', [AttributeController::class, 'store'])->name('admin.attributes.store');
        Route::get('show/{id}', [AttributeController::class, 'show'])->name('admin.attributes.show');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('admin.attributes.edit');
        Route::post('update', [AttributeController::class, 'update'])->name('admin.attributes.update');
        Route::get('destroy/{id}', [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');
    });

    // Giá trị thuộc tính (Attribute Values)
    Route::prefix('attribute_values')->group(function () {
        Route::get('/{id}', [AttributeValueController::class, 'index'])->name('admin.attribute_values.index');
        Route::get('create/{id}', [AttributeValueController::class, 'create'])->name('admin.attribute_values.create');
        Route::post('store', [AttributeValueController::class, 'store'])->name('admin.attribute_values.store');
        Route::get('show/{id}', [AttributeValueController::class, 'show'])->name('admin.attribute_values.show');
        Route::get('{id}/edit', [AttributeValueController::class, 'edit'])->name('admin.attribute_values.edit');
        Route::put('update/{id}', [AttributeValueController::class, 'update'])->name('admin.attribute_values.update');
        Route::delete('destroy/{id}', [AttributeValueController::class, 'destroy'])->name('admin.attribute_values.destroy');
    });

    // Sản phẩm
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::get('/get-values/{id}', [AttributeController::class, 'getAttributeValues'])->name('admin.products.get-values');
        Route::post('store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('show/{id}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        Route::get('/get-subcategories/{parent_id}', [ProductController::class, 'getSubcategories']);
    });
    Route::prefix('productvariants')->group(function () {
        Route::get('/', [ProductVariantController::class, 'index'])->name('admin.productvariants.index');
        Route::get('create/{id}', [ProductVariantController::class, 'create'])->name('admin.productvariants.create');
        Route::post('store', [ProductVariantController::class, 'store'])->name('admin.productvariants.store');
        Route::get('{id}/edit', [ProductVariantController::class, 'edit'])->name('admin.productvariants.edit');
        Route::put('{id}/update', [ProductVariantController::class, 'update'])->name('admin.productvariants.update');
        Route::delete('destroy/{id}', [ProductVariantController::class, 'destroy'])->name('admin.productvariants.destroy');
    });

    // Đơn Hàng
    Route::prefix('order_items')->group(function () {
        Route::get('users-search', [OrderItemController::class, 'search'])->name('admin.orders.user-search');
        Route::get('products-search', [OrderItemController::class, 'searchPro'])->name('admin.products.search');
        Route::post('add-order-item', [OrderItemController::class, 'addOrderItem'])->name('admin.order.addItem');
        Route::post('remove-order-item', [OrderItemController::class, 'removeOrderItem'])->name('admin.order.removeItem');
        Route::post('update-order-item', [OrderItemController::class, 'updateOrderItem'])->name('admin.order.updateItem');
        Route::post('check-voucher', [OrderItemController::class, 'checkVoucher'])->name('admin.vouchers.check');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('create', [OrderController::class, 'create'])->name('admin.orders.create');
        Route::post('store', [OrderController::class, 'store'])->name('admin.orders.store');
        Route::get('show/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::get('{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
        Route::put('{id}/update', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
        Route::delete('{id}/destroy', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::post('{order}/send-shipment', [ShipmentController::class, 'store'])->name('admin.shipments.send');
        Route::post('{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    });


    // Thương hiệu
    Route::resource('brands', BrandController::class)->names('admin.brands');

    // Phân quyền
    Route::resource('permissions', PermissionController::class)->names('admin.permissions');

    // vai trò
    Route::resource('roles', RoleController::class)->names('admin.roles');

    // Bình luận
    Route::prefix('comments')->group(function () {
        Route::get('comments', [CommentController::class, 'index'])->name('admin.comments.index');
        Route::get('/{id}/edit', [CommentController::class, 'edit'])->name('admin.comments.edit');
        Route::put('/{id}', [CommentController::class, 'update'])->name('admin.comments.update');
        Route::get('/comments/product', [CommentController::class, 'productComments'])->name('admin.comments.product');
    });

    // Bài viết
    Route::resource('posts', PostController::class)->names('admin.posts');

    // upload ảnh
    Route::post('/upload-image', [ImageController::class, 'uploadImage']);
    Route::post('/remove-image', [ImageController::class, 'removeImage']);
    Route::post('/update-image/{id}', [ImageController::class, 'updateImage'])->name('admin.products.update-image');

    // đơn hàng
    // Route::resource('orders', OrderController::class)->names('admin.orders');

    //settings

    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [AdminAuth::class, 'edit'])->name('admin.settings.edit');
        Route::post('/settings', [AdminAuth::class, 'update'])->name('admin.settings.update');
    });

    //login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    //settings
    Route::resource('settings', SettingController::class)->names('admin.settings');


    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('admin.settings.create');
    Route::post('/settings', [SettingController::class, 'store'])->name('admin.settings.store');
    Route::get('/settings/{id}/edit', [SettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/settings/{id}', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::delete('/settings/{id}', [SettingController::class, 'destroy'])->name('admin.settings.destroy');
});

// phần Staff
// Đăng nhập staff
Route::prefix('staff')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'adminLogin'])->name('login');
    Route::post('/logout', [AdminLoginController::class, 'adminLogout'])->name('logout');
    Route::get('forgot-password', [AdminLoginController::class, 'forgotPasswordForm'])
        ->name('password.forgot');
    Route::post('forgot-password', [AdminLoginController::class, 'admin.ForgotPassword'])
        ->name('password.email');
});
// chức năng staff
Route::prefix('staff')->middleware('staff')->group(function () {
    // bảng điều khiển
    Route::get('/', [DashboardController::class, 'revenue'])->name('staff.dashboard.revenue');
    Route::get('report_stock', [DashboardController::class, 'stock'])->name('staff.dashboard.stock');
    Route::get('report_customer', [DashboardController::class, 'customer'])->name('staff.dashboard.customer');

    // danh mục
    Route::resource('categories', CategoryController::class)->names('staff.categories');

    // Banner
    Route::resource('banners', BannerController::class)->names('staff.banners');
    Route::get('/', [BannerController::class, 'index'])->name('index'); // Trang danh sách banner chính
    Route::get('/trash', [BannerController::class, 'trash'])->name('trash'); // Trang thùng rác
    Route::post('/{id}/restore', [BannerController::class, 'restore'])->name('restore'); // Khôi phục
    Route::delete('/{id}/force-delete', [BannerController::class, 'forceDelete'])->name('forceDelete'); // Xóa vĩnh viễn
    Route::delete('/{id}', [BannerController::class, 'destroy'])->name('destroy'); // Xóa mềm (chuyển vào thùng rác)


    // người dùng
    Route::resource('users', UserController::class)->names('staff.users');

    // thuộc tính sản phẩm
    Route::prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('staff.attributes.index');
        Route::get('create', [AttributeController::class, 'create'])->name('staff.attributes.create');
        Route::post('store', [AttributeController::class, 'store'])->name('staff.attributes.store');
        Route::get('show/{id}', [AttributeController::class, 'show'])->name('staff.attributes.show');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('staff.attributes.edit');
        Route::post('update', [AttributeController::class, 'update'])->name('staff.attributes.update');
        Route::get('destroy/{id}', [AttributeController::class, 'destroy'])->name('staff.attributes.destroy');
    });

    // Giá trị thuộc tính (Attribute Values)
    Route::prefix('attribute_values')->group(function () {
        Route::get('/{id}', [AttributeValueController::class, 'index'])->name('staff.attribute_values.index');
        Route::get('create/{id}', [AttributeValueController::class, 'create'])->name('staff.attribute_values.create');
        Route::post('store', [AttributeValueController::class, 'store'])->name('staff.attribute_values.store');
        Route::get('show/{id}', [AttributeValueController::class, 'show'])->name('staff.attribute_values.show');
        Route::get('{id}/edit', [AttributeValueController::class, 'edit'])->name('staff.attribute_values.edit');
        Route::put('update/{id}', [AttributeValueController::class, 'update'])->name('staff.attribute_values.update');
        Route::delete('destroy/{id}', [AttributeValueController::class, 'destroy'])->name('staff.attribute_values.destroy');
    });

    // Sản phẩm
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('staff.products.index');
        Route::get('create', [ProductController::class, 'create'])->name('staff.products.create');
        Route::get('/get-values/{id}', [AttributeController::class, 'getAttributeValues'])->name('staff.products.get-values');
        Route::post('store', [ProductController::class, 'store'])->name('staff.products.store');
        Route::get('show/{id}', [ProductController::class, 'show'])->name('staff.products.show');
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('staff.products.edit');
        Route::put('{id}/update', [ProductController::class, 'update'])->name('staff.products.update');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('staff.products.destroy');

        Route::get('/get-subcategories/{parent_id}', [ProductController::class, 'getSubcategories']);
    });
    Route::prefix('productvariants')->group(function () {
        Route::get('/', [ProductVariantController::class, 'index'])->name('staff.productvariants.index');
        Route::get('create/{id}', [ProductVariantController::class, 'create'])->name('staff.productvariants.create');
        Route::post('store', [ProductVariantController::class, 'store'])->name('staff.productvariants.store');
        Route::get('{id}/edit', [ProductVariantController::class, 'edit'])->name('staff.productvariants.edit');
        Route::put('{id}/update', [ProductVariantController::class, 'update'])->name('staff.productvariants.update');
        Route::delete('destroy/{id}', [ProductVariantController::class, 'destroy'])->name('staff.productvariants.destroy');
    });

    // Thương hiệu
    Route::resource('brands', BrandController::class)->names('staff.brands');

    // Phân quyền
    Route::resource('permissions', PermissionController::class)->names('staff.permissions');

    // vai trò
    Route::resource('roles', RoleController::class)->names('staff.roles');

    // Bình luận
    Route::resource('comments', CommentController::class)->names('staff.comments');

    // Bài viết
    Route::resource('posts', PostController::class)->names('staff.posts');

    // upload ảnh
    Route::post('/upload-image', [ImageController::class, 'uploadImage']);
    Route::post('/remove-image', [ImageController::class, 'removeImage']);
    Route::post('/update-image/{id}', [ImageController::class, 'updateImage'])->name('staff.products.update-image');

    // đơn hàng
    Route::resource('orders', OrderController::class)->names('staff.orders');

    //settings
    Route::resource('settings', SettingController::class)->names('staff.settings');
});
