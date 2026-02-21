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
        // Login Page
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'loginStore')->name('loginStore');
        // Forgot Password
        Route::get('/recover-password', 'recover_password')->name('recover-password');
        // Logout Page
        Route::post('/logout', 'logout')->name('logout');
    });

    Route::controller(OfflineCustomerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/amc', 'amc')->name('amc');
        Route::get('/account-detail', 'accountDetail')->name('accountDetail');
        Route::get('/address', 'address')->name('address');
        Route::get('/change-password', 'changePassword')->name('changePassword');
    });
});