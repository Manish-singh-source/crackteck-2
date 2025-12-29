@extends('frontend/layout/master')

@section('main-content')
    <div class="container-fluid" style="z-index: 10;display: flex;opacity: 0.9;position: absolute;">
        <div class="container">
            <div class="category-scroll-container " class="box-btn-slide-2 sw-nav-effect wow fadeInUp" data-wow-delay="0s">
                <div class="swiper tf-sw-products slider-category" data-preview="10" data-tablet="7" data-mobile-sm="4"
                    data-mobile="3" data-pagination="2" data-pagination-sm="4" data-pagination-md="7"
                    data-pagination-lg="10">
                    <div class="category-track swiper-wrapper">
                        @if (isset($categories) && $categories->count() > 0)
                            @foreach ($categories as $category)
                                <div class="category-item swiper-slide">
                                    <a href="{{ $category->url }}" class="hover-img" style="text-decoration: none;">
                                        <img src="{{ $category->category_image ? asset($category->category_image) : asset('frontend-assets/images/new-products/default-category.png') }}"
                                            alt="{{ $category->parent_categories }}"
                                            style="width: 100%; height: auto; object-fit: cover;">
                                        <span style="color: #ffffff;">{{ $category->parent_categories }}</span>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback content when no categories are available -->
                            <div class="category-item swiper-slide">
                                <div class="hover-img">
                                    <img src="{{ asset('frontend-assets/images/new-products/header-product-1.png') }}"
                                        alt="Default Category">
                                    <span style="color: #ffffff;">No Categories Available</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if ($banners->count() > 0)
                @foreach ($banners as $index => $banner)
                    <!-- Slide {{ $index + 1 }} -->
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        style="background-image: url('{{ $banner->banner_image_url }}');">
                        <div class="container">
                            <div class="carousel-caption">
                                @if ($banner->banner_sub_heading)
                                    <h5>{{ $banner->banner_sub_heading }}</h5>
                                @endif
                                @if ($banner->banner_heading)
                                    <h1>{!! nl2br(e($banner->banner_heading)) !!}</h1>
                                @endif
                                @if ($banner->banner_description)
                                    <p>{{ $banner->banner_description }}</p>
                                @endif
                                @if ($banner->button_text && $banner->banner_url)
                                    <a href="{{ $banner->banner_url }}"
                                        class="btn btn-outline-light">{{ $banner->button_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default slide when no banners are available -->
                <div class="carousel-item active"
                    style="background-image: url('{{ asset('frontend-assets/images/banner/main-banner-1.jpg') }}');">
                    <div class="container">
                        <div class="carousel-caption">
                            <h5>Welcome to CrackTeck</h5>
                            <h1>Your Technology Partner</h1>
                            <p>Discover our latest products and services</p>
                            <a href="{{ route('shop') }}" class="btn btn-outline-light">EXPLORE NOW</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Navigation buttons - only show if there are multiple banners -->
        @if ($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            <!-- Carousel indicators -->
            <div class="carousel-indicators">
                @foreach ($banners as $index => $banner)
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- /Banner Product -->
    <!-- Iconbox -->
    <div class="tf-sp-2">
        <div class="container">
            <div class="swiper tf-sw-iconbox" data-preview="5" data-tablet="3" data-mobile-sm="2" data-mobile="1"
                data-space-lg="20" data-space-md="20" data-space="15">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="tf-icon-box wow fadeInLeft" data-wow-delay="0s">
                            <div class="icon-box">
                                <img src="{{ asset('frontend-assets/images/icons/icon-1.png') }}" alt="icon">
                            </div>
                            <div class="content">
                                <p class="body-text fw-semibold">Free delivery</p>
                                <p class="body-text-3">Free Shipping for orders over ₹20</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box wow fadeInLeft" data-wow-delay="0.1s">
                            <div class="icon-box">
                                <img src="{{ asset('frontend-assets/images/icons/icon-2.png') }}" alt="icon">
                            </div>
                            <div class="content">
                                <p class="body-text fw-semibold">Support 24/7</p>
                                <p class="body-text-3">24 hours a day, 7 days a week</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="icon-box">
                                <img src="{{ asset('frontend-assets/images/icons/icon-3.png') }}" alt="icon">
                            </div>
                            <div class="content">
                                <p class="body-text fw-semibold">Payment</p>
                                <p class="body-text-3">Pay with Multiple Credit Cards</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box wow fadeInLeft" data-wow-delay="0.3s">
                            <div class="icon-box">
                                <img src="{{ asset('frontend-assets/images/icons/icon-4.png') }}" alt="icon">
                            </div>
                            <div class="content">
                                <p class="body-text fw-semibold">Reliable</p>
                                <p class="body-text-3">Trusted by 2000+ major brands</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box wow fadeInLeft" data-wow-delay="0.4s">
                            <div class="icon-box">
                                <img src="{{ asset('frontend-assets/images/icons/icon-5.png') }}" alt="icon">
                            </div>
                            <div class="content">
                                <p class="body-text fw-semibold">Guarantee</p>
                                <p class="body-text-3">Within 30 days for an exchange</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sw-pagination-iconbox sw-dot-default justify-content-center"></div>
            </div>
        </div>
    </div>
    <!-- /Iconbox -->

    <!-- Deal Today -->
    @foreach ($activeDeals as $deal)
        @if ($activeDeals->count() > 0)
            <section class="tf-sp-2 pt-3">
                <div class="container">
                    <div class="flat-title pb-8 wow fadeInUp" data-wow-delay="0s">
                        <h5 class="fw-semibold text-primary flat-title-has-icon">
                            {{ $deal->deal_title }}
                        </h5>
                        <div class="box-btn-slide relative">
                            <div class="swiper-button-prev nav-swiper nav-prev-products">
                                <i class="icon-arrow-left-lg"></i>
                            </div>
                            <div class="swiper-button-next nav-swiper nav-next-products">
                                <i class="icon-arrow-right-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="box-btn-slide-2 sw-nav-effect">

                        <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                            data-mobile="2" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="2"
                            data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                            <div class="swiper-wrapper">

                                @foreach ($deal->dealItems as $index => $dealItem)
                                    <div class="swiper-slide">
                                        <div class="card-product style-img-border wow fadeInLeft"
                                            data-wow-delay="{{ $index * 0.1 }}s">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('product.detail', $dealItem->ecommerceProduct->id) }}"
                                                    class="product-img">
                                                    @if ($dealItem->ecommerceProduct->warehouseProduct->main_product_image)
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($dealItem->ecommerceProduct->warehouseProduct->main_product_image) }}"
                                                            data-src="{{ asset($dealItem->ecommerceProduct->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $dealItem->ecommerceProduct->warehouseProduct->product_name }}">
                                                        <img class="img-hover ls-is-cached lazyloaded"
                                                            src="{{ asset($dealItem->ecommerceProduct->warehouseProduct->additional_product_images[0]) }}"
                                                            data-src="{{ asset($dealItem->ecommerceProduct->warehouseProduct->additional_product_images[0]) }}"
                                                            alt="image-product">
                                                    @else
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($dealItem->ecommerceProduct->warehouseProduct->additional_product_images) }}"
                                                            data-src="{{ asset($dealItem->ecommerceProduct->warehouseProduct->additional_product_images) }}"
                                                            alt="{{ $dealItem->ecommerceProduct->warehouseProduct->additional_product_images }}">
                                                    @endif
                                                </a>
                                                <div class="box-sale-wrap pst-default z-5">
                                                    <p class="small-text">Deal</p>
                                                    <p class="title-sidebar-2">
                                                        @if ($dealItem->discount_type === 'percentage')
                                                            {{ number_format($dealItem->discount_value, 0) }}%
                                                        @else
                                                            ₹{{ number_format($dealItem->discount_value, 0) }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <ul class="list-product-btn">
                                                    <li>
                                                        <a href="#;"
                                                            class="box-icon add-to-cart-btn btn-icon-action hover-tooltip tooltip-left"
                                                            data-product-id="{{ $dealItem->ecommerceProduct->id }}"
                                                            data-product-name="{{ $dealItem->ecommerceProduct->warehouseProduct->product_name ?? 'Product' }}">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class="wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip tooltip-left add-to-wishlist-btn"
                                                            data-product-id="{{ $dealItem->ecommerceProduct->id }}"
                                                            data-product-name="{{ $dealItem->ecommerceProduct->warehouseProduct->product_name ?? 'Product' }}">
                                                            <span><i class="fa-solid fa-heart"></i></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView{{ $dealItem->ecommerceProduct->id }}"
                                                            data-bs-toggle="modal"
                                                            data-product-id="{{ $dealItem->ecommerceProduct->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-none d-sm-block">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip tooltip-left compare-btn"
                                                            data-product-id="{{ $dealItem->ecommerceProduct->id }}"
                                                            data-product-name="{{ $dealItem->ecommerceProduct->warehouseProduct->product_name ?? 'Product' }}">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-product-info">
                                                <div class="box-title">
                                                    <div class="d-flex flex-column">
                                                        <p class="caption text-main-2 font-2">
                                                            {{ $dealItem->ecommerceProduct->warehouseProduct->brand->brand_title ?? 'Brand' }}
                                                        </p>
                                                        <a href="{{ route('ecommerce-product-detail', $dealItem->ecommerceProduct->id) }}"
                                                            class="name-product body-md-2 fw-semibold text-secondary link text-truncate"
                                                            style="max-width: 230px;">
                                                            {{ $dealItem->ecommerceProduct->warehouseProduct->product_name }}
                                                        </a>
                                                    </div>
                                                    <p class="price-wrap fw-medium">
                                                        <span
                                                            class="new-price price-text fw-medium text-primary mb-0">₹{{ number_format($dealItem->offer_price, 0) }}</span>
                                                        <span
                                                            class="old-price price-text text-decoration-line-through text-muted ms-2">₹{{ number_format($dealItem->original_price, 0) }}</span>
                                                    </p>
                                                </div>
                                                <div class="box-infor-detail">
                                                    <div class="countdown-timer"
                                                        data-end-time="{{ $deal->offer_end_date->toISOString() }}">
                                                        <div class="d-flex justify-content-between text-center">
                                                            <div class="time-unit d-flex flex-column">
                                                                <span
                                                                    class="time-value days fw-bold bg-primary p-2 text-white rounded-circle">00</span>
                                                                <span class="time-label caption">Days</span>
                                                            </div>
                                                            <div class="time-unit d-flex flex-column">
                                                                <span
                                                                    class="time-value hours fw-bold bg-primary p-2 text-white rounded-circle">00</span>
                                                                <span class="time-label caption">Hours</span>
                                                            </div>
                                                            <div class="time-unit d-flex flex-column">
                                                                <span
                                                                    class="time-value minutes fw-bold bg-primary p-2 text-white rounded-circle">00</span>
                                                                <span class="time-label caption">Min</span>
                                                            </div>
                                                            <div class="time-unit d-flex flex-column">
                                                                <span
                                                                    class="time-value seconds fw-bold bg-primary p-2 text-white rounded-circle">00</span>
                                                                <span class="time-label caption">Sec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="sw-dot-default sw-pagination-products justify-content-center">
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        @endif
    @endforeach
    <!-- /Deal Today -->

    <!-- Deal Today -->
    {{-- <section class="tf-sp-2 pt-3">
        <div class="container">
            <div class="flat-title pb-8 wow fadeInUp" data-wow-delay="0">
                <h5 class="fw-semibold flat-title-has-icon">
                     
                </h5>
            </div>
            <div class="box-btn-slide-2 sw-nav-effect timer">
                <div class="swiper tf-sw-products slider-thumb-deal" data-preview="4" data-tablet="3" data-mobile-sm="2"
                    data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                    data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="card-product style-border wow fadeInLeft" data-wow-delay="0">
                                <div class="card-product-wrapper overflow-visible ">
                                    <div class="product-thumb-image">
                                        <a href="{{ route('product-detail') }}" class="card-image">
                                            <img width="600" height="520"
                                                src="{{ asset('frontend-assets/images/new-products/1-1.png') }}"
                                                alt="Image Product" class="lazyload img-product">
                                        </a>
                                    </div>
                                    <ul class="list-product-btn top-0 end-0">
                                        <li>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-cart2"></i>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class=" wishlist">
                                            <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-heart2"></i>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-view"></i>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#compare" data-bs-toggle="offcanvas"
                                                class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-compare1"></i>
                                                <span class="tooltip">Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="box-sale-wrap top-0 start-0 z-5">
                                        <p class="small-text">Sale</p>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <div class="box-title gap-xl-12">
                                        <div class="d-flex flex-column">
                                            <h6>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product fw-semibold text-secondary link">
                                                    CCTV
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="price-wrap fw-medium">
                                            <span class="new-price h4 fw-normal text-primary mb-0">₹37.500</span>
                                        </p>
                                    </div>
                                    <div class="box-infor-detail gap-xl-20">
                                        <div class="countdown-box">
                                            <div class="js-countdown" data-timer="102738"
                                                data-labels="Days,Hours,Mins,Secs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card-product style-border  wow fadeInLeft" data-wow-delay="0.1s">
                                <div class="card-product-wrapper overflow-visible">
                                    <div class="product-thumb-image">
                                        <a href="{{ route('product-detail') }}" class="card-image">
                                            <img width="600" height="520"
                                                src="{{ asset('frontend-assets/images/new-products/1-2.png') }}"
                                                alt="Image Product" class="lazyload img-product">
                                        </a>
                                        <div class="box-sale-wrap top-0 start-0 z-5">
                                            <p class="small-text">Sale</p>
                                        </div>
                                    </div>
                                    <ul class="list-product-btn top-0 end-0">
                                        <li>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-cart2"></i>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class=" wishlist">
                                            <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-heart2"></i>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-view"></i>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#compare" data-bs-toggle="offcanvas"
                                                class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-compare1"></i>
                                                <span class="tooltip">Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-product-info">
                                    <div class="box-title gap-xl-12">
                                        <div class="d-flex flex-column">
                                            <h6>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product fw-semibold text-secondary link">
                                                    Printer
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="price-wrap fw-medium">
                                            <span class="new-price h4 fw-normal text-primary mb-0">₹62.000</span>
                                        </p>
                                    </div>
                                    <div class="box-infor-detail gap-xl-20">
                                        <div class="countdown-box">
                                            <div class="js-countdown" data-timer="22671"
                                                data-labels="Days,Hours,Mins,Secs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card-product style-border wow fadeInLeft" data-wow-delay="0.2s">
                                <div class="card-product-wrapper overflow-visible">
                                    <div class="product-thumb-image">
                                        <a href="{{ route('product-detail') }}" class="card-image">
                                            <img width="600" height="520"
                                                src="{{ asset('frontend-assets/images/new-products/1-3.png') }}"
                                                alt="Image Product" class="lazyload img-product">
                                        </a>
                                    </div>
                                    <ul class="list-product-btn top-0 end-0">
                                        <li>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-cart2"></i>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class=" wishlist">
                                            <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-heart2"></i>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-view"></i>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#compare" data-bs-toggle="offcanvas"
                                                class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-compare1"></i>
                                                <span class="tooltip">Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="box-sale-wrap top-0 start-0 z-5">
                                        <p class="small-text">Sale</p>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <div class="box-title gap-xl-12">
                                        <div class="d-flex flex-column">
                                            <h6>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product fw-semibold text-secondary link">
                                                    Bio-metric
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="price-wrap fw-medium">
                                            <span class="new-price h4 fw-normal text-primary mb-0">₹42.500</span>
                                        </p>
                                    </div>
                                    <div class="box-infor-detail gap-xl-20">
                                        <div class="countdown-box">
                                            <div class="js-countdown" data-timer="5804"
                                                data-labels="Days,Hours,Mins,Secs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card-product style-border wow fadeInLeft" data-wow-delay="0.3s">
                                <div class="card-product-wrapper overflow-visible">
                                    <div class="product-thumb-image">
                                        <a href="{{ route('product-detail') }}" class="card-image">
                                            <img width="600" height="520"
                                                src="{{ asset('frontend-assets/images/new-products/1-4.png') }}"
                                                alt="Image Product" class="lazyload img-product">
                                        </a>
                                    </div>
                                    <ul class="list-product-btn top-0 end-0">
                                        <li>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-cart2"></i>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class=" wishlist">
                                            <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-heart2"></i>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-view"></i>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#compare" data-bs-toggle="offcanvas"
                                                class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-compare1"></i>
                                                <span class="tooltip">Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="box-sale-wrap top-0 start-0 z-5">
                                        <p class="small-text">Sale</p>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <div class="box-title gap-xl-12">
                                        <div class="d-flex flex-column">
                                            <h6>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product fw-semibold text-secondary link">
                                                    Laptop
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="price-wrap fw-medium">
                                            <span class="new-price h4 fw-normal text-primary mb-0">₹48.000</span>
                                        </p>
                                    </div>
                                    <div class="box-infor-detail gap-xl-20">
                                        <div class="countdown-box">
                                            <div class="js-countdown" data-timer="8738"
                                                data-labels="Days,Hours,Mins,Secs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card-product style-border">
                                <div class="card-product-wrapper overflow-visible">
                                    <div class="product-thumb-image">
                                        <a href="{{ route('product-detail') }}" class="card-image">
                                            <img width="600" height="520"
                                                src="{{ asset('frontend-assets/images/new-products/1-5.png') }}"
                                                alt="Image Product" class="lazyload img-product">
                                        </a>
                                    </div>
                                    <ul class="list-product-btn top-0 end-0">
                                        <li>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-cart2"></i>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class=" wishlist">
                                            <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-heart2"></i>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-view"></i>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#compare" data-bs-toggle="offcanvas"
                                                class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                <i class="icon icon-compare1"></i>
                                                <span class="tooltip">Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="box-sale-wrap top-0 start-0 z-5">
                                        <p class="small-text">Sale</p>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <div class="box-title gap-xl-12">
                                        <div class="d-flex flex-column">
                                            <h6>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product fw-semibold text-secondary link">
                                                    Desktop
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="price-wrap fw-medium">
                                            <span class="new-price h4 fw-normal text-primary mb-0">₹80.000</span>
                                        </p>
                                    </div>
                                    <div class="box-infor-detail gap-xl-20">
                                        <div class="countdown-box">
                                            <div class="js-countdown" data-timer="102738"
                                                data-labels="Days,Hours,Mins,Secs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
                </div>
                <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-products-2">
                    <i class="icon-arrow-left-lg"></i>
                </div>
                <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-products-2">
                    <i class="icon-arrow-right-lg"></i>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- /Deal Today -->

    <!-- Collection section -->
    <section class="tf-sp-2 pt-3">
        <div class="container">
            <div class="flat-title pb-8 wow fadeInUp" data-wow-delay="0s">
                <h5 class="fw-semibold text-primary flat-title-has-icon">
                    Our Collections
                </h5>
                <div class="box-btn-slide relative">
                    <div class="swiper-button-prev nav-swiper nav-prev-products">
                        <i class="icon-arrow-left-lg"></i>
                    </div>
                    <div class="swiper-button-next nav-swiper nav-next-products">
                        <i class="icon-arrow-right-lg"></i>
                    </div>
                </div>
            </div>
            <div class="swiper tf-sw-products" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1"
                data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1" data-pagination-sm="2"
                data-pagination-md="3" data-pagination-lg="4" data-grid="2">
                <div class="swiper-wrapper">
                    @if (isset($collections) && $collections->count() > 0)
                        @foreach ($collections as $collection)
                            <div class="swiper-slide" style="background-color: #d1d1d1; padding: 15px">
                                <div class="wg-cls hover-img type-abs wow fadeInUp" data-wow-delay="0s">
                                    <a href="{{ route('collection.details', $collection->id) }}"
                                        class="img-style d-block">
                                        @if ($collection->image)
                                            <img src="{{ asset($collection->image) }}" alt="{{ $collection->title }}">
                                        @else
                                            <img src="{{ asset('frontend-assets/images/collection/default-collection.jpg') }}"
                                                alt="{{ $collection->title }}">
                                        @endif
                                    </a>
                                    <div class="content">
                                        <h6 class="fw-normal">
                                            <a href="{{ route('collection.details', $collection->id) }}" class="link">
                                                {{ $collection->title }}
                                            </a>
                                        </h6>
                                        @if ($collection->description)
                                            <p class="text-muted small">{{ Str::limit($collection->description, 50) }}</p>
                                        @endif
                                        {{-- <small class="text-primary">{{ $collection->categories->count() }} categories</small> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback content when no collections are available -->
                        <div class="swiper-slide">
                            <div class="wg-cls hover-img type-abs wow fadeInUp" data-wow-delay="0s">
                                <a href="{{ route('shop') }}" class="img-style d-block">
                                    <img src="{{ asset('frontend-assets/images/collection/cls-grid-1.jpg') }}"
                                        alt="Default Collection">
                                </a>
                                <div class="content">
                                    <h6 class="fw-normal">
                                        <a href="{{ route('shop') }}" class="link">
                                            Browse Our Products
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Category -->

    <!-- Banner Product -->
    <section>
        <div class="container">
            <div class=" swiper tf-sw-categories overflow-xxl-visible" data-preview="2" data-tablet="2"
                data-mobile-sm="1" data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15"
                data-pagination="1" data-pagination-sm="2" data-pagination-md="2" data-pagination-lg="2">
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <a href="{{ route('product-detail') }}"
                            class="banner-image-product-2 style-2 type-sp-2 hover-img d-block">
                            <div class="item-image img-style overflow-visible position3">
                                <img src="{{ asset('frontend-assets/images/item/camera-1.webp') }}"
                                    data-src="{{ asset('frontend-assets/images/item/camera-1.webp') }}" alt=""
                                    class="lazyload">
                            </div>
                            <div class=" item-banner has-bg-img " data-bg-img=""
                                style="background-image: url( {{ asset('frontend-assets/images/banner/banner-4.jpg') }} );"
                                data-bg-size="cover" data-bg-repeat="no-repeat">
                                <div class="inner">
                                    <div class="box-sale-wrap box-price type-3 relative">
                                        <p class="small-text sub-price">From</p>
                                        <p class="main-title-2 num-price">₹1.399</p>
                                    </div>
                                    <h4 class="name fw-normal text-white lh-lg-38 text-xxl-center text-line-clamp-2">
                                        ThinkPad X1 Carbon Gen 9
                                        <br class="d-none d-sm-block">
                                        <span class="fw-bold">
                                            4K HDR-Core i7 32GB
                                        </span>
                                    </h4>

                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <a href="{{ route('product-detail') }}"
                            class="banner-image-product-2 type-sp-2 hover-img d-block">
                            <div class="item-image img-style overflow-visible position2">
                                <img src="{{ asset('frontend-assets/images/item/laptop.webp') }}"
                                    data-src="{{ asset('frontend-assets/images/item/laptop.webp') }}" alt=""
                                    class="lazyload">
                            </div>
                            <div class=" item-banner has-bg-img " data-bg-img=""
                                style="background-image: url({{ asset('frontend-assets/images/banner/banner-3.jpg') }});"
                                data-bg-size="cover" data-bg-repeat="no-repeat">
                                <div class="inner justify-content-xl-end">
                                    <div class="box-sale-wrap type-3 relative">
                                        <p class="small-text">From</p>
                                        <p class="main-title-2">₹399</p>
                                    </div>
                                    <h4 class="name fw-normal text-white lh-lg-38 text-xl-end">
                                        Lenovo ThinkBook
                                        <br>
                                        <span class="fw-bold">
                                            8GB/MX450 2GB
                                        </span>
                                    </h4>

                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="sw-dot-default sw-pagination-categories justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Banner Product -->

    <!-- Tab Product -->
    <div class="tf-sp-2 flat-animate-tab">
        <div class="container">
            <div class="flat-title">
                <div class="flat-title-tab-default">
                    <ul class="menu-tab-line" role="tablist">
                        <li class="nav-tab-item d-flex" role="presentation">
                            <a href="#feature" class="tab-link main-title link fw-semibold active"
                                data-bs-toggle="tab">Feature</a>
                        </li>
                        <li class="nav-tab-item d-flex" role="presentation">
                            <a href="#toprate" class="tab-link main-title link fw-semibold"
                                data-bs-toggle="tab">Toprate</a>
                        </li>
                        <li class="nav-tab-item d-flex" role="presentation">
                            <a href="#on-sale" class="tab-link main-title link fw-semibold" data-bs-toggle="tab">On
                                sale</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active show" id="feature" role="tabpanel">
                    <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                        data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                        data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info px-">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">CCTV</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk
                                                    Night Vision Security Camera (1 Channel)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹72.000</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹92.750</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.1s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Printer</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner
                                                    Cartridge, 1 Ink Bottle Included)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹36.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹45.900</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 3 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.2s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Bio-metric</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance
                                                    (Fingerprint)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹87.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹92.750</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 4 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.3s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Laptop</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11
                                                    Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming
                                                    Laptop
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹42.700</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹53.990</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 5 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.4s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Desktop</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    ASUS AiO A3 Series All in One Desktop, Intel 12th Gen Core i3
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹45.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹56.800</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
                    </div>
                </div>
                <div class="tab-pane" id="toprate" role="tabpanel">
                    <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                        data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                        data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.2s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Bio-metric</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance
                                                    (Fingerprint)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹87.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹92.750</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.4s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Desktop </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    ASUS AiO A3 Series All in One Desktop, Intel 12th Gen Core i3
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹45.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹56.800</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 3 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">CCTV</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk
                                                    Night Vision Security Camera (1 Channel)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹72.000</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹92.750</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 4 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.1s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Printer</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner
                                                    Cartridge, 1 Ink Bottle Included)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹36.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹45.900</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 5 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.3s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Laptop</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11
                                                    Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming
                                                    Laptop
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹42.700</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹53.990</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
                    </div>
                </div>
                <div class="tab-pane" id="on-sale" role="tabpanel">
                    <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                        data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                        data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.1s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Printer</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner
                                                    Cartridge, 1 Ink Bottle Included)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹36.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹45.900</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.3s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Laptop</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11
                                                    Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming
                                                    Laptop
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹42.700</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹53.990</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 3 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">CCTV</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk
                                                    Night Vision Security Camera (1 Channel)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹72.000</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹92.750</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 4 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.4s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Desktop </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    ASUS AiO A3 Series All in One Desktop, Intel 12th Gen Core i3
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹45.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹56.800</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 5 -->
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.2s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="d-none d-sm-block wishlist">
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
                                            <li class="d-none d-sm-block">
                                                <a href="#compare" data-bs-toggle="offcanvas"
                                                    class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                                    <span class="icon icon-compare1"></span>
                                                    <span class="tooltip">Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">Bio-metric</p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance
                                                    (Fingerprint)
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                <span class="new-price price-text fw-medium mb-0">₹87.500</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹92.750</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Tab Product -->

    <div class="tf-sp-2 pt-3">
        <div class="container">
            <img src="{{ asset('frontend-assets/images/banner/AMC.png') }}" style="width: 100%;" alt="AMC">
        </div>
    </div>

    <!-- Product Trend -->
    <section class="tf-sp-2 pt-3">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <h5 class="fw-semibold">Trending Products</h5>
                <!-- <div class="box-btn-slide relative">
                                            <div class="swiper-button-prev nav-swiper nav-prev-products">
                                                <i class="icon-arrow-left-lg"></i>
                                            </div>
                                            <div class="swiper-button-next nav-swiper nav-next-products">
                                                <i class="icon-arrow-right-lg"></i>
                                            </div>
                                        </div> -->
            </div>
            <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3" data-mobile="1"
                data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1" data-pagination-sm="3"
                data-pagination-md="4" data-pagination-lg="5">
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0s">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="d-none d-sm-block wishlist">
                                        <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                    <li class="d-none d-sm-block">
                                        <a href="#compare" data-bs-toggle="offcanvas"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-compare1"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div class="d-flex flex-column">
                                        <p class="caption text-main-2 font-2">Desktop</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            ASUS AiO A3 Series All in One Desktop, Intel 12th Gen Core i3
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium mb-0">₹15.400</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹19.800</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.1s">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="d-none d-sm-block wishlist">
                                        <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                    <li class="d-none d-sm-block">
                                        <a href="#compare" data-bs-toggle="offcanvas"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-compare1"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div class="d-flex flex-column">
                                        <p class="caption text-main-2 font-2">Bio-metric</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance
                                            (Fingerprint)
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium mb-0">₹35.200</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹28.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="d-none d-sm-block wishlist">
                                        <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                    <li class="d-none d-sm-block">
                                        <a href="#compare" data-bs-toggle="offcanvas"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-compare1"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div class="d-flex flex-column">
                                        <p class="caption text-main-2 font-2">CCTV</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk Night
                                            Vision Security Camera (1 Channel)
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium mb-0">₹38.400</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹48.990</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.3s">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="d-none d-sm-block wishlist">
                                        <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                    <li class="d-none d-sm-block">
                                        <a href="#compare" data-bs-toggle="offcanvas"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-compare1"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div class="d-flex flex-column">
                                        <p class="caption text-main-2 font-2">Printer</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner Cartridge, 1
                                            Ink Bottle Included)
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium mb-0">₹26.900</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹33.800</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0.4s">
                            <div class="card-product-wrapper">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                        data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="d-none d-sm-block wishlist">
                                        <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                    <li class="d-none d-sm-block">
                                        <a href="#compare" data-bs-toggle="offcanvas"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-compare1"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div class="d-flex flex-column">
                                        <p class="caption text-main-2 font-2">Laptop</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11 Home/6 GB
                                            Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming Laptop
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium mb-0">₹64.999</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹79.999</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 6 -->
                    <div class="swiper-slide">
                        <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0s">
                            <div class="card-product-wrapper ">
                                <a href="{{ route('product-detail') }}" class="product-img">
                                    <img class="img-product lazyload"
                                        src="{{ asset('frontend-assets/images/product/product-11.jpg') }}"
                                        data-src="{{ asset('frontend-assets/images/product/product-11.jpg') }}"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        src="{{ asset('frontend-assets/images/product/product-38.jpg') }}"
                                        data-src="{{ asset('frontend-assets/images/product/product-38.jpg') }}"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="d-none d-sm-block wishlist">
                                        <a href="#;" class="box-icon btn-icon-action hover-tooltip tooltip-left">
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
                                    <li class="d-none d-sm-block">
                                        <a href="#compare" data-bs-toggle="offcanvas"
                                            class="box-icon btn-icon-action hover-tooltip tooltip-left">
                                            <span class="icon icon-compare1"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info">
                                <div class="box-title">
                                    <div class="d-flex flex-column">
                                        <p class="caption text-main-2 font-2">Gaming Mice</p>
                                        <a href="{{ route('product-detail') }}"
                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                            Klim Blaze Rechargeable Wireless Gaming Mouse – RGB Lighting,
                                            High-Precision Sensor & Long-Lasting Battery
                                        </a>
                                    </div>
                                    <p class="price-wrap fw-medium">
                                        <span class="new-price price-text fw-medium mb-0">₹15.400</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹19.800</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex d-lg-none sw-dot-default sw-pagination-products justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Product Trend -->

    <!-- Banner Product -->
    <section>
        <div class="container">
            <a href="{{ route('product-detail') }}" class="banner-image-product-2 hover-img d-block">
                <div class="item-image item-1 img-style overflow-visible">
                    <img src="{{ asset('frontend-assets/images/item/laptop.webp') }}" style="height: 200%;"
                        data-src="{{ asset('frontend-assets/images/item/laptop.webp') }}" alt=""
                        class="lazyload">
                </div>
                <div class="item-image item-2 img-style overflow-visible d-none d-lg-block">
                    <img src="{{ asset('frontend-assets/images/item/camera-3.webp') }}"
                        data-src="{{ asset('frontend-assets/images/item/camera-3.webp') }}" alt=""
                        class="lazyload">
                </div>
                <div class=" item-banner has-bg-img" data-bg-img="" data-bg-size="cover"
                    style="background-image: url({{ asset('frontend-assets/images/banner/banner-21.jpg') }});"
                    data-bg-repeat="no-repeat">
                    <div class="inner">
                        <h3 class="fw-normal text-white lh-lg-50 font-2">Shop and <span class="fw-bold">SAVE
                                BIG</span>
                            <br>
                            on hottest camera
                        </h3>
                        <div class="box-sale-wrap type-3 relative">
                            <p class="small-text">Save</p>
                            <p class="price-text-2 ">₹67.700</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <!-- /Banner Product -->

    <!-- Application -->
    <section class="tf-sp-2 pt-3">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <h5 class="fw-semibold">Best Selling Products</h5>
                <!-- <div class="box-btn-slide relative">
                                            <div class="swiper-button-prev nav-swiper nav-prev-products">
                                                <i class="icon-arrow-left-lg"></i>
                                            </div>
                                            <div class="swiper-button-next nav-swiper nav-next-products">
                                                <i class="icon-arrow-right-lg"></i>
                                            </div>
                                        </div> -->
            </div>
            <div class="swiper tf-sw-products" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1"
                data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1" data-pagination-sm="2"
                data-pagination-md="3" data-pagination-lg="4">
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <ul class="product-list-wrap wow fadeInUp" data-wow-delay="0s">
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    CCTV
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk
                                                    Night Vision Security Camera
                                                </a>
                                            </div>

                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹14.500</span>
                                                    <span class="old-price body-md-2 text-main-2">₹18.600</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Printer
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner
                                                    Cartridge, 1 Ink Bottle Included)
                                                </a>
                                            </div>
                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹49.900</span>
                                                    <span class="old-price body-md-2 text-main-2">₹62.300</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <ul class="product-list-wrap wow fadeInUp" data-wow-delay="0.1s">
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Laptop
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11
                                                    Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming
                                                    Laptop
                                                </a>
                                            </div>

                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹60.200</span>
                                                    <span class="old-price body-md-2 text-main-2">₹76.900</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    CCTV
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk
                                                    Night Vision Security Camera
                                                </a>
                                            </div>
                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹33.000</span>
                                                    <span class="old-price body-md-2 text-main-2">₹41.600</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <ul class="product-list-wrap wow fadeInUp" data-wow-delay="0.2s">
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Bio-metric
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance
                                                    (Fingerprint)
                                                </a>
                                            </div>

                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹73.200</span>
                                                    <span class="old-price body-md-2 text-main-2">₹91.450</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Laptop
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11
                                                    Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming
                                                    Laptop
                                                </a>
                                            </div>
                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹47.500</span>
                                                    <span class="old-price body-md-2 text-main-2">₹59.300</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <ul class="product-list-wrap wow fadeInUp" data-wow-delay="0.3s">
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Printer
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner
                                                    Cartridge, 1 Ink Bottle Included)
                                                </a>
                                            </div>

                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹65.800</span>
                                                    <span class="old-price body-md-2 text-main-2">₹82.600</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Bio-metric
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance
                                                    (Fingerprint)
                                                </a>
                                            </div>
                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹29.100</span>
                                                    <span class="old-price body-md-2 text-main-2">₹36.450</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <ul class="product-list-wrap wow fadeInUp" data-wow-delay="0s">
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    CCTV
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk
                                                    Night Vision Security Camera
                                                </a>
                                            </div>

                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹14.500</span>
                                                    <span class="old-price body-md-2 text-main-2">₹18.600</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card-product style-row row-small-2 ">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail') }}" class="product-img">
                                            <img class="img-product lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                            <img class="img-hover lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                                alt="image-product">
                                        </a>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="relative z-5">
                                                <p class="caption text-main-2 font-2">
                                                    Printer
                                                </p>
                                                <a href="{{ route('product-detail') }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link">
                                                    HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner
                                                    Cartridge, 1 Ink Bottle Included)
                                                </a>
                                            </div>
                                            <div class="group-btn">
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium">₹49.900</span>
                                                    <span class="old-price body-md-2 text-main-2">₹62.300</span>
                                                </p>
                                                <ul class="list-product-btn flex-row">
                                                    <li>
                                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                            class="box-icon add-to-cart btn-icon-action hover-tooltip">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class=" wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView" data-bs-toggle="modal"
                                                            class="box-icon quickview btn-icon-action hover-tooltip">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            class="box-icon btn-icon-action hover-tooltip">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sw-dot-default sw-pagination-products justify-content-center"></div>

            </div>
        </div>
    </section>
    <!-- /Application -->


    <!-- Newsletter -->
    <div class="modal modalCentered fade auto-popup modal-def modal-newleter" id="newsletterModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <span class="icon icon-close icon-close-popup link btn-hide-popup" data-bs-dismiss="modal"></span>
                <div class="heading">
                    <h5 class="fw-semibold">Join our newsletter for ₹10 offs</h5>
                    <p class="body-md-2">Register now to get latest updates on promotions & coupons. <br>
                        Don’t worry, we not spam!</p>
                </div>
                <form class="form-sub" id="newsletterForm">
                    @csrf
                    <div class="form-content">
                        <fieldset>
                            <input type="email" id="newsletter-email" name="email"
                                placeholder="Enter Your Email Address" aria-required="true" required>
                        </fieldset>
                    </div>
                    <div class="box-btn">
                        <button type="submit" class="tf-btn w-100" id="newsletter-submit-btn">
                            <span class="text-white">Subscribe</span>
                        </button>
                    </div>
                    <div id="newsletter-message" class="mt-3" style="display: none;"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Newsletter -->

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

            // Newsletter subscription form handling
            $('#newsletterForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = $('#newsletter-submit-btn');
                const messageDiv = $('#newsletter-message');
                const email = $('#newsletter-email').val();

                // Disable submit button and show loading state
                submitBtn.prop('disabled', true);
                submitBtn.find('span').text('Subscribing...');
                messageDiv.hide();

                // AJAX request to subscribe
                $.ajax({
                    url: '{{ route('newsletter.subscribe') }}',
                    type: 'POST',
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content') || $(
                            'input[name="_token"]').val()
                    },
                    success: function(response) {

                        if (response.success) {
                            // Show success message
                            messageDiv.html('<div class="alert alert-success">' + response
                                .message + '</div>').show();

                            // Clear form
                            form[0].reset();

                            // Set localStorage to prevent popup from showing again
                            localStorage.setItem('newsletterSubscribed', 'true');
                            sessionStorage.setItem('showPopup', 'true');

                            // Close modal after 3 seconds
                            setTimeout(function() {
                                $('#newsletterModal').modal('hide');
                            }, 3000);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        // Show error message
                        messageDiv.html('<div class="alert alert-danger">' + errorMessage +
                            '</div>').show();
                    },
                    complete: function() {
                        // Re-enable submit button
                        submitBtn.prop('disabled', false);
                        submitBtn.find('span').text('Subscribe');
                    }
                });
            });

            // Enhanced auto-popup functionality with localStorage check
            function initNewsletterPopup() {
                if ($(".auto-popup").length > 0) {
                    // Check if user has already subscribed
                    const hasSubscribed = localStorage.getItem('newsletterSubscribed');
                    const showPopup = sessionStorage.getItem('showPopup');

                    // Only show popup if user hasn't subscribed and session flag is not set
                    if (!hasSubscribed && !JSON.parse(showPopup)) {
                        setTimeout(function() {
                            $(".auto-popup").modal("show");
                        }, 3000);
                    }
                }
            }

            // Initialize popup
            initNewsletterPopup();

            // Handle popup close button
            $(".btn-hide-popup").on("click", function() {
                sessionStorage.setItem("showPopup", true);
            });

            // Countdown Timer for Deal of the Day
            function initCountdownTimers() {
                $('.countdown-timer').each(function() {
                    const $timer = $(this);
                    const endTime = new Date($timer.data('end-time')).getTime();

                    function updateTimer() {
                        const now = new Date().getTime();
                        const timeLeft = endTime - now;

                        if (timeLeft > 0) {
                            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                            $timer.find('.days').text(String(days).padStart(2, '0'));
                            $timer.find('.hours').text(String(hours).padStart(2, '0'));
                            $timer.find('.minutes').text(String(minutes).padStart(2, '0'));
                            $timer.find('.seconds').text(String(seconds).padStart(2, '0'));
                        } else {
                            // Deal expired
                            $timer.find('.days, .hours, .minutes, .seconds').text('00');
                            $timer.closest('.swiper-slide').fadeOut();
                        }
                    }

                    // Update immediately and then every second
                    updateTimer();
                    setInterval(updateTimer, 1000);
                });
            }

            // Initialize countdown timers
            initCountdownTimers();
        });
    </script>

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
                                            $('.model_main_product_image').attr('src', response.data
                                                .main_product_image);
                                            $('.model_additional_product_image').attr('src', response.data
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
                                            $('model_product_quantity-product').val(response.data.min_order_qty);
                                            $('.add-to-cart-btn, .add-to-cart').data('product-id', response.data.id);
                                        @endforeach

                                        // Note: Add to Cart, Wishlist, and Compare functionality is handled by product-actions.js
                                }
                            },
                            error: function(e) {
                                console.log(e.responseText);
                                console.log('Error fetching product details');
                            }
                        });
                });

            // Note: Add to Wishlist functionality is handled by product-actions.js

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

        // Note: Cart, Wishlist, and Compare functionality is handled by product-actions.js
        // Wishlist count function is now global in master layout
        // Cart count function is now global in master layout

        // Function to update cart sidebar
        function updateCartSidebar() {
            $.ajax({
                url: '{{ route('cart.data') }}',
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
