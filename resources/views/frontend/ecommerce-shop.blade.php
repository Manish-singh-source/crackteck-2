@extends('frontend/layout/master')

@push('styles')
    <style>
        /* Filter Tags Styling */
        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }

        .filter-tag .remove-tag {
            cursor: pointer;
            font-size: 12px;
            color: #666;
            transition: color 0.2s;
        }

        .filter-tag .remove-tag:hover {
            color: #d32f2f;
        }

        .meta-filter-shop {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        #applied-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            flex: 1;
        }

        .remove-all-filters {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .remove-all-filters:hover {
            background-color: #b71c1c;
        }

        #product-count-grid {
            font-weight: 600;
            color: #333;
        }

        /* Loading spinner */
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Active state styles for cart, wishlist, and compare buttons */
        .box-icon.in-cart .icon-cart2,
        .add-to-cart-btn.in-cart .icon-cart-2 {
            color: #ff0080 !important;
        }

        .box-icon.in-wishlist .icon-heart2 {
            color: #FF3D3D !important;
            fill: #FF3D3D !important;
        }

        .box-icon.in-compare .icon-compare1 {
            color: #004EC3 !important;
        }

        /* Button active states */
        .tf-btn.in-cart {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
        }

        .tf-btn.in-cart:hover {
            background-color: #218838 !important;
        }
    </style>
@endpush

@section('main-content')

    <!-- Breakcrumbs -->
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
                    <span class="body-small">Product Grid</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Main Content -->
    <div class="flat-content mb-5">
        <div class="container">
            <div class="tf-product-view-content wrapper-control-shop">
                <div class="canvas-filter-product sidebar-filter handle-canvas left"
                    style="border: 1px solid #e9e9e9; padding: 20px;">
                    <div class="canvas-wrapper">
                        <div class="canvas-header d-flex d-xl-none">
                            <h5 class="title">Filter</h5>
                            <span class="icon-close link icon-close-popup close-filter" data-bs-dismiss="offcanvas"></span>
                        </div>
                        <div class="canvas-body">
                            {{-- <div class="facet-categories">
                                <h6 class="title fw-medium">Show all categories</h6>
                                <div class="box-fieldset-item">
                                    @forelse($categories as $category)
                                        <fieldset class="fieldset-item">
                                            <input type="checkbox" name="category" class="tf-check category-filter"
                                                id="category-{{ $category->id }}" value="{{ $category->id }}">
                                            <label
                                                for="category-{{ $category->id }}">{{ $category->parent_categories }}</label>
                                        </fieldset>
                                    @empty
                                        <p class="text-muted">No categories available</p>
                                    @endforelse
                                </div>
                            </div> --}}

                            <div class="widget-facet facet-fieldset has-loadmore">
                                <p class="facet-title title-sidebar fw-semibold">Categories</p>
                                <div class="box-fieldset-item">
                                    @forelse($categories as $category)
                                        <fieldset class="fieldset-item">
                                            <input type="checkbox" name="category" class="tf-check category-filter"
                                                id="category-{{ $category->id }}" value="{{ $category->id }}">
                                            <label
                                                for="category-{{ $category->id }}">{{ $category->parent_categories }}</label>
                                        </fieldset>
                                    @empty
                                        <p class="text-muted">No categories available</p>
                                    @endforelse
                                </div>
                                @if ($brands->count() > 5)
                                    <div class="btn-loadmore">See more <i class="icon-arrow-down"></i></div>
                                @endif
                            </div>

                            <div class="widget-facet facet-fieldset has-loadmore">
                                <p class="facet-title title-sidebar fw-semibold">Brand</p>
                                <div class="box-fieldset-item">
                                    @forelse($brands as $brand)
                                        <fieldset class="fieldset-item">
                                            <input type="checkbox" name="brand" class="tf-check brand-filter"
                                                id="brand-{{ $brand->id }}" value="{{ $brand->id }}">
                                            <label for="brand-{{ $brand->id }}">{{ $brand->brand_title }}</label>
                                        </fieldset>
                                    @empty
                                        <p class="text-muted">No brands available</p>
                                    @endforelse
                                </div>
                                @if ($brands->count() > 5)
                                    <div class="btn-loadmore">See more <i class="icon-arrow-down"></i></div>
                                @endif
                            </div>
                            <div class="widget-facet facet-price">
                                <p class="facet-title title-sidebar fw-semibold">Price</p>
                                <div class="box-fieldset-item">
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="price_range" class="tf-check price-range-filter"
                                            id="under_10000" value="under_10000">
                                        <label for="under_10000">Under ₹10,000</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="price_range" class="tf-check price-range-filter"
                                            id="10000_15000" value="10000_15000">
                                        <label for="10000_15000">₹10,000 to ₹15,000</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="price_range" class="tf-check price-range-filter"
                                            id="15000_25000" value="15000_25000">
                                        <label for="15000_25000">₹15,000 to ₹25,000</label>
                                    </fieldset>
                                    <fieldset class="fieldset-item">
                                        <input type="checkbox" name="price_range" class="tf-check price-range-filter"
                                            id="above_35000" value="above_35000">
                                        <label for="above_35000">₹35,000 &amp; Above</label>
                                    </fieldset>
                                </div>
                                <div class="box-price-product">
                                    <p class="facet-title title-sidebar fw-semibold mb-3">Custom Price Range</p>
                                    <form class="w-100 form-filter-price" id="custom-price-form">
                                        <div class="cols w-100">
                                            <fieldset class="box-price-item">
                                                <input type="number" class="min-price price-input" id="custom-min-price"
                                                    name="min_price" placeholder="₹ Min" min="0">
                                            </fieldset>
                                            <span class="br-line"></span>
                                            <fieldset class="box-price-item">
                                                <input type="number" class="max-price price-input" id="custom-max-price"
                                                    name="max_price" placeholder="₹ Max" min="0">
                                            </fieldset>
                                        </div>
                                        <button type="button" class="btn-filter-price cs-pointer link"
                                            id="apply-custom-price">
                                            <span class="title-sidebar fw-bold">
                                                Go
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
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
                        {{-- <div class="d-flex align-items-center gap-10">
                        <button id="filterShop" class="tf-btn-filter d-flex d-xl-none">
                            <span class="icon icon-filter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#121212" viewBox="0 0 256 256">
                                    <path d="M176,80a8,8,0,0,1,8-8h32a8,8,0,0,1,0,16H184A8,8,0,0,1,176,80ZM40,88H144v16a8,8,0,0,0,16,0V56a8,8,0,0,0-16,0V72H40a8,8,0,0,0,0,16Zm176,80H120a8,8,0,0,0,0,16h96a8,8,0,0,0,0-16ZM88,144a8,8,0,0,0-8,8v16H40a8,8,0,0,0,0,16H80v16a8,8,0,0,0,16,0V152A8,8,0,0,0,88,144Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="body-md-2 fw-medium">Filter</span>
                        </button>
                        <p class="body-text-3 d-none d-lg-block">1-16 of 66 results for "
                            <span class="title-sidebar fw-bold">
                                hp
                            </span>"
                        </p>
                    </div> --}}
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

                            <div class=" type-sort-by">
                                <select id="sortBy" class="form-select">
                                    <option value="">Sort by</option>
                                    <option value="a-z">Alphabetically, A-Z</option>
                                    <option value="z-a">Alphabetically, Z-A</option>
                                    <option value="price-low-high">Price, low to high</option>
                                    <option value="price-high-low">Price, high to low</option>
                                </select>
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
                        <div class="tf-grid-layout lg-col-4 md-col-3 sm-col-2 flat-grid-product wrapper-shop layout-tabgrid-1"
                            id="gridLayout">
                            @forelse($products as $product)
                                <!-- Dynamic Product Item -->
                                <div class="card-product"
                                    data-condition="{{ $product->is_featured ? 'Featured' : 'New' }}"
                                    data-brand="{{ $product->warehouseProduct->brand->brand_title ?? '' }}"
                                    data-brand-id="{{ $product->warehouseProduct->brand_id ?? '' }}"
                                    data-category="{{ $product->warehouseProduct->parentCategorie->parent_categories ?? '' }}"
                                    data-category-id="{{ $product->warehouseProduct->parent_category_id ?? '' }}"
                                    data-price="{{ $product->warehouseProduct->discount_price > 0 ? $product->warehouseProduct->discount_price : $product->warehouseProduct->selling_price }}"
                                    data-deal="{{ $product->is_todays_deal ? 'Deal Today' : '' }}" data-rate="5 Star">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product.detail', $product->id) }}" class="product-img">
                                            @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                <img class="img-product lazyload"
                                                    src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                    data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                    alt="{{ $product->warehouseProduct->product_name }}">
                                                @if (
                                                    $product->warehouseProduct->additional_product_images &&
                                                        count($product->warehouseProduct->additional_product_images) > 0)
                                                    <img class="img-hover lazyload"
                                                        src="{{ asset($product->warehouseProduct->additional_product_images[0]) }}"
                                                        data-src="{{ asset($product->warehouseProduct->additional_product_images[0]) }}"
                                                        alt="{{ $product->warehouseProduct->product_name }}">
                                                @endif
                                            @else
                                                <img class="img-product lazyload"
                                                    src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                    data-src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                    alt="No Image">
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
                                                    <span><i class="fa-solid fa-heart"></i></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block">
                                                <a href="#;" id="compare"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left compare-btn"
                                                    data-product-id="{{ $product->id }}">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('product.detail', $product->id) }}"
                                                    data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                    class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </li>
                                        </ul>
                                        @if (
                                            $product->warehouseProduct &&
                                                $product->warehouseProduct->discount_price &&
                                                $product->warehouseProduct->selling_price > $product->warehouseProduct->discount_price)
                                            @php
                                                $discountPercent = round(
                                                    (($product->warehouseProduct->selling_price -
                                                        $product->warehouseProduct->discount_price) /
                                                        $product->warehouseProduct->selling_price) *
                                                        100,
                                                );
                                            @endphp
                                            <div class="box-sale-wrap pst-default">
                                                <p class="small-text">Sale</p>
                                                <p class="title-sidebar-2">{{ $discountPercent }}%</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div>
                                                @if ($product->warehouseProduct && $product->warehouseProduct->parentCategorie)
                                                    <p class="product-tag caption text-main-2">
                                                        {{ $product->warehouseProduct->parentCategorie->parent_categories }}
                                                    </p>
                                                @endif
                                                <a href="{{ route('product.detail', $product->id) }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link text-truncate"
                                                    style="max-width: 220px;">
                                                    {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                @if ($product->warehouseProduct)
                                                    @if ($product->warehouseProduct->final_price)
                                                        <span class="new-price price-text fw-medium">
                                                            ₹{{ number_format($product->warehouseProduct->final_price, 2) }}
                                                        </span>

                                                        @if ($product->warehouseProduct->discount_price > 0)
                                                            @php
                                                                $final = $product->warehouseProduct->final_price;
                                                                $discount = $product->warehouseProduct->discount_price;
                                                                $combined = $final + $discount;
                                                            @endphp
                                                            <span class="old-price body-md-2 text-main-2">
                                                                ₹{{ number_format($combined, 2) }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                @else
                                                    <span class="new-price price-text fw-medium">₹0.00</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="box-infor-detail">
                                            @if ($product->warehouseProduct && $product->warehouseProduct->short_description)
                                                <div class="product-description">
                                                    <p class="caption">{!! Str::limit($product->warehouseProduct->short_description, 100) !!}</p>
                                                </div>
                                            @endif
                                            <div class="star-review flex-wrap">
                                                <ul class="list-star">
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                </ul>
                                                <p class="caption text-main-2">({{ $product->total_sold }})</p>
                                            </div>
                                            {{-- <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                        stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="body-text-3 fw-normal">Compare</span>
                                            </a> --}}
                                        </div>
                                    </div>
                                    <div class="card-product-btn">
                                        <a href="#;" class="tf-btn btn-line w-100 add-to-cart-btn"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                            <span>Add to cart</span>
                                            <i class="icon-cart-2"></i>
                                        </a>
                                        <div class="box-btn">
                                            <a href="#compare" data-bs-toggle="offcanvas"
                                                class="tf-btn-icon style-2 type-black">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                        stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                                <span class="body-text-3 fw-normal">Compare</span>
                                            </a>
                                            <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                        stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                                <span class="body-text-3 fw-normal">Wishlist</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <h4>No Products Found</h4>
                                        <p class="text-muted">No e-commerce products are currently available.</p>
                                    </div>
                                </div>
                            @endforelse
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


    <!-- modal Quick View -->

    <div class="modal fade modalCentered modal-def modal-quick-view" id="quickView">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content flex-md-row">
                <span class="icon-close icon-close-popup link" data-bs-dismiss="modal"></span>
                <div class="quickview-image">
                    <div class="product-thumb-slider">
                        <div class="swiper tf-product-view-main">
                            <div class="swiper-wrapper">
                                <!-- item 1 -->
                                <div class="swiper-slide">
                                    <a href="" class="d-block tf-image-view">
                                        <img class="model_main_product_image" src="/"
                                            data-src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}"
                                            alt="" class="lazyload">
                                    </a>
                                </div>
                            </div>
                            <div class="swiper-button-prev nav-swiper-2 single-slide-prev"></div>
                            <div class="swiper-button-next nav-swiper-2 single-slide-next"></div>
                        </div>
                        <div class="swiper tf-product-view-thumbs" data-direction="horizontal">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="item">
                                        <img class="model_additional_product_image" src="/" alt="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="quickview-info-wrap">
                    <div class="quickview-info-inner">
                        <div class="tf-product-info-content">
                            <div class="infor-heading">
                                <p class="caption">Categories:
                                    <a href="{{ route('shop') }}" class="link text-secondary">
                                        laptop
                                    </a>
                                </p>
                                <h5 class="product-info-name fw-semibold">
                                    <a href="" class="link model_product_name">
                                        XYZ
                                    </a>
                                </h5>
                                <ul class="product-info-rate-wrap">
                                    <li class="star-review">
                                        <ul class="list-star">
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star text-main-4"></i>
                                            </li>
                                        </ul>
                                        <p class="caption text-main-2">Reviews (1.738)</p>
                                    </li>
                                    <li>
                                        <p class="caption text-main-2">Sold: 349</p>
                                    </li>
                                    <li class="d-flex">
                                        <a href="{{ route('shop') }}" class="caption text-secondary link">View
                                            shop</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="infor-center">
                                <div class="product-info-price">
                                    <h4 class="text-primary model_product_selling_price">₹18.99</h4>
                                    <span class="price-text text-main-2 old-price model_product_cost_price">₹20.99</span>
                                </div>
                                <ul class="product-fearture-list">
                                    <li>
                                        <p class="body-md-2 fw-semibold">Brand</p>
                                        <span class="body-text-3 model_product_brand">Elite Gourmet</span>
                                    </li>
                                    <li>
                                        <p class="body-md-2 fw-semibold">Model No</p>
                                        <span class="body-text-3 model_product_model_no">1</span>
                                    </li>
                                    <li>
                                        <p class="body-md-2 fw-semibold">SKU</p>
                                        <span class="body-text-3 model_product_sku">Glass</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="infor-bottom">
                                <h6 class="fw-semibold">About this item</h6>
                                <ul class="product-about-list model_product_short_description">
                                    <li>
                                        <p class="body-text-3">
                                            Here’s the quickest way to enjoy your delicious hot tea
                                            every
                                            single day.
                                        </p>
                                    </li>
                                </ul>
                                <ul class="product-about-list model_product_full_description">
                                    <li>
                                        <p class="body-text-3">
                                            Here’s the quickest way to enjoy your delicious hot tea
                                            every
                                            single day.
                                        </p>
                                    </li>
                                </ul>
                                <ul class="product-about-list model_product_technical_specification">
                                    <li>
                                        <p class="body-text-3">
                                            Here’s the quickest way to enjoy your delicious hot tea
                                            every
                                            single day.
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-quantity-wrap">
                            {{-- <div class="wg-quantity">
                                <span class="btn-quantity minus-btn">
                                    <i class="icon-minus"></i>
                                </span>
                                <input class="quantity-product" type="text" name="number" value="1">
                                <span class="btn-quantity plus-btn">
                                    <i class="icon-plus"></i>
                                </span>
                            </div> --}}
                            <a href="#;" class="tf-btn text-white add-to-cart-btn">
                                Add to cart
                                <i class="icon-cart-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /modal Quick View -->

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

            // Quick view functionality
            $('.quickview').on('click', function(e) {
                    e.preventDefault();

                    const productId = $(this).data('product-id');
                    console.log(productId);

                    // Make AJAX request to fetch product details
                    $.ajax({
                            url: '{{ route('product.get') }}',
                            method: 'GET',
                            data: {
                                id: productId
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    // Populate quick view modal with product details
                                    // ... (your code to populate the modal goes here)
                                    @foreach ($products as $product)
                                        $('#quickView').modal('show');

                                        $('.model_product_name').html(
                                            '<a href="/product-detail/' + response.data.id +
                                            '" class="product-link">' +
                                            response.data.product_name +
                                            '</a>'
                                        );

                                        $('.model_product_selling_price').text('₹' + response.data
                                            .selling_price);
                                        $('.model_product_cost_price').text('₹' + response.data
                                            .cost_price);
                                        // $('.model_product_main_images').html(response.data
                                        //     .main_product_image);
                                        // $('.model_product_thumbs_images').html(response.data
                                        //     .additional_product_images);
                                        $('.model_main_product_image').attr('src', '/' + response.data
                                            .main_product_image);
                                        $('.model_additional_product_image').attr('src', '/' + response
                                            .data
                                            .additional_product_images);
                                        $('.model_product_brand').text(response.data.brand.brand_title);
                                        $('.model_product_model_no').text(response.data.model_no);
                                        $('.model_product_sku').text(response.data.sku);
                                        $('.model_product_short_description').html(response.data
                                            .short_description);
                                        $('.model_product_full_description').html(response.data
                                            .full_description);
                                        $('.model_product_technical_specification').html(response.data
                                            .technical_specification);
                                        $('model_product_quantity-product').val(response.data
                                            .min_order_qty);
                                        $('.add-to-cart-btn, .add-to-cart').data('product-id', response
                                            .data.id);
                                    @endforeach

                                    // Add to Cart functionality
                                    $('.add-to-cart-btn, .add-to-cart').on('click', function(e) {
                                            e.preventDefault();

                                            const $button = $(this);
                                            const productId = $button.data('product-id');
                                            const quantity = $('.quantity-input').val() || 1;

                                            // Check if user is authenticated
                                            @guest
                                            // Show login modal for unauthenticated users
                                            showLoginModal();
                                            return;
                                        @endguest

                                        // Show loading state
                                        const originalText = $button.html(); $button.html(
                                            '<i class="spinner-border spinner-border-sm me-2"></i>Adding...'
                                        ); $button.prop('disabled', true);

                                        // Make AJAX request
                                        $.ajax({
                                            url: '{{ route('cart.add') }}',
                                            method: 'POST',
                                            data: {
                                                ecommerce_product_id: productId,
                                                quantity: quantity
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    showNotification(response.message,
                                                        'success');

                                                    // Update button state
                                                    $button.html(
                                                        'Added to Cart <i class="icon-cart-2"></i>'
                                                    );
                                                    $button.addClass('in-cart');

                                                    // Update cart count and sidebar
                                                    updateCartCount();
                                                    updateCartSidebar();
                                                } else {
                                                    showNotification(response.message,
                                                        'error');
                                                    // Reset button state
                                                    $button.html(originalText);
                                                }
                                            },
                                            error: function(xhr) {
                                                if (xhr.status === 401 && xhr
                                                    .responseJSON && xhr.responseJSON
                                                    .requires_auth) {
                                                    showLoginModal();
                                                } else {
                                                    console.log(productId)
                                                    console.log(xhr.responseJSON);
                                                    showNotification(
                                                        'Error adding product to cart. Please try again.',
                                                        'error');
                                                    // Reset button state
                                                    $button.html(originalText);
                                                }
                                            },
                                            complete: function() {
                                                $button.prop('disabled', false);
                                            }
                                        });
                                    });
                            }
                        },
                        error: function(e) {
                            console.log(e.responseText);
                            console.log('Error fetching product details');
                        }
                    });
            });

        // Wishlist handler is now in product-actions.js

        // Compare handler is now in product-actions.js

        // showNotification function is now global in master layout
        // Wishlist count function is now global in master layout

        // Cart handler is now in product-actions.js
        // Cart count function is now global in master layout
        // updateCartSidebar function is now global in master layout
        // showLoginModal function is now global in master layout

        // Initialize counts on page load (handled by master layout)
        // Button state initialization is now handled by product-actions.js

        // ============================================
        // SHOP FILTER FUNCTIONALITY
        // ============================================

        let selectedCategories = [];
        let selectedBrands = [];
        let selectedPriceRanges = [];
        let customMinPrice = null;
        let customMaxPrice = null;
        let selectedSort = null;


        // Category filter change
        $('.category-filter').on('change', function() {
            const categoryId = $(this).val();
            if ($(this).is(':checked')) {
                if (!selectedCategories.includes(categoryId)) {
                    selectedCategories.push(categoryId);
                }
            } else {
                selectedCategories = selectedCategories.filter(id => id !== categoryId);
            }
            applyShopFilters();
        });

        // Brand filter change
        $('.brand-filter').on('change', function() {
            const brandId = $(this).val();
            if ($(this).is(':checked')) {
                if (!selectedBrands.includes(brandId)) {
                    selectedBrands.push(brandId);
                }
            } else {
                selectedBrands = selectedBrands.filter(id => id !== brandId);
            }
            applyShopFilters();
        });

        // Price range filter change
        $('.price-range-filter').on('change', function() {
            const priceRange = $(this).val();
            if ($(this).is(':checked')) {
                if (!selectedPriceRanges.includes(priceRange)) {
                    selectedPriceRanges.push(priceRange);
                }
                // Clear custom price when selecting predefined ranges
                customMinPrice = null;
                customMaxPrice = null;
                $('#custom-min-price').val('');
                $('#custom-max-price').val('');
            } else {
                selectedPriceRanges = selectedPriceRanges.filter(range => range !== priceRange);
            }
            applyShopFilters();
        });

        // Custom price range
        $('#apply-custom-price').on('click', function() {
            const minPrice = $('#custom-min-price').val();
            const maxPrice = $('#custom-max-price').val();

            if (minPrice || maxPrice) {
                customMinPrice = minPrice ? parseFloat(minPrice) : null;
                customMaxPrice = maxPrice ? parseFloat(maxPrice) : null;

                // Validate
                if (customMinPrice && customMaxPrice && customMinPrice > customMaxPrice) {
                    alert('Minimum price cannot be greater than maximum price');
                    return;
                }

                // Clear predefined price ranges
                selectedPriceRanges = [];
                $('.price-range-filter').prop('checked', false);

                applyShopFilters();
            }
        });

        // Clear custom price when clicking on input
        $('#custom-min-price, #custom-max-price').on('focus', function() {
            selectedPriceRanges = [];
            $('.price-range-filter').prop('checked', false);
        });

        // Remove all filters
        $('#remove-all').on('click', function() {
            selectedCategories = [];
            selectedBrands = [];
            selectedPriceRanges = [];
            customMinPrice = null;
            customMaxPrice = null;

            $('.category-filter').prop('checked', false);
            $('.brand-filter').prop('checked', false);
            $('.price-range-filter').prop('checked', false);
            $('#custom-min-price').val('');
            $('#custom-max-price').val('');

            applyShopFilters();
        });

        $('#sortBy').on('change', function() {
            selectedSort = $(this).val();
            applyShopFilters();
        });


        // Apply filters function
        function applyShopFilters() {
            // Show loading state
            $('#gridLayout').html(
                '<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );

            // Build filter parameters
            const filterParams = {};

            if (selectedCategories.length > 0) {
                filterParams.categories = selectedCategories;
            }

            if (selectedBrands.length > 0) {
                filterParams.brands = selectedBrands;
            }

            if (selectedPriceRanges.length > 0) {
                filterParams.price_range = selectedPriceRanges;
            }

            if (customMinPrice !== null) {
                filterParams.min_price = customMinPrice;
            }

            if (customMaxPrice !== null) {
                filterParams.max_price = customMaxPrice;
            }

            if (selectedSort) {
                filterParams.sort_by = selectedSort;
            }

            // Make AJAX request
            $.ajax({
                url: '{{ route('shop.filter') }}',
                method: 'GET',
                data: filterParams,
                success: function(response) {
                    if (response.success) {
                        renderProducts(response.products);
                        updateFilterMeta(response.products.length);
                    } else {
                        showError('Failed to filter products');
                    }
                },
                error: function(xhr) {
                    console.error('Filter error:', xhr);
                    showError('An error occurred while filtering products');
                }
            });
        }

        // Render products
        function renderProducts(products) {
            const gridLayout = $('#gridLayout');
            gridLayout.empty();

            if (products.length === 0) {
                gridLayout.html(`
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h4>No Products Found</h4>
                            <p class="text-muted">No products match your selected filters.</p>
                        </div>
                    </div>
                `);
                return;
            }

            products.forEach(function(product) {
                const productHtml = createProductCard(product);
                gridLayout.append(productHtml);
            });
        }

        // Create product card HTML
        function createProductCard(product) {
            // console.log(product);
            const shortDescription = product.short_description ? product.short_description : '';
            // console.log(shortDescription);
            const discountPercent = product.selling_price > product.final_price ?
                Math.round(((product.selling_price - product.final_price) / product.selling_price) * 100) :
                0;

            return `
                <div class="card-product"
                     data-brand-id="${product.brand_id || ''}"
                     data-category-id="${product.category_id || ''}"
                     data-price="${product.final_price}">
                    <div class="card-product-wrapper">
                        <a href="${product.url}" class="product-img">
                            <img class="img-product lazyload" src="/${product.main_image || '{{ asset('frontend-assets/images/placeholder-product.png') }}'}" alt="${product.name}">
                        </a>
                        <ul class="list-product-btn top-0 end-0">
                            <li>
                                <a href="#;" class="box-icon add-to-cart-btn btn-icon-action hover-tooltip tooltip-left" data-product-id="${product.id}" data-product-name="${product.name}">
                                    <span class="icon icon-cart2"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li class="wishlist">
                                <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left add-to-wishlist-btn" data-product-id="${product.id}" data-product-name="${product.name}">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li class="d-none d-sm-block">
                                <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left compare-btn" data-product-id="${product.id}" data-product-name="${product.name}">
                                    <span class="icon icon-compare1"></span>
                                    <span class="tooltip">Compare</span>
                                </a>
                            </li>
                        </ul>
                        ${discountPercent > 0 ? `
                                <div class="box-sale-wrap pst-default">
                                    <p class="small-text">Sale</p>
                                    <p class="title-sidebar-2">${discountPercent}%</p>
                                </div>
                            ` : ''}
                    </div>
                    <div class="card-product-info">
                        <div class="box-title">
                            <div>
                                ${product.category ? `<p class="product-tag caption text-main-2">${product.category}</p>` : ''}
                                <a href="${product.url}" class="name-product body-md-2 fw-semibold text-secondary link text-truncate" style="max-width: 220px;">
                                    ${product.name}
                                </a>
                            </div>
                            
                            <p class="price-wrap fw-medium">
                                ${product.final_price ? `<span class="new-price price-text fw-medium">₹${product.final_price}</span>` : `<span class="new-price price-text fw-medium">₹0.00</span>`}

                                ${product.discount_price > 0 ? `<span class="old-price body-md-2 text-main-2">₹${(parseFloat(product.final_price) + parseFloat(product.discount_price)).toFixed(2)}</span>` : ''}

                            </p>

                            ${shortDescription ? `<div class="product-description">
                                                                <p class="caption">${shortDescription}</p>
                                                            </div>` : ''}
                            <div class="box-infor-detail">
                                <div class="star-review flex-wrap">
                                    <ul class="list-star">
                                        <li><i class="icon-star"></i></li>
                                        <li><i class="icon-star"></i></li>
                                        <li><i class="icon-star"></i></li>
                                        <li><i class="icon-star"></i></li>
                                        <li><i class="icon-star"></i></li>
                                    </ul>
                                    <p class="caption text-main-2">({{ $product->total_sold }})</p>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-product-btn">
                        <a href="#;" class="tf-btn btn-line w-100 add-to-cart-btn" data-product-id="${product.id}">
                            <span>Add to cart</span>
                            <i class="icon-cart-2"></i>
                        </a>
                    </div>
                </div>
            `;
        }

        // Update filter meta information
        function updateFilterMeta(count) {
            const metaFilterShop = $('.meta-filter-shop');
            const appliedFilters = $('#applied-filters');
            const removeAllBtn = $('#remove-all');

            appliedFilters.empty();

            // Add category filters
            selectedCategories.forEach(function(categoryId) {
                const categoryLabel = $(`#category-${categoryId}`).next('label').text();
                appliedFilters.append(`
                    <span class="filter-tag">${categoryLabel}
                        <span class="remove-tag icon-close" data-filter="category" data-value="${categoryId}"></span>
                    </span>
                `);
            });

            // Add brand filters
            selectedBrands.forEach(function(brandId) {
                const brandLabel = $(`#brand-${brandId}`).next('label').text();
                appliedFilters.append(`
                    <span class="filter-tag">${brandLabel}
                        <span class="remove-tag icon-close" data-filter="brand" data-value="${brandId}"></span>
                    </span>
                `);
            });

            // Add price range filters
            selectedPriceRanges.forEach(function(range) {
                let rangeLabel = '';
                switch (range) {
                    case 'under_10000':
                        rangeLabel = 'Under ₹10,000';
                        break;
                    case '10000_15000':
                        rangeLabel = '₹10,000 to ₹15,000';
                        break;
                    case '15000_25000':
                        rangeLabel = '₹15,000 to ₹25,000';
                        break;
                    case 'above_35000':
                        rangeLabel = '₹35,000 & Above';
                        break;
                }
                appliedFilters.append(`
                    <span class="filter-tag">${rangeLabel}
                        <span class="remove-tag icon-close" data-filter="price_range" data-value="${range}"></span>
                    </span>
                `);
            });

            // Add custom price filter
            if (customMinPrice !== null || customMaxPrice !== null) {
                let priceLabel = '';
                if (customMinPrice !== null && customMaxPrice !== null) {
                    priceLabel = `₹${customMinPrice.toLocaleString()} - ₹${customMaxPrice.toLocaleString()}`;
                } else if (customMinPrice !== null) {
                    priceLabel = `₹${customMinPrice.toLocaleString()} +`;
                } else {
                    priceLabel = `Up to ₹${customMaxPrice.toLocaleString()}`;
                }
                appliedFilters.append(`
                    <span class="filter-tag">${priceLabel}
                        <span class="remove-tag icon-close" data-filter="custom_price"></span>
                    </span>
                `);
            }

            // Show/hide meta filter section
            const hasFilters = selectedCategories.length > 0 || selectedBrands.length > 0 ||
                selectedPriceRanges.length > 0 || customMinPrice !== null || customMaxPrice !== null;

            if (hasFilters) {
                metaFilterShop.show();
                removeAllBtn.show();
                $('#product-count-grid').text(`Showing ${count} products`);
            } else {
                metaFilterShop.hide();
                removeAllBtn.hide();
            }
        }

        // Remove individual filter tag
        $(document).on('click', '.remove-tag', function() {
            const filterType = $(this).data('filter');
            const filterValue = $(this).data('value');

            if (filterType === 'category') {
                // Uncheck the checkbox
                $(`.category-filter[value="${filterValue}"]`).prop('checked', false);
                // Remove from array (convert both to string for safety)
                selectedCategories = selectedCategories.filter(id => String(id) !== String(filterValue));
            } else if (filterType === 'brand') {
                $(`.brand-filter[value="${filterValue}"]`).prop('checked', false);
                selectedBrands = selectedBrands.filter(id => String(id) !== String(filterValue));
            } else if (filterType === 'price_range') {
                selectedPriceRanges = selectedPriceRanges.filter(range => range !== filterValue);
                $(`.price-range-filter[value="${filterValue}"]`).prop('checked', false);
            } else if (filterType === 'custom_price') {
                customMinPrice = null;
                customMaxPrice = null;
                $('#custom-min-price').val('');
                $('#custom-max-price').val('');
            }

            applyShopFilters();
        });

        // Show error message
        function showError(message) {
            $('#gridLayout').html(`
                <div class="col-12">
                    <div class="alert alert-danger text-center" role="alert">
                        ${message}
                    </div>
                </div>
            `);
        }

        });
    </script>
@endsection
