<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EcommerceOrderController;
use App\Http\Controllers\EcommerceProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductDealController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ProductVariantsController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
// **************************************************************      E-Commerce      *******************************************************************
// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
Route::prefix('/demo')->group(function () {
    // Index Page
    Route::get('/e-commerce/index', function () {
        return view('/e-commerce/index');
    })->name('e-commerce/index');

    // ------------------------------------------------------------ E-Commerce Customer Page -------------------------------------------------------------

    Route::controller(CustomerController::class)->group(function () {
        // E-commerce Customer Page
        Route::get('/e-commerce/customers', 'ec_index')->name('ec.customer.index');
        // Create EC Customer Page
        Route::get('/e-commerce/create-customer', 'ec_create')->name('ec.customer.create');
        // Store EC Customer Detail
        Route::post('/e-commerce/store-customer', 'ec_store')->name('ec.customer.store');
        // View EC Customer Page
        Route::get('/e-commerce/view-customer/{id}', 'ec_view')->name('ec.customer.view');
        // Edit EC Customer Page
        Route::get('/e-commerce/edit-customer/{id}', 'ec_edit')->name('ec.customer.edit');
        // Update EC Customer Page
        Route::put('/e-commerce/update-customer/{id}', 'ec_update')->name('ec.customer.update');
        // Delete EC Customer Page
        Route::delete('/e-commerce/delete-customer/{id}', 'ec_delete')->name('ec.customer.delete');
    });

    // ------------------------------------------------------------ E-Commerce Order Page -------------------------------------------------------------

    Route::controller(OrderController::class)->group(function () {
        // Order Page
        Route::get('/e-commerce/order', 'index')->name('order.index');
        // Create Order Page
        Route::get('/e-commerce/create-order', 'create')->name('order.create');
        // Store Order
        Route::post('/e-commerce/order', 'store')->name('order.store');
        // Edit Order Page
        Route::get('/e-commerce/order/{id}/edit', 'edit')->name('order.edit');
        // Update Order
        Route::put('/e-commerce/order/{id}', 'update')->name('order.update');
        // Delete Order
        Route::delete('/e-commerce/order/{id}', 'destroy')->name('order.delete');
        // Bulk Delete Orders
        Route::post('/e-commerce/orders/bulk-delete', 'bulkDestroy')->name('order.bulk-delete');
        // View Order Page
        Route::get('/e-commerce/view-order/{id}', 'show')->name('order.view');
        // Generate PDF Invoice
        Route::get('/order/{id}/invoice', 'generateInvoice')->name('order.invoice');
        // AJAX Routes for Order Management
        Route::get('/e-commerce/delivery-men-by-city/{city}', 'getDeliveryMenByCity')->name('order.delivery-men-by-city');
        Route::post('/e-commerce/order/{id}/assign-delivery-man', 'assignDeliveryMan')->name('order.assign-delivery-man');
        Route::post('/e-commerce/order/{id}/update-status', 'updateStatus')->name('order.update-status');
        Route::get('/e-commerce/search-users', 'searchUsers')->name('order.search-users');
        Route::get('/e-commerce/search-products', 'searchProducts')->name('order.search-products');
    });

    // ------------------------------------------------------------ E-Commerce Orders Management -------------------------------------------------------------

    Route::controller(EcommerceOrderController::class)->group(function () {
        // Ecommerce Orders List Page
        Route::get('/e-commerce/ecommerce-orders', 'index')->name('ecommerce-order.index');
        // View Ecommerce Order Details
        Route::get('/e-commerce/ecommerce-order/{id}', 'show')->name('ecommerce-order.show');
        // Update Order Status (AJAX)
        Route::post('/e-commerce/ecommerce-order/{id}/update-status', 'updateStatus')->name('ecommerce-order.update-status');
        // Generate PDF Invoice
        Route::get('/e-commerce/ecommerce-order/{id}/invoice', 'generateInvoice')->name('ecommerce-order.invoice');
        // Bulk Delete Orders (AJAX)
        Route::post('/e-commerce/ecommerce-orders/bulk-delete', 'bulkDestroy')->name('ecommerce-order.bulk-delete');
    });

    // ------------------------------------------------------------ E-Commerce Products Page -------------------------------------------------------------

    Route::controller(EcommerceProductController::class)->group(function () {
        // Product List Page
        Route::get('/e-commerce/products', 'index')->name('ec.product.index');
        // Create Product Page
        Route::get('/e-commerce/create-product', 'create')->name('ec.product.create');
        // Store Product
        Route::post('/e-commerce/create-product', 'store')->name('ec.product.store');
        // View Product Page
        Route::get('/e-commerce/view-product/{id}', 'show')->name('ec.product.view');
        // Edit Product Page
        Route::get('/e-commerce/edit-product/{id}', 'edit')->name('ec.product.edit');
        // Update Product
        Route::put('/e-commerce/edit-product/{id}', 'update')->name('ec.product.update');
        // Delete Product
        Route::delete('/e-commerce/delete-product/{id}', 'destroy')->name('ec.product.delete');

        // AJAX Routes for Warehouse Product Search
        Route::get('/e-commerce/search-warehouse-products', 'searchWarehouseProducts')->name('ec.product.search-warehouse');
        Route::get('/e-commerce/get-warehouse-product/{id}', 'getWarehouseProduct')->name('ec.product.get-warehouse');
        // AJAX SKU Validation
        Route::get('/e-commerce/check-sku-unique', 'checkSkuUnique')->name('ec.product.check-sku');
    });

    // Keep old ProductListController routes for backward compatibility (scrap items)
    Route::controller(ProductListController::class)->group(function () {
        // Scrap Items Product Page
        Route::get('/e-commerce/scrap-items', 'ec_scrapItems')->name('scrap-items');
    });

    // ------------------------------------------------------------ E-Commerce Categories Page -------------------------------------------------------------

    Route::controller(CategorieController::class)->group(function () {
        // Categorie Page
        Route::get('/e-commerce/categories', 'index')->name('category.index');
        // Create Categorie Page
        Route::get('/e-commerce/create-categorie', 'create')->name('category.create');
        // Store Categorie Page
        // Route::post('/e-commerce/store-categorie' ,'store')->name('category.store');
        // Parent Categorie Store
        Route::post('/e-commerce/store-parent-categorie', 'storeParent')->name('parent.category.store');
        // Sub Categorie Store
        Route::post('/e-commerce/store-sub-categorie', 'storeSubCategorie')->name('sub.category.store');
        // View Sub Categorie From Parent View
        Route::get('/e-commerce/view-categorie/{id}', 'parentCategorie')->name('categorie.view');
        // Edit Create Categorie Page
        Route::get('/e-commerce/edit-categorie/{id}', 'edit')->name('category.edit');
        // Update Categorie Page
        Route::put('/e-commerce/update-categorie/{id}', 'update')->name('category.update');
        // Delete Categorie Page
        Route::delete('/e-commerce/delete-categorie/{id}', 'delete')->name('category.delete');
        // Edit Child Category
        Route::get('/e-commerce/edit-child-categorie/{id}', 'editChild')->name('child.category.edit');
        // Update Child Category
        Route::put('/e-commerce/update-child-categorie/{id}', 'updateChild')->name('child.category.update');
        // Delete Child Category
        Route::delete('/e-commerce/delete-child-categorie/{id}', 'destroyChild')->name('child.category.delete');
        // Update Category Order
        Route::post('/e-commerce/update-category-order', 'updateOrder')->name('category.update.order');
        // Get Child Category Data for AJAX
        Route::get('/e-commerce/get-child-category-data/{id}', 'getChildCategoryData')->name('child.category.data');

        Route::get('/e-commerce/check-sort-order-unique', 'checkSortOrderUnique')->name('category.check-sort-order');
    });

    Route::get('/categorie-dependent', [CategorieController::class, 'getDependentData']);

    // ------------------------------------------------------------ E-Commerce Brands Page -------------------------------------------------------------

    Route::controller(BrandController::class)->group(function () {
        // Brands Page
        Route::get('/e-commerce/brands', 'index')->name('brand.index');
        // Create Brands Page
        Route::get('/e-commerce/create-brand', 'create')->name('brand.create');
        // Store Brands Page
        Route::post('/e-commerce/store-brand', 'store')->name('brand.store');
        // Edit Brands Page
        Route::get('/e-commerce/edit-brand/{id}', 'edit')->name('brand.edit');
        // Update Brands Page
        Route::put('/e-commerce/update-brand/{id}', 'update')->name('brand.update');
        // Delete Brands Page
        Route::delete('/e-commerce/delete-brand/{id}', 'delete')->name('brand.delete');
    });

    // ------------------------------------------------------------ E-Commerce Product Variants Page -------------------------------------------------------------

    Route::controller(ProductVariantsController::class)->group(function () {
        // Product Variants Page
        Route::get('/e-commerce/product-variants', 'index')->name('variant.index');
        // Product Attribute List Page
        Route::get('/e-commerce/product-attribute-list/{id}', 'view')->name('variant.view');
        // Edit Product Attribute List
        Route::get('/e-commerce/edit-product-attribute/{id}', 'editAttribute')->name('variant.edit');
        // Update Product Attribute List
        Route::put('/e-commerce/update-product-attribute/{id}', 'updateAttribute')->name('variant.update');
        // Store Product Attribute
        Route::post('/e-commerce/store-product-attribute', 'storeAttribute')->name('variant.store');
        // Delete Product Attribute
        Route::delete('/e-commerce/delete-product-attribute/{id}', 'deleteAttribute')->name('variant.delete');
        // Store Product Attribute Value
        Route::post('/e-commerce/store-product-attribute-value', 'storeAttributeValue')->name('variant.store.attribute.value');
        // Update Product Attribute Value
        Route::put('/e-commerce/update-product-attribute-value/{id}', 'updateAttributeValue')->name('variant.update.attribute.value');
        // Delete Product Attribute Value
        Route::delete('/e-commerce/delete-product-attribute-value/{id}', 'deleteAttributeValue')->name('variant.delete.attribute.value');
    });



    Route::prefix('/e-commerce')->group(function () {

        // ------------------------------------------------------------ E-Commerce Coupons Page -------------------------------------------------------------
        Route::controller(CouponsController::class)->group(function () {
            Route::get('/coupons', 'index')->name('coupon.index');
            Route::get('/coupons/create', 'create')->name('coupon.create');
            Route::post('/coupons', 'store')->name('coupon.store');
            Route::get('/coupons/{id}/edit', 'edit')->name('coupon.edit');
            Route::put('/coupons/{id}', 'update')->name('coupon.update');
            Route::delete('/coupons/{id}', 'destroy')->name('coupon.delete');

            // AJAX Routes for search
            Route::get('/coupons/search-categories', 'searchCategories')->name('coupon.search-categories');
            Route::get('/coupons/search-brands', 'searchBrands')->name('coupon.search-brands');
            Route::get('/coupons/search-products', 'searchProducts')->name('coupon.search-products');
        }); 

        // ------------------------------------------------------------ E-Commerce Subscribers Page -------------------------------------------------------------
        Route::controller(SubscriberController::class)->group(function () {
            Route::get('/subscribers', 'index')->name('subscriber.index');
            Route::get('/send-mail-subscriber', 'sendMail')->name('subscriber.send-mail');
            Route::delete('/delete-subscriber/{id}', 'delete')->name('subscriber.delete');
            Route::post('/send-mails', 'sendMails')->name('send-mails');
        });

        // ------------------------------------------------------------ E-Commerce Contact Page -------------------------------------------------------------
        Route::controller(ContactController::class)->group(function () {
            Route::get('/contacts', 'index')->name('contact.index');
            Route::get('/view-contact/{id}', 'view')->name('contact.view');
            Route::delete('/delete-contact/{id}', 'delete')->name('contact.delete');
        });

        Route::controller(BannerController::class)->group(function () {
            // ---------------------------------------- E-Commerce Website Banner Page ------------------------------------------------
            Route::get('/website-banner', 'websiteBanner')->name('website.banner.index');
            Route::get('/add-banner', 'addWebsiteBanner')->name('website.banner.create');
            Route::post('/store-banner', 'storeWebsiteBanner')->name('website.banner.store');
            Route::get('/show-banner/{id}', 'showWebsiteBanner')->name('website.banner.show');
            Route::get('/edit-banner/{id}', 'editWebsiteBanner')->name('website.banner.edit');
            Route::put('/update-banner/{id}', 'updateWebsiteBanner')->name('website.banner.update');
            Route::delete('/delete-banner/{id}', 'deleteWebsiteBanner')->name('website.banner.delete');
        });

        // ------------------------------------------------------------ E-Commerce Product Deals Page -------------------------------------------------------------
        Route::controller(ProductDealController::class)->group(function () {
            Route::get('/product-deals', 'index')->name('product-deals.index');
            Route::get('/add-product-deals', 'create')->name('product-deals.create');
            Route::post('/add-product-deals', 'store')->name('product-deals.store');
            Route::get('/view-product-deal/{productDeal}', 'show')->name('product-deals.view');
            Route::get('/edit-product-deal/{productDeal}', 'edit')->name('product-deals.edit');
            Route::put('/edit-product-deal/{productDeal}', 'update')->name('product-deals.update');
            Route::delete('/delete-product-deal/{productDeal}', 'destroy')->name('product-deals.delete');

            // AJAX Routes for E-commerce Product Search
            Route::get('/search-ecommerce-products', 'searchEcommerceProducts')->name('product-deals.search-products');
            Route::get('/get-ecommerce-product/{id}', 'getEcommerceProduct')->name('product-deals.get-product');
        });

        // ------------------------------------------------------------ E-Commerce Collection Page -------------------------------------------------------------
        Route::controller(CollectionController::class)->group(function () {
            Route::get('/collections', 'index')->name('collection.index');
            Route::get('/add-collections', 'create')->name('collection.create');
            Route::post('/add-collections', 'store')->name('collection.store');

            Route::get('/edit-collections/{id}', 'edit')->name('collection.edit');
            Route::put('/edit-collections/{id}', 'update')->name('collection.update');
            Route::delete('/collections/{id}', 'destroy')->name('collection.delete');

            // AJAX Routes for Category Search
            Route::get('/search-categories', 'searchCategories')->name('collection.search-categories');
        });
    });
});
