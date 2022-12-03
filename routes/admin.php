<?php 
/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RewardsController;
use App\Http\Controllers\Admin\ZipCodeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DeliveryBoysController;
use App\Http\Controllers\Admin\MenuCategoryController;
use App\Http\Controllers\Admin\PaymentHistoryController;

Route::group(['namespace'=>'Auth','prefix' => 'admin'], function() {
    Route::get('/login', [LoginController::class, 'showloginPage'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
});
Route::group(['as' => 'admin.','prefix' => 'admin','middleware' => ['auth']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/edit-profile', [ProfileController::class, 'editProfile'])->name('profile.edit');  
    Route::post('/profile-update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/menus', MenuController::class)->names(['index' => 'menus.index']);
    Route::resource('/menu-category', MenuCategoryController::class)->names(['index' => 'menu-category.index']);
    Route::post('/menus/delete-menu-image', [MenuController::class, 'deleteMenuImage']);
    Route::post('/menu-category/delete-menucat-image', [MenuCategoryController::class, 'deleteMenuCatImage']);

    Route::resource('/slider', SliderController::class)->names(['index' => 'slider.index']);
    Route::post('/slider/delete-slider-image', [SliderController::class, 'deleteSliderImage']);
    Route::resource('/reward', RewardsController::class)->names(['index' => 'reward.index']);
    Route::post('/reward/delete-reward-image', [RewardsController::class, 'deleteRewardImage']);

    Route::resource('/orders', OrderController::class)->names(['index' => 'order.index']);
    Route::post('orders-search', [OrderController::class, 'searchOrder'])->name('orders.search');
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.history');
    Route::post('/payment-history-search', [PaymentHistoryController::class, 'historyByDate'])->name('payment.history.search');

    Route::resource('/delivery-boys', DeliveryBoysController::class)->names(['index' => 'delivery-boys.index']);
    Route::resource('/zipcodes', ZipCodeController::class)->names(['index' => 'zipcodes.index']);
});