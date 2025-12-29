@extends('frontend/layout/master')

@section('main-content')

    <!-- Breadcrumb -->
    {{-- <div class="tf-breadcrumb">
        <div class="container">
            <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
                <div class="tf-breadcrumb-list">
                    <a href="{{ route('website') }}" class="text">Home</a>
                    <i class="icon icon-arrow-right"></i>
                    <a href="#" class="text">Collections</a>
                    <i class="icon icon-arrow-right"></i>
                    <span class="text">{{ $collection->title }}</span>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="tf-sp-1">
    <div class="container">
        <ul class="breakcrumbs">
            <li>
                <a href="{{ route('website') }}" class="body-small link">
                    Home
                </a>
            </li>
            <li class="d-flex align-items-center">
                <i class="icon icon-arrow-right"></i>
            </li>
            <li>
                <span class="body-small">Collections</span>
            </li>
            <li class="d-flex align-items-center">
                <i class="icon icon-arrow-right"></i>
            </li>
            <li>
                <span class="body-small">{{ $collection->title }}</span>
            </li>
        </ul>
    </div>
</div>
    <!-- /Breadcrumb -->

    <!-- Collection Header -->
    {{-- <section class="flat-spacing-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="collection-image">
                    @if ($collection->image)
                        <img src="{{ asset($collection->image) }}" alt="{{ $collection->title }}" class="img-fluid rounded">
                    @else
                        <img src="{{ asset('images/default-collection.png') }}" alt="Default Collection" class="img-fluid rounded">
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="collection-info">
                    <h1 class="collection-title">{{ $collection->title }}</h1>
                    @if ($collection->description)
                        <div class="collection-description mt-3">
                            <p>{{ $collection->description }}</p>
                        </div>
                    @endif
                    <div class="collection-stats mt-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <h4>{{ $collection->categories->count() }}</h4>
                                    <p class="text-muted">Categories</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <h4>{{ $products->total() }}</h4>
                                    <p class="text-muted">Products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="collection-categories mt-4">
                        <h5>Categories in this collection:</h5>
                        <div class="category-tags mt-2">
                            @foreach ($collection->categories as $category)
                                <span class="badge bg-primary me-2 mb-2">{{ $category->parent_categories }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}



    <div class="flat-content mb-5">
        <div class="container">
            <div class="tf-product-view-content wrapper-control-shop">
                <div class="canvas-filter-product sidebar-filter handle-canvas left">
                    <div class="canvas-wrapper">
                        <div class="canvas-header d-flex d-xl-none">
                            <h5 class="title">Filter</h5>
                            <span class="icon-close link icon-close-popup close-filter" data-bs-dismiss="offcanvas"></span>
                        </div>
                        <div class="canvas-body">
                            <div class="widget-facet facet-fieldset has-loadmore">
                                <p class="facet-title title-sidebar fw-semibold">Brand</p>
                                <div class="box-fieldset-item">
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="razer">
                                        <label for="razer">Hp</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="corsair">
                                        <label for="corsair">Dell</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="steelseri">
                                        <label for="steelseri">Apple</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="hyperx">
                                        <label for="hyperx">Lenovo</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="jbl">
                                        <label for="jbl">Logitech</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="logitech-g">
                                        <label for="logitech-g">Samsung</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="logitech">
                                        <label for="logitech">Sony </label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="steelseri2">
                                        <label for="steelseri2">Microsoft</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="brand" class="tf-check" id="hyperx2">
                                        <label for="hyperx2">Xiaomi </label>
                                    </fieldset>
                                </div>
                                <div class="btn-loadmore">See more <i class="icon-arrow-down"></i></div>
                            </div>
                            <div class="widget-facet facet-price">
                                <p class="facet-title title-sidebar fw-semibold">Price</p>
                                <div class="box-fieldset-item">
                                    <fieldset class="fieldset-item">
                                        <input type="radio" name="price" class="tf-check" id="u10">
                                        <label for="u10">Under ₹10</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="radio" name="price" class="tf-check" id="u15">
                                        <label for="u15">₹10 to ₹15</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="radio" name="price" class="tf-check" id="u25">
                                        <label for="u25">₹15 to ₹25</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="radio" name="price" class="tf-check" id="up35">
                                        <label for="up35">₹35 &amp; Above</label>
                                    </fieldset>
                                </div>
                                <div class="box-price-product">
                                    <form class="w-100 form-filter-price">
                                        <div class="cols w-100">
                                            <fieldset class="box-price-item">
                                                <input type="number" class="min-price price-input" name="price"
                                                    placeholder="₹ Min">
                                            </fieldset>
                                            <span class="br-line"></span>
                                            <fieldset class="box-price-item">
                                                <input type="number" class="max-price price-input" name="price"
                                                    placeholder="₹ Max">
                                            </fieldset>
                                        </div>
                                        <div class="btn-filter-price cs-pointer link">
                                            <span class="title-sidebar fw-bold">
                                                Go
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- <div class="widget-facet facet-vote">
                                        <p class="facet-title title-sidebar fw-semibold">Customer Review</p>
                                        <div class="box-fieldset-item">
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="starRate" class="tf-check" id="fiveStar">
                                                <label for="fiveStar">
                                                    <span class="list-star">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                    </span>
                                                </label>
                                            </fieldset>
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="starRate" class="tf-check" id="fourStar">
                                                <label for="fourStar">
                                                    <span class="list-star">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                    </span>
                                                    <span class="body-text-3">& Up</span>
                                                </label>
                                            </fieldset>
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="starRate" class="tf-check" id="threeStar">
                                                <label for="threeStar">
                                                    <span class="list-star">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                    </span>
                                                    <span class="body-text-3">& Up</span>
                                                </label>
                                            </fieldset>
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="starRate" class="tf-check" id="twoStar">
                                                <label for="twoStar">
                                                    <span class="list-star">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                    </span>
                                                    <span class="body-text-3">& Up</span>
                                                </label>
                                            </fieldset>
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="starRate" class="tf-check" id="oneStar">
                                                <label for="oneStar">
                                                    <span class="list-star">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                        <i class="icon-star text-main-4"></i>
                                                    </span>
                                                    <span class="body-text-3">& Up</span>
                                                </label>
                                            </fieldset>
                                        </div>
                                    </div> -->
                            <!-- <div class="widget-facet facet-fieldset">
                                        <p class="facet-title title-sidebar fw-semibold">Condition</p>
                                        <div class="box-fieldset-item">
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="condition" class="tf-check" id="inNew">
                                                <label for="inNew">New</label>
                                            </fieldset>
                                            <fieldset class="fieldset-item">
                                                <input type="radio" name="condition" class="tf-check" id="inUsed">
                                                <label for="inUsed">Used</label>
                                            </fieldset>
                                        </div>
                                    </div> -->
                            <div class="widget-facet facet-fieldset">
                                <p class="facet-title title-sidebar fw-semibold">Deals &amp; Discounts</p>
                                <div class="box-fieldset-item">
                                    <fieldset class="fieldset-item">
                                        <input type="radio" name="deal" class="tf-check" id="dealAll">
                                        <label for="dealAll">All Discounts</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="radio" name="deal" class="tf-check" id="dealToday">
                                        <label for="dealToday">Today’s Deals</label>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="canvas-bottom d-flex d-xl-none">
                            <button id="reset-filter" class="tf-btn btn-reset w-100">
                                <span class="caption text-white">Reset Filters</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tf-shop-content">
                    <div class="tf-shop-control flex-wrap gap-10">
                        <div class="tf-control-view flat-title-tab-product flex-wrap">
                            <ul class="tf-control-layout menu-tab-line" role="tablist">
                                <li class="tf-view-layout-switch" data-tab="tabgrid-1">
                                    <a href="#" class="tab-link main-title link fw-semibold d-flex"
                                        data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                        <i class="icon-menu-dots"></i>
                                    </a>
                                </li>
                                <li class="tf-view-layout-switch" data-tab="tabgrid-2">
                                    <a href="#" class="tab-link main-title link d-flex fw-semibold"
                                        data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                        <i class="icon-dot-line"></i>
                                    </a>
                                </li>
                                <li class="tf-view-layout-switch active" data-tab="tablist-1">
                                    <a href="#" class="tab-link main-title link d-flex fw-semibold active"
                                        data-bs-toggle="tab" aria-selected="true" role="tab">
                                        <i class="icon-list-1"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="tf-dropdown-sort tf-sort type-sort-by" data-bs-toggle="dropdown">
                                <div class="btn-select w-100">
                                    <i class="icon-sort"></i>
                                    <p class="body-text-3 w-100">Sort by: <span class="text-sort-value">Featured</span>
                                    </p>
                                    <i class="icon-arrow-down fs-10"></i>
                                </div>
                                <div class="dropdown-menu">
                                    <div class="select-item" data-sort-value="best-selling">
                                        <span class="text-value-item">Featured</span>
                                    </div>
                                    <div class="select-item" data-sort-value="a-z">
                                        <span class="text-value-item">Alphabetically, A-Z</span>
                                    </div>
                                    <div class="select-item" data-sort-value="z-a">
                                        <span class="text-value-item">Alphabetically, Z-A</span>
                                    </div>
                                    <div class="select-item" data-sort-value="price-low-high">
                                        <span class="text-value-item">Price, low to high</span>
                                    </div>
                                    <div class="select-item" data-sort-value="price-high-low">
                                        <span class="text-value-item">Price, high to low</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="meta-filter-shop" style="display: flex;">
                        <div id="product-count-grid" class="count-text"></div>
                        <div id="product-count-list" class="count-text"></div>
                        <div id="applied-filters"></div>
                        <button id="remove-all" class="remove-all-filters" style="display: none;">
                            <span class="caption">REMOVE ALL</span>
                            <i class="icon icon-close"></i>
                        </button>
                    </div>
                    <div class="gridLayout-wrapper">
                        <div class="tf-grid-layout flat-grid-product wrapper-shop layout-tabgrid-1" id="gridLayout">
                            @if ($products->count() > 0)
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                                            <div class="card-product">
                                                <div class="card-product-wrapper">
                                                    <a href="{{ route('product.detail', $product->id) }}" class="product-img">
                                                        @if ($product->main_product_image)
                                                            <img class="lazyload img-product"
                                                                data-src="{{ asset($product->main_product_image) }}"
                                                                src="{{ asset($product->main_product_image) }}"
                                                                alt="{{ $product->product_name }}">
                                                            @if ($product->additional_product_images && count($product->additional_product_images) > 0)
                                                                <img class="img-hover lazyload"
                                                                    src="{{ asset($product->additional_product_images[0]) }}"
                                                                    data-src="{{ asset($product->additional_product_images[0]) }}"
                                                                    alt="{{ $product->product_name }}">
                                                            @endif
                                                        @else
                                                            <img class="lazyload img-product"
                                                                data-src="{{ asset('images/default-product.png') }}"
                                                                src="{{ asset('images/default-product.png') }}"
                                                                alt="Default Product">
                                                        @endif
                                                    </a>
                                                    <ul class="list-product-btn top-0 end-0">
                                                        <li>
                                                            <a href="#;"
                                                                class="box-icon add-to-cart-btn btn-icon-action hover-tooltip tooltip-left"
                                                                data-product-id="{{ $product->id }}"
                                                                data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                                <span class="icon icon-cart2"></span>
                                                                <span class="tooltip">Add to Cart</span>
                                                            </a>
                                                        </li>
                                                        <li class="wishlist">
                                                            <a href="#;"
                                                                class="box-icon btn-icon-action hover-tooltip tooltip-left add-to-wishlist-btn"
                                                                data-product-id="{{ $product->id }}"
                                                                data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                                <span class="icon icon-heart2"></span>
                                                                <span class="tooltip">Add to Wishlist</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#quickView" data-bs-toggle="modal"
                                                                class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                                <span class="icon icon-view"></span>
                                                                <span class="tooltip">Quick View</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-product-info">
                                                    @if ($product->brand)
                                                        <div class="product-brand">
                                                            <small
                                                                class="text-muted">{{ $product->brand->brand_title }}</small>
                                                        </div>
                                                    @endif
                                                    <a href="#" class="name-product body-md-2 fw-semibold text-secondary link title link text-truncate" style="max-width: 260px;">{{ $product->product_name }}</a>
                                                    <span class="price">
                                                        @if ($product->discount_price && $product->discount_price < $product->selling_price)
                                                            <span
                                                                class="new-price fw-semibold text-primary fs-20">₹{{ number_format($product->selling_price, 2) }}</span>
                                                            <span
                                                                class="old-price">₹{{ number_format($product->cost_price, 2) }}</span>
                                                        @else
                                                            ₹{{ number_format($product->selling_price, 2) }}
                                                        @endif
                                                    </span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="tf-pagination-wrap view-more-button text-center">
                                    {{ $products->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <h4>No products found in this collection</h4>
                                    <p class="text-muted">This collection doesn't have any products yet.</p>
                                    <a href="{{ route('shop') }}" class="tf-btn btn-outline radius-3">
                                        <span>Browse All Products</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="tf-pagination-wrap view-more-button">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .collection-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .collection-info {
            padding-left: 2rem;
        }

        .collection-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .stat-item h4 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #007bff;
        }

        .category-tags .badge {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        @media (max-width: 768px) {
            .collection-info {
                padding-left: 0;
                margin-top: 2rem;
            }

            .collection-title {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add to Wishlist functionality
    $('.add-to-wishlist-btn').on('click', function(e) {
        e.preventDefault();

        const $button = $(this);
        const productId = $button.data('product-id');
        const productName = $button.data('product-name');

        // Check if user is authenticated (you can customize this check)
        @guest
            // Show login message for unauthenticated users
            showNotification('Please login to add products to your wishlist.', 'warning');
            return;
        @endguest

        // Show loading state
        const originalIcon = $button.find('.icon').attr('class');
        const originalTooltip = $button.find('.tooltip').text();

        $button.find('.icon').attr('class', 'icon icon-loading');
        $button.find('.tooltip').text('Adding...');
        $button.prop('disabled', true);

        // Make AJAX request
        $.ajax({
            url: '{{ route("wishlist.add") }}',
            method: 'POST',
            data: {
                ecommerce_product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Update button state to show it's in wishlist
                    $button.find('.icon').attr('class', 'icon icon-heart-fill');
                    $button.find('.tooltip').text('In Wishlist');
                    $button.addClass('in-wishlist');

                    // Update wishlist count if there's a counter
                    updateWishlistCount();
                } else {
                    showNotification(response.message, 'error');
                    // Reset button state
                    $button.find('.icon').attr('class', originalIcon);
                    $button.find('.tooltip').text(originalTooltip);
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while adding the product to your wishlist.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.status === 401) {
                    message = 'Please login to add products to your wishlist.';
                } else if (xhr.status === 409) {
                    message = 'This product is already in your wishlist.';
                }

                showNotification(message, 'error');

                // Reset button state
                $button.find('.icon').attr('class', originalIcon);
                $button.find('.tooltip').text(originalTooltip);
            },
            complete: function() {
                $button.prop('disabled', false);
            }
        });
    });

    // Function to show notifications
    function showNotification(message, type) {
        // Create notification element
        const notification = $(`
            <div class="notification notification-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : type === 'warning' ? '#ffc107' : '#dc3545'};
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                max-width: 300px;
                word-wrap: break-word;
            ">
                ${message}
            </div>
        `);

        // Add to body
        $('body').append(notification);

        // Auto remove after 5 seconds
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);

        // Allow manual close on click
        notification.on('click', function() {
            $(this).fadeOut(300, function() {
                $(this).remove();
            });
        });
    }

    // Wishlist count function is now global in master layout

    // Add to Cart functionality
    $('.add-to-cart-btn').on('click', function(e) {
        e.preventDefault();

        const $button = $(this);
        const productId = $button.data('product-id');
        const productName = $button.data('product-name');

        // Check if user is authenticated
        @guest
            // Show login modal for unauthenticated users
            showLoginModal();
            return;
        @endguest

        // Show loading state
        const originalText = $button.find('span').text();
        $button.find('span').text('Adding...');
        $button.prop('disabled', true);

        // Make AJAX request
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                ecommerce_product_id: productId,
                quantity: 1
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Update button state
                    $button.find('span').text('Added to Cart');
                    $button.addClass('in-cart');

                    // Update cart count and sidebar
                    updateCartCount();
                    updateCartSidebar();
                } else {
                    showNotification(response.message, 'error');
                    // Reset button state
                    $button.find('span').text(originalText);
                }
            },
            error: function(xhr) {
                if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON.requires_auth) {
                    showLoginModal();
                } else {
                    showNotification('Error adding product to cart. Please try again.', 'error');
                    // Reset button state
                    $button.find('span').text(originalText);
                }
            },
            complete: function() {
                $button.prop('disabled', false);
            }
        });
    });

    // Cart count function is now global in master layout

    // Function to update cart sidebar
    function updateCartSidebar() {
        $.ajax({
            url: '{{ route("cart.data") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Update cart sidebar content
                    updateCartSidebarContent(response);
                }
            },
            error: function() {
                console.log('Error updating cart sidebar');
            }
        });
    }

    // Function to show login modal
    function showLoginModal() {
        // Create and show login modal
        const modalHtml = `
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p>Please login to add products to your cart.</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('ecommerce.login') }}" class="btn btn-primary">Login</a>
                                <a href="{{ route('ecommerce.signup') }}" class="btn btn-outline-primary">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        $('#loginModal').remove();

        // Add modal to body and show
        $('body').append(modalHtml);
        $('#loginModal').modal('show');
    }

    // Initialize counts on page load
    updateWishlistCount();
    updateCartCount();
});
</script>
@endsection
