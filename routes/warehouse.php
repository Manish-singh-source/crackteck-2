<?php

use App\Http\Controllers\LowStockController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\TrackProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorPurchaseBillController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseRackController;
use Illuminate\Support\Facades\Route;

// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
// **************************************************************      Warehouse       *******************************************************************
// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************

Route::prefix('demo')->group(function () {
    // Index Page
    Route::get('/warehouse/index', function () {
        return view('/warehouse/index');
    })->name('warehouse/index');

    // ------------------------------------------------------------ Products List -------------------------------------------------------------

    Route::controller(ProductListController::class)->group(function () {
        // Products List Page
        Route::get('/warehouse/product-list', 'index')->name('products.index');
        // Create Product Page
        Route::get('/warehouse/create-product', 'create')->name('product-list.create');
        // Store Product
        Route::post('/warehouse/create-product', 'store')->name('product-list.store');
        // View Product Page
        Route::get('/warehouse/view-product-list/{id}', 'view')->name('product-list.view');
        // Edit Products Page
        Route::get('/warehouse/edit-product-list/{id}', 'edit')->name('product-list.edit');
        // Update Product
        Route::put('/warehouse/edit-product-list/{id}', 'update')->name('product-list.update');
        // Delete Product
        Route::delete('/warehouse/product-list/{id}', 'destroy')->name('product-list.destroy');
        // Scrap Items Page
        Route::get('/warehouse/scrap-items', 'scrapItems')->name('product-list.scrap-items');
        // Scrap Product
        Route::post('/warehouse/scrap-product', 'scrapProduct')->name('product-list.scrap-product');
        // Restore Product
        Route::post('/warehouse/restore-product/{scrapItemId}', 'restoreProduct')->name('product-list.restore-product');
        // Save Serial Number
        Route::post('/warehouse/save-serial', 'saveSerial')->name('product-list.save-serial');
        // AJAX SKU Validation
        Route::get('/warehouse/check-sku-unique', 'checkSkuUnique')->name('product-list.check-sku');

        Route::get('/warehouse/get-vendor-purchase-orders-by-vendor', 'getVendorPurchaseOrdersByVendor')->name('product-list.get-vendor-purchase-orders-by-vendor');
        Route::get('/warehouse/get-sub-categories', 'getSubCategories')->name('product-list.get-sub-categories');

    });

    Route::get('/warehouse-dependent', [WarehouseRackController::class, 'getDependentData']);
    Route::get('/category-dependent', [ProductListController::class, 'getSubcategoriesByParent']);

    // ------------------------------------------------------------ Track Product List -------------------------------------------------------------

    Route::controller(TrackProductController::class)->group(function () {
        // Track Product List Page
        Route::get('/warehouse/track-product-list', 'index')->name('track-product.index');
        // Track Product Search
        Route::post('/warehouse/track-product-search', 'search')->name('track-product.search');
    });

    // ------------------------------------------------------------ Spare Parts List -------------------------------------------------------------

    Route::controller(SparePartController::class)->group(function () {
        // Spare Parts Requests
        Route::get('/warehouse/spare-parts', 'index')->name('spare-parts.index');
        // View/Edit Stock Request Page
        Route::get('/warehouse/spare-parts/{stockRequest}', 'warehouse_show')->name('stock-request.show');

        // Update Stock Request
        Route::put('/warehouse/stock-requests/{stockRequest}', 'warehouse_update')->name('stock-request.update');
        // Remove Product from Stock Request
        Route::delete('/warehouse/stock-requests/remove-product/{id}', 'removeProduct')->name('stock-request.remove-product');

        // Assign Delivery Man
        Route::post('/warehouse/assign-delivery-man/{id}', 'assignDeliveryMan')->name('spare-parts.assign-delivery-man');
    });

    // ------------------------------------------------------------ Warehouse Page ------------------------------------------------------------

    Route::controller(WarehouseController::class)->group(function () {
        // Warehouses List Page
        Route::get('/warehouse/warehouses-list', 'index')->name('warehouses-list.index');
        // Create Warehouse Page
        Route::get('/warehouse/create-warehouse', 'create')->name('warehouse-list.create');
        // Store Warehouse Page
        Route::post('/warehouse/store-warehouse', 'store')->name('warehouse.store');
        // View Warehouse Page
        Route::get('/warehouse/view-warehouse-list/{id}', 'view')->name('warehouses-list.view');
        // Edit Warehouse Page
        Route::get('/warehouse/edit-warehouse/{id}', 'edit')->name('warehouses-list.edit');
        // Update Warehouse Page
        Route::put('/warehouse/update-warehouse/{id}', 'update')->name('warehouse.update');
        // Update Status Of Warehouse
        Route::put('/warehouse/update-status/{id}', 'updateStatus')->name('warehouse.updateStatus');
        // Delete Warehouse Page
        Route::delete('/warehouse/delete-warehouse/{id}', 'delete')->name('warehouse.delete');
    });

    // ------------------------------------------------------------ Warehouse Rack Page -------------------------------------------------------------

    Route::controller(WarehouseRackController::class)->group(function () {
        // Warehouse Rack Page
        Route::get('/warehouse/rack', 'index')->name('rack.index');
        // Create Warehouse Rack Page
        Route::get('/warehouse/create-rack', 'create')->name('rack.create');
        // Store Warehouse Rack Page
        Route::post('/warehouse/store-rack', 'store')->name('rack.store');
        // Edit Warehouse Rack Page
        Route::get('/warehouse/edit-rack/{id}', 'edit')->name('rack.edit');
        // Update Warehouse Rack Page
        Route::put('/warehouse/update-rack/{id}', 'update')->name('rack.update');
        // Delete Warehouse Rack Page
        Route::delete('/warehouse/delete-rack/{id}', 'delete')->name('rack.delete');
    });

    // ------------------------------------------------------------ Vendor Purchase Page -------------------------------------------------------------

    Route::controller(VendorController::class)->group(function () {
        // Vendor Index Page
        Route::get('/warehouse/vendor', 'index')->name('vendor_list.index');
        // Create Vendor Page
        Route::get('/warehouse/create-vendor', 'create')->name('vendor_list.create');
        // Store Vendor
        Route::post('/warehouse/create-vendor', 'store')->name('vendor_list.store');
        // View Vendor Page
        Route::get('/warehouse/view-vendor/{id}', 'view')->name('vendor_list.view');
        // Edit Vendor Page
        Route::get('/warehouse/edit-vendor/{id}', 'edit')->name('vendor_list.edit');
        // Update Vendor
        Route::put('/warehouse/edit-vendor/{id}', 'update')->name('vendor_list.update');
        // Delete Vendor
        Route::delete('/warehouse/vendor/{id}', 'destroy')->name('vendor_list.destroy');
    });

    // ------------------------------------------------------------ Vendor Purchase Page -------------------------------------------------------------

    Route::controller(VendorPurchaseBillController::class)->group(function () {
        // Vendor Purchase Bills Index Page
        Route::get('/warehouse/vendor-purchase-bills', 'index')->name('vendor.index');
        // Create Vendor Purchase Bill Page
        Route::get('/warehouse/create-vendor-purchase-bill', 'create')->name('vendor.create');
        // Store Vendor Purchase Bill
        Route::post('/warehouse/create-vendor-purchase-bill', 'store')->name('vendor.store');
        // View Vendor Purchase Bill Page
        Route::get('/warehouse/view-vendor-purchase-bill/{id}', 'view')->name('vendor.view');
        // Edit Vendor Purchase Bill Page
        Route::get('/warehouse/edit-vendor-purchase-bill/{id}', 'edit')->name('vendor.edit');
        // Update Vendor Purchase Bill
        Route::put('/warehouse/edit-vendor-purchase-bill/{id}', 'update')->name('vendor.update');
        // Delete Vendor Purchase Bill
        Route::delete('/warehouse/vendor-purchase-bill/{id}', 'destroy')->name('vendor.destroy');
    });

    // ------------------------------------------------------------ Stock Requests Page -------------------------------------------------------------

    Route::controller(StockReportController::class)->group(function () {
        // Stock Requests Index Page
        Route::get('/warehouse/stock-requests', 'warehouse_index')->name('stock-request.index');
        // Create Stock Request Page
        Route::get('/warehouse/create-stock-request', 'warehouse_create')->name('stock-request.create');
        // Store Stock Request
        Route::post('/warehouse/create-stock-request', 'warehouse_store')->name('stock-request.store');

        // Delete Stock Request
        Route::delete('/warehouse/stock-requests/{stockRequest}', 'delete')->name('stock-request.destroy');

        // AJAX Routes for Product Search
        Route::get('/warehouse/search-products', 'searchProducts')->name('stock-request.search-products');
        Route::get('/warehouse/get-product/{product}', 'getProduct')->name('stock-request.get-product');
    });

    // ------------------------------------------------------------ Low Stock Page -------------------------------------------------------------

    Route::controller(LowStockController::class)->group(function () {
        // Low Stock Page
        Route::get('/warehouse/low-stock-alert', 'warehouse_index')->name('low-stock.index');
    });
});
