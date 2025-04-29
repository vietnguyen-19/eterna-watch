<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\Auth\EmailVerificationController;
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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\RefundController;


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
    Route::get('/login', [LoginController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.forgot');
    Route::post('forgot-password', [ForgotPasswordController::class, 'admin.ForgotPassword'])->name('admin.password.email');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('admin.password.request');

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('admin.password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('admin.password.reset');

    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->name('admin.password.update');
});

// ADMIN CHỨC NĂNG (middleware auth + admin)
Route::prefix('admin')->middleware(['auth:admin', 'admin'])->group(function () {

    // DASHBOARD
    Route::get('/', [DashboardController::class, 'revenue'])->name('admin.dashboard.revenue');
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('admin.dashboard.customer')
        ->middleware('permission:view_dashboard');
    Route::get('/dashboard/stock', [DashboardController::class, 'stock'])->name('admin.dashboard.stock')
        ->middleware('permission:view_dashboard');

    // DANH MỤC (categories)
    Route::prefix('categories')->name('admin.categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware('permission:view_categories');
        Route::get('create', [CategoryController::class, 'create'])->name('create')->middleware('permission:create_categories');
        Route::post('store', [CategoryController::class, 'store'])->name('store')->middleware('permission:create_categories');
        Route::get('show/{id}', [CategoryController::class, 'show'])->name('show')->middleware('permission:view_categories');
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('edit')->middleware('permission:edit_categories');
        Route::put('{id}/update', [CategoryController::class, 'update'])->name('update')->middleware('permission:edit_categories');
        Route::delete('{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy')->middleware('permission:delete_categories');

        Route::get('trash', [CategoryController::class, 'trash'])->name('trash')->middleware('permission:delete_categories');
        Route::put('restore/{id}', [CategoryController::class, 'restore'])->name('restore')->middleware('permission:delete_categories');
        Route::delete('force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('force-delete')->middleware('permission:delete_categories');
    });

    // BANNER
    Route::prefix('banners')->name('admin.banners.')->group(function () {
        Route::resource('/', BannerController::class)->except(['show'])->parameters(['' => 'id'])
            ->middleware('permission:view_banners');

        Route::prefix('trash')->group(function () {
            Route::get('/', [BannerController::class, 'trash'])->name('trash')->middleware('permission:view_banners');
            Route::post('/{id}/restore', [BannerController::class, 'restore'])->name('restore')->middleware('permission:restore_banners');
            Route::delete('/{id}/force-delete', [BannerController::class, 'forceDelete'])->name('forceDelete')->middleware('permission:delete_banners');
        });
    });

    // VOUCHER
    Route::prefix('vouchers')->name('admin.vouchers.')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('index')->middleware('permission:view_vouchers');
        Route::get('/create', [VoucherController::class, 'create'])->name('create')->middleware('permission:create_vouchers');
        Route::post('', [VoucherController::class, 'store'])->name('store')->middleware('permission:create_vouchers');
        Route::get('/{voucher}/edit', [VoucherController::class, 'edit'])->name('edit')->middleware('permission:edit_vouchers');
        Route::put('/{voucher}', [VoucherController::class, 'update'])->name('update')->middleware('permission:edit_vouchers');
        Route::delete('/{voucher}', [VoucherController::class, 'destroy'])->name('destroy')->middleware('permission:delete_vouchers');
        Route::get('/trash', [VoucherController::class, 'trash'])->name('trash')->middleware('permission:view_vouchers');
        Route::post('/{id}/restore', [VoucherController::class, 'restore'])->name('restore')->middleware('permission:restore_vouchers');
        Route::delete('/{id}/force-delete', [VoucherController::class, 'forceDelete'])->name('forceDelete')->middleware('permission:delete_vouchers');
    });



    // NGƯỜI DÙNG
    Route::prefix('users')->name('admin.users.')->middleware('permission:view_users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->name('update');

        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('{user}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('{user}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
        Route::get('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });


    // THUỘC TÍNH SẢN PHẨM
    Route::prefix('attributes')->name('admin.attributes.')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('index')->middleware('permission:view_attributes');
        Route::get('create', [AttributeController::class, 'create'])->name('create')->middleware('permission:create_attributes');
        Route::post('store', [AttributeController::class, 'store'])->name('store')->middleware('permission:create_attributes');
        Route::get('show/{id}', [AttributeController::class, 'show'])->name('show')->middleware('permission:view_attributes');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('edit')->middleware('permission:edit_attributes');
        Route::post('update', [AttributeController::class, 'update'])->name('update')->middleware('permission:edit_attributes');
        Route::get('destroy/{id}', [AttributeController::class, 'destroy'])->name('destroy')->middleware('permission:delete_attributes');
    });

    // ATTRIBUTE VALUES
    Route::prefix('attribute_values')->name('admin.attribute_values.')->group(function () {
        Route::get('/{id}', [AttributeValueController::class, 'index'])->name('index')->middleware('permission:view_attributes');
        Route::get('create/{id}', [AttributeValueController::class, 'create'])->name('create')->middleware('permission:create_attributes');
        Route::post('store', [AttributeValueController::class, 'store'])->name('store')->middleware('permission:create_attributes');
        Route::get('show/{id}', [AttributeValueController::class, 'show'])->name('show')->middleware('permission:view_attributes');
        Route::get('{id}/edit', [AttributeValueController::class, 'edit'])->name('edit')->middleware('permission:edit_attributes');
        Route::put('update/{id}', [AttributeValueController::class, 'update'])->name('update')->middleware('permission:edit_attributes');
        Route::delete('destroy/{id}', [AttributeValueController::class, 'destroy'])->name('destroy')->middleware('permission:delete_attributes');
    });

    // SẢN PHẨM
    Route::prefix('products')->name('admin.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index')->middleware('permission:view_products');
        Route::get('create', [ProductController::class, 'create'])->name('create')->middleware('permission:create_products');
        Route::post('store', [ProductController::class, 'store'])->name('store')->middleware('permission:create_products');
        Route::get('show/{id}', [ProductController::class, 'show'])->name('show')->middleware('permission:view_products');
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('edit')->middleware('permission:edit_products');
        Route::put('{id}/update', [ProductController::class, 'update'])->name('update')->middleware('permission:edit_products');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('destroy')->middleware('permission:delete_products');

        Route::get('/get-values/{id}', [AttributeController::class, 'getAttributeValues']);
        Route::get('/get-subcategories/{parent_id}', [ProductController::class, 'getSubcategories']);

        Route::get('trash', [ProductController::class, 'trash'])->name('trash')->middleware('permission:delete_products');
        Route::put('restore/{id}', [ProductController::class, 'restore'])->name('restore')->middleware('permission:delete_products');
        Route::delete('force-delete/{id}', [ProductController::class, 'forceDelete'])->name('force-delete')->middleware('permission:delete_products');
    });

    // PHIÊN BẢN SẢN PHẨM
    Route::prefix('productvariants')->name('admin.productvariants.')->group(function () {
        Route::get('/', [ProductVariantController::class, 'index'])->name('index')->middleware('permission:view_products');
        Route::get('create', [ProductVariantController::class, 'create'])->name('create')->middleware('permission:create_products');
        Route::post('store', [ProductVariantController::class, 'store'])->name('store')->middleware('permission:create_products');
        Route::post('store-many', [ProductVariantController::class, 'storeMany'])->name('store-many');
        Route::get('{id}/edit', [ProductVariantController::class, 'edit'])->name('edit')->middleware('permission:edit_products');
        Route::put('{id}/update', [ProductVariantController::class, 'update'])->name('update')->middleware('permission:edit_products');
        Route::delete('destroy/{id}', [ProductVariantController::class, 'destroy'])->name('destroy')->middleware('permission:delete_products');
    });

    // ĐƠN HÀNG
    Route::prefix('orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index')->middleware('permission:view_orders');
        Route::get('create', [OrderController::class, 'create'])->name('create')->middleware('permission:create_orders');
        Route::post('store', [OrderController::class, 'store'])->name('store')->middleware('permission:create_orders');
        Route::get('show/{id}', [OrderController::class, 'show'])->name('show')->middleware('permission:view_orders');
        Route::get('{id}/edit', [OrderController::class, 'edit'])->name('edit')->middleware('permission:edit_orders');
        Route::put('{id}/update', [OrderController::class, 'updateStatus'])->name('update')->middleware('permission:edit_orders');
        Route::post('{order}/send-shipment', [ShipmentController::class, 'store'])->name('admin.shipments.send')->middleware('permission:edit_orders');
        Route::post('{order}/status', [OrderController::class, 'updateStatus'])->name('status')->middleware('permission:edit_orders');



        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy')->middleware('permission:delete_orders'); // Xoá mềm
        Route::get('/trash', [OrderController::class, 'trash'])->name('trash')->middleware('permission:delete_orders'); // Danh sách đã xoá
        Route::post('/restore/{id}', [OrderController::class, 'restore'])->name('restore')->middleware('permission:delete_orders'); // Khôi phục
        Route::delete('/force-delete/{id}', [OrderController::class, 'forceDelete'])->name('forceDelete')->middleware('permission:delete_orders'); // Xoá vĩnh viễn
    });


    Route::prefix('refunds')->group(function () {
        Route::get('/refunds', [RefundController::class, 'index'])->name('admin.refunds.index');
        Route::get('/refunds/{refund}', [RefundController::class, 'show'])->name('admin.refunds.show');
        Route::post('/refunds/{refund}/approve', [RefundController::class, 'approve'])->name('admin.refunds.approve');
        Route::post('/refunds/{refund}/reject', [RefundController::class, 'reject'])->name('admin.refunds.reject');
    });

    Route::prefix('order_items')->group(function () {
        Route::get('users-search', [OrderItemController::class, 'search'])->name('admin.orders.user-search');
        Route::get('products-search', [OrderItemController::class, 'searchPro'])->name('admin.products.search');
        Route::post('add-order-item', [OrderItemController::class, 'addOrderItem'])->name('admin.order.addItem');
        Route::post('remove-order-item', [OrderItemController::class, 'removeOrderItem'])->name('admin.order.removeItem');
        Route::post('update-order-item', [OrderItemController::class, 'updateOrderItem'])->name('admin.order.updateItem');
        Route::post('check-voucher', [OrderItemController::class, 'checkVoucher'])->name('admin.vouchers.check');
    });

    // THƯƠNG HIỆU
    Route::resource('brands', BrandController::class)->names('admin.brands')->middleware('permission:view_brands');

    // PHÂN QUYỀN
    Route::resource('permissions', PermissionController::class)->names('admin.permissions')->middleware('permission:manage_permissions');
    Route::resource('roles', RoleController::class)->names('admin.roles')->middleware('permission:manage_roles');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('admin.roles.update_permissions')->middleware('permission:manage_roles');

    // BÌNH LUẬN

    Route::put('{id}/approve', [CommentController::class, 'approve'])->name('admin.comments.approve');
    Route::post('comments/delete-multiple', [CommentController::class, 'deleteMultiple'])->name('admin.comments.deleteMultiple');
    Route::prefix('comments')->group(function () {
        Route::get('/posts', [CommentController::class, 'indexPost'])->name('admin.comments.posts');
        Route::get('/products', [CommentController::class, 'indexProduct'])->name('admin.comments.products');

        Route::post('reply', [CommentController::class, 'reply'])->name('admin.comments.reply');
        Route::put('update/{id}', [CommentController::class, 'update'])->name('admin.comments.update');
        Route::post('approve/{id}', [CommentController::class, 'approve'])->name('admin.comments.approve');
        Route::post('reject/{id}', [CommentController::class, 'reject'])->name('admin.comments.reject');
        Route::post('delete/{id}', [CommentController::class, 'delete'])->name('admin.comments.delete');
    });



    // BÀI VIẾT
    Route::prefix('posts')->name('admin.posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index')->middleware('permission:view_posts');
        Route::get('create', [PostController::class, 'create'])->name('create')->middleware('permission:create_posts');
        Route::post('store', [PostController::class, 'store'])->name('store')->middleware('permission:create_posts');
        Route::get('show/{id}', [PostController::class, 'show'])->name('show')->middleware('permission:view_posts');
        Route::get('{id}/edit', [PostController::class, 'edit'])->name('edit')->middleware('permission:edit_posts');
        Route::put('{id}/update', [PostController::class, 'update'])->name('update')->middleware('permission:edit_posts');

        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy'); // Xoá mềm
        Route::get('/trash', [PostController::class, 'trash'])->name('trash'); // Danh sách đã xoá
        Route::post('/restore/{id}', [PostController::class, 'restore'])->name('restore'); // Khôi phục
        Route::delete('/force-delete/{id}', [PostController::class, 'forceDelete'])->name('forceDelete'); // Xoá vĩnh viễn
    });

    // ẢNH
    Route::post('/upload-image', [ImageController::class, 'uploadImage'])->middleware('permission:edit_products');
    Route::post('/remove-image', [ImageController::class, 'removeImage'])->middleware('permission:edit_products');
    Route::post('/update-image/{id}', [ImageController::class, 'updateImage'])->name('admin.products.update-image')->middleware('permission:edit_products');

    // CÀI ĐẶT
    Route::resource('settings', SettingController::class)->names('admin.settings')->middleware('permission:manage_settings');

    Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index')->middleware('permission:manage_contacts');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('admin.contacts.show')->middleware('permission:manage_contacts');
    Route::patch('/contacts/{id}/update', [ContactController::class, 'updateStatus'])->name('admin.contacts.update')->middleware('permission:manage_contacts');

    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy')->middleware('permission:manage_contacts');
    Route::get('/contacts/trash', [ContactController::class, 'trash'])->name('admin.contacts.trash')->middleware('permission:manage_contacts');
    Route::post('/contacts/{id}/restore', [ContactController::class, 'restore'])->name('admin.contacts.restore')->middleware('permission:manage_contacts');
    Route::delete('/contacts/{id}/force-delete', [ContactController::class, 'forceDelete'])->name('admin.contacts.forceDelete')->middleware('permission:manage_contacts');

});
