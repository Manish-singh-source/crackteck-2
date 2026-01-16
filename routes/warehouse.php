<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LowStockController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\TrackProductController;
use App\Http\Controllers\WarehouseRackController;
use App\Http\Controllers\VendorPurchaseBillController;
use App\Http\Controllers\Warehouse\ScrapItemController;

// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
// **************************************************************      Warehouse       *******************************************************************
// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************

Route::prefix('demo/warehouse')->group(function () {
    // Index Page
    Route::get('/index', function () {
        return view('/warehouse/index');
    })->name('warehouse/index');

    
    // ------------------------------------------------------------ Warehouse Page ------------------------------------------------------------

    Route::controller(WarehouseController::class)->group(function () {
        // Warehouses List Page
        Route::get('/warehouses-list', 'index')->name('warehouses-list.index');
        // Create Warehouse Page
        Route::get('/create-warehouse', 'create')->name('warehouse-list.create');
        // Store Warehouse Page
        Route::post('/store-warehouse', 'store')->name('warehouse.store');
        // View Warehouse Page
        Route::get('/view-warehouse-list/{id}', 'view')->name('warehouses-list.view');
        // Edit Warehouse Page
        Route::get('/edit-warehouse/{id}', 'edit')->name('warehouses-list.edit');
        // Update Warehouse Page
        Route::put('/update-warehouse/{id}', 'update')->name('warehouse.update');
        // Update Status Of Warehouse
        Route::put('/update-status/{id}', 'updateStatus')->name('warehouse.updateStatus');
        // Delete Warehouse Page
        Route::delete('/delete-warehouse/{id}', 'delete')->name('warehouse.delete');
    });

    // ------------------------------------------------------------ Warehouse Rack Page -------------------------------------------------------------

    Route::controller(WarehouseRackController::class)->group(function () {
        // Warehouse Rack Page
        Route::get('/rack', 'index')->name('rack.index');
        // Create Warehouse Rack Page
        Route::get('/create-rack', 'create')->name('rack.create');
        // Store Warehouse Rack Page
        Route::post('/store-rack', 'store')->name('rack.store');
        // Edit Warehouse Rack Page
        Route::get('/edit-rack/{id}', 'edit')->name('rack.edit');
        // Update Warehouse Rack Page
        Route::put('/update-rack/{id}', 'update')->name('rack.update');
        // Delete Warehouse Rack Page
        Route::delete('/delete-rack/{id}', 'delete')->name('rack.delete');
    });

    // ------------------------------------------------------------ Vendor Purchase Page -------------------------------------------------------------

    Route::controller(VendorController::class)->group(function () {
        // Vendor Index Page
        Route::get('/vendor', 'index')->name('vendor_list.index');
        // Create Vendor Page
        Route::get('/create-vendor', 'create')->name('vendor_list.create');
        // Store Vendor
        Route::post('/create-vendor', 'store')->name('vendor_list.store');
        // View Vendor Page
        Route::get('/view-vendor/{id}', 'view')->name('vendor_list.view');
        // Edit Vendor Page
        Route::get('/edit-vendor/{id}', 'edit')->name('vendor_list.edit');
        // Update Vendor
        Route::put('/edit-vendor/{id}', 'update')->name('vendor_list.update');
        // Delete Vendor
        Route::delete('/vendor/{id}', 'destroy')->name('vendor_list.destroy');
    });

    // ------------------------------------------------------------ Vendor Purchase Page -------------------------------------------------------------

    Route::controller(VendorPurchaseBillController::class)->group(function () {
        // Vendor Purchase Bills Index Page
        Route::get('/vendor-purchase-bills', 'index')->name('vendor.index');
        // Create Vendor Purchase Bill Page
        Route::get('/create-vendor-purchase-bill', 'create')->name('vendor.create');
        // Store Vendor Purchase Bill
        Route::post('/create-vendor-purchase-bill', 'store')->name('vendor.store');
        // View Vendor Purchase Bill Page
        Route::get('/view-vendor-purchase-bill/{id}', 'view')->name('vendor.view');
        // Edit Vendor Purchase Bill Page
        Route::get('/edit-vendor-purchase-bill/{id}', 'edit')->name('vendor.edit');
        // Update Vendor Purchase Bill
        Route::put('/edit-vendor-purchase-bill/{id}', 'update')->name('vendor.update');
        // Delete Vendor Purchase Bill
        Route::delete('/vendor-purchase-bill/{id}', 'destroy')->name('vendor.destroy');
    });


    // ------------------------------------------------------------ Products List -------------------------------------------------------------

    Route::controller(ProductListController::class)->group(function () {
        // Products List Page
        Route::get('/product-list', 'index')->name('products.index');
        // Create Product Page
        Route::get('/create-product', 'create')->name('product-list.create');
        // Store Product
        Route::post('/create-product', 'store')->name('product-list.store');
        // View Product Page
        Route::get('/view-product-list/{id}', 'view')->name('product-list.view');
        // Edit Products Page
        Route::get('/edit-product-list/{id}', 'edit')->name('product-list.edit');
        // Update Product
        Route::put('/edit-product-list/{id}', 'update')->name('product-list.update');
        // Delete Product
        Route::delete('/product-list/{id}', 'destroy')->name('product-list.destroy');
        // Scrap Items Page
        Route::get('/scrap-items', 'scrapItems')->name('product-list.scrap-items');
        // Scrap Product
        Route::post('/scrap-product', 'scrapProduct')->name('product-list.scrap-product');
        // Restore Product
        Route::post('/restore-product/{scrapItemId}', 'restoreProduct')->name('product-list.restore-product');
        // Save Serial Number
        Route::post('/save-serial', 'saveSerial')->name('product-list.save-serial');
        // AJAX SKU Validation
        Route::get('/check-sku-unique', 'checkSkuUnique')->name('product-list.check-sku');

        Route::get('/get-vendor-purchase-orders-by-vendor', 'getVendorPurchaseOrdersByVendor')->name('product-list.get-vendor-purchase-orders-by-vendor');
        Route::get('/get-sub-categories', 'getSubCategories')->name('product-list.get-sub-categories');

    });

    Route::get('/warehouse-dependent', [WarehouseRackController::class, 'getDependentData']);
    Route::get('/category-dependent', [ProductListController::class, 'getSubcategoriesByParent']);

    // ------------------------------------------------------------ Scrap Items List -------------------------------------------------------------
    Route::controller(ScrapItemController::class)->group(function () {
        // Scrap Items List Page
        Route::get('/scrap-items', 'index')->name('scrap-items.index');
        // Add to Scrap
        Route::post('/add-to-scrap', 'addToScrap')->name('scrap-items.add-to-scrap');
        // Remove from Scrap
        Route::post('/remove-from-scrap', 'removeFromScrap')->name('scrap-items.remove-from-scrap');
    });

    // ------------------------------------------------------------ Track Product List -------------------------------------------------------------

    Route::controller(TrackProductController::class)->group(function () {
        // Track Product List Page
        Route::get('/track-product-list', 'index')->name('track-product.index');
        // Track Product Search
        Route::post('/track-product-search', 'search')->name('track-product.search');
    });

    // ------------------------------------------------------------ Spare Parts List -------------------------------------------------------------

    Route::controller(SparePartController::class)->group(function () {
        // Spare Parts Requests
        Route::get('/spare-parts', 'index')->name('spare-parts.index');
        // View/Edit Stock Request Page
        Route::get('/spare-parts/{stockRequest}', 'view')->name('spare-parts.view');
        // Assign Delivery Man/Engineer
        Route::put('/assign-person/{id}', 'assignPerson')->name('spare-parts.assign-person');

        //warehouse_show')->name('stock-request.show');

        // // Update Stock Request
        // Route::put('/stock-requests/{stockRequest}', 'warehouse_update')->name('stock-request.update');
        // // Remove Product from Stock Request
        // Route::delete('/stock-requests/remove-product/{id}', 'removeProduct')->name('stock-request.remove-product');

        // // Assign Delivery Man
        // Route::post('/assign-delivery-man/{id}', 'assignDeliveryMan')->name('spare-parts.assign-delivery-man');
    });

    // ------------------------------------------------------------ Stock Requests Page -------------------------------------------------------------

    Route::controller(StockReportController::class)->group(function () {
        // Stock Reports 
        Route::get('/stock-reports', 'index')->name('stock-reports.index');
    });

    // ------------------------------------------------------------ Low Stock Page -------------------------------------------------------------

    Route::controller(LowStockController::class)->group(function () {
        // Low Stock Page
        Route::get('/low-stock-alert', 'index')->name('low-stock.index');
        // export low stock products
        Route::get('/export-low-stock', 'exportLowStock')->name('low-stock.export');
    });
});
