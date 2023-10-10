<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//auth
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/forgot_password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/verify_email', [AuthController::class, 'verifyEmail']);
Route::post('/auth/send_verify', [AuthController::class, 'sendVerify']);
Route::post('/upload_image', [ImageController::class, 'store']);


Route::middleware(['auth:sanctum', \App\Http\Middleware\AuthUser::class])->group(function () {
    Route::post('/auth/change_password', [AuthController::class, 'changePassword']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

});