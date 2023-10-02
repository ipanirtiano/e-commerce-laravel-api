<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClientMiddleware;
use App\Models\Address;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// route
Route::post('/admin/register', [AdminController::class, 'register']);
Route::post('/admin/login', [AdminController::class, 'login']);

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::get("/all-product", [ProductController::class, 'getAllProduct']);
Route::get("/product/{id}", [ProductController::class, 'getProductById']);

// route group admin midleware
Route::middleware(AdminMiddleware::class)->group(function(){
    // get admin
    Route::get('/admin/current', [AdminController::class, 'getCurrentAdmin']);
    Route::delete('/admin/logout', [AdminController::class, 'logout']);

    // route product
    Route::post("/admin/add-product", [ProductController::class, 'addProduct']);
    Route::get("/admin/all-product", [ProductController::class, 'getAllProduct']);
    Route::get("/admin/product/{id}", [ProductController::class, 'getProductById']);
    Route::put("/admin/product/{id}", [ProductController::class, 'updateProduct']);
    Route::delete("/admin/product/{id}", [ProductController::class, 'deleteProduct']);
});

// route group client middleware
Route::middleware(ClientMiddleware::class)->group(function(){
    // get user
    Route::get('/user/current', [UserController::class, 'getCurrentUser']);
    Route::delete('/user/logout', [UserController::class, 'logout']);
    Route::put('/user/update', [UserController::class, 'updateUser']);

    // route product
    Route::post('/user/product/add-cart', [CartController::class, 'addCart']);
    Route::get('/user/product/cart', [CartController::class, 'getAllCart']);
    Route::delete('/user/product/cart-delete/{id}', [CartController::class, 'deleteCart']);
    Route::get('/user/product/cart-increase-amount/{id}', [CartController::class, 'increaseAmount']);
    Route::get('/user/product/cart-decrease-amount/{id}', [CartController::class, 'decreaseAmount']);
    
    // address route
    Route::post('/user/address/add', [AddressController::class, 'addNewAdress']);
    Route::get('/user/address/get', [AddressController::class, 'getAddress']);

    // order routes
    Route::post('/user/order/add',[OrderController::class, 'addNewOrder']);
    Route::get('/user/order/get',[OrderController::class, 'getAllOrder']);
    Route::get('/user/order/detail/{uuid}',[OrderController::class, 'getOrderById']);
});