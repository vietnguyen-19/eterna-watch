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


Route::prefix('admin')->group(function () {
    // bảng điều khiển
    Route::get('/', [DashboardController::class, 'revenue'])->name('admin.dashboard.revenue');
    Route::get('report_stock', [DashboardController::class, 'stock'])->name('admin.dashboard.stock');
    Route::get('report_customer', [DashboardController::class, 'customer'])->name('admin.dashboard.customer');

    // danh mục
    Route::resource('categories', CategoryController::class)->names('admin.categories');

    // Banner
    Route::resource('banners', BannerController::class)->names('admin.banners');

    //voucher
    Route::resource('vouchers', VoucherController::class)->names('admin.vouchers');
    Route::delete('/{id}/force-delete', [VoucherController::class, 'forceDelete'])->name('admin.vouchers.forceDelete');

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
        Route::put('{id}/update', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::get('{id}/destroy', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::post('{id}/shipments/send', [ShipmentController::class, 'sendToGhn'])->name('admin.shipments.send');
        Route::post('{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    });


    // Thương hiệu
    Route::resource('brands', BrandController::class)->names('admin.brands');

    // Phân quyền
    Route::resource('permissions', PermissionController::class)->names('admin.permissions');

    // vai trò
    Route::resource('roles', RoleController::class)->names('admin.roles');

    // Bình luận
    Route::resource('comments', CommentController::class)->names('admin.comments');

    // Bài viết
    Route::resource('posts', PostController::class)->names('admin.posts');

    // upload ảnh
    Route::post('/upload-image', [ImageController::class, 'uploadImage']);
    Route::post('/remove-image', [ImageController::class, 'removeImage']);
    Route::post('/update-image/{id}', [ImageController::class, 'updateImage'])->name('admin.products.update-image');

    // đơn hàng
    // Route::resource('orders', OrderController::class)->names('admin.orders');

    //settings
    Route::resource('settings', SettingController::class)->names('admin.settings');
});
