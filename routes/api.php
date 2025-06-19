<?php

use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('sellers')->group(function () {
    Route::post('/', [SellerController::class, 'store']);          // Cadastrar vendedor
    Route::get('/', [SellerController::class, 'index']);           // Listar todos vendedores
    Route::get('/{id}', [SellerController::class, 'show']);        // Mostrar vendedor específico (opcional)

    // Vendas por vendedor
    Route::get('/{id}/sales', [SellerController::class, 'sales']); // Listar vendas do vendedor
});

// Rotas para Vendas
Route::prefix('sales')->group(function () {
    Route::post('/', [SaleController::class, 'store']);            // Cadastrar venda
    Route::get('/', [SaleController::class, 'index']);             // Listar todas vendas
});
