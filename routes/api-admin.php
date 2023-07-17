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
    Route::middleware(['auth:sanctum',\App\Http\Middleware\AuthAdmin::class])->group(function () {

        Route::post('/update_image/{id}', [\App\Http\Controllers\Admin\ImageAdminController::class,'update']);
        Route::apiResource('/product', ProductAdminController::class);
        Route::apiResource('/post', PostAdminController::class);
        Route::apiResource('/advisory', \App\Http\Controllers\Admin\AdvisoryController::class);
        Route::apiResource('/setting', \App\Http\Controllers\Admin\SettingAdminController::class);
        Route::apiResource('/category', \App\Http\Controllers\Admin\CategoryAdminController::class);
        Route::apiResource('/image', \App\Http\Controllers\Admin\ImageAdminController::class);
        Route::apiResource('/order', OrderAdminController::class);
        Route::apiResource('/user', \App\Http\Controllers\Admin\UserAdminController::class);
        Route::apiResource('/tag', \App\Http\Controllers\Admin\TagController::class);
    });

});
