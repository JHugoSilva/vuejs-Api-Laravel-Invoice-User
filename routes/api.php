<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserShowController;
use App\Http\Controllers\Api\VerifyEmailController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', LoginController::class);
Route::post('register', RegisterController::class);

Route::controller(PasswordResetController::class)->group(function(){
    Route::post('password/email',  'sendResetLink');
    Route::post('password/reset',  'reset')->middleware('signed')->name('password.reset');
});

Route::middleware('auth:sanctum')->group(function(){

    Route::controller(VerifyEmailController::class)->group(function(){
        Route::post('email/verify/send', 'sendMail');
        Route::post('email/verify', 'verify')->name('verify-email');

    });

    Route::middleware('verified')->group(function() {
        Route::get('dashboard', DashboardController::class);
    });

    Route::get('user', UserShowController::class);

    Route::delete('logout', LogoutController::class);
});

Route::controller(InvoiceController::class)->group(function(){
    Route::get('getInvoices',  'index');
    Route::get('getSearchInvoice', 'search');
    Route::get('createInvoice', 'create');
    Route::post('addInvoice', 'store');
    Route::get('showInvoice/{id}', 'show');
    Route::get('editInvoice/{id}', 'edit');
    Route::delete('deleteInvoiceItems/{id}','destroyInvoiceItems');
    Route::put('updateInvoice/{id}',  'update');
    Route::delete('deleteInvoice/{id}', 'destroyInvoice');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('products', 'index');
    Route::post('addProduct', 'store');
    Route::get('product/{id}', 'edit');
    Route::put('product/{id}', 'update');
    Route::delete('product/{id}', 'destroy');
});

Route::get('customers', [CustomerController::class, 'index']);











