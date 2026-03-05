<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// مسارات عامة
Route::get('/shops', [ShopController::class, 'index']);
Route::get('/shops/{shop_id}/products', [ProductController::class, 'index']);

// مسارات عامة (لا تحتاج توكن للوصول إليها)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// مسارات محمية (يجب أن يرسل الموبايل التوكن ليدخل إليها)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();

    });
    Route::post('/shops', [ShopController::class, 'store']);
    Route::post('/products', [ProductController::class, 'store']);
});