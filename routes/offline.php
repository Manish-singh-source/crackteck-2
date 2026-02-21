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
        Route::get('/login', 'login')->name('offlinelogin');
        Route::post('/login', 'loginStore')->name('offlineloginStore');
        Route::get('/recover-password', 'recover_password')->name('offlinerecover-password');
    });

    // Protected routes - require customer authentication
    // Route::middleware('customer_web')->group(function () {

        Route::controller(AuthController::class)->group(function () {
            Route::post('/logout', 'offlinelogout')->name('offline-logout');
        });

        Route::controller(OfflineCustomerController::class)->group(function () {
            Route::get('/', 'index')->name('offline-index');
            Route::get('/offline-amc', 'amc')->name('offline-amc');
            Route::get('/offline-amc-view/{id}', 'amcView')->name('offline-amc-view');
            Route::get('/offline-account-detail', 'accountDetail')->name('accountDetail');
            Route::get('/offline-address', 'address')->name('address');
            Route::get('/offline-change-password', 'changePassword')->name('changePassword');
        });
    // });
});
