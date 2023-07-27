<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/upload_image', [ImageController::class, 'store']);
Route::get('/setting', [SettingController::class, 'index']);
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::post('/auth/send_verify', [AuthController::class,'sendVerify']);
Route::post('/auth/forgot_password', [AuthController::class,'forgotPassword']);
Route::get('/category', [CategoryController::class,'index']);
Route::get('/product/{slug}', [ProductController::class,'show']);
Route::get('/product', [ProductController::class,'index']);
Route::post('/advisory', [\App\Http\Controllers\AdvisoryController::class,'store']);
Route::get('/product_by_category/{slug}', [CategoryController::class,'getByCategory']);
Route::post('/auth/verify_email', [AuthController::class,'verifyEmail']);
Route::post('create_order', [OrderController::class,'store']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/profile', [UserController::class,'show']);
    Route::post('/profile', [UserController::class,'store']);
    Route::post('/update_avatar', [ImageController::class,'updateAvatar']);

    Route::post('/auth/change_password', [AuthController::class,'changePassword']);

});
require __DIR__ . '/api-admin.php';
