<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ProductDealController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\EcommerceOrderController;
use App\Http\Controllers\ProductVariantsController;
use App\Http\Controllers\EcommerceProductController;

// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
// **************************************************************      E-Commerce      *******************************************************************
// *******************************************************************************************************************************************************
// *******************************************************************************************************************************************************
Route::prefix('/demo/e-commerce')->group(function () {
    // Index Page
    Route::get('/index', function () {
        return view('/e-commerce/index');
    })->name('e-commerce/index');

    // ------------------------------------------------------------ E-Commerce Customer Page -------------------------------------------------------------

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'ec_index')->name('ec.customer.index');
        Route::get('/create-customer', 'ec_create')->name('ec.customer.create');
        Route::post('/store-customer', 'store')->name('ec.customer.store');
        Route::get('/view-customer/{id}', 'ec_view')->name('ec.customer.view');
        Route::get('/edit-customer/{id}', 'ec_edit')->name('ec.customer.edit');
        Route::put('/update-customer/{id}', 'update')->name('ec.customer.update');
        Route::delete('/delete-customer/{id}', 'ec_delete')->name('ec.customer.delete');
    });

    // ------------------------------------------------------------ E-Commerce Order Page -------------------------------------------------------------
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order', 'index')->name('order.index');
        Route::get('/create-order', 'create')->name('order.create');
        Route::post('/order', 'store')->name('order.store');
        Route::get('/order/{id}/edit', 'edit')->name('order.edit');
        Route::put('/order/{id}', 'update')->name('order.update');
        Route::delete('/order/{id}', 'destroy')->name('order.delete');
        Route::post('/orders/bulk-delete', 'bulkDestroy')->name('order.bulk-delete');
        Route::get('/view-order/{id}', 'show')->name('order.view');
        Route::put('/order/{id}/assign-person', 'assignPerson')->name('order.assign-person');
        Route::get('/order/{id}/invoice', 'generateInvoice')->name('order.invoice');
        Route::get('/delivery-men-by-city/{city}', 'getDeliveryMenByCity')->name('order.delivery-men-by-city');
        Route::post('/order/{id}/assign-delivery-man', 'assignDeliveryMan')->name('order.assign-delivery-man');
        Route::post('/order/{id}/update-status', 'updateStatus')->name('order.update-status');
        Route::get('/search-customers', 'searchCustomers')->name('order.search-customers');
        Route::get('/search-products', 'searchProducts')->name('order.search-products');
    });


    // // ------------------------------------------------------------ E-Commerce Orders Management -------------------------------------------------------------

    // Route::controller(EcommerceOrderController::class)->group(function () {
    //     // Ecommerce Orders List Page
    //     Route::get('/ecommerce-orders', 'index')->name('ecommerce-order.index');
    //     // View Ecommerce Order Details
    //     Route::get('/ecommerce-order/{id}', 'show')->name('ecommerce-order.show');
    //     // Update Order Status (AJAX)
    //     Route::post('/ecommerce-order/{id}/update-status', 'updateStatus')->name('ecommerce-order.update-status');
    //     // Generate PDF Invoice
    //     Route::get('/ecommerce-order/{id}/invoice', 'generateInvoice')->name('ecommerce-order.invoice');
    //     // Bulk Delete Orders (AJAX)
    //     Route::post('/ecommerce-orders/bulk-delete', 'bulkDestroy')->name('ecommerce-order.bulk-delete');
    // });

    // ------------------------------------------------------------ E-Commerce Products Page -------------------------------------------------------------
    Route::controller(EcommerceProductController::class)->group(function () {
        Route::get('/products', 'index')->name('ec.product.index');
        Route::get('/create-product', 'create')->name('ec.product.create');
        Route::post('/create-product', 'store')->name('ec.product.store');
        Route::get('/view-product/{id}', 'show')->name('ec.product.view');
        Route::get('/edit-product/{id}', 'edit')->name('ec.product.edit');
        Route::put('/edit-product/{id}', 'update')->name('ec.product.update');
        Route::delete('/delete-product/{id}', 'destroy')->name('ec.product.delete');

        // AJAX Routes for Warehouse Product Search
        Route::get('/search-warehouse-products', 'searchWarehouseProducts')->name('ec.product.search-warehouse');
        Route::get('/get-warehouse-product/{id}', 'getWarehouseProduct')->name('ec.product.get-warehouse');
        // AJAX SKU Validation
        Route::get('/check-sku-unique', 'checkSkuUnique')->name('ec.product.check-sku');
    });

    Route::controller(ProductListController::class)->group(function () {
        Route::get('/scrap-items', 'ec_scrapItems')->name('scrap-items');
    });

    // ------------------------------------------------------------ E-Commerce Categories Page -------------------------------------------------------------
    Route::controller(CategorieController::class)->group(function () {
        Route::get('/categories', 'index')->name('category.index');
        Route::get('/create-categorie', 'create')->name('category.create');
        Route::post('/store-parent-categorie', 'storeParent')->name('parent.category.store');
        Route::post('/store-sub-categorie', 'storeSubCategorie')->name('sub.category.store');

        Route::delete('/delete-categorie/{id}', 'delete')->name('category.delete');

        // Route::post('/store-categorie' ,'store')->name('category.store');
        Route::get('/view-categorie/{id}', 'parentCategorie')->name('categorie.view');
        Route::get('/edit-categorie/{id}', 'edit')->name('category.edit');
        Route::put('/update-categorie/{id}', 'update')->name('category.update');
        Route::get('/edit-child-categorie/{id}', 'editChild')->name('child.category.edit');
        Route::put('/update-child-categorie/{id}', 'updateChild')->name('child.category.update');
        Route::delete('/delete-child-categorie/{id}', 'destroyChild')->name('child.category.delete');
        Route::post('/update-category-order', 'updateOrder')->name('category.update.order');
        Route::get('/get-child-category-data/{id}', 'getChildCategoryData')->name('child.category.data');
        Route::get('/check-sort-order-unique', 'checkSortOrderUnique')->name('category.check-sort-order');
    });
    // ------------------------------------------------------------ E-Commerce Brands Page -------------------------------------------------------------
    Route::controller(BrandController::class)->group(function () {
        Route::get('/brands', 'index')->name('brand.index');
        Route::get('/create-brand', 'create')->name('brand.create');
        Route::post('/store-brand', 'store')->name('brand.store');
        Route::get('/edit-brand/{id}', 'edit')->name('brand.edit');
        Route::put('/update-brand/{id}', 'update')->name('brand.update');
        Route::delete('/delete-brand/{id}', 'delete')->name('brand.delete');
    });

    // ------------------------------------------------------------ E-Commerce Product Variants Page -------------------------------------------------------------
    Route::controller(ProductVariantsController::class)->group(function () {
        Route::get('/product-variants', 'index')->name('variant.index');
        Route::post('/store-product-attribute', 'storeAttribute')->name('variant.store');
        Route::post('/store-product-attribute-value', 'storeAttributeValue')->name('variant.store.attribute.value');
        Route::get('/product-attribute-list/{id}', 'view')->name('variant.view');
        Route::delete('/delete-product-attribute/{id}', 'deleteAttribute')->name('variant.delete');

        Route::get('/edit-product-attribute/{id}', 'editAttribute')->name('variant.edit');
        Route::put('/update-product-attribute/{id}', 'updateAttribute')->name('variant.update');
        Route::put('/update-product-attribute-value/{id}', 'updateAttributeValue')->name('variant.update.attribute.value');
        Route::delete('/delete-product-attribute-value/{id}', 'deleteAttributeValue')->name('variant.delete.attribute.value');
    });

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
            Route::post('/remove-product-from-deal', 'removeProductFromDeal')->name('product-deals.remove-product');
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
