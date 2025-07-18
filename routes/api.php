<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('sellers')->group(function () {
        Route::post('/', [SellerController::class, 'store']);
        Route::get('/', [SellerController::class, 'index']);
        Route::get('/{id}', [SellerController::class, 'show']);
        Route::get('/{id}/sales', [SellerController::class, 'sales']);
        Route::post('/{seller}/resend-commission', [CommissionController::class, 'resend']);
    });

    Route::prefix('sales')->group(function () {
        Route::post('/', [SaleController::class, 'store']);
        Route::get('/', [SaleController::class, 'index']);
    });
});

