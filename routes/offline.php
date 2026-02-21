<?php
use App\Http\Controllers\OfflineCustomer\OfflineCustomerController;
use App\Http\Controllers\OfflineCustomer\AuthController;

use Illuminate\Support\Facades\Route;

// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
// **************************************************************      E-Commerce      *******************************************************************
// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
Route::prefix('/demo/offline-customer')->group(function () { 
    Route::controller(AuthController::class)->group(function () {
        Route::middleware('customer.guest')->group(function () {
            Route::get('/login', 'login')->name('offlinelogin');
            Route::post('/login', 'loginStore')->name('offlineloginStore');
            Route::get('/recover-password', 'recover_password')->name('offlinerecover-password');
        });
        Route::post('/logout', 'offlinelogout')->name('offline-logout');
    });

    // Protected routes - require customer authentication
    Route::middleware('customer.auth')->group(function () {
        Route::controller(OfflineCustomerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/amc', 'amc')->name('amc');
            Route::get('/account-detail', 'accountDetail')->name('accountDetail');
            Route::get('/address', 'address')->name('address');
            Route::get('/change-password', 'changePassword')->name('changePassword');
        });
    });
});