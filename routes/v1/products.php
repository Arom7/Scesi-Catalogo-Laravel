<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;

Route::controller(ProductController::class)->group(function () {
    Route::get('/', 'index'); // List all products
    Route::post('/', 'store'); // Create a new product
    Route::get('/{id}', 'show'); // Get a specific product
    Route::put('/{id}', 'update'); // Update a specific product
    Route::delete('/{id}', 'destroy'); // Delete a specific product
});
