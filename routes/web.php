<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', function () {
        return view('admin/dashboard');
    })->name('admin.dashboard');
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

    Route::prefix('users')->group(function () {
        Route::get('create', [UserController::class, 'create'])->name('admin.users.create');
        Route::get('/{id}', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('show/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('{id}/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // permission
    Route::prefix('permissions')->group(function () {
        Route::get('/',                 [PermissionController::class, 'index'])
            ->name('admin.permissions.index');
        Route::get('/create',           [PermissionController::class, 'create'])
            ->name('admin.permissions.create');
        Route::post('create',           [PermissionController::class,  'store'])
            ->name('admin.permissions.store');
        Route::get('show/{id}',         [PermissionController::class,  'show'])
            ->name('admin.permissions.show');
        Route::get('/edit/{id}',        [PermissionController::class,  'edit'])
            ->name('admin.permissions.edit');
        Route::put('/edit/{id}',        [PermissionController::class,  'update'])
            ->name('admin.permissions.update');
        Route::delete('/destroy/{id}',  [PermissionController::class,  'destroy'])
            ->name('admin.permissions.destroy');
    });

// Banner
Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/{id}', [BannerController::class, 'show'])->name('admin.banners.show');
    Route::get('/{id}/edit', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
});

});
