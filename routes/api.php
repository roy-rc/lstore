<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Products API endpoints
Route::apiResource('products', ProductController::class)->names([
    'index' => 'api.products.index',
    'store' => 'api.products.store',
    'show' => 'api.products.show',
    'update' => 'api.products.update',
    'destroy' => 'api.products.destroy',
]);

// Categories API endpoints
Route::apiResource('categories', CategoryController::class)->names([
    'index' => 'api.categories.index',
    'store' => 'api.categories.store',
    'show' => 'api.categories.show',
    'update' => 'api.categories.update',
    'destroy' => 'api.categories.destroy',
]);
