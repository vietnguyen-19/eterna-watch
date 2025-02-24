<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
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

     // permission
     Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])     ->name('admin.permissions.index');
        Route::get('create',          [PermissionController::class, 'create'])    ->name('admin.permissions.create');
        Route::post('store',         [PermissionController::class,  'store'])    ->name('admin.permissions.store');
        Route::post('show/{id}',     [PermissionController::class,  'show'])    ->name('admin.permissions.show');
        Route::get('{id}/edit',      [PermissionController::class,  'edit'])     ->name('admin.permissions.edit');
        Route::put('{id}/update',    [PermissionController::class,  'update'])   ->name('admin.permissions.update');
        Route::get('/{id}/destroy',  [PermissionController::class,  'destroy'])  ->name('admin.permissions.destroy');
    });

});
