<?php

use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\Productcontroller;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\RozerpayController;
use Illuminate\Http\Request;
use App\Http\Controllers\ShiprockettController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/user/login', [UserController::class, 'loginSubmitApi'])->name('login.api');
Route::post('/user/register', [UserController::class, 'registerSubmitApi'])->name('register.api');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/user/logout', [Productcontroller::class, 'logoutApi'])->name('logout.api');
    Route::get('/account', [UserController::class, 'account'])->name('logout.api');
});
Route::get('/home', [HomeController::class, 'home']);
Route::get('/product-detail/{slug}', [Productcontroller::class, 'productDetail'])->name('product-detail');
Route::post('/product/search', [Productcontroller::class, 'productSearch'])->name('product.search');

Route::get('/product-cat/{slug}', [Productcontroller::class, 'productCat'])->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}', [Productcontroller::class, 'productSubCat'])->name('product-sub-cat');
Route::get('/product-brand/{slug}', [Productcontroller::class, 'productBrand'])->name('product-brand');
Route::get('/product-type/{slug}', [Productcontroller::class, 'productType'])->name('product-type');
Route::get('/product-concern/{slug}', [Productcontroller::class, 'productConcern'])->name('product-concern');
Route::get('/product-sub-concern/{slug}/{sub_slug}', [Productcontroller::class, 'productSubConcern'])->name('product-sub-concern');

Route::get('/product-categories', [Productcontroller::class, 'AllCategory'])->name('product-categories');
Route::get('/product-concerns', [Productcontroller::class, 'AllConcern'])->name('product-concerns');
Route::get('/product-brands', [Productcontroller::class, 'AllBrand'])->name('product-brands');
Route::get('/product-types', [Productcontroller::class, 'AllType'])->name('product-types');
Route::get('/product-sub-categories/{slug}', [Productcontroller::class, 'AllSubCategory'])->name('product-sub-categories');
Route::get('/product-sub-concerns/{slug}', [Productcontroller::class, 'AllSubConcern'])->name('product-sub-concerns');
Route::get('/product-sub-brands/{slug}', [Productcontroller::class, 'AllSubBrand'])->name('product-sub-brands');
Route::get('/product-sub-types/{slug}', [Productcontroller::class, 'AllSubType'])->name('product-sub-types');

Route::get('test-cros', function () {
    return 'hello';
});


Route::post('/shipping', [ShiprockettController::class, 'createShipping'])->name('shipping.create');
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/pickup-locations', [ShiprocketController::class, 'fetchPickupLocations']);
    
});
