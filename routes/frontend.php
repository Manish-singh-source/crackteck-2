<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\FrontendAuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FrontendEcommerceController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('beta')->group(function () {
    // Login routes
    // Route::get('/register', [FrontendAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FrontendAuthController::class, 'register'])->name('frontend.register');

    // Route::get('/login', [FrontendAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FrontendAuthController::class, 'login'])->name('frontend.login');

    Route::post('/frontend-logout', [FrontendAuthController::class, 'logout'])->name('frontend.logout');

    // E-commerce Authentication Routes
    Route::get('/e-commerce/login', [FrontendAuthController::class, 'showEcommerceLogin'])->name('ecommerce.login');
    Route::get('/e-commerce/signup', [FrontendAuthController::class, 'showEcommerceSignup'])->name('ecommerce.signup');
    Route::post('/e-commerce/login', [FrontendAuthController::class, 'ecommerceLogin'])->name('ecommerce.login.post');
    Route::post('/e-commerce/signup', [FrontendAuthController::class, 'ecommerceSignup'])->name('ecommerce.signup.post');

    // Home
    Route::get('/', [FrontendController::class, 'index'])->name('website');

    // Shop
    // Route::get('/shop', function () {
    //     return view('frontend/shop');
    // })->name('shop');

    // E-commerce Routes
    Route::get('/e-commerce/shop', [FrontendEcommerceController::class, 'shop'])->name('shop');
    Route::get('/e-commerce/product/{id}', [FrontendEcommerceController::class, 'productDetail'])->name('ecommerce.product.detail');
    Route::get('/product-detail/{id}', [FrontendEcommerceController::class, 'productDetail'])->name('product.detail');
    Route::get('/product/get', [FrontendController::class, 'getProduct'])->name('product.get');

    // Shop Filter API Routes
    Route::get('/api/shop/categories', [FrontendEcommerceController::class, 'getCategories'])->name('shop.categories');
    Route::get('/api/shop/brands', [FrontendEcommerceController::class, 'getBrands'])->name('shop.brands');
    Route::get('/api/shop/filter-products', [FrontendEcommerceController::class, 'filterProducts'])->name('shop.filter');

    // About US
    Route::get('/about-us', function () {
        return view('frontend/about');
    })->name('about');

    // AMC Plans
    Route::get('/amc', [FrontendController::class, 'amcPlans'])->name('amc');

    Route::get('/non-amc', function () {
        return view('frontend/non-amc');
    })->name('non-amc');

    // AMC Form API Routes
    Route::get('/api/amc/categories', [FrontendController::class, 'getProductCategories'])->name('amc.categories');
    Route::get('/api/amc/brands', [FrontendController::class, 'getBrands'])->name('amc.brands');
    Route::get('/api/amc/plans', [FrontendController::class, 'getAmcPlansData'])->name('amc.plans');
    Route::post('/api/amc/check-email', [FrontendController::class, 'checkCustomerEmail'])->name('amc.check-email');
    Route::post('/api/amc/get-customer-data', [FrontendController::class, 'getCustomerData'])->name('amc.get-customer-data');
    Route::post('/api/amc/submit', [FrontendController::class, 'submitAmcRequest'])->name('amc.submit');
    Route::post('/api/non-amc/submit', [FrontendController::class, 'submitNonAmcRequest'])->name('non-amc.submit');
    
    // Customer Check Login API Route
    Route::get('/api/customer/check-login', [FrontendController::class, 'checkCustomerLogin'])->name('customer.check-login');

    // Contact US
    Route::get('/contact-us', function () {
        return view('frontend/contact');
    })->name('contact');
    Route::post('/contact-us', [FrontendController::class, 'storeContact'])->name('contact.store');

    // AMC
    // Route::get('/amc', function () {
    //     return view('frontend/amc');
    // })->name('amc');

    // AMC Detail
    Route::get('/amc-detail', function () {
        return view('frontend/amc-details');
    })->name('amc-details');

    // Wishlist Routes
    Route::controller(WishlistController::class)->group(function () {
        // Display wishlist page (requires authentication)
        Route::get('/wishlist', 'index')->name('wishlist')->middleware('auth:customer_web');

        // AJAX routes for wishlist operations (auth handled in controller)
        Route::post('/wishlist/add', 'store')->name('wishlist.add');
        Route::post('/wishlist/toggle', 'toggleWishlist')->name('wishlist.toggle');
        Route::delete('/wishlist/{id}', 'destroy')->name('wishlist.remove');
        Route::post('/wishlist/{id}/move-to-cart', 'moveToCart')->name('wishlist.move-to-cart');

        // Wishlist count (can be accessed without auth, returns 0 for guests)
        Route::get('/wishlist/count', 'getWishlistCount')->name('wishlist.count');

        // Check wishlist status
        Route::post('/wishlist/check-status', 'checkWishlistStatus')->name('wishlist.check-status');
    });

    // Cart Routes
    Route::controller(CartController::class)->group(function () {
        // Display cart page (requires authentication)
        Route::get('/shop-cart', 'index')->name('shop-cart')->middleware('auth:customer_web');

        // AJAX routes for cart operations (auth handled in controller)
        Route::post('/cart/add', 'store')->name('cart.add');
        Route::post('/cart/toggle', 'toggleCart')->name('cart.toggle');
        Route::post('/cart/buy-now', 'buyNow')->name('cart.buy-now');
        Route::put('/cart/update/{id}', 'update')->name('cart.update');
        Route::delete('/cart/remove/{id}', 'destroy')->name('cart.remove');
        Route::get('/cart/data', 'getCartData')->name('cart.data');
        Route::post('/cart/check-status', 'checkCartStatus')->name('cart.check-status');
    });

    // Coupon Application Routes
    Route::controller(App\Http\Controllers\CouponApplicationController::class)->middleware('auth:customer_web')->group(function () {
        Route::post('/cart/apply-coupon', 'applyCoupon')->name('cart.apply-coupon');
        Route::post('/cart/remove-coupon', 'removeCoupon')->name('cart.remove-coupon');
        Route::get('/cart/applied-coupon', 'getAppliedCoupon')->name('cart.applied-coupon');
    });

    // Cart count route (can be accessed without auth, returns 0 for guests)
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

    // Compare Routes
    Route::controller(CompareController::class)->group(function () {
        // Display compare page
        Route::get('/compare', 'index')->name('compare');

        // AJAX routes for compare operations
        Route::post('/compare/add', 'addToCompare')->name('compare.add');
        Route::delete('/compare/remove/{id}', 'removeFromCompare')->name('compare.remove');
        Route::post('/compare/clear', 'clearCompare')->name('compare.clear');
        Route::get('/compare/data', 'getCompareData')->name('compare.data');
        Route::get('/compare/count', 'getCompareCount')->name('compare.count');
        Route::post('/compare/check-status', 'checkCompareStatus')->name('compare.check-status');
    });

    // Terms & Conditions
    Route::get('/t&c', function () {
        return view('frontend/t&c');
    })->name('t&c');

    // Shipping Information
    Route::get('/shipping-info', function () {
        return view('frontend/shipping-info');
    })->name('shipping-info');

    // Return & Refund Policy
    Route::get('/return-refund-policy', function () {
        return view('frontend/return-refund-policy');
    })->name('return-refund-policy');

    // Privacy Policy
    Route::get('/privacy', function () {
        return view('frontend/privacy');
    })->name('privacy');

    // FAQ
    Route::get('/faq', function () {
        return view('frontend/faq');
    })->name('faq');

    // Checkout Routes
    Route::controller(CheckoutController::class)->group(function () {
        // Display checkout page (requires authentication)
        Route::get('/checkout', 'index')->name('checkout')->middleware('auth:customer_web');

        // AJAX routes for checkout operations (require authentication)
        Route::middleware('auth:customer_web')->group(function () {
            Route::post('/checkout/place-order', 'store')->name('checkout.store');
            Route::get('/checkout/addresses', 'getUserAddresses')->name('checkout.addresses');
            Route::post('/checkout/save-address', 'saveAddress')->name('checkout.save-address');
        });

        // Order details page (requires authentication)
        Route::get('/order-details/{orderNumber}', 'orderDetails')->name('order-details')->middleware('auth:customer_web');
    });

    // Product Detail
    Route::get('/product-detail', function () {
        return view('frontend/product-detail');
    })->name('product-detail');

    // Track Your Order Routes
    Route::controller(OrderTrackingController::class)->group(function () {
        Route::get('/track-your-order', 'index')->name('track-your-order');
        Route::post('/track-your-order/search', 'searchOrder')->name('track-order.search');
    });

    // My Account order
    Route::get('/my-account-orders', [CheckoutController::class, 'myAccountOrders'])
        ->name('my-account-orders')->middleware('auth:customer_web');

    // My Account Address
    Route::get('/my-account-address', [MyAccountController::class, 'addresses'])
        ->name('my-account-address')->middleware('auth:customer_web');

    // My Account Address AJAX Routes
    Route::middleware('auth:customer_web')->group(function () {
        Route::post('/my-account/address', [MyAccountController::class, 'storeAddress'])->name('my-account.address.store');
        Route::get('/my-account/address/{id}', [MyAccountController::class, 'getAddress'])->name('my-account.address.get');
        Route::put('/my-account/address/{id}', [MyAccountController::class, 'updateAddress'])->name('my-account.address.update');
        Route::delete('/my-account/address/{id}', [MyAccountController::class, 'deleteAddress'])->name('my-account.address.delete');

        // Profile update route
        Route::put('/my-account/profile', [MyAccountController::class, 'updateProfile'])->name('my-account.profile.update');

        // Password update route
        Route::put('/my-account/password', [MyAccountController::class, 'updatePassword'])->name('my-account.password.update');
    });

    // My Account Edit
    Route::get('/my-account-edit', [MyAccountController::class, 'accountDetails'])
        ->name('my-account-edit')->middleware('auth:customer_web');

    // My Account Password
    Route::get('/my-account-password', [MyAccountController::class, 'changePassword'])
        ->name('my-account-password')->middleware('auth:customer_web');

    // My Account AMC
    Route::get('/my-account-amc', [MyAccountController::class, 'amcServices'])
        ->name('my-account-amc')->middleware('auth:customer_web');

    // My Account AMC Service Details
    Route::get('/my-account-amc/{id}', [MyAccountController::class, 'viewAmcService'])
        ->name('my-account-amc.view')->middleware('auth:customer_web');

    // My Account Non-AMC
    Route::get('/my-account-non-amc', [MyAccountController::class, 'nonAmcServices'])
        ->name('my-account-non-amc')->middleware('auth:customer_web');

    // My Account
    Route::get('/my-account', function () {
        return view('frontend/my-account');
    })->name('my-account');

    // 404
    // Route::get('/404', function () {
    //     return view('frontend/404');
    // })->name('404');

    // Order Details route is now handled by CheckoutController

    Route::fallback(function () {
        return view('frontend/404');
    });

    Route::controller(SubscriberController::class)->group(function () {
        Route::post('/newsletter/subscribe', 'subscribe')->name('newsletter.subscribe');
    });

    // Product Deal
    Route::get('/product-deals', [FrontendEcommerceController::class, 'productDeals'])->name('ecommerce-product-detail');

    // Collections Routes
    Route::get('/collections/{id}', [FrontendController::class, 'collectionDetails'])->name('collection.details');
});
