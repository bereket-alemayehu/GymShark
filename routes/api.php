<?php

use App\Http\Controllers\Api\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::apiResource('/blogs', BlogController::class);
Route::get('/blog-categories', [\App\Http\Controllers\Api\BlogCategoryController::class, 'index']);
Route::apiResource('/blog-categories', \App\Http\Controllers\Api\BlogCategoryController::class);
Route::apiResource('/product-categories', \App\Http\Controllers\Api\ProductCategoryController::class)->except(['update', 'destroy']);
Route::apiResource('/product-sub-categories', \App\Http\Controllers\Api\ProductSubCategoryController::class)->except(['update', 'destroy']);
Route::apiResource('/products', \App\Http\Controllers\Api\ProductController::class);
Route::apiResource('/product-variants', \App\Http\Controllers\Api\ProductVariantController::class);
//Route::apiResource('/product-images', \App\Http\Controllers\Api\ProductImagesController::class);