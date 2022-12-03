<?php

use App\Http\Controllers\API\App\DeliveryBoy\DeliveryBoyAuthController;
use App\Http\Controllers\API\App\DeliveryBoy\DeliveryBoyLoginApiController;
use App\Http\Controllers\API\App\DeliveryBoy\ScanCode\ScanCodeApiController;
use App\Http\Controllers\API\App\DeliveryBoy\DeliverOrder\DeliverOrderApiController;



Route::prefix('app/delivery-boy')->group(function () {
    Route::name('deliveryboy.')->middleware(['auth:api', 'verify.delivery.role'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [DeliveryBoyLoginApiController::class, 'dashboard']);
        Route::post('/logout', [DeliveryBoyLoginApiController::class, 'logout']);

        // Scan Code
        Route::put('/scan-code', [ScanCodeApiController::class, 'scanCode']);
       
        // Profile update
        Route::put('/edit-profile', [DeliveryBoyAuthController::class, 'editProfile']);

        // Orders
        Route::get('/orders', [DeliverOrderApiController::class, 'orders']);
        Route::put('/deliver-orders/{id}', [DeliverOrderApiController::class, 'changeStatus']);
    });

    Route::post('/login', [DeliveryBoyLoginApiController::class, 'login']);
});