<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AmcController;
use App\Http\Controllers\AmcServicesController;
use App\Http\Controllers\AssignedJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CallLogController;
use App\Http\Controllers\CaseTransferController;
use App\Http\Controllers\ClientReceiptController;
use App\Http\Controllers\CreditorsReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Delivery;
use App\Http\Controllers\EngineerController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\FieldIssuesController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\InHandProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\KycLogController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LowStockController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayToVendorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PickupRequestController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\QuickServiceController;
use App\Http\Controllers\QuickServiceRequestController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\SalesInvoicingController;
use App\Http\Controllers\SalesPersonController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\TrackProductController;
use App\Http\Controllers\TrackRequestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SduiPageController;
use App\Http\Controllers\Admin\SduiSettingController;


Route::get('/', function () {
    return view('comming-soon');
})->name('comming-soon');

Route::prefix('/demo')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        // Login Page
        Route::get('/admin/login', 'login')->name('login');
        Route::post('/admin/login', 'loginStore')->name('loginStore');
        // Sign Up Page
        Route::get('/admin/signup', 'signup')->name('signup');
        Route::post('/admin/signup', 'register')->name('register');
        // Forgot Password
        Route::get('/admin/recover-password', 'recover_password')->name('recover-password');
        // Profile Page
        Route::get('/crm/profile', 'profile')->name('profile');
        // Logout Page
        Route::post('/admin/logout', 'logout')->name('logout');
    });

    // Route::get('/', function () {
    //     return view('login');
    // })->name('login');

    // Sign Up
    // Route::get('/signup', function () {
    //     return view('signup');
    // })->name('signup');

    // Recover Password
    // Route::get('/recover-password', function () {
    //     return view('recover-password');
    // })->name('recover-password');

    // 404
    Route::get('/404', function () {
        return view('404');
    })->name('404');

    // 500
    Route::get('/500', function () {
        return view('500');
    })->name('500');

    // 503
    Route::get('/503', function () {
        return view('503');
    })->name('503');

    // 503
    // Route::get('/crm/profile', function () {
    //     return view('/crm/profile');
    // })->name('profile');

    // Index
    // Create
    // Store
    // Delete
    // Edit
    // Update
    // View

    // *******************************************************************************************************************************************************
    // *******************************************************************************************************************************************************
    // ********************************************************************      CRM       *******************************************************************
    // *******************************************************************************************************************************************************
    // *******************************************************************************************************************************************************

    // Index Page
    Route::get('/crm/index', function () {
        return view('/crm/index');
    })->name('crm/index');

    // ------------------------------------------------------------ Access Control ( Staff Page) -------------------------------------------------------------

    Route::prefix('/crm')->group(function () {

        Route::controller(StaffController::class)->group(function () {
            Route::get('/staff', 'index')->name('staff.index');
            Route::get('/create-staff/{role?}', 'create')->name('staff.create');
            Route::post('/store-staff', 'store')->name('staff.store');
            Route::delete('/delete-staff/{id}', 'delete')->name('staff.delete');



            Route::get('/edit-staff/{id}', 'edit')->name('staff.edit');
            Route::get('/view-staff/{id}', 'view')->name('staff.view');
            Route::put('/update-staff/{id}', 'update')->name('staff.update');

            Route::put('/assign-role-to-staff/{id}', 'assignRole')->name('assign.role');
            Route::post('/approve-task', 'approveTask')->name('staff.approve.task');
        });

        // ------------------------------------------------------------ Access Control ( Roles Page) -------------------------------------------------------------
        // completed
        Route::controller(RoleController::class)->group(function () {
            Route::get('/roles', 'index')->name('roles.index');
            Route::get('/create-role', 'create')->name('roles.create');
            Route::post('/store-role', 'store')->name('role.store');
            Route::get('/edit-role/{id}', 'edit')->name('roles.edit');
            Route::put('/update-role/{id}', 'update')->name('role.update');
            Route::delete('/delete-role/{id}', 'delete')->name('role.delete');
        });

        // ------------------------------------------------------------ Access Control ( Permission Page) -------------------------------------------------------------
        // completed
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permission', 'index')->name('permission.index');
            Route::get('/create-permission', 'create')->name('permission.create');
            Route::post('/store-permission', 'store')->name('permission.store');
            Route::get('/edit-permission/{id}', 'edit')->name('permission.edit');
            Route::put('/update-permission/{id}', 'update')->name('permission.update');
            Route::delete('/delete-permission/{id}', 'delete')->name('permission.delete');
        });
    });



    // ------------------------------------------------------------ Accounts Page -------------------------------------------------------------

    // Transactions Page
    Route::get('/crm/transactions', [TransactionController::class, 'index'])->name('transactions');

    // Payment Page
    Route::get('/crm/payments', [PaymentController::class, 'index'])->name('payments');

    // Reimbursement Page
    Route::get('/crm/reimbursement', [ReimbursementController::class, 'index'])->name('reimbursement');

    // Withdraw Page
    Route::get('/crm/withdraw', [WithdrawController::class, 'index'])->name('withdraw');

    // KYC Log Page
    Route::get('/crm/kyc-log', [KycLogController::class, 'index'])->name('kyc-log');

    // ######################## Sales Invoicing  ########################

    Route::controller(SalesInvoicingController::class)->group(function () {
        //  Sales Invoicing List Page
        Route::get('/crm/sales-invoicing', 'index')->name('sales.index');
        // Create Sales Invoicing List Page
        Route::get('/crm/create-sales-invoicing', 'create')->name('sales.create');
        // View Sales Invoicing List Page
        Route::get('/crm/view-sales-invoicing', 'view')->name('sales.view');
    });

    // ######################## Client Receipts  ########################

    Route::controller(ClientReceiptController::class)->group(function () {
        // Client Receipts List Page
        Route::get('/crm/client-receipts', 'index')->name('client.index');
        // Create Client Recipot Page
        Route::get('/crm/create-client-receipts', 'create')->name('client.create');
        // View Client Receipt Page
        Route::get('/crm/view-client-receipts', 'view')->name('client.view');
        // Edit Client Receipt Page
        Route::get('/crm/edit-client-receipts', 'edit')->name('client.edit');
    });

    // ######################## Payments to Vendors  ########################

    Route::controller(PayToVendorController::class)->group(function () {
        // Payments to Vendors List Page
        Route::get('/crm/payments-to-vendor', 'index')->name('pay-to-vendors.index');
        // Create Payments to Vendors List Page
        Route::get('/crm/create-payments-to-vendor', 'create')->name('pay-to-vendors.create');
    });

    // ######################## Creditors Report  ########################

    Route::controller(CreditorsReportController::class)->group(function () {
        // Creditors Report List Page
        Route::get('/crm/creditors-report', 'index')->name('creditors-report.index');
    });

    // ######################## Expenses  ########################

    Route::controller(ExpensesController::class)->group(function () {
        // Expenses List Page
        Route::get('/crm/expenses', 'index')->name('expenses.index');
        // Expenses Create Page
        Route::get('/crm/create-expenses', 'create')->name('expenses.create');
    });

    // ######################## Stock Request  ########################

    Route::controller(StockReportController::class)->group(function () {
        // Stock Request Page
        Route::get('/crm/stock-report', 'index')->name('stock-report.index');
        // Stock Request Create Page
        Route::get('/crm/create-stock-report', 'create')->name('stock-report.create');
        // Stock Request Edit Page
        Route::get('/crm/edit-stock-report', 'edit')->name('stock-report.edit');
    });

    // ######################## Low Stock Alert  ########################

    Route::controller(LowStockController::class)->group(function () {
        // Low Stock Alert Page
        Route::get('/crm/low-stock-alert', 'index')->name('low-stock-alert');
    });

    // ------------------------------------------------------------ Customer Page -------------------------------------------------------------

    Route::controller(CustomerController::class)->group(function () {
        // Customers Page
        Route::get('/crm/customers', 'index')->name('customer.index');
        // Create Customer Page
        Route::get('/crm/create-customer', 'create')->name('customer.create');
        // Store Customer Detail
        Route::post('/crm/store-customer', 'store')->name('customer.store');
        // View Customer Page
        Route::get('/crm/view-customer/{id}', 'view')->name('customer.view');
        // Edit Customer Page
        Route::get('/crm/edit-customer/{id}', 'edit')->name('customer.edit');
        // Update Customer Page
        Route::put('/crm/update-customer/{id}', 'update')->name('customer.update');
        // Delete Customer Page
        Route::delete('/crm/delete-customer/{id}', 'delete')->name('customer.delete');
        // Search Customer by First Name
        Route::get('/crm/search-customer-by-first-name', 'searchByFirstName')->name('customers.search.by-first-name');
    });

    // ------------------------------------------------------------ Engineers Page -------------------------------------------------------------

    Route::controller(EngineerController::class)->group(function () {
        // Engineers Page
        Route::get('/crm/engineers', 'index')->name('engineers.index');
        // Create Engineer Page
        Route::get('/crm/create-staff', 'create')->name('engineer.create');
        // Store Engineer Page
        Route::post('/crm/store-engineers', 'store')->name('engineer.store');
        // View Engineer Page
        Route::get('/crm/view-engineer/{id}', 'view')->name('engineer.view');
        // Edit Engineer Page
        Route::get('/crm/edit-engineer/{id}', 'edit')->name('engineer.edit');
        // Update Engineer Page
        Route::put('/crm/update-engineer/{id}', 'update')->name('engineer.update');
        // Delete Engineer Page
        Route::delete('/crm/delete-engineer/{id}', 'delete')->name('engineer.delete');
        // Visit Detail Page
        Route::get('/crm/engineer-visit-detail/{id}', 'visitDetail')->name('engineers.visit-detail');
    });

    // Task Engineer Page
    Route::get('/crm/engineer-tasks', function () {
        return view('/crm/engineers/task');
    })->name('engineers.task');

    // ------------------------------------------------------------ Delivery Man Page -------------------------------------------------------------

    Route::controller(Delivery::class)->group(function () {
        // Delivery Man Page
        Route::get('/crm/delivery-man', 'index')->name('delivery-man.index');
        // Create Delivery Man Page
        Route::get('/crm/create-delivery-man', 'create')->name('delivery-man.create');
        // Store Delivery Man Page
        Route::post('/crm/store-delivery-man', 'store')->name('delivery-man.store');
        // View Delivery Man Page
        Route::get('/crm/view-delivery-man/{id}', 'view')->name('delivery-man.view');
        // Edit Delivery Man Page
        Route::get('/crm/edit-delivery-man/{id}', 'edit')->name('delivery-man.edit');
        // Update Delivery Man Page
        Route::put('/crm/update-delivery-man/{id}', 'update')->name('delivery-man.update');
        // Delete Delivery Man Page
        Route::delete('/crm/delete-delivery-man/{id}', 'delete')->name('delivery-man.delete');
    });

    Route::controller(SalesPersonController::class)->group(function () {
        // Sales Person Page
        Route::get('/crm/sales-person', 'index')->name('sales-person.index');
        // Create Sales Person Page
        Route::get('/crm/create-sales-person', 'create')->name('sales-person.create');
        // Store Sales Person Page
        Route::post('/crm/store-sales-person', 'store')->name('sales-person.store');
        // View Sales Person Page
        Route::get('/crm/view-sales-person/{id}', 'view')->name('sales-person.view');
        // Edit Sales Person Page
        Route::get('/crm/edit-sales-person/{id}', 'edit')->name('sales-person.edit');
        // Update Sales Person Page
        Route::put('/crm/update-sales-person/{id}', 'update')->name('sales-person.update');
        // Delete Sales Person Page
        Route::delete('/crm/delete-sales-person/{id}', 'delete')->name('sales-person.delete');
        // Sales Person Task Page
        Route::get('/crm/sales-person-task', 'task')->name('sales-person.task');
        // Sales Person Task Page
        Route::get('/crm/sales-person-visit', 'visit')->name('sales-person.visit');
        // Sales Person Visit Detail Page
        Route::get('/crm/sales-person-visit-detail/{id}', 'visitDetail')->name('sales-person.visit-detail');
    });

    // Order Delivery Page
    Route::get('/crm/delivery-order', function () {
        return view('/crm/delivery-man/order');
    })->name('delivery.order');

    // Order Delivery Page
    Route::get('/crm/delivery-order-detail', function () {
        return view('/crm/delivery-man/detail');
    })->name('delivery.detail');

    // Task Delivery Page
    Route::get('/crm/delivery-order-tasks', function () {
        return view('/crm/delivery-man/task');
    })->name('delivery.task');

    // ------------------------------------------------------------ Sales Reports Page -------------------------------------------------------------

    // Sales Reports Page
    Route::controller(SaleReportController::class)->group(function () {
        Route::get('/crm/sales-report', 'index')->name('sales-reports.index');
    });

    // ------------------------------------------------------------ Leads Page -------------------------------------------------------------

    Route::controller(LeadController::class)->group(function () {
        // Leads Page
        Route::get('/crm/leads', 'index')->name('leads.index');
        // Create Leads Page
        Route::get('/crm/create-leads', 'create')->name('leads.create');
        // Store Leads Page
        Route::post('/crm/store-leads', 'store')->name('leads.store');
        // View Leads Page
        Route::get('/crm/view-leads/{id}', 'view')->name('leads.view');
        // Edit Leads Page
        Route::get('/crm/edit-leads/{id}', 'edit')->name('leads.edit');
        // Update Leads Page
        Route::put('/crm/update-leads/{id}', 'update')->name('leads.update');
        // Delete Leads Page
        Route::delete('/crm/delete-leads/{id}', 'delete')->name('leads.delete');

        Route::get('/search-customers', 'searchCustomers')->name('leads.search-customers');


        // Branch Management Routes
        Route::post('/crm/leads/branches/store', 'storeBranch')->name('leads.branches.store');
        Route::put('/crm/leads/branches/{id}', 'updateBranch')->name('leads.branches.update');
        Route::delete('/crm/leads/branches/{id}', 'deleteBranch')->name('leads.branches.delete');
        Route::get('/crm/leads/{leadId}/branches', 'getBranches')->name('leads.branches.get');
    });

    // ------------------------------------------------------------ Follow Up Page -------------------------------------------------------------

    Route::controller(FollowUpController::class)->group(function () {
        // Follow Up Page
        Route::get('/crm/follow-up', 'index')->name('follow-up.index');
        // Create Follow Up Page
        Route::get('/crm/create-follow-up', 'create')->name('follow-up.create');
        // Store Follow Up Page
        Route::post('/crm/store-follow-up', 'store')->name('follow-up.store');
        // View Follow Up Page
        Route::get('/crm/view-follow-up/{id}', 'view')->name('follow-up.view-page');
        // Edit Follow Up Page
        Route::get('/crm/edit-follow-up/{id}', 'edit')->name('follow-up.edit');
        // Update Follow Up Page
        Route::put('/crm/update-follow-up/{id}', 'update')->name('follow-up.update');
        // Delete Follow Up Page
        Route::delete('/crm/delete-follow-up/{id}', 'delete')->name('follow-up.delete');
        // Fetch leads Data
        Route::get('/crm/fetch-leads/{id}', [FollowUpController::class, 'fetchLeads'])->name('follow-up.fetch-leads');
    });

    // ------------------------------------------------------------ Meets Pages -------------------------------------------------------------

    Route::controller(MeetController::class)->group(function () {
        // Meet Page
        Route::get('/crm/meets', 'index')->name('meets.index');
        // Create Meet Page
        Route::get('/crm/create-meets', 'create')->name('meets.create');
        // Store Meet Page
        Route::post('/crm/store-meets', 'store')->name('meets.store');
        // View Meet Page
        Route::get('/crm/view-meets/{id}', 'view')->name('meets.view');
        // Edit Meet Page
        Route::get('/crm/edit-meets/{id}', 'edit')->name('meets.edit');
        // Update Meet Page
        Route::put('/crm/update-meets/{id}', 'update')->name('meets.update');
        // Delete Meet Page
        Route::delete('/crm/delete-meets/{id}', 'delete')->name('meets.delete');
        // Fetch leads Data
        Route::get('/crm/fetch-client/{id}', 'fetchClient')->name('fetch-client.view');
    });

    // ------------------------------------------------------------ Quotation Page -------------------------------------------------------------

    Route::controller(QuotationController::class)->group(function () {
        Route::get('/crm/quotation', 'index')->name('quotation.index');
        // Create Quotation Page
        Route::get('/crm/create-quotation', 'create')->name('quotation.create');
        // Store Quotation Page
        Route::post('/crm/store-quotation', 'store')->name('quotation.store');
        // View Quotation Page
        Route::get('/crm/view-quotation/{id}', 'view')->name('quotation.view');
        // Edit Quotation Page
        Route::get('/crm/edit-quotation/{id}', 'edit')->name('quotation.edit');
        // Update Quotation Page
        Route::put('/crm/update-quotation/{id}', 'update')->name('quotation.update');
        // Delete Quotation Page
        Route::delete('/crm/delete-quotation/{id}', 'delete')->name('quotation.delete');

        // Update Status
        Route::put('/crm/quotation/{id}/update-status', 'updateStatus')->name('quotation.updateStatus');

        // Product Management Routes
        Route::post('/crm/quotation/products/store', 'storeProduct')->name('quotation.products.store');
        Route::put('/crm/quotation/products/{id}', 'updateProduct')->name('quotation.products.update');
        Route::delete('/crm/quotation/products/{id}', 'deleteProduct')->name('quotation.products.delete');
        Route::get('/crm/quotation/{quotationId}/products', 'getProducts')->name('quotation.products.get');
        Route::post('/crm/quotation/update-amc-plan', 'storeOrUpdateAmcDetail')->name('quotation.update.amc.plan');

        Route::post('/crm/quotation/amc/store', 'storeOrUpdateAmcDetail')->name('quotation.amc.store');
        // AMC Details Management Routes
        Route::get('/crm/quotation/{quotationId}/amc', 'getAmcDetail')->name('quotation.amc.get');

        // Engineer Assignment Routes
        Route::post('/crm/quotation/assign-engineer', 'assignEngineer')->name('quotation.assign-engineer');
        // Generate Invoice from Quotation
        Route::get('/crm/quotation/{id}/generate-invoice', 'generateInvoice')->name('quotation.generateInvoice');
        Route::post('/crm/quotation/{id}/store-invoice', 'storeInvoice')->name('quotation.storeInvoice');
        Route::get('/crm/quotation/{id}/edit-invoice', 'generateInvoice')->name('quotation.editInvoice');
        Route::get('/crm/quotation/{id}/view-invoice', 'viewInvoice')->name('quotation.viewInvoice');
    });

    Route::prefix('/crm')->group(function () {
        // ------------------------------------------------------------ AMC Plans Page -------------------------------------------------------------
        Route::controller(AmcController::class)->group(function () {
            Route::get('/amc-plans', 'index')->name('amc-plans.index');
            Route::get('/create-amc-plans', 'create')->name('amc-plan.create');
            Route::post('/store-amc-plans', 'store')->name('amc-plan.store');
            Route::get('/edit-amc-plans/{id}', 'edit')->name('amc-plan.edit');
            Route::put('/update-amc-plans/{id}', 'update')->name('amc-plan.update');
            Route::delete('/delete-amc-plans{id}', 'delete')->name('amc-plan.delete');

            // Covered Items Page
            Route::get('/covered-items', 'coveredItems')->name('covered-items.index');
            Route::get('/create-covered-items', 'createCoveredItems')->name('covered-items.create');
            Route::post('/store-covered-items', 'storeCoveredItems')->name('covered-items.store');
            Route::get('/edit-covered-items/{id}', 'editCoveredItems')->name('covered-items.edit');
            Route::put('/update-covered-items/{id}', 'updateCoveredItems')->name('covered-items.update');
            Route::delete('/delete-covered-items/{id}', 'deleteCoveredItems')->name('covered-items.delete');

            // Covered Items Page
            Route::get('/device-specific-diagnosis', 'deviceSpecificDiagnosis')->name('device-specific-diagnosis.index');
            Route::get('/create-device-specific-diagnosis', 'createDeviceSpecificDiagnosis')->name('device-specific-diagnosis.create');
            Route::post('/store-device-specific-diagnosis', 'storeDeviceSpecificDiagnosis')->name('device-specific-diagnosis.store');
            Route::get('/edit-device-specific-diagnosis/{id}', 'editDeviceSpecificDiagnosis')->name('device-specific-diagnosis.edit');
            Route::put('/update-device-specific-diagnosis/{id}', 'updateDeviceSpecificDiagnosis')->name('device-specific-diagnosis.update');
            Route::delete('/delete-device-specific-diagnosis/{id}', 'deleteDeviceSpecificDiagnosis')->name('device-specific-diagnosis.delete');

            // AJAX endpoint to fetch diagnosis list
            Route::get('/get-diagnosis-list/{id?}', 'getDiagnosisList')->name('get-diagnosis-list');

            // Active AMC Page
            Route::get('/amcs-list', 'listAmcRequests')->name('amcs-lists.index');
            Route::delete('/amcs-request/{id}', 'deleteAmcsRequest')->name('amcs-request.delete');
            Route::get('/amcs-request/{id}', 'viewAmcsRequest')->name('amcs-request.view');
        });
    });

    // ------------------------------------------------------------ AMC Services Page (Active AMC Services) -------------------------------------------------------------

    Route::controller(AmcServicesController::class)->group(function () {
        // AMC Services Index Page (Active AMC Services only)
        Route::get('/crm/amc-services', 'index')->name('amc-services.index');
        // View AMC Service Page
        Route::get('/crm/view-amc-service/{id}', 'view')->name('amc-services.view');
        // Edit AMC Service Page
        Route::get('/crm/edit-amc-service/{id}', 'edit')->name('amc-services.edit');
        // Update AMC Service
        Route::put('/crm/update-amc-service/{id}', 'update')->name('amc-services.update');
        // Assign Engineer to AMC Service
        Route::post('/crm/assign-amc-service-engineer', 'assignEngineer')->name('amc-services.assign-engineer');
        // Generate Visits for AMC Service
        Route::post('/crm/amc-service-generate-visits/{id}', 'generateVisits')->name('amc-services.generate-visits');
        // Assign Engineer to Visit
        Route::post('/crm/amc-service-assign-visit-engineer', 'assignVisitEngineer')->name('amc-services.assign-visit-engineer');
        // Update Visit Engineer
        Route::post('/crm/amc-service-update-visit-engineer', 'updateVisitEngineer')->name('amc-services.update-visit-engineer');
    });

    // ------------------------------------------------------------ Service Request Page -------------------------------------------------------------

    Route::controller(ServiceRequestController::class)->group(function () {
        // Service Request Page
        Route::get('/crm/service-request', 'index')->name('service-request.index');

        // Create Service Request Page
        // Route::get('/crm/create-service-request', 'create')->name('service-request.create-servies');
        // View Service Request Page
        // Route::get('/crm/view-service-request/{id}', 'viewServiceRequest')->name('service-request.view-quick-service-request);
        // Route::get('/crm/view-service-request-old', 'view')->name('service-request.view-service');
        // Edit Service Request Page
        // Route::get('/crm/edit-service-request', 'edit')->name('service-request.edit-service');

        // Quick Service Request Create
        Route::get('/crm/create-request', 'createQuickServiceRequest')->name('quick-service-requests.create');
        // Quick Service Request Store
        Route::post('/crm/store-request', 'storeQuickServiceRequest')->name('quick-service-requests.store');
        // Get Customer Addresses by Email (AJAX)
        Route::get('/crm/get-customer-addresses', 'getCustomerAddresses')->name('customer.addresses');
        // Quick Service Request View
        Route::get('/crm/service-request/view-service-request/{id}', 'viewQuickServiceRequest')->name('service-request.view-quick-service-request');
        // Quick Service Request Edit
        Route::get('/crm/service-request/edit-service-request/{id}/{service_type}', 'editQuickServiceRequest')->name('service-request.edit-quick-service-request');
        // Quick Service Request Update
        Route::put('/crm/service-request/update-service-request/{id}/{service_type}', 'updateQuickServiceRequest')->name('service-request.update-quick-service-request');
        // Submit Diagnosis for Pickup Product
        Route::post('/crm/service-request/submit-diagnosis', 'submitDiagnosis')->name('service-request.submit-diagnosis');
        // Admin Stock In Hand Approval
        Route::post('/crm/service-request/admin-stock-in-hand-approval', 'adminStockInHandApproval')->name('service-request.admin-stock-in-hand-approval');
        // Assign Part To Person (Engineer/Delivery Man)
        Route::post('/crm/service-request/assign-part-to-person', 'assignPartToPerson')->name('service-request.assign-part-to-person');

        // Delete Section For All the Service Request
        Route::delete('/crm/service-request/destroy-service-request/{id}', 'destroyQuickServiceRequest')->name('service-request.destroy-quick-service-request');

        // 
        Route::post('/crm/service-request/assign-quick-service-engineer', 'assignQuickServiceEngineer')->name('service-request.assign-quick-service-engineer');
        Route::post('/crm/service-request/assign-non-amc-engineer', 'assignNonAmcEngineer')->name('service-request.assign-non-amc-engineer');      /// need to check

        // Assign Pickup for Quick Service Request
        Route::post('/crm/service-request/assign-pickup', 'assignPickup')->name('service-request.assign-pickup');
        Route::post('/crm/service-request/pickup-admin-action', 'pickupAdminAction')->name('service-request.pickup-admin-action');
        Route::post('/crm/service-request/pickup-received', 'pickupReceived')->name('service-request.pickup-received');
        Route::post('/crm/service-request/assign-return', 'assignReturn')->name('service-request.assign-return');
        Route::post('/crm/service-request/return-picked', 'returnPicked')->name('service-request.return-picked');

        // Mark part as picked from warehouse
        Route::post('/crm/service-request/part-picked', 'partPicked')->name('service-request.part-picked');



        // Amc Service Request Create
        Route::get('/crm/create-amc-request', 'createAmcServiceRequest')->name('amc-service-requests.create');
        // Amc Service Request Store
        Route::post('/crm/store-amc-request', 'storeAmcServiceRequest')->name('amc-service-requests.store');
        // Amc Service Request View
        Route::get('/crm/service-request/view-amc-service-request/{id}', 'viewAmcServiceRequest')->name('service-request.view-amc-service-request');
        // Amc Service Request Edit
        Route::get('/crm/service-request/edit-amc-service-request/{id}/{service_type}', 'editAmcServiceRequest')->name('service-request.edit-amc-service-request');
        // Amc Service Request Update
        Route::put('/crm/service-request/update-amc-service-request/{id}', 'updateAmcServiceRequest')->name('service-request.update-amc-service-request');



        // AMC Request CRUD Routes
        // Create AMC Request Page
        // Route::get('/crm/create-amc-request', 'create_amc')->name('service-request.create-amc');
        // Store AMC Request
        // Route::post('/crm/store-amc-request', 'store_amc')->name('service-request.store-amc');
        // View AMC Request Page
        // Route::get('/crm/view-amc-request/{id}', 'view_amc')->name('service-request.view-amc');
        // Edit AMC Request Page
        // Route::get('/crm/edit-amc-request/{id}', 'edit_amc')->name('service-request.edit-amc');
        // Update AMC Request
        // Route::put('/crm/update-amc-request/{id}', 'update_amc')->name('service-request.update-amc');
        // Delete AMC Request
        // Route::delete('/crm/delete-amc-request/{id}', 'destroy_amc')->name('service-request.delete-amc');
        // Get AMC Plan Details (AJAX)
        // Route::get('/crm/get-amc-plan/{id}', 'getAmcPlanDetails')->name('service-request.get-amc-plan');
        // Assign Engineer to AMC
        Route::post('/crm/assign-amc-engineer', 'assignEngineer')->name('service-request.assign-engineer');

        // Non-AMC Request CRUD Routes
        // Create Non-AMC Request Page
        Route::get('/crm/create-non-amc-request', 'create_non_amc')->name('service-request.create-non-amc');
        // Store Non-AMC Request
        Route::post('/crm/store-non-amc-request', 'store_non_amc')->name('service-request.store-non-amc');
        // View Non-AMC Request Page
        Route::get('/crm/view-non-amc-request/{id}', 'view_non_amc')->name('service-request.view-non-amc');
        // Edit Non-AMC Request Page
        Route::get('/crm/edit-non-amc-request/{id}', 'edit_non_amc')->name('service-request.edit-non-amc');
        // Update Non-AMC Request
        Route::put('/crm/update-non-amc-request/{id}', 'update_non_amc')->name('service-request.update-non-amc');
        // Delete Non-AMC Request
        Route::delete('/crm/delete-non-amc-request/{id}', 'destroy_non_amc')->name('service-request.delete-non-amc');
        // Assign Engineer to Non-AMC
        // Route::post('/crm/assign-non-amc-engineer', 'assignNonAmcEngineer')->name('service-request.assign-non-amc-engineer');
    });

    // ------------------------------------------------------------ Track Request Page -------------------------------------------------------------

    Route::controller(TrackRequestController::class)->group(function () {
        // Track Request Page
        Route::get('/crm/track-request', 'index')->name('track-request.index');
        Route::post('/crm/track-request', 'track')->name('track-request.track');
    });

    // ------------------------------------------------------------ Case Transfer Page -------------------------------------------------------------

    Route::controller(CaseTransferController::class)->group(function () {
        // Case Transfer Page
        Route::get('/crm/case-transfer', 'index')->name('case-transfer.index');
        // Create Case Transfer Page
        Route::get('/crm/create-case-transfer', 'create')->name('case-transfer.create');
        // View Case Transfer Page
        Route::get('/crm/view-case-transfer/{id}', 'view')->name('case-transfer.view');
        // Approve Case Transfer
        Route::post('/crm/approve-case-transfer/{id}', 'approve')->name('case-transfer.approve');
    });

    // View Case Transfer Page (duplicate route removed)

    // ------------------------------------------------------------ Call Logs Page -------------------------------------------------------------

    Route::controller(CallLogController::class)->group(function () {
        // Call Logs Page
        Route::get('/crm/call-logs', 'index')->name('call-logs.index');
        // View Logs Page
        Route::get('/crm/view-call-logs', 'view')->name('call-logs.view');
    });

    // ------------------------------------------------------------ Activity Logs Page -------------------------------------------------------------

    Route::controller(ActivityLogController::class)->group(function () {
        // Activity Logs Page
        Route::get('/crm/activity-logs', 'index')->name('activity-logs.index');
    });

    Route::prefix('/crm')->group(function () {
        // ------------------------------------------------------------ Pincodes Page -------------------------------------------------------------
        Route::controller(PincodeController::class)->group(function () {
            Route::get('/manage-pincodes', 'index')->name('pincodes.index');
            Route::get('/create-manage-pincodes', 'create')->name('pincodes.create');
            Route::post('/store-manage-pincodes', 'store')->name('pincodes.store');
            Route::get('/edit-manage-pincodes/{id}', 'edit')->name('pincodes.edit');
            Route::put('/update-manage-pincodes/{id}', 'update')->name('pincodes.update');
            Route::delete('/delete-manage-pincode/{id}', 'delete')->name('pincodes.delete');
        });
    });

    // ------------------------------------------------------------ Pickup Requests Page -------------------------------------------------------------

    Route::controller(PickupRequestController::class)->group(function () {
        // Pickup Requests Page
        Route::get('/crm/pickup-requests', 'index')->name('pickup-requests.index');
        // View Request Page
        Route::get('/crm/view-pickup-requests/{id}', 'view')->name('pickup-requests.view');
    });

    // ------------------------------------------------------------ View Jobs Page -------------------------------------------------------------

    Route::controller(JobController::class)->group(function () {
        // View Jobs Page
        Route::get('/crm/jobs', 'index')->name('jobs.index');
        // Create Jobs Page
        Route::get('/crm/create-job', 'create')->name('jobs.create');
        // Store Job Page
        Route::post('/crm/store-jobs', 'store')->name('jobs.store');
        // View Job Page
        Route::get('/crm/view-jobs/{id}', 'view')->name('jobs.view');
        // Edit Job Page
        Route::get('/crm/edit-jobs/{id}', 'edit')->name('jobs.edit');
        // Update Job Page
        Route::put('/crm/update-jobs/{id}', 'update')->name('jobs.update');
        // Delete Job Page
        Route::delete('/crm/delete-jobs/{id}', 'delete')->name('jobs.delete');
        // Delete Device
        Route::delete('/crm/delete-device/{id}', 'deleteDevice')->name('jobs.deleteDevice');
        // Bulk Delete Devices
        Route::post('/crm/bulk-delete-devices', 'bulkDeleteDevices')->name('jobs.bulkDeleteDevices');
        // Assign Job to Engineer
        Route::post('/crm/assign-job', 'assignJob')->name('jobs.assignJob');
        // Bulk Delete Jobs
        Route::post('/crm/bulk-delete-jobs', 'bulkDeleteJobs')->name('jobs.bulkDeleteJobs');
    });

    // ------------------------------------------------------------ Assigned Jobs Page -------------------------------------------------------------

    Route::controller(AssignedJobController::class)->group(function () {
        // Assigned Jobs Page
        Route::get('/crm/assigned-jobs', 'index')->name('assigned-jobs.index');
        // View Assigned Jobs Page
        Route::get('/crm/view-assigned-job/{id}', 'view')->name('assigned-jobs.view');
        // Edit Assigned Jobs Page
        Route::get('/crm/edit-assigned-jobs/{id}', 'edit')->name('assigned-jobs.edit');
        // Update Assigned Jobs Page
        Route::put('/crm/update-assigned-jobs/{id}', 'update')->name('assigned-jobs.update');
        // Delete Assigned Jobs Page
        Route::delete('/crm/delete-assigned-jobs/{id}', 'delete')->name('assigned-jobs.delete');

        // Workflow Operations
        Route::post('/crm/assigned-jobs/{id}/start-job', 'startJob')->name('assigned-jobs.startJob');
        Route::post('/crm/assigned-jobs/{id}/perform-diagnosis', 'performDiagnosis')->name('assigned-jobs.performDiagnosis');
        Route::post('/crm/assigned-jobs/{id}/take-action', 'takeAction')->name('assigned-jobs.takeAction');
        Route::post('/crm/assigned-jobs/{id}/complete-job', 'completeJob')->name('assigned-jobs.completeJob');
        Route::post('/crm/assigned-jobs/{id}/escalate', 'escalateToOnSite')->name('assigned-jobs.escalate');
    });

    // ------------------------------------------------------------ Field Issues Page -------------------------------------------------------------

    Route::controller(FieldIssuesController::class)->group(function () {
        // Field Issues Page
        Route::get('/crm/field-issues', 'index')->name('field-issues.index');
        // View Field Issues Page
        Route::get('/crm/view-field-issues/{id}', 'view')->name('field-issues.view');
        // Edit Field Issues Page
        Route::get('/crm/edit-field-issues/{id}', 'edit')->name('field-issues.edit');
        // Create Field Issue
        Route::post('/crm/field-issues', 'store')->name('field-issues.store');
        // Update Field Issue
        Route::put('/crm/field-issues/{id}', 'update')->name('field-issues.update');
        // Delete Field Issue
        Route::delete('/crm/field-issues/{id}', 'destroy')->name('field-issues.destroy');
    });

    // ------------------------------------------------------------ Spare Parts Page -------------------------------------------------------------

    Route::controller(SparePartController::class)->group(function () {
        // Spare Parts Requests Page
        Route::get('/crm/spare-parts-requests', 'index')->name('spare-parts-requests.index');
        // View Parts Requests Page
        Route::get('/crm/spare-parts-requests/{id}', 'view')->name('spare-parts-requests.view');
        // Admin Approval/Rejection
        Route::put('/crm/spare-parts-requests/{id}/admin-approval', 'adminApproval')->name('spare-parts.admin-approval');
        // Warehouse Approval/Rejection
        Route::put('/crm/spare-parts-requests/{id}/warehouse-approval', 'warehouseApproval')->name('spare-parts.warehouse-approval');
        // Picked by Engineer
        Route::put('/crm/spare-parts-requests/{id}/picked', 'picked')->name('spare-parts.picked');
    });

    // ------------------------------------------------------------ Assign Products Page -------------------------------------------------------------

    Route::controller(InHandProductController::class)->group(function () {
        // In Hand Products Page
        Route::get('/crm/in-hand-products', 'index')->name('in-hand-products.index');
        // View In Hand Products Page
        Route::get('/crm/view-in-hand-products', 'view')->name('assign-products.view');
    });

    // ------------------------------------------------------------ Assign Products Page -------------------------------------------------------------

    Route::controller(SupportTicketController::class)->group(function () {
        // Support Ticket Page
        Route::get('/crm/support-ticket', 'index')->name('support-ticket.index');
        // View Support Ticket Page
        Route::get('/crm/view-support-ticket', 'view')->name('support-ticket.view');
    });

    // ------------------------------------------------------------ Assign Products Page -------------------------------------------------------------

    Route::controller(InvoiceController::class)->group(function () {
        // Invoice Page
        Route::get('/crm/invoice', 'index')->name('invoice.index');
    });

    // route::get('/warehouse/track-product', [TrackProductController::class, 'index'])->name('track-product.index');

    // *******************************************************************************************************************************************************
    // *******************************************************************************************************************************************************
    // ********************************************************************      SDUI ADMIN PANEL       ******************************************************
    // *******************************************************************************************************************************************************
    // *******************************************************************************************************************************************************


    Route::prefix('admin/sdui')->middleware(['auth', 'admin'])->name('admin.sdui.')->group(function () {

        // Pages Management (Page-Level SDUI Architecture)
        Route::resource('pages', SduiPageController::class);
        Route::get('pages/{id}/restore', [SduiPageController::class, 'restore'])->name('pages.restore');
        Route::delete('pages/{id}/force-delete', [SduiPageController::class, 'forceDelete'])->name('pages.force-delete');
        Route::get('pages/{id}/revert/{version}', [SduiPageController::class, 'revert'])->name('pages.revert');
        Route::get('pages/{id}/versions', [SduiPageController::class, 'versions'])->name('pages.versions');
        Route::get('pages/{id}/duplicate', [SduiPageController::class, 'duplicate'])->name('pages.duplicate');

        // Settings Management
        Route::get('settings', [SduiSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SduiSettingController::class, 'update'])->name('settings.update');
        Route::post('settings', [SduiSettingController::class, 'store'])->name('settings.store');
        Route::delete('settings/{id}', [SduiSettingController::class, 'destroy'])->name('settings.destroy');
        Route::get('settings/initialize', [SduiSettingController::class, 'initializeDefaults'])->name('settings.initialize');
    });

    // *******************************************************************************************************************************************************
    // *******************************************************************************************************************************************************
    // ********************************************************************      Customer App Section       **************************************************
    // *******************************************************************************************************************************************************
    // *******************************************************************************************************************************************************

    Route::controller(QuickServiceController::class)->group(function () {
        // Quick Services Page
        Route::get('crm/quick-services', 'index')->name('quick-services.index');
        // Create Quick Services Page
        Route::get('crm/create-quick-services', 'create')->name('quick-services.create');
        // Store Quick Services Page
        Route::post('crm/quick-services', 'store')->name('quick-services.store');
        // Edit Quick Services Page
        Route::get('crm/edit-quick-services/{id}', 'edit')->name('quick-services.edit');
        // Route::get('/quick-services/{id}/edit', 'edit')->name('quick-services.edit');
        // Update Quick Services Page
        Route::put('crm/quick-services/{id}', 'update')->name('quick-services.update');
        // Delete Quick Services Page
        Route::delete('crm/quick-services/{id}', 'destroy')->name('quick-services.destroy');
    });

    // ------------------------------------------------------------ Quick Service Requests -------------------------------------------------------------

    Route::controller(QuickServiceRequestController::class)->group(function () {
        // Quick Service Requests Index Page
        Route::get('crm/quick-service-requests', 'index')->name('quick-service-requests.index');
        // View Quick Service Request Page
        Route::get('crm/quick-service-requests/{id}', 'view')->name('quick-service-requests.view');
        // Edit Quick Service Request Page
        Route::get('crm/quick-service-requests/{id}/edit', 'edit')->name('quick-service-requests.edit');
        // Update Quick Service Request
        Route::put('crm/quick-service-requests/{id}', 'update')->name('quick-service-requests.update');
        // Delete Quick Service Request
        Route::delete('crm/quick-service-requests/{id}', 'destroy')->name('quick-service-requests.destroy');
        // Assign Engineer to Quick Service Request
        Route::post('crm/quick-service-requests/assign-engineer', 'assignEngineer')->name('quick-service-requests.assign-engineer');
    });
});
