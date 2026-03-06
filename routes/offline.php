<?php

use App\Http\Controllers\OfflineCustomer\AuthController;
use App\Http\Controllers\OfflineCustomer\OfflineCustomerController;
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
        Route::get('/logout', 'offlinelogoutGet')->name('offline-logout-get');
    });

    Route::controller(OfflineCustomerController::class)->group(function () {
        Route::get('/', 'index')->name('offline-index');
        Route::get('/offline-amc', 'amc')->name('offline-amc');
        Route::get('/offline-amc-view/{id}', 'amcView')->name('offline-amc-view');
        Route::post('/offline-amc/ticket', 'storeAmcTicket')->name('offline-amc.ticket.store');
        Route::get('/offline-ticket', 'ticket')->name('offline-ticket');
        Route::get('/offline-ticket-view/{id}', 'ticketView')->name('offline-ticket-view');
        Route::get('/offline-account-detail', 'accountDetail')->name('accountDetail');
        Route::put('/offline-account-detail', 'updateProfile')->name('offline-account-update');
        Route::get('/offline-address', 'address')->name('address');
        Route::post('/offline-address', 'storeAddress')->name('offline-address-store');
        Route::get('/offline-address/{id}', 'editAddress')->name('offline-address-edit');
        Route::put('/offline-address/{id}', 'updateAddress')->name('offline-address-update');
        Route::delete('/offline-address/{id}', 'deleteAddress')->name('offline-address-delete');
        Route::get('/offline-change-password', 'changePassword')->name('changePassword');
        Route::put('/offline-change-password', 'updatePassword')->name('offline-password-update');
    });
    // });
});
