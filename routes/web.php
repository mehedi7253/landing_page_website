<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Page\OrderController;
use App\Http\Controllers\Page\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();




//front page routes
Route::get('/', [PageController::class, 'index']);
Route::post('/cart', [PageController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/increase', [PageController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decrease', [PageController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::get('/cart-item',[PageController::class, 'cartItem'])->name('cart.item');
Route::delete('/remove-item/{productId}', [PageController::class, 'removeItem'])->name('cart.remove');
Route::get('/product-details/{slug}', [PageController::class, 'productDetails'])->name('product.details');
Route::resource('/orders', OrderController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/home',[AdminController::class, 'index'])->name('admin.home');
    Route::get('site-settings', [AdminController::class, 'applicationSetting'])->name('site-settings');
    Route::post('site-setting-update', [AdminController::class, 'updateApplicationSetting'])->name('settings-update');
    Route::get('about-settings', [AdminController::class, 'aboutUs'])->name('about-settings');
    Route::post('update-about',[AdminController::class, 'updateAboutUs'])->name('update-about');

    Route::get('mission-vision', [AdminController::class, 'missionVision'])->name('mission-vision');
    Route::post('update-mission-vision',[AdminController::class, 'updateMissionVision'])->name('update-mission-vision');
    Route::resource('banners', BannerController::class);

    Route::get('sfv', [AdminController::class, 'getService'])->name('get-service-FV');
    Route::post('update-service-facilities-values', [AdminController::class, 'updateSFV'])->name('update-service-facilities-values');

    Route::resource('products', ProductController::class);

    //EMAIL SETTING ROUTE LIST ==========>
    Route::get('email-setting', [AdminController::class, 'emailSettingIndex'])->name('email-setting.index');
    Route::post('email-setting/update', [AdminController::class, 'emailSettingUpdate'])->name('email-setting.update');
    Route::get('email-setting/test-mail', [AdminController::class, 'testMail'])->middleware('mail-service')->name('email-setting.test-mail');
});
