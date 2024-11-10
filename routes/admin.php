<?php

use App\Http\Controllers\Admin\OfflineInvoiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\PromiseController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\NewctasController;
use App\Http\Controllers\StrepController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\CertfiedByController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PickupLocationController;
use App\Http\Controllers\SkintypeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShowAppointmentController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ShiprocketController;
use App\Http\Controllers\ShiprockettController;

Route::get('login', function () {
    return redirect()->route('admin.login');
});
route::middleware(['adminguest'])->group(function () {
    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
});

Route::post('/admin/login', [AdminController::class, 'login_submit'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('login', function () {
    abort(403, 'This route is disabled.');
});
Route::post('/logout', function () {
    abort(403, 'This route is disabled.');
});
Route::group(['prefix' => '/admin', 'middleware' => ['admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/file-manager', function () {
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // User route
    Route::resource('users', UsersController::class);
    // Banner
    Route::resource('banner', BannerController::class);
    // Poster
    Route::resource('poster', PosterController::class);
    // Promise
    Route::resource('promise', PromiseController::class);
    //certified By
    Route::resource('certified', CertfiedByController::class);
    // Brand
    Route::resource('brand', BrandController::class);
    // CTA
    Route::resource('cta', NewctasController::class);
    // Strep
    Route::resource('strep', StrepController::class);
    // Profile

    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
    // Category
    Route::resource('/category', CategoryController::class);
    // Concern
    Route::resource('/concern', ConcernController::class);
    Route::resource('/skin', SkintypeController::class);
    // Product Type
    Route::resource('/product_type', ProductTypeController::class);
    // Product
    Route::resource('/product', ProductController::class);
    Route::resource('variant', VariantController::class);
    Route::resource('stocks', StocksController::class);

    // Ajax for sub category
    Route::post('/category/{id}/child', [CategoryController::class, 'getChildByParent']);
    Route::post('/concern/{id}/child', [ConcernController::class, 'getChildByParent']);
    Route::resource('post-category', PostCategoryController::class);
    // Post tag
    Route::resource('post-tag', PostTagController::class);
    // Post
    Route::resource('post', PostController::class);
    // Testimonial
    Route::resource('testimonial', TestimonialController::class);
    // faq
    Route::resource('faq', FaqController::class);
    // returns
    Route::resource('returns', ReturnsController::class);
    // question
    Route::resource('question', QuestionController::class);
    // story
    Route::resource('story', StoryController::class);
    // terms
    Route::resource('terms', TermsController::class);
    // Message
    Route::resource('message', MessageController::class);
    Route::get('message/five', [MessageController::class, 'messageFive'])->name('messages.five');
    // Order
    Route::resource('order', OrderController::class);
    Route::post('submit-tracking', [OrderController::class, 'submitTracking'])->name('submit-tracking');
    // Shipping
    Route::resource('shipping', ShippingController::class);
    // Coupon
    Route::resource('coupon', CouponController::class);
    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('centerUpdate', [AdminController::class, 'centerUpdate'])->name('centerUpdate');

    Route::get('/stock/invoice/{invoice_no}', [AdminController::class, 'generateInvoiceShow'])->name('stocks.generateInvoiceShow');
    Route::post('/stock/generateInvoice', [AdminController::class, 'generateInvoice']);

    Route::get('/stocks/trash/{id}', [AdminController::class, 'trashInvoiceBill'])->name('stocks.trashInvoice');

    Route::post('/stock/getBatchData', [StocksController::class, 'getStockByBatch'])->name('stock.getByBatch');
    Route::post('/stock/add', [StocksController::class, 'addStock'])->name('stock.add');
    Route::post('/stock/remove', [StocksController::class, 'removeStock'])->name('stock.remove');

    // offline_stock_billing
    Route::get('/offline-invoices/get-product-batches/{productId}', [OfflineInvoiceController::class, 'getProductBatches']);
    Route::get('/offline-invoices/get-product-stock/{productId}', [OfflineInvoiceController::class, 'getProductStock']);
    Route::post('/offline-invoices/generateInvoice', [OfflineInvoiceController::class, 'generateInvoice']);
    Route::resource('/offline-invoices', OfflineInvoiceController::class);
    
    // offline_stock_billing



    Route::get('/stock/get-product-batches/{productId}', [AdminController::class, 'getProductBatches']);
    Route::get('/stock/get-product-stock/{stockId}', [AdminController::class, 'getProductStock']);
    Route::get('/stock/buy', [AdminController::class, 'buy'])->name('stocks.buy');
    Route::get('/invoice', [AdminController::class, 'showinvoice'])->name('show.invoice');
    Route::post('/invoice/show', [AdminController::class, 'showinvoiceData'])->name('admin.offline.invoice.show');

    Route::get('/stock/new_sale_return', [AdminController::class, 'new_sale_return'])->name('stocks.new_sale_return');
    Route::get('/stock/search-invoice-id', [AdminController::class, 'searchInvoiceId'])->name('stocks.search-invoice-id');
    Route::get('/stock/get-invoice-details', [AdminController::class, 'getInvoiceDetails'])->name('stocks.get-invoice-details');
    Route::post('/stock/return-stock-product', [AdminController::class, 'processStockProductReturn'])->name('stocks.return-stock-product');
    Route::get('/stock/returnInvoiceGenerate', [AdminController::class, 'returnInvoiceGenerate'])->name('stocks.returnInvoiceGenerate');



    Route::get('/stock/product-price/{price}', [AdminController::class, 'getProductPrice']);
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    Route::post('admin/update', [AdminController::class, 'adminUpdate'])->name('admin.update');
    // Notification
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
    // Order Notification
    Route::get('/order_notification', [NotificationController::class, 'order_notify'])->name('admin.notification.order_notify');
    Route::get('/order_notification/all', [NotificationController::class, 'order_notify_all'])->name('admin.notification.all');
    // Route::delete('/order_notification/delete/{id}', [NotificationController::class, 'order_notify_delete'])->name('admin.notification.OrdDelete');
    // Password Change 
    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');
    Route::get('slot', [ShowAppointmentController::class, 'index'])->name('show.slot');
    Route::resource('suppliers', 'SupplierController');
    Route::resource('routine', 'RoutineController');
    Route::resource('purchases', 'PurchaseController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('social', 'SocialController');
    Route::resource('/comment', 'PostCommentController');
    Route::resource('review', ProductReviewController::class);

    Route::get('/search', [ProductReviewController::class, 'search'])->name('review.search');

    Route::get('/add-review', [ProductReviewController::class, 'addreview'])->name('add.review.backend');
    Route::post('/add-review-backend-post', [ProductReviewController::class, 'addreviewpost'])->name('add.review.backend.post');
    Route::resource('/billing', 'BillingController');
    Route::resource('information', InformationController::class);
    //Store Add
    Route::resource('store', StoreController::class);
    Route::get('/shiprocket/track/{awb}', [ShiprocketController::class, 'trackOrder']);
    Route::post('/shiprocket/create-order', [ShiprocketController::class, 'createOrder']);
    Route::resource('/centers', CenterController::class);

    Route::get('/pickup-address',[PickupLocationController::class,'pickup_address'])->name('pickup_index');
    Route::get('/pickup-address/create',[PickupLocationController::class,'create_address'])->name('pickup_create');
    Route::post('/pickup-address/store',[PickupLocationController::class,'store_address'])->name('pickup_store');
    // Route::get('/pickup-address/edit/{id}',[PickupLocationController::class,'edit_address'])->name('pickup_edit');
    // Route::post('/pickup-address/update/{id}',[PickupLocationController::class,'update_address'])->name('pickup_update');
    
    // Route::get('/add_user',function(){
    //     return view('backend.shipping.shipment_work.add_user');
    // });
    Route::get('/generate_token',function(){
        return view('backend.shipping.shipment_work.generate_token');
    });

    Route::get('/add_user',[ShiprockettController::class,'addUser'])->name('shipUserDetail');
    Route::post('/shipUser',[ShiprockettController::class,'shipUserCreate'])->name('shipUser');
    Route::post('/generateToken',[ShiprockettController::class,'generateToken'])->name('generateToken');

});
// Route::get('/stocks/buy', [AdminController::class, 'buy'])->name('stocks.buy');
use UniSharp\LaravelFilemanager\Controllers\LfmController;
use UniSharp\LaravelFilemanager\Controllers\CropController;
use UniSharp\LaravelFilemanager\Controllers\ItemsController;
use UniSharp\LaravelFilemanager\Controllers\ResizeController;
use UniSharp\LaravelFilemanager\Controllers\DownloadController;
use UniSharp\LaravelFilemanager\Controllers\FolderController;
use UniSharp\LaravelFilemanager\Controllers\RenameController;
use UniSharp\LaravelFilemanager\Controllers\DeleteController;
use UniSharp\LaravelFilemanager\Controllers\DemoController;
use UniSharp\LaravelFilemanager\Controllers\UploadController;
use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Artisan;
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['admin']], function () {
    Lfm::routes();
});
// Apply middleware to all filemanager routes
Route::middleware(['admin'])->group(function () {
    if (file_exists(__DIR__ . '/migrate.php')) {
        include __DIR__ . '/migrate.php';
    }
    Route::resource('sales', 'SaleController');
    Route::get('filemanager', [LfmController::class, 'show']);
    Route::get('filemanager/crop', [CropController::class, 'getCrop']);
    Route::get('filemanager/cropimage', [CropController::class, 'getCropImage']);
    Route::get('filemanager/cropnewimage', [CropController::class, 'getNewCropImage']);
    Route::get('filemanager/delete', [DeleteController::class, 'getDelete']);
    Route::get('filemanager/demo', [DemoController::class, 'index']);
    Route::get('filemanager/domove', [ItemsController::class, 'doMove']);
    Route::get('filemanager/doresize', [ResizeController::class, 'performResize']);
    Route::get('filemanager/doresizenew', [ResizeController::class, 'performResizeNew']);
    Route::get('filemanager/download', [DownloadController::class, 'getDownload']);
    Route::get('filemanager/errors', [LfmController::class, 'getErrors']);
    Route::get('filemanager/folders', [FolderController::class, 'getFolders']);
    Route::get('filemanager/jsonitems', [ItemsController::class, 'getItems']);
    Route::get('filemanager/move', [ItemsController::class, 'move']);
    Route::get('filemanager/newfolder', [FolderController::class, 'getAddfolder']);
    Route::get('filemanager/rename', [RenameController::class, 'getRename']);
    Route::get('filemanager/resize', [ResizeController::class, 'getResize']);
    Route::any('filemanager/upload', [UploadController::class, 'upload']);
    Route::get('cache-clear', function () {
        Artisan::call('optimize:clear');
        session()->flash('success', 'Successfully cache cleared.');
        return redirect()->back();
    })->name('cache.clear');

    Route::get('storage-link', [AdminController::class, 'storageLink'])->name('storage.link');
});
