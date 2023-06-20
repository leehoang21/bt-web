<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/upload_image', [ImageController::class, 'store']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/send_verify', [AuthController::class,'sendVerify']);
    Route::post('/auth/change_password', [AuthController::class,'changePass']);
    Route::post('/auth/verify_email', [AuthController::class,'verifyEmail']);
    Route::post('/update_avatar', [ImageController::class,'updateAvatar']);
    Route::get('/profile', [UserController::class,'show']);
    Route::post('/profile', [UserController::class,'store']);
    Route::get('/category', [CategoryController::class,'index']);
    Route::get('/product/{slug}', [ProductController::class,'show']);
    Route::get('/product', [ProductController::class,'index']);
});
require __DIR__ . '/api-admin.php';
