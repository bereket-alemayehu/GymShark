<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PromotionController;
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

// Blog routes
Route::apiResource('/blogs', BlogController::class);
// Route::get('/blog-categories', [\App\Http\Controllers\Api\BlogCategoryController::class, 'index']);
Route::apiResource('/blog-categories', \App\Http\Controllers\Api\BlogCategoryController::class);

// Product-related routes
Route::apiResource('/product-categories', \App\Http\Controllers\Api\ProductCategoryController::class)->except(['update', 'destroy']);
Route::apiResource('/products', \App\Http\Controllers\Api\ProductController::class);
Route::apiResource('/product-variants', \App\Http\Controllers\Api\ProductVariantController::class);
Route::apiResource('/product-images', \App\Http\Controllers\Api\ProductImageController::class);

// Cart-related routes (with auth)
Route::middleware('auth:sanctum')->group(function () {
    // Cart operations
    Route::get('/cart', [CartController::class, 'index']); // Get the user's cart
    Route::post('/cart/{productVariantId}', [CartController::class, 'store']); // Add or update a cart item
    Route::put('/cart/items/{cartItemId}', [CartController::class, 'update']); // Update a cart item
    Route::delete('/cart/items/{cartItemId}', [CartController::class, 'destroy']); // Remove a cart item
    Route::post('/checkout', [CartController::class, 'checkout']); // Checkout

    // CartItem operations
    Route::post('cart-items/{productVariantId}', [CartItemController::class, 'store']); // Store (add) cart item
    Route::put('cart-items/{cartItemId}', [CartItemController::class, 'update']); // Update cart item
    Route::delete('cart-items/{cartItemId}', [CartItemController::class, 'destroy']); // Remove cart item
});
// Order routes (with auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/orders', OrderController::class); // Place an order
});

// Authentication routes
Route::post("auth/register", [AuthController::class, "register"]);
Route::post("/auth/login", [AuthController::class, "login"]);
Route::post("/auth/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");

// Profile-related routes (with auth)
Route::put("/profile/update", [ProfileController::class, 'updateProfile'])->middleware(['auth:sanctum']);
Route::post("/profile/upload", [ProfileController::class, 'uploadAvatar'])->middleware(['auth:sanctum']);
Route::get('/profile', [ProfileController::class, 'getProfile'])->middleware(['auth:sanctum']);
Route::post('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])->middleware(['auth:sanctum']);

// Password-related routes
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->post('change-password', [AuthController::class, 'changePassword']);

// Review routes (with auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/reviews', ReviewController::class);
});

// Wishlist routes (with auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/wishlists', WishlistController::class);
});

// Contact Us routes
Route::apiResource('/contact-us', ContactUsController::class)->only(['index', 'store']);

// Subscriber routes
Route::apiResource('/subscribers', \App\Http\Controllers\Api\SubscriberController::class);

// Promotion routes
Route::apiResource('/promotions', PromotionController::class);

// Order routes (with auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/orders', OrderController::class);
});
