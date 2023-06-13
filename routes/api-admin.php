<?php
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/auth/login', [AuthAdminController::class,'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('/product', ProductAdminController::class);

        Route::get('/order', [OrderAdminController::class,'index']);
        Route::patch('/order/{id}', [OrderAdminController::class,'update']);
    });

});
