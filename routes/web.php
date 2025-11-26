<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Products routes
Route::resource('products', ProductController::class);

// Categories routes
Route::resource('categories', CategoryController::class);
