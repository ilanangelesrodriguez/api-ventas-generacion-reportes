<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Usuarios
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});

// Productos
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
});

// Clientes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

// Ventas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('sales', [SaleController::class, 'store']);
    Route::get('sales/{id}', [SaleController::class, 'show']);
});

// Reportes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports/top-selling-products', [ReportController::class, 'getTopSellingProducts']);
    Route::get('/reports/sales-by-time-range', [ReportController::class, 'getSalesByTimeRange']);
    Route::get('/reports/export-top-selling-products', [ReportController::class, 'exportTopSellingProducts']);
    Route::get('/reports/export-sales-by-time-range', [ReportController::class, 'exportSalesByTimeRange']);
});
