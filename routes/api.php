<?php

use App\Http\Controllers\Api\AllServicesController;
use App\Http\Controllers\Api\AmcServicesController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryOrderController;
use App\Http\Controllers\Api\FollowUpController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\MeetController;
use App\Http\Controllers\Api\NonAmcServicesController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\QuickServiceController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\SDUIController;
use App\Http\Controllers\Api\StockinHandController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Symfony\Component\Mime\Address;

// use App\Http\Controllers\AMCRequestController;
// use App\Http\Controllers\AMCRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// // Public API routes (no authentication required)
// Route::prefix('auth')->group(function () {
//     // Route::post('/login', [ApiAuthController::class, 'login']);
// });

// // Order-related API routes (public for now, can be protected later)
// Route::get('/search-product', [OrderController::class, 'searchProducts']);
// Route::get('/search-customer', [OrderController::class, 'searchCustomers']);

// // Protected API routes (authentication required)
// Route::middleware('auth:sanctum')->group(function () {
//     // Authentication routes
//     Route::prefix('auth')->group(function () {
//         Route::post('/logout', [ApiAuthController::class, 'logout']);
//         Route::get('/user', [ApiAuthController::class, 'user']);
//     });

//     // Example protected routes with role-based access
//     Route::middleware('role:admin')->group(function () {
//         Route::get('/admin/users', function () {
//             return response()->json(['message' => 'Admin only endpoint']);
//         });
//     });

//     Route::middleware('role:user,admin')->group(function () {
//         Route::get('/user/profile', function () {
//             return response()->json(['message' => 'User or Admin endpoint']);
//         });

//         // AMC Request Routes (Commented out - using FrontendController instead)
//         // Route::prefix('crm')->group(function () {
//         //     Route::post('/create-amc-request', [AMCRequestController::class, 'store']);
//         //     Route::get('/amc-plans', [AMCRequestController::class, 'getAmcPlans']);
//         // });
//     });
// });

// /*
// |--------------------------------------------------------------------------
// | SDUI API Routes for Flutter App
// |--------------------------------------------------------------------------
// |
// | These routes provide Server-Driven UI configuration for the Flutter app.
// | They can be accessed with or without authentication based on settings.
// |
// */

// // SDUI Public Routes (can be protected via settings)
// Route::prefix('ui')->group(function () {
//     Route::get('/role-selection', [SDUIController::class, 'handleRoleSelectionSchema']);
//     // Route::get('/login', [SDUIController::class, 'handleLoginSchema']);
//     // Get SDUI configuration for a specific screen/role (returns complete JSON schema)
//     Route::get('/config', [SDUIController::class, 'getConfig']);

//     // Get all available screens for a role
//     Route::get('/screens', [SDUIController::class, 'getScreens']);

//     // Get component types and schemas (reference documentation)
//     Route::get('/component-types', [SDUIController::class, 'getComponentTypes']);
// });

// // SDUI Protected Routes (admin only)
// Route::prefix('ui')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     // Clear SDUI cache
//     Route::post('/clear-cache', [SDUIController::class, 'clearCache']);
// });

Route::prefix('v1')->group(function () {
    Route::post('/signup', [ApiAuthController::class, 'signup']);
    Route::post('/send-otp', [ApiAuthController::class, 'login']);
    Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);

    Route::middleware(['jwt.verify'])->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::post('/refresh-token', [ApiAuthController::class, 'refreshToken']);

        // Sales Person APIs
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index');
            Route::get('/sales-overview', 'salesOverview');

            // Customer APIs
            Route::get('/banners', 'banners');
        });

        Route::controller(TaskController::class)->group(function () {
            Route::get('/task', 'index');
        });

        // Sales and Customer Product and Order APIs
        Route::controller(OrderController::class)->group(function () {
            Route::get('/product', 'listProducts'); // Sales Person and Customer
            Route::get('/product/categories', 'listProductCategories'); // Sales Person and Customer
            Route::get('/product/{id}', 'product'); // Sales Person and Customer

            Route::post('/buy-product/{id}', 'buyProduct'); // Sales Person and Customer
            
            Route::get('/order', 'listOrders'); // Sales Person and Customer
            Route::get('/order/{id}', 'order'); // Sales Person and Customer

            // Engineer APIs
            Route::get('/all-product', 'allListProducts'); // Engineer
            Route::get('/all-product/{id}', 'allProduct'); // Engineer
            Route::post('/request-product', 'requestProduct'); // Engineer

        });

        // 
        Route::controller(LeadController::class)->group(function () {
            Route::get('/leads', 'index');
            Route::post('/lead', 'store');
            Route::get('/lead/{id}', 'show');
            Route::put('/lead/{id}', 'update');
            Route::delete('/lead/{id}', 'destroy');
        });

        Route::controller(FollowUpController::class)->group(function () {
            Route::get('/follow-up', 'index');
            Route::post('/follow-up', 'store');
            Route::get('/follow-up/{id}', 'show');
            Route::put('/follow-up/{id}', 'update');
            Route::delete('/follow-up/{id}', 'destroy');
        });

        Route::controller(MeetController::class)->group(function () {
            Route::get('/meets', 'index');
            Route::post('/meet', 'store');
            Route::get('/meet/{id}', 'show');
            Route::put('/meet/{id}', 'update');
            Route::delete('/meet/{id}', 'destroy');
        });

        Route::controller(QuotationController::class)->group(function () {
            Route::get('/quotation', 'index');
            Route::post('/quotation', 'store');
            Route::get('/quotation/{id}', 'show');
            Route::put('/quotation/{id}', 'update');
            Route::delete('/quotation/{id}', 'destroy');
        });

        Route::controller(ProfileController::class)->group(function () {
            // For Profile APIs 
            Route::get('/profile', 'index');
            Route::put('/profile', 'update');

            // For Address APIs
            Route::get('/addresses', 'getAddresses');
            Route::post('/address', 'addAddress');
            Route::put('/address/{id}', 'updateAddress');

            // For Aadhar Card APIs
            Route::get('/aadhar-card', 'getAadharCard');
            Route::post('/aadhar-card', 'addAadharCard');
            Route::put('/aadhar-card/{id}', 'updateAadharCard');

            // For Pan Card APIs
            Route::get('/customer-pan-card', 'getPanCard');
            Route::post('/customer-pan-card', 'addPanCard');
            Route::put('/customer-pan-card/{id}', 'updatePanCard');

            // For Company Details APIs
            Route::get('/company-details', 'getCompanyDetails');
            Route::post('/company-details', 'addCompanyDetails');
            Route::put('/company-details/{id}', 'updateCompanyDetails');

        });

        Route::controller(AttendanceController::class)->group(function () {
            Route::get('/attendance', 'index');
            Route::post('/attendance-login', 'store');
            Route::post('/attendance-logout', 'logout');
        });

        Route::controller(QuickServiceController::class)->group(function () {
            Route::get('/quick-service', 'index');
            Route::post('/quick-service/{id}', 'store');
        });

        // AMC Request APIs
        Route::controller(AmcServicesController::class)->group(function () {
            Route::get('/amc-plans', 'getAmcPlans');
            Route::get('/amc-plan-details/{id}', 'amcPlanDetails');
            Route::post('/create-amc-request', 'store');
        });

        Route::controller(NonAmcServicesController::class)->group(function () {
            // Installation Request APIs
            Route::post('/installation-request', 'installationStore');
            // Repair Request APIs
            Route::post('/repair-request', 'repairStore');
        });


        // Delivery Man APIs
        Route::controller(DeliveryOrderController::class)->group(function () {
            Route::get('/orders', 'allOrders');
            Route::get('/order/{order_id}', 'orderDetails');
            // Route::post('/orders', 'store');

            Route::get('/accept-order/{order_id}', 'acceptOrder');
            Route::post('/order/profile/{order_id}', 'updateOrderProfile');
            Route::post('/order/{order_id}/otp', 'updateOrderOtp');
            Route::post('/order/{order_id}/verify-otp', 'verifyOrderOtp');

            Route::get('/delivered-order/{order_id}', 'deliveredOrderDetails');

            Route::post('/delivery-orders', 'store');

            // vehical registration
            Route::get('/vehicle-registration', 'getVehicleDetails');
            Route::post('/vehicle-registration', 'vehicleRegistration');
            Route::put('/update-vehicle-details', 'updateVehicleRegistration');

            // update aadhar
            Route::get('/aadhar', 'getAadharDetails');
            Route::post('/store-aadhar', 'storeAadhar');
            Route::put('/update-aadhar', 'updateAadhar');

            // pan card
            Route::get('/pan-card', 'getPanCardDetails');
            Route::post('/store-pan-card', 'storePanCard');
            Route::put('/update-pan-card', 'updatePanCard');

            // driving license
            Route::get('/driving-license', 'getDrivingLicenseDetails');
            Route::post('/store-driving-license', 'storeDrivingLicense');
            Route::put('/update-driving-license', 'updateDrivingLicense');

        });

        // Engineer APIs
        // Route::controller(StockinHandController::class)->group(function () {
        //     Route::get('/stock-in-hand', 'index');
        //     Route::get('/stock-in-hand/{id}', 'show');
        //     Route::post('/stock-in-hand', 'store');
        // });


        // ================================== Customer APIs ========================================
        // All Requests APIs AMC and Non-AMC
        Route::controller(AllServicesController::class)->group(function () {
            // Quick Services List 
            Route::get('/services', 'servicesList');
            Route::get('/quick-services', 'quickServicesList');
            Route::get('/services-list', 'servicesListByType');
            Route::get('/service-details/{id}', 'getServiceDetails');
            // submit service request 
            Route::post('/submit-quick-service-request', 'submitQuickServiceRequest');

            // service request quotation details
            Route::get('/service-request-quotations', 'serviceRequestQuotations');
            Route::get('/service-request-quotation-details/{id}', 'serviceRequestQuotationDetails');


            // Give Feedback APIs
            Route::post('/give-feedback', 'giveFeedback');
            Route::get('/get-all-feedback', 'getAllFeedback');
            Route::get('/get-feedback/{feedback_id}', 'getFeedback');
        });

    });
});

