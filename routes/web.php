<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
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


    Route::prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('admin.attributes.index');
        Route::get('create', [AttributeController::class, 'create'])->name('admin.attributes.create');
        Route::post('store', [AttributeController::class, 'store'])->name('admin.attributes.store');
        Route::get('show/{id}', [AttributeController::class, 'show'])->name('admin.attributes.show');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('admin.attributes.edit');
        Route::post('update', [AttributeController::class, 'update'])->name('admin.attributes.update');
        Route::delete('destroy/{id}', [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');

    });

    Route::prefix('attribute_values')->group(function () {
        Route::get('/{id}', [AttributeValueController::class, 'index'])->name('admin.attribute_values.index');
        Route::get('create/{id}', [AttributeValueController::class, 'create'])->name('admin.attribute_values.create');
        Route::post('store', [AttributeValueController::class, 'store'])->name('admin.attribute_values.store');
        Route::get('show/{id}', [AttributeValueController::class, 'show'])->name('admin.attribute_values.show');
        Route::get('{id}/edit', [AttributeValueController::class, 'edit'])->name('admin.attribute_values.edit');
        Route::put('{id}/update', [AttributeValueController::class, 'update'])->name('admin.attribute_values.update');
        Route::delete('destroy/{id}', [AttributeValueController::class, 'destroy'])->name('admin.attribute_values.destroy');
    });

   
    // permission
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('create',          [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('store',         [PermissionController::class,  'store'])->name('admin.permissions.store');
        Route::post('show/{id}',     [PermissionController::class,  'show'])->name('admin.permissions.show');
        Route::get('{id}/edit',      [PermissionController::class,  'edit'])->name('admin.permissions.edit');
        Route::put('{id}/update',    [PermissionController::class,  'update'])->name('admin.permissions.update');
        Route::get('/{id}/destroy',  [PermissionController::class,  'destroy'])->name('admin.permissions.destroy');
    });
});
