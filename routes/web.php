<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Auth;


Auth::routes(['register' => false]);
Route::get('/userroutine', [FrontendController::class, 'routine'])->name('userroutine');
Route::resource('invoice', InvoiceController::class);

require __DIR__ . '/front_user.php';
require __DIR__ . '/unauth_user.php';
require __DIR__ . '/admin.php';
