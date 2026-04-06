<?php

use App\Http\Controllers\Api\AllServicesController;
use App\Http\Controllers\Api\AmcServicesController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\StaticContentController;
use App\Http\Controllers\Api\CashReceivedController;
use App\Http\Controllers\Api\CheckoutController as ApiCheckoutController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryOrderController;
use App\Http\Controllers\Api\DeviceTokenController;
use App\Http\Controllers\Api\FcmTestController;
use App\Http\Controllers\Api\FollowUpController;
use App\Http\Controllers\Api\KycController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\MacAddress;
use App\Http\Controllers\Api\MeetController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentRefundController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\QuickServiceController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\RazorpayWebhookController;
use App\Http\Controllers\Api\ReplacementRequestController;
use App\Http\Controllers\Api\RewardClaimController;
use App\Http\Controllers\Api\StaffWalletController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\FcmTestFinalController;
use App\Http\Controllers\FieldEngineerController;
use App\Http\Controllers\PartRequestController;
use App\Http\Controllers\PickupRequestController;
use App\Http\Controllers\ReturnRequestController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    // Authentication APIs for customer and staff login/signup flows
    Route::post('/signup', [ApiAuthController::class, 'signup']);
    Route::post('/send-otp', [ApiAuthController::class, 'login']);
    Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);

    Route::post('/send-verification-code', [ApiAuthController::class, 'sendVerificationCode']);
    Route::post('/verify-verification-code', [ApiAuthController::class, 'verifyVerificationCode']);
    Route::post('/resend-verification-code', [ApiAuthController::class, 'resendVerificationCode']);

    Route::post('/google-login', [ApiAuthController::class, 'googleLogin']);
    Route::post('email-pass-login', [ApiAuthController::class, 'emailPasswordLogin']);
    // forgot password apis
    Route::post('/forgot-password/send-code', [ApiAuthController::class, 'sendForgotPasswordCode']);
    Route::post('/forgot-password/verify-code', [ApiAuthController::class, 'verifyForgotPasswordCode']);
    Route::post('/forgot-password/resend-code', [ApiAuthController::class, 'resendForgotPasswordCode']);
    Route::post('/forgot-password/reset', [ApiAuthController::class, 'resetForgotPassword']);

    // Razorpay webhook API: receives payment status events from Razorpay server-to-server
    Route::post('/webhooks/razorpay', RazorpayWebhookController::class);

    // Public route for staff wallet status update (used by admin panel)
    Route::put('/staff-expenses/{id}/status', [StaffWalletController::class, 'updateStatus']);

    // KYC Routes (public - for Engineer, Sales Person, Delivery Man)
    Route::controller(KycController::class)->group(function () {
        Route::get('/kyc/status', 'getStatus'); // Get KYC status and reason
        Route::post('/kyc/submit', 'submitKyc'); // Submit KYC details
    });

    // Static Content Routes (no auth required)
    Route::get('/static/{key}', [StaticContentController::class, 'getStaticContent']);
    // Route::get('/all-static', [StaticContentController::class, 'getAllStaticContent']);
    // Route::get('/static-keys', [StaticContentController::class, 'getAvailableKeys']);

    // Receipt download route (public - outside JWT middleware)
    Route::get('/receipts/{filename}', function ($filename) {
        $path = storage_path('app/public/receipts/' . $filename);

        if (! file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return response()->file($path);
    });

    // Only for testing notification
    Route::post('/test-fcm', [FcmTestController::class, 'send'])->middleware('throttle:60,1');
    Route::post('/test-fcm-final', [FcmTestFinalController::class, 'sendFinal'])->middleware('throttle:60,1');

    Route::middleware(['throttle:60,1', 'jwt.verify'])->group(function () {
        // E-commerce payment APIs: create Razorpay order, verify checkout payment, and request order refund
        Route::post('/checkout/orders/{order}/razorpay', [ApiCheckoutController::class, 'createRazorpayOrder']); // Create a Razorpay order for an e-commerce order checkout
        Route::post('/checkout/razorpay/verify', [ApiCheckoutController::class, 'verifyRazorpayPayment']); // Verify Razorpay payment signature after successful checkout
        Route::post('/payments/{payment}/refund', PaymentRefundController::class); // Initiate refund for an e-commerce payment record

        // Service request APIs: customer service booking, tracking, quotation review, and invoice/payment actions
        Route::controller(AllServicesController::class)->group(function () {
            Route::get('/services', 'servicesList'); // List available service categories for customers
            Route::get('/quick-services', 'quickServicesList'); // List quick service offerings
            Route::get('/services-list', 'servicesListByType'); // List services filtered by selected type
            Route::get('/service-details/{id}', 'getServiceDetails'); // Get full details of a specific service
            Route::post('/submit-quick-service-request', 'submitQuickServiceRequest'); // Create a new quick service request
            Route::get('/all-service-requests', 'allServiceRequests'); // Get all service requests for the authenticated customer
            Route::get('/service-request-details/{id}', 'serviceRequestDetails'); // Get summary details of a specific service request
            Route::get('/service-request-product-diagnostics/{id}/{product_id}', 'serviceRequestProductDiagnostics'); // Get diagnosis details for a service request product
            Route::get('/devices-types', 'getDevicesTypes'); // List supported device types for service requests
            Route::post('/customer-approve-reject-part', 'customerApproveRejectPart'); // Approve or reject requested parts for a service request
            Route::get('/part-apply-coupon', 'partApplyCoupon'); // Apply coupon on service request part charges
            Route::post('/customer-approve-reject-pickup', 'customerApproveRejectPickup'); // Approve or reject pickup action for a service request

            Route::get('/service-request-quotations', 'serviceRequestQuotations'); // List quotations generated for customer service requests
            Route::get('/service-request-quotation-details/{id}', 'serviceRequestQuotationDetails'); // Get one service request quotation in detail
            Route::post('/service-request-quotation-payment', 'makeServiceRequestQuotationPayment'); // Record payment for a service request quotation
            Route::post('/service-request-quotations/{id}/accept', 'acceptQuotation'); // Accept a service request quotation
            Route::post('/service-request-quotations/{id}/reject', 'rejectQuotation'); // Reject a service request quotation
            Route::get('/service-request-invoices', 'serviceRequestInvoicesList'); // List invoices raised for service requests
            Route::get('/service-request-invoice/{id}', 'serviceRequestInvoice'); // Get a specific service request invoice
            Route::post('/service-request-invoice/{id}/accept', 'acceptInvoice'); // Accept a generated service request invoice
            Route::post('/service-request-invoice/{id}/reject', 'rejectInvoice'); // Reject a generated service request invoice
            Route::post('/invoice-payment/{id}', 'payInvoice'); // Record payment against a service request invoice
            Route::post('/give-feedback', 'giveFeedback'); // Submit customer feedback after service completion
            Route::get('/get-all-feedback', 'getAllFeedback'); // List customer feedback entries
            Route::get('/get-feedback/{feedback_id}', 'getFeedback'); // Get one feedback entry by id


            // AMC APIs
            Route::get('/customer-amcs', 'customerAmcs'); // List AMC
            Route::get('/customer-amc/{id}', 'customerAmcDetails'); // Get AMC details
        });

        // Field engineer service request APIs: assigned jobs, diagnosis, part requests, and field updates
        Route::controller(FieldEngineerController::class)->group(function () {
            Route::get('/service-requests', 'serviceRequests'); // List service requests assigned to the engineer
            Route::get('/service-request/{id}', 'serviceRequestDetails'); // Get service request details for engineer workflow
            Route::get('/service-request/{id}/{product_id}', 'serviceRequestProductDetails'); // Get service request product details
            Route::post('/service-request/{id}/accept', 'acceptServiceRequest'); // Accept an assigned service request
            Route::post('/service-request/{id}/send-otp', 'startDiagnosis'); // Send OTP to begin diagnosis at customer location
            Route::post('/service-request/{id}/verify-otp', 'verifyDiagnosis'); // Verify OTP before starting diagnosis
            Route::post('/service-request/{id}/case-transfer', 'caseTransfer'); // Transfer a service request to another engineer or team
            Route::post('/service-request/{id}/reschedule', 'rescheduleServiceRequest'); // Reschedule a service visit
            Route::get('/service-request/{id}/{product_id}/diagnosis-list', 'diagnosisList'); // List diagnosis entries for a service request product
            Route::post('/service-request/{id}/{product_id}/submit-diagnosis', 'submitDiagnosis'); // Submit diagnosis result for a service request product
            Route::post('/service-request/{id}/{product_id}/request-part', 'requestPart'); // Raise a part requirement against a service request product

            // Stock In Hand Products APIs
            Route::get('/stock-in-hand', 'stockInHand');

            // Field Issues
            Route::post('/field-issue', 'fieldIssueStore');
            Route::get('/field-issues', 'fieldIssuesList');
            Route::get('/field-issue/{id}', 'fieldIssueView');

            // Attendance APIs
            Route::get('/attendance', 'index');
            Route::post('/check-in', 'store');
            Route::post('/check-out', 'logout');
        });

        // MAC Address APIs
        Route::get('/mac-address', [MacAddress::class, 'getMacAddress']);

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'getNotifications']);

        Route::post('/device-token', [DeviceTokenController::class, 'store']);
        Route::delete('/device-token', [DeviceTokenController::class, 'destroy']);

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

            // Order Invoices 
            Route::get('/order-invoices', 'listOrderInvoices'); // Sales Person and Customer
            Route::get('/order/{id}/invoice', 'orderInvoice'); // Sales Person and Customer

            // Cancel and Return Order APIs
            Route::post('/cancel-order/{order_id}', 'cancelOrder');
            Route::post('/return-order/{order_id}', 'returnOrder');

            // Reward Claim APIs
            Route::post('/orders/{id}/claim-reward', [RewardClaimController::class, 'claimReward']);
            Route::get('/orders/{id}/reward-availability', [RewardClaimController::class, 'checkRewardAvailability']);
            Route::get('/rewards', [RewardClaimController::class, 'listRewards']);

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
            Route::get('/attendance-dm', 'index');
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
            // Route::post('/create-amc-request', 'store');
        });

        // Delivery Man APIs
        Route::controller(DeliveryOrderController::class)->group(function () {
            Route::get('/orders', 'allOrders');
            Route::get('/orders/{order_id}', 'orderDetails');
            // Route::post('/orders', 'store');

            Route::get('/accept-order/{order_id}', 'acceptOrder');
            Route::post('/order/profile/{order_id}', 'updateOrderProfile');
            Route::post('/order/{order_id}/otp', 'updateOrderOtp');
            Route::post('/order/{order_id}/verify-otp', 'verifyOrderOtp');

            Route::get('/delivered-order/{order_id}', 'deliveredOrderDetails');

            Route::post('/delivery-orders', 'store');

            // Return Order Flow
            Route::get('/return-orders', 'allReturnOrders');
            Route::get('/return-orders/{id}', 'returnOrderDetails');
            Route::post('/accept-return-order/{id}', 'acceptReturnOrder');
            Route::post('/return-order/{id}/otp', 'returnOrderOtp');
            Route::post('/return-order/{id}/verify-otp', 'verifyReturnOrderOtp');
            Route::post('/return-order-received/{id}', 'receiveReturnOrder');
            Route::get('/return-order-picked/{id}', 'pickedReturnOrderDetails');
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

        Route::controller(ReplacementRequestController::class)->group(function () {
            Route::get('/replacement-requests', 'index');
            Route::get('/replacement-requests/{id}', 'show');
        });

        // 1. Products List of all the product avialble in warehouse how status is active ( Basic Details )
        // 2. Products Detail Page ( In Details )
        // 3. Request New Product For Stock In Hand ( Product Id, quantity, user_is, role_id )
        // 4. List Of stock in hand product ( Product Id, quantity, status )

        // Product APIs
        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'listProducts');
            Route::get('/products/{product_id}', 'productDetail');
            Route::get('/stock-in-hand/list', 'listStockInHand'); // List stock in hand
            Route::post('/stock-in-hand/request', 'requestStockInHand'); // Request new product
        });

        // Pickup Request APIs for Delivery Man and Engineer
        Route::controller(PickupRequestController::class)->group(function () {
            // (1) Get pickup requests - check if user is delivery man or engineer and return service requests
            Route::get('/pickup-requests', 'getPickupRequests');

            // (2) Get particular pickup request details with product details
            Route::get('/pickup-request/{id}', 'getPickupRequestDetails');

            // (3) Accept pickup request - change status to approved for all products in same service
            Route::post('/pickup-request/{id}/accept', 'acceptPickupRequest');

            // (4) Send OTP for pickup - generate OTP with 5 min expiry
            Route::post('/pickup-request/{id}/send-otp', 'sendPickupOtp');

            // (5) Verify OTP and change status to picked
            Route::post('/pickup-request/{id}/verify-otp', 'verifyPickupOtp');
        });

        // Return Request APIs for Delivery Man and Engineer
        Route::controller(ReturnRequestController::class)->group(function () {
            // (1) Get return requests - check if user is delivery man or engineer and return their assigned return requests
            Route::get('/return-requests', 'getReturnRequests');

            // (2) Get particular return request details with product details
            Route::get('/return-request/{id}', 'getReturnRequestDetails');

            // (3) Accept return request - change status to accepted
            Route::post('/return-request/{id}/accept', 'acceptReturnRequest');

            // (4) Send OTP for return - generate OTP with 5 min expiry (only if status is picked)
            Route::post('/return-request/{id}/send-otp', 'sendReturnOtp');

            // (5) Verify OTP and change status to delivered
            Route::post('/return-request/{id}/verify-otp', 'verifyReturnOtp');
        });

        // Part Request APIs for Delivery Man and Engineer
        Route::controller(PartRequestController::class)->group(function () {
            // (1) Get part requests - check if user is delivery man or engineer and return their assigned part requests
            Route::get('/part-requests', 'getPartRequests');

            // (2) Get particular part request details with product details
            Route::get('/part-request/{id}', 'getPartRequestDetails');

            // (3) Accept part request - change status to ap_approved
            Route::post('/part-request/{id}/accept', 'acceptPartRequest');

            // (4) Send OTP for part delivery - generate OTP with 5 min expiry (only if status is picked)
            Route::post('/part-request/{id}/send-otp', 'sendPartRequestOtp');

            // (5) Verify OTP and change status to delivered
            Route::post('/part-request/{id}/verify-otp', 'verifyPartRequestOtp');
        });

        // Staff Wallet / Expense APIs for Engineer and Delivery Man
        Route::controller(StaffWalletController::class)->group(function () {
            // Get expense details
            Route::get('/staff-reimbursements', 'index');
            // Submit expense form
            Route::post('/staff-reimbursements', 'store');
            // Get single expense details
            Route::get('/staff-reimbursements/{id}', 'show');
            // Get expense history
            Route::get('/staff-reimbursements-history', 'history');
        });

        // Cash Received APIs for staff (Delivery Man / Engineer)
        Route::controller(CashReceivedController::class)->group(function () {
            // Store cash received from customer
            Route::post('/cash-received', 'store');
            // Get all cash received entries (with filters)
            Route::get('/cash-received', 'index');
            // Get single cash received entry
            Route::get('/cash-received/{id}', 'show');
        });
    });
});
