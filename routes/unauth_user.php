<?php

use App\Http\Controllers\BillinController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OTPLoginController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\RozerpayController;
use App\Http\Controllers\SlotController;
use Illuminate\Support\Facades\Route;
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/billings/{id}', [BillinController::class, 'billgernate'])->name('billings');
Route::get('/book_slot', [SlotController::class, 'book_slot'])->name('book_slot');
Route::post('/book_slot', [SlotController::class, 'save_slot'])->name('book_slot.save_slot');
Route::get('/available-slots', [SlotController::class, 'getAvailableSlot'])->name('available_slots');
Route::get('/location', [BillinController::class, 'billgernate2'])->name('location2');
Route::post('webhook/razorpay', [RazorpayController::class, 'handleWebhook']);
Route::post('webhook/', [RazorpayController::class, 'handleWebhook']);

/**
 * other route
 * 
 */
Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('/returns', [FrontendController::class, 'returns'])->name('returns');
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/contact/message', [MessageController::class, 'store_contact'])->name('contact.store');

Route::get('razorpay', [RazorpayController::class, 'razorpay'])->name('razorpay');
Route::post('razorpaypayment', [RazorpayController::class, 'payment'])->name('payment');

// Route::get('/wishlist/{slug}', [WishlistController::class, 'wishlist'])->name('add-to-wishlist')->middleware('user');
// Route::get('wishlist-delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist-delete');

Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');

Route::match(['get', 'post'], '/filter', [FrontendController::class, 'productFilter'])->name('shop.filter');
// Order Track
Route::get('track/{id}', [OrderController::class, 'orderTrack'])->name('order.track');
Route::post('product/track/order', [OrderController::class, 'productTrackOrder'])->name('product.track.order');
// Blog
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blog.search');
Route::post('/blog/filter', [FrontendController::class, 'blogFilter'])->name('blog.filter');
Route::get('blog-cat/{slug}', [FrontendController::class, 'blogByCategory'])->name('blog.category');
Route::get('blog-tag/{slug}', [FrontendController::class, 'blogByTag'])->name('blog.tag');

// NewsLetter
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// Post Comment
Route::post('post/{slug}/comment', [PostCommentController::class, 'store'])->name('post-comment.store');
Route::get('/story', [FrontendController::class, 'story'])->name('story');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::post('routine-submit', [FrontendController::class, 'routineSubmit'])->name('routine.submit');

/**
 * 
 * User Register and login routes
 * 
 */
route::middleware(['guest:web'])->group(function () {
    Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
    Route::post('register', [OTPLoginController::class, 'register'])->name('register.submit');

});

route::post('send-otp', [OTPLoginController::class, 'sendOTP'])->name('send.otp');
route::post('send-otp-register', [OTPLoginController::class, 'sendOtpRegister'])->name('send.otp.register');

Route::post('login-otp', [OTPLoginController::class, 'verifyOTP'])->name('verify.otp');
Route::get('customlogin/{id}', [OTPLoginController::class, 'customlogin']);
Route::get('user/logout', [FrontendController::class, 'logout'])->name('user.logout');
Route::get('user/register', [FrontendController::class, 'register'])->name('register.form');

// UserLogin With Email/Password
Route::get('/login/google', [GoogleAuthController::class, 'showSocialLoginForm'])->name('login.social');
Route::post('/login/google', [GoogleAuthController::class, 'socialLogin']);
Route::get('/login/google/callback', [GoogleAuthController::class, 'handleProviderCallback']);




/**
 * 
 * Product Routes 
 * 
 */
Route::get('/product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
Route::get('/product-lists', [FrontendController::class, 'productLists'])->name('product-lists');
Route::get('product-detail/{slug}/{id?}', [FrontendController::class, 'productDetail'])->name('product-detail');

Route::get('/product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}', [FrontendController::class, 'productSubCat'])->name('product-sub-cat');
Route::get('/product-brand/{slug}', [FrontendController::class, 'productBrand'])->name('product-brand');
Route::get('/product-type/{slug}', [FrontendController::class, 'productType'])->name('product-type');
Route::get('/product-concern/{slug}', [FrontendController::class, 'productConcern'])->name('product-concern');
Route::get('/product-sub-concern/{slug}/{sub_slug}', [FrontendController::class, 'productSubConcern'])->name('product-sub-concern');

Route::get('/product-categories', [FrontendController::class, 'AllCategory'])->name('product-categories');
Route::get('/product-concerns', [FrontendController::class, 'AllConcern'])->name('product-concerns');
Route::get('/product-brands', [FrontendController::class, 'AllBrand'])->name('product-brands');
Route::get('/product-types', [FrontendController::class, 'AllType'])->name('product-types');
Route::get('/product-sub-categories/{slug}', [FrontendController::class, 'AllSubCategory'])->name('product-sub-categories');
Route::get('/product-sub-concerns/{slug}', [FrontendController::class, 'AllSubConcern'])->name('product-sub-concerns');
Route::get('/product-sub-brands/{slug}', [FrontendController::class, 'AllSubBrand'])->name('product-sub-brands');
Route::get('/product-sub-types/{slug}', [FrontendController::class, 'AllSubType'])->name('product-sub-types');
Route::post('product/{slug}/review', [ProductReviewController::class, 'store'])->name('review.store');
Route::post('/create-order', [RozerpayController::class, 'createOrder']);
Route::post('/verify-payment', [RozerpayController::class, 'verifyPayment']);