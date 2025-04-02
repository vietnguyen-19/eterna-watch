<?php


use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ImageController; 
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VoucherController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Client\ClientSettingsController;

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
});
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/dashboard/revenue', [DashboardController::class, 'revenue'])->name('admin.dashboard.revenue');
    // danh mục
    Route::resource('categories', CategoryController::class)->names('admin.categories');

    Route::prefix('admin')->group(function () {
        Route::resource('roles', RoleController::class)->names([
            'index' => 'admin.roles.index',
            'create' => 'admin.roles.create',
            'store' => 'admin.roles.store',
            'show' => 'admin.roles.show',
            'edit' => 'admin.roles.edit',
            'update' => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy',
        ]);
    });




    Route::prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('admin.attributes.index');
        Route::get('create', [AttributeController::class, 'create'])->name('admin.attributes.create');
        Route::post('store', [AttributeController::class, 'store'])->name('admin.attributes.store');
        Route::get('show/{id}', [AttributeController::class, 'show'])->name('admin.attributes.show');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('admin.attributes.edit');
        Route::post('update', [AttributeController::class, 'update'])->name('admin.attributes.update');
        Route::get('destroy/{id}', [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');
    });

    // 📌 Giá trị thuộc tính (Attribute Values)
    Route::prefix('attribute_values')->group(function () {
        Route::get('/{id}', [AttributeValueController::class, 'index'])->name('admin.attribute_values.index');
        Route::get('create/{id}', [AttributeValueController::class, 'create'])->name('admin.attribute_values.create');
        Route::post('store', [AttributeValueController::class, 'store'])->name('admin.attribute_values.store');
        Route::get('show/{id}', [AttributeValueController::class, 'show'])->name('admin.attribute_values.show');
        Route::get('{id}/edit', [AttributeValueController::class, 'edit'])->name('admin.attribute_values.edit');
        Route::put('update/{id}', [AttributeValueController::class, 'update'])->name('admin.attribute_values.update');
        Route::delete('destroy/{id}', [AttributeValueController::class, 'destroy'])->name('admin.attribute_values.destroy');
    });

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

    // permission
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('create',          [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('/store',         [PermissionController::class,  'store'])->name('admin.permissions.store');
        Route::get('show/{id}',     [PermissionController::class,  'show'])->name('admin.permissions.show');
        Route::get('/edit/{id}',      [PermissionController::class,  'edit'])->name('admin.permissions.edit');
        Route::put('/update/{id}',    [PermissionController::class,  'update'])->name('admin.permissions.update');
        Route::delete('/destroy/{id}',  [PermissionController::class,  'destroy'])->name('admin.permissions.destroy');
    });

    // Banner

    Route::post('/upload-image', [ImageController::class, 'uploadImage']);
    Route::post('/remove-image', [ImageController::class, 'removeImage']);
    Route::post('/update-image/{id}', [ImageController::class, 'updateImage'])->name('admin.products.update-image');


    // đơn hàng
    Route::resource('orders', OrderController::class)->names('admin.orders');


    //settings
    // Route admin
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingsController::class, 'store'])->name('settings.store');
    Route::get('/support', [AdminSettingsController::class, 'index'])->name('support');
    
    
});
Route::get('user/settings', [ClientSettingsController::class, 'index'])->name('client.settings.index');
Route::post('user/settings', [ClientSettingsController::class, 'store'])->name('client.settings.store');

