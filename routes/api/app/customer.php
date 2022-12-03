<?php
use App\Http\Controllers\API\App\Customer\AuthController;
use App\Http\Controllers\API\App\Customer\LoginController;
use App\Http\Controllers\API\App\Customer\Cart\CartApiController;
use App\Http\Controllers\API\App\Customer\Coin\CoinApiController;
use App\Http\Controllers\API\App\Customer\Menu\MenuApiController;
use App\Http\Controllers\API\App\Customer\Order\OrderApiController;
use App\Http\Controllers\API\App\Customer\Slider\SliderApiController;
use App\Http\Controllers\API\App\Customer\Address\AddressApiController;
use App\Http\Controllers\API\App\Customer\Setting\SettingApiController;
use App\Http\Controllers\API\App\Customer\Zipcode\ZipCodeApiController;
use App\Http\Controllers\API\App\Customer\UserReward\UserRewardApiController;
use App\Http\Controllers\API\App\Customer\MenuCategory\MenuCategoryApiController;
use App\Http\Controllers\API\App\Customer\OrderFeedback\OrderFeedbackApiController;


Route::prefix('app/customer')->group(function () {
    Route::name('customer.')->middleware(['auth:api', 'verify.customer.role'])->group(function () {

        Route::get('/dashboard', [LoginController::class, 'dashboard']);
        Route::put('/edit-profile', [LoginController::class, 'editProfile']);
        Route::put('/edit-password', [LoginController::class, 'resetPassword']);
        Route::post('/logout', [LoginController::class, 'logout']);

        // Order
        Route::get('/menus-status', [CartApiController::class, 'menusStatus']);
        Route::post('/place-order', [OrderApiController::class, 'placeOrder']);
        Route::get('/order-history', [OrderApiController::class, 'orderHistory']);

        // My Rewards
        Route::post('/my-rewards', [UserRewardApiController::class, 'myReward']);
        
        // Address
        Route::apiResource('addresses', AddressApiController::class);

        // Check Zip code availability.
        Route::post('/check-zipcode', [ZipCodeApiController::class, 'checkZipcode']);

        // Feedback
        Route::post('/create-feedback', [OrderFeedbackApiController::class, 'saveFeedback']);

        // Coin redeem.
        Route::get('/coin-redeem', [CoinApiController::class, 'redeemStatus']);
        Route::post('/apply-coin', [CoinApiController::class, 'applyCoin']);

     });

    Route::post('/registration', [LoginController::class, 'customerRegistration']);
    Route::post('/login', [LoginController::class, 'login']);
    
    // Slider
    Route::post('/sliders', [SliderApiController::class, 'viewSlider']);

    // Cart
    Route::apiResource('carts', CartApiController::class);
    Route::put('update-cart', [CartApiController::class, 'updateCart']);

    // Menus
    Route::get('/menus', [MenuApiController::class, 'index']);
    Route::get('/popular-menus', [MenuApiController::class, 'popularMenu']);

    // Menu Categories
    Route::get('/menu-categories', [MenuCategoryApiController::class, 'index']);
    Route::get('/menu-categories/{id}', [MenuCategoryApiController::class, 'show']);

    // Forget Password
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/check-otp', [AuthController::class, 'checkOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Settings
    Route::get('/settings/{id}', [SettingApiController::class, 'setting']);
});