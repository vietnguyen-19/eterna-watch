<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AddressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Address API Routes
Route::prefix('address')->group(function () {
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/districts/{provinceCode}', [AddressController::class, 'getDistricts']);
    Route::get('/wards/{districtCode}', [AddressController::class, 'getWards']);
    Route::get('/provinces/search', [AddressController::class, 'searchProvinces']);
    Route::get('/districts/search', [AddressController::class, 'searchDistricts']);
    Route::get('/wards/search', [AddressController::class, 'searchWards']);
});
