@extends('frontend/layout/master')

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
<div class="flat-content">
    <div class="container">
        <div class="tf-product-view-content wrapper-control-shop">
            <div class="canvas-filter-product sidebar-filter handle-canvas left">
                <div class="canvas-wrapper">
                    <div class="canvas-header d-flex d-xl-none">
                        <h5 class="title">Filter</h5>
                        <span class="icon-close link icon-close-popup close-filter"
                            data-bs-dismiss="offcanvas"></span>
                    </div>
                    <div class="canvas-body">
                        <div class="facet-categories">
                            <h6 class="title fw-medium">Show all categories</h6>
                            <ul>
                                <li><a href="#">Laptops & Notebooks <i class="icon-arrow-right"></i></a>
                                </li>
                                <li><a href="#">Desktops & All-in-One PCs <i class="icon-arrow-right"></i></a></li>
                                <li><a href="#">Computer Components <i class="icon-arrow-right"></i></a></li>
                                <li><a href="#">Monitors <i class="icon-arrow-right"></i></a>
                                </li>
                                <li><a href="#">Peripherals & Accessories <i class="icon-arrow-right"></i></a></li>
                                <li><a href="#">Storage Devices <i class="icon-arrow-right"></i></a></li>
                                <li><a href="#">Networking Devices <i class="icon-arrow-right"></i></a></li>
                                <li><a href="#">Printers & Scanners <i class="icon-arrow-right"></i></a></li>
                                <li><a href="#">Software <i class="icon-arrow-right"></i></a></li>
                            </ul>
                        </div>
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
                                    <label for="up35">₹35 & Above</label>
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
                            <p class="facet-title title-sidebar fw-semibold">Deals & Discounts</p>
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
            <div class="content-area">
                <div class="tf-shop-control flex-wrap gap-10">
                    <div class="d-flex align-items-center gap-10">
                        <button id="filterShop" class="tf-btn-filter d-flex d-xl-none">
                            <span class="icon icon-filter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#121212"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M176,80a8,8,0,0,1,8-8h32a8,8,0,0,1,0,16H184A8,8,0,0,1,176,80ZM40,88H144v16a8,8,0,0,0,16,0V56a8,8,0,0,0-16,0V72H40a8,8,0,0,0,0,16Zm176,80H120a8,8,0,0,0,0,16h96a8,8,0,0,0,0-16ZM88,144a8,8,0,0,0-8,8v16H40a8,8,0,0,0,0,16H80v16a8,8,0,0,0,16,0V152A8,8,0,0,0,88,144Z">
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
                    </div>
                    <div class="tf-control-view flat-title-tab-product flex-wrap">
                        <ul class="tf-control-layout menu-tab-line" role="tablist">
                            <li class="tf-view-layout-switch" data-tab="tabgrid-1">
                                <a href="#" class="tab-link main-title link fw-semibold d-flex active"
                                    data-bs-toggle="tab">
                                    <i class="icon-menu-dots"></i>
                                </a>
                            </li>
                            <li class="tf-view-layout-switch" data-tab="tabgrid-2">
                                <a href="#" class="tab-link main-title link d-flex fw-semibold"
                                    data-bs-toggle="tab">
                                    <i class="icon-dot-line"></i>
                                </a>
                            </li>
                            <li class="tf-view-layout-switch" data-tab="tablist-1">
                                <a href="#" class="tab-link main-title link d-flex fw-semibold"
                                    data-bs-toggle="tab">
                                    <i class="icon-list-1"></i>
                                </a>
                            </li>
                            <li class="tf-view-layout-switch" data-tab="tablist-2">
                                <a href="#" class="tab-link main-title link d-flex fw-semibold"
                                    data-bs-toggle="tab">
                                    <i class="icon-list-2"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="tf-my-dropdown tf-control-show nice-select" tabindex="0">
                            <div class="btn-select">
                                <i class="icon-menu-dots"></i>
                                <p class="body-text-3 w-100 current">Show: 50</p>
                                <i class="icon-arrow-down fs-10"></i>
                            </div>
                            <ul class="list">
                                <li class="option select-item" data-sort-value="0-5">
                                    <span class="text-value-item">Show: 5</span>
                                </li>
                                <li class="option select-item" data-sort-value="0-10">
                                    <span class="text-value-item">Show: 10</span>
                                </li>
                                <li class="option select-item" data-sort-value="0-15">
                                    <span class="text-value-item">Show: 15</span>
                                </li>
                                <li class="option select-item" data-sort-value="0-20">
                                    <span class="text-value-item">Show: 20</span>
                                </li>
                                <li class="option select-item selected" data-sort-value="0-50">
                                    <span class="text-value-item">Show: 50</span>
                                </li>
                            </ul>
                        </div>
                        <div class="tf-dropdown-sort tf-sort type-sort-by" data-bs-toggle="dropdown">
                            <div class="btn-select w-100">
                                <i class="icon-sort"></i>
                                <p class="body-text-3 w-100">Sort by: <span
                                        class="text-sort-value">Featured</span></p>
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
                <div class="meta-filter-shop" style="display: none;">
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
                        <!-- item 1 -->
                        <div class="card-product" data-condition="New" data-brand="steelseri2"
                            data-deal="Deal Today" data-rate="3 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-sale-wrap pst-default">
                                    <p class="small-text">Sale</p>
                                    <p class="title-sidebar-2">70%</p>
                                </div>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk Night Vision Security Camera 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹80.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                        <!-- item 2 -->
                        <div class="card-product" data-condition="Old" data-brand="steelseri"
                            data-rate="5 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner Cartridge, 1 Ink Bottle Included) 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹23.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 3 -->
                        <div class="card-product" data-condition="New" data-brand="hyperx2" data-rate="2 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance (Fingerprint) 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹13.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 4 -->
                        <div class="card-product" data-condition="New" data-brand="razer" data-rate="4 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11 Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming Laptop 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹5.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 5 -->
                        <div class="card-product" data-rate="1 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance (Fingerprint) 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹10.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 6 -->
                        <div class="card-product" data-brand="corsair" data-deal="Deal Today"
                            data-rate="5 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-sale-wrap pst-default">
                                    <p class="small-text">Sale</p>
                                    <p class="title-sidebar-2">70%</p>
                                </div>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11 Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming Laptop 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹80.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 7 -->
                        <div class="card-product" data-brand="jbl" data-deal="Deal Today" data-rate="3 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-sale-wrap pst-default">
                                    <p class="small-text">Sale</p>
                                    <p class="title-sidebar-2">70%</p>
                                </div>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner Cartridge, 1 Ink Bottle Included) 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹50.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 8 -->
                        <div class="card-product" data-condition="Old" data-brand="hyperx2" data-rate="2 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                           Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk Night Vision Security Camera 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹70.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 9 -->
                        <div class="card-product" data-brand="logitech" data-deal="Deal Today"
                            data-rate="4 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-sale-wrap pst-default">
                                    <p class="small-text">Sale</p>
                                    <p class="title-sidebar-2">70%</p>
                                </div>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11 Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming Laptop 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹68.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 10 -->
                        <div class="card-product" data-condition="Old" data-brand="corsair" data-rate="1 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk Night Vision Security Camera 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹22.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 11 -->
                        <div class="card-product" data-brand="steelseri2" data-rate="5 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance (Fingerprint) 
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹15.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- item 12 -->
                        <div class="card-product" data-brand="logitech" data-rate="3 Star">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}" alt="image-product">
                                    <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}" alt="image-product">
                                </a>
                                <ul class="list-product-btn top-0 end-0">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class=" wishlist">
                                        <a href="#;"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                <div class="box-title">
                                    <div>
                                        <p class="product-tag caption text-main-2 d-none">Headphone</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner Cartridge, 1 Ink Bottle Included)
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium">₹79.000</span>
                                        <span class="old-price body-md-2 text-main-2">₹100.000</span>
                                    </p>
                                </div>
                                <div class="box-infor-detail">
                                    <ul class="list-computer-memory">
                                        <li>
                                            <p class="caption">RAM 8GB</p>
                                        </li>
                                        <li>
                                            <p class="caption">SSD 512 GB</p>
                                        </li>
                                    </ul>
                                    <ul class="list-infor-fearture">
                                        <li>
                                            <p class="caption name-feature">Screen Size: </p>
                                            <p class="caption property"> 13 Inches </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Operating System: </p>
                                            <p class="caption property"> Mac OS </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Graphics Card: </p>
                                            <p class="caption property"> Integrated </p>
                                        </li>
                                        <li>
                                            <p class="caption name-feature">Processor Count:</p>
                                            <p class="caption property"> 4 </p>
                                        </li>
                                    </ul>
                                    <div class="star-review flex-wrap">
                                        <ul class="list-star">
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                            <li><i class="icon-star text-main-4"></i></li>
                                        </ul>
                                        <p class="caption text-main-2">(74)</p>
                                    </div>
                                    <a href="#compare" data-bs-toggle="offcanvas" class="tf-btn-icon style-2">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 6.5V9V6.5ZM9 9V11.5V9ZM9 9H11.5H9ZM9 9H6.5H9ZM16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                                                stroke="#004EC3" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                </div>

                            </div>
                            <div class="card-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-line w-100">
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
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Compare</span>
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="tf-btn-icon style-2 type-black">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.59837 5.26487C3.25014 5.61309 2.97391 6.02649 2.78546 6.48146C2.597 6.93644 2.5 7.42408 2.5 7.91654C2.5 8.409 2.597 8.89664 2.78546 9.35161C2.97391 9.80658 3.25014 10.22 3.59837 10.5682L10 16.9699L16.4017 10.5682C17.105 9.86494 17.5001 8.9111 17.5001 7.91654C17.5001 6.92197 17.105 5.96814 16.4017 5.26487C15.6984 4.5616 14.7446 4.16651 13.75 4.16651C12.7555 4.16651 11.8016 4.5616 11.0984 5.26487L10 6.3632L8.9017 5.26487C8.55348 4.91665 8.14008 4.64042 7.68511 4.45196C7.23013 4.2635 6.74249 4.1665 6.25003 4.1665C5.75757 4.1665 5.26993 4.2635 4.81496 4.45196C4.35998 4.64042 3.94659 4.91665 3.59837 5.26487V5.26487Z"
                                                stroke="#FF3D3D" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <span class="body-text-3 fw-normal">Wishlist</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Navigation -->
                        <ul class="wg-pagination wd-load my-4">
                            <li>
                                <a href="#" class="link">
                                    <i class="icon-arrow-left-lg"></i>
                                </a>
                            </li>
                            <li class="active">
                                <p class="title-normal link">1</p>
                            </li>
                            <li>
                                <a href="#" class="title-normal link">2</a>
                            </li>
                            <li class="d-none d-sm-flex">
                                <a href="#" class="title-normal link">3</a>
                            </li>
                            <li class="d-none d-sm-flex">
                                <a href="#" class="title-normal link">4</a>
                            </li>
                            <li>
                                <p class="title-normal">...</p>
                            </li>
                            <li>
                                <a href="#" class="title-normal link">10</a>
                            </li>
                            <li>
                                <a href="#" class="link">
                                    <i class="icon-arrow-right-lg"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Content -->

@endsection