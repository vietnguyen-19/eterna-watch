<?php

use App\Http\Controllers\Admin\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

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
//test git
});
Route::prefix('admin')->group(function () {
    Route::resource('brands', BrandController::class)->names([
        'index' => 'admin.brands.index',
        'create' => 'admin.brands.create',
        'store' => 'admin.brands.store',
        'show' => 'admin.brands.show',
        'edit' => 'admin.brands.edit',
        'update' => 'admin.brands.update',
        'destroy' => 'admin.brands.destroy',
    ]);
});
