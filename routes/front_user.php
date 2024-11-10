<?php

use App\Http\Controllers\BillinController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\Skincareroutinecontroller;
use App\Http\Controllers\ShiprockettController;

use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\Productcontroller;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DietController;


Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('user');
    // Profile
    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    //  Order
    Route::get('/order', "HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}', "HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}', [HomeController::class, 'userOrderDelete'])->name('user.order.delete');
    // Product Review
    Route::get('/user-review', [HomeController::class, 'productReviewIndex'])->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}', [HomeController::class, 'productReviewDelete'])->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}', [HomeController::class, 'productReviewEdit'])->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}', [HomeController::class, 'productReviewUpdate'])->name('user.productreview.update');
    // Post comment
    Route::get('user-post/comment', [HomeController::class, 'userComment'])->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}', [HomeController::class, 'userCommentDelete'])->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}', [HomeController::class, 'userCommentEdit'])->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}', [HomeController::class, 'userCommentUpdate'])->name('user.post-comment.update');
    // Password Change
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
    
});
Route::group(['middleware' => ['user']], function () {
    // Cart section
    Route::post('/add-to-carts', [CartController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/buy-now', [CartController::class, 'buy'])->name('buy')->middleware('auth');
    Route::post('/add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart')->middleware('auth');
    Route::post('/show-variant', [VariantController::class, 'ShowVariant'])->name('show-variant')->middleware('auth');
    Route::get('cart-delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');
    Route::post('cart-remove/{id}', [CartController::class, 'cartRemove'])->name('cart-remove');
    Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart.update');
    Route::get('/cart', [ShippingController::class, 'show'])->name('cart');
    // Coupon
    Route::post('/coupon-store', [CouponController::class, 'couponStore'])->name('coupon-store');
    // Payment
    Route::post('/payments', [FrontendController::class, 'payments'])->name('payments');
    Route::post('cart/order', [OrderController::class, 'store'])->name('cart.order');
    Route::get('order/pdf/{id}', [OrderController::class, 'pdf'])->name('order.pdf');
    // web.php
    Route::get('/cart-data', [CartController::class, 'getCartData'])->name('cart.data');
    Route::get('/shipping', [ShippingController::class, 'shipping'])->name('shipping');
    Route::post('/shipping', [ShippingController::class, 'shippingSubmit'])->name('shipping.submit');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/dummy', [CartController::class, 'dummy'])->name('dummy');
    Route::get('/get-address/{id}', [FrontendController::class, 'getAddress'])->name('getaddress');
    Route::get('/remove-address/{id}', [FrontendController::class, 'removeAddress'])->name('getaddress');
    Route::get('/get-address-details/{pincode}', [ShippingController::class, 'getAddressDetails']);
    Route::get('/account', [FrontendController::class, 'account'])->name('account');
    Route::get('/history', [FrontendController::class, 'history'])->name('history');
    Route::get('/order', [FrontendController::class, 'order'])->name('order');
    Route::get('/payment', [FrontendController::class, 'index']);
    Route::post('/review/{slug}', [ProductReviewController::class, 'store'])->name('review.user.store');
    Route::post('/account-edit', [FrontendController::class, 'editaccount'])->name('account.edit');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('auth');
    Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove')->middleware('auth');
    Route::post('/product/search', [FrontendController::class, 'productSearch'])->name('product.search');



});
Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->name('wishlist');

Route::get('/skin-routine', function () {
    return view('frontend.pages.skinroutine');
})->name('skin-routine');

// Updated route without required parameter
// Route::get('/product/search', [Productcontroller::class, 'productSearch'])->name('search.product');



Route::get('/diet-recommendation', [DietController::class, 'recommendDiet']);

Route::get('/face-scan', function () {
    return view('face_scan'); // Return the Blade view
});




Route::get('/skin-care', function () {
    return view('frontend.skincare'); // Return the Blade view
});

Route::post('/skincare', [Skincareroutinecontroller::class, 'skincare'])->name('skincare.routine');

Route::get('/scan-face', [Skincareroutinecontroller::class, 'scanFace'])->name('scan.face');
Route::get('/random-diet', [Skincareroutinecontroller::class, 'randomDiet'])->name('random.diet');
Route::get('/shiprocket-token', [ShiprockettController::class, 'getToken']);
Route::get('/track-order/{awb}', [ShiprockettController::class, 'trackOrder']);
