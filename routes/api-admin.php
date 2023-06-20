<?php
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/auth/login', [AuthAdminController::class,'login']);
//    Route::post('/auth/verify', [AuthAdminController::class,'verify']);
//    Route::post('/auth/send_verify', [AuthAdminController::class,'sendVerify']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('/product', ProductAdminController::class);

        Route::get('/order', [OrderAdminController::class,'index']);
        Route::patch('/order/{id}', [OrderAdminController::class,'update']);
        Route::apiResource('/post', PostAdminController::class);
        Route::get('/detail_post/{slug}', [PostAdminController::class,'showBySlug']);
        Route::apiResource('/advisory', \App\Http\Controllers\Admin\AdvisoryController::class);
        Route::apiResource('/setting', \App\Http\Controllers\Admin\SettingAdminController::class);
        Route::apiResource('/category', \App\Http\Controllers\Admin\CategoryAdminController::class);
        Route::apiResource('/image', \App\Http\Controllers\Admin\ImageAdminController::class);
        Route::apiResource('/user', \App\Http\Controllers\Admin\UserAdminController::class);
        Route::apiResource('/tag', \App\Http\Controllers\Admin\TagController::class);
    });

});
