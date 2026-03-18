@extends('frontend/layout/master')

@section('main-content')
    <div class="container-fluid" style="z-index: 10;display: flex;opacity: 0.9;position: absolute;">
        <div class="container">
            <div class="category-scroll-container box-btn-slide-2 sw-nav-effect wow fadeInUp" data-wow-delay="0s">
                <div class="swiper tf-sw-products slider-category" data-preview="10" data-tablet="7" data-mobile-sm="4"
                    data-mobile="3" data-pagination="2" data-pagination-sm="4" data-pagination-md="7"
                    data-pagination-lg="10">
                    <div class="category-track swiper-wrapper">
                        @if (isset($categories) && $categories->count() > 0)
                            @foreach ($categories as $category)
                                <div class="category-item swiper-slide">
                                    <a href="{{ route('shop') }}?category={{ $category->id }}" class="hover-img"
                                        style="text-decoration: none;">
                                        <img src="{{ $category->image ? asset($category->image) : asset('frontend-assets/images/new-products/default-category.png') }}"
                                            alt="{{ $category->name }}"
                                            style="width: 100%; height: auto; object-fit: cover;">
                                        <span style="color: #ffffff;">{{ $category->name }}</span>
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
                        style="background-image: url('{{ asset($banner->image_url) ?? asset('frontend-assets/images/banner/main-banner-1.jpg') }}');">
                        <div class="container">
                            <div class="carousel-caption">
                                @if ($banner->title)
                                    <h1>{!! nl2br(e($banner->title)) !!}</h1>
                                @endif
                                @if ($banner->description)
                                    <p>{{ $banner->description }}</p>
                                @endif
                                @if ($banner->link_url)
                                    <a href="{{ $banner->link_url }}"
                                        target="{{ $banner->link_target == '1' ? '_blank' : '_self' }}"
                                        class="btn btn-outline-light">EXPLORE NOW</a>
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
    {{-- @foreach ($activeDeals as $deal)
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
                                                        <a href="{{ route('ecommerce.product.detail', $dealItem->ecommerceProduct->id) }}"
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
    @endforeach --}}
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
                                    <a href=""
                                        class="img-style d-block">
                                        @if ($collection->image_url)
                                            <img src="{{ asset($collection->image_url) }}"
                                                alt="{{ $collection->name }}">
                                        @else
                                            <img src="{{ asset('frontend-assets/images/collection/default-collection.jpg') }}"
                                                alt="{{ $collection->name }}">
                                        @endif
                                    </a>
                                    <div class="content">
                                        <h6 class="fw-normal">
                                            {{-- <a href="{{ route('collection.details', $collection->id) }}" class="link">
                                                {{ $collection->name }}
                                            </a> --}}
                                            {{ $collection->name }}
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
                        <a href="{{ route('shop') }}"
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
                        <a href="{{ route('shop') }}"
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
                            @if (isset($featuredProducts) && $featuredProducts->count() > 0)
                                @foreach ($featuredProducts as $index => $product)
                                    <div class="swiper-slide">
                                        <div class="card-product style-img-border wow fadeInLeft"
                                            data-wow-delay="{{ $index * 0.1 }}s">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                    class="product-img">
                                                    @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                        @if (!empty($product->warehouseProduct->additional_product_images))
                                                            @php
                                                                $images =
                                                                    $product->warehouseProduct
                                                                        ->additional_product_images;

                                                                // agar string hai to array bana do
                                                                if (!is_array($images)) {
                                                                    $decoded = json_decode($images, true);

                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        $images = $decoded; // JSON string -> array
                                                                    } else {
                                                                        $images = $images ? [$images] : []; // normal string -> array
                                                                    }
                                                                }
                                                            @endphp

                                                            @if (count($images) > 0)
                                                                <img class="img-hover lazyload"
                                                                    src="{{ asset($images[0]) }}"
                                                                    data-src="{{ asset($images[0]) }}"
                                                                    alt="{{ $product->warehouseProduct->product_name }}">
                                                            @endif
                                                        @else
                                                            <img class="img-hover lazyload"
                                                                src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                alt="image-product">
                                                        @endif
                                                    @else
                                                        <img class="img-product lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            alt="Product Image">
                                                        <img class="img-hover lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            alt="image-product">
                                                    @endif
                                                </a>
                                                {{-- <ul class="list-product-btn">
                                                    <li>
                                                        <a href="#;"
                                                            class="box-icon add-to-cart-btn btn-icon-action hover-tooltip tooltip-left"
                                                            data-product-id="{{ $product->id }}"
                                                            data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                            <span class="icon icon-cart2"></span>
                                                            <span class="tooltip">Add to Cart</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-none d-sm-block wishlist">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip tooltip-left add-to-wishlist-btn"
                                                            data-product-id="{{ $product->id }}"
                                                            data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                            <span class="icon icon-heart2"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#quickView{{ $product->id }}" data-bs-toggle="modal"
                                                            data-product-id="{{ $product->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-none d-sm-block">
                                                        <a href="#;"
                                                            class="box-icon btn-icon-action hover-tooltip tooltip-left compare-btn"
                                                            data-product-id="{{ $product->id }}"
                                                            data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                            <span class="icon icon-compare1"></span>
                                                            <span class="tooltip">Compare</span>
                                                        </a>
                                                    </li>
                                                </ul> --}}

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
                                                    {{-- <li>
                                                        <a href="{{ route('product.detail', $product->id) }}"
                                                            data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                            <div class="card-product-info px-">
                                                <div class="box-title">
                                                    <div class="d-flex flex-column">
                                                        <p class="caption text-main-2 font-2">
                                                            {{ $product->warehouseProduct->brand->name ?? 'Brand' }}</p>
                                                        <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                                            {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                        </a>
                                                    </div>
                                                    <p class="price-wrap fw-medium">
                                                        @if ($product->warehouseProduct && $product->warehouseProduct->discount_price > 0)
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->final_price ?? 0, 0) }}</span>
                                                            <span
                                                                class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->final_price + $product->warehouseProduct->discount_price, 2) }}</span>
                                                        @else
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 0) }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback when no featured products are available -->
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
                                                        No Featured Products Available
                                                    </a>
                                                </div>
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium mb-0">₹0</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="toprate" role="tabpanel">
                    <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                        data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                        data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                        <div class="swiper-wrapper">
                            @if (isset($suggestedProducts) && $suggestedProducts->count() > 0)
                                @foreach ($suggestedProducts as $index => $product)
                                    <div class="swiper-slide">
                                        <div class="card-product style-img-border wow fadeInLeft"
                                            data-wow-delay="{{ $index * 0.1 }}s">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                    class="product-img">
                                                    @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                        @if (!empty($product->warehouseProduct->additional_product_images))
                                                            @php
                                                                $images =
                                                                    $product->warehouseProduct
                                                                        ->additional_product_images;

                                                                // agar string hai to array bana do
                                                                if (!is_array($images)) {
                                                                    $decoded = json_decode($images, true);

                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        $images = $decoded; // JSON string -> array
                                                                    } else {
                                                                        $images = $images ? [$images] : []; // normal string -> array
                                                                    }
                                                                }
                                                            @endphp

                                                            @if (count($images) > 0)
                                                                <img class="img-hover lazyload"
                                                                    src="{{ asset($images[0]) }}"
                                                                    data-src="{{ asset($images[0]) }}"
                                                                    alt="{{ $product->warehouseProduct->product_name }}">
                                                            @endif
                                                        @else
                                                            <img class="img-hover lazyload"
                                                                src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                alt="image-product">
                                                        @endif
                                                    @else
                                                        <img class="img-product lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            alt="Product Image">
                                                        <img class="img-hover lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            alt="image-product">
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
                                                    {{-- <li>
                                                        <a href="{{ route('product.detail', $product->id) }}"
                                                            data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                            <div class="card-product-info px-">
                                                <div class="box-title">
                                                    <div class="d-flex flex-column">
                                                        <p class="caption text-main-2 font-2">
                                                            {{ $product->warehouseProduct->brand->name ?? 'Brand' }}</p>
                                                        <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                                            {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                        </a>
                                                    </div>
                                                    <p class="price-wrap fw-medium">
                                                        @if ($product->warehouseProduct && $product->warehouseProduct->discount_price > 0)
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->final_price ?? 0, 0) }}</span>
                                                            <span
                                                                class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->final_price + $product->warehouseProduct->discount_price, 2) }}</span>
                                                        @else
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 0) }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback when no suggested products are available -->
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
                                                        No Suggested Products Available
                                                    </a>
                                                </div>
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium mb-0">₹0</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
                    </div>
                </div>
                <div class="tab-pane" id="on-sale" role="tabpanel">
                    <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                        data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                        data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                        <div class="swiper-wrapper">
                            @if (isset($todaysDealProducts) && $todaysDealProducts->count() > 0)
                                @foreach ($todaysDealProducts as $index => $product)
                                    <div class="swiper-slide">
                                        <div class="card-product style-img-border wow fadeInLeft"
                                            data-wow-delay="{{ $index * 0.1 }}s">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                    class="product-img">
                                                    @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                        @if (!empty($product->warehouseProduct->additional_product_images))
                                                            @php
                                                                $images =
                                                                    $product->warehouseProduct
                                                                        ->additional_product_images;

                                                                // agar string hai to array bana do
                                                                if (!is_array($images)) {
                                                                    $decoded = json_decode($images, true);

                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        $images = $decoded; // JSON string -> array
                                                                    } else {
                                                                        $images = $images ? [$images] : []; // normal string -> array
                                                                    }
                                                                }
                                                            @endphp

                                                            @if (count($images) > 0)
                                                                <img class="img-hover lazyload"
                                                                    src="{{ asset($images[0]) }}"
                                                                    data-src="{{ asset($images[0]) }}"
                                                                    alt="{{ $product->warehouseProduct->product_name }}">
                                                            @endif
                                                        @else
                                                            <img class="img-hover lazyload"
                                                                src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                alt="image-product">
                                                        @endif
                                                    @else
                                                        <img class="img-product lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            alt="Product Image">
                                                        <img class="img-hover lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            alt="image-product">
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
                                                    {{-- <li>
                                                        <a href="{{ route('product.detail', $product->id) }}"
                                                            data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                            <div class="card-product-info px-">
                                                <div class="box-title">
                                                    <div class="d-flex flex-column">
                                                        <p class="caption text-main-2 font-2">
                                                            {{ $product->warehouseProduct->brand->name ?? 'Brand' }}</p>
                                                        <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                                            {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                        </a>
                                                    </div>
                                                    <p class="price-wrap fw-medium">
                                                        @if ($product->warehouseProduct && $product->warehouseProduct->discount_price > 0)
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->final_price ?? 0, 0) }}</span>
                                                            <span
                                                                class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->final_price + $product->warehouseProduct->discount_price, 2) }}</span>
                                                        @else
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 0) }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback when no todays deal products are available -->
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
                                                    <p class="caption text-main-2 font-2">No Products</p>
                                                    <a href="{{ route('product-detail') }}"
                                                        class="name-product body-md-2 fw-semibold text-secondary link">
                                                        No deals available
                                                    </a>
                                                </div>
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium mb-0">₹0</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
                    </div>
                </div>
                <div class="tab-pane" id="on-sale" role="tabpanel">
                    <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                        data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1"
                        data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                        <div class="swiper-wrapper">
                            @if (isset($todaysDealProducts) && $todaysDealProducts->count() > 0)
                                @foreach ($todaysDealProducts as $index => $product)
                                    <div class="swiper-slide">
                                        <div class="card-product style-img-border wow fadeInLeft"
                                            data-wow-delay="{{ $index * 0.1 }}s">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                    class="product-img">
                                                    @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                        @if (!empty($product->warehouseProduct->additional_product_images))
                                                            @php
                                                                $images =
                                                                    $product->warehouseProduct
                                                                        ->additional_product_images;

                                                                // agar string hai to array bana do
                                                                if (!is_array($images)) {
                                                                    $decoded = json_decode($images, true);

                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        $images = $decoded; // JSON string -> array
                                                                    } else {
                                                                        $images = $images ? [$images] : []; // normal string -> array
                                                                    }
                                                                }
                                                            @endphp

                                                            @if (count($images) > 0)
                                                                <img class="img-hover lazyload"
                                                                    src="{{ asset($images[0]) }}"
                                                                    data-src="{{ asset($images[0]) }}"
                                                                    alt="{{ $product->warehouseProduct->product_name }}">
                                                            @endif
                                                        @else
                                                            <img class="img-hover lazyload"
                                                                src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                alt="image-product">
                                                        @endif
                                                    @else
                                                        <img class="img-product lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            alt="Product Image">
                                                        <img class="img-hover lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            alt="image-product">
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
                                                    {{-- <li>
                                                        <a href="{{ route('product.detail', $product->id) }}"
                                                            data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                            <div class="card-product-info px-">
                                                <div class="box-title">
                                                    <div class="d-flex flex-column">
                                                        <p class="caption text-main-2 font-2">
                                                            {{ $product->warehouseProduct->brand->name ?? 'Brand' }}</p>
                                                        <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                                            {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                        </a>
                                                    </div>
                                                    <p class="price-wrap fw-medium">
                                                        @if ($product->warehouseProduct && $product->warehouseProduct->discount_price > 0)
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->final_price ?? 0, 0) }}</span>
                                                            <span
                                                                class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->final_price + $product->warehouseProduct->discount_price, 2) }}</span>
                                                        @else
                                                            <span
                                                                class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 0) }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback when no todays deal products are available -->
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
                                                    <p class="caption text-main-2 font-2">No Products</p>
                                                    <a href="{{ route('product-detail') }}"
                                                        class="name-product body-md-2 fw-semibold text-secondary link">
                                                        No deals available
                                                    </a>
                                                </div>
                                                <p class="price-wrap fw-medium">
                                                    <span class="new-price price-text fw-medium mb-0">₹0</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                    @if (isset($trendingProducts) && $trendingProducts->count() > 0)
                        @foreach ($trendingProducts as $index => $product)
                            <div class="swiper-slide">
                                <div class="card-product style-img-border wow fadeInLeft"
                                    data-wow-delay="{{ $index * 0.1 }}s">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                            class="product-img">
                                            @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                <img class="img-product lazyload"
                                                    src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                    data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                    alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                @if (isset($product->warehouseProduct->additional_product_images[0]))
                                                    @php
                                                        $images = $product->warehouseProduct->additional_product_images;

                                                        // agar string hai to array bana do
                                                        if (!is_array($images)) {
                                                            $decoded = json_decode($images, true);

                                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                                $images = $decoded; // JSON string -> array
                                                            } else {
                                                                $images = $images ? [$images] : []; // normal string -> array
                                                            }
                                                        }
                                                    @endphp

                                                    @if (count($images) > 0)
                                                        <img class="img-hover lazyload" src="{{ asset($images[0]) }}"
                                                            data-src="{{ asset($images[0]) }}"
                                                            alt="{{ $product->warehouseProduct->product_name }}">
                                                    @endif
                                                @endif
                                            @else
                                                <img class="img-product lazyload"
                                                    src="{{ asset('frontend-assets/images/product/product-1.jpg') }}"
                                                    data-src="{{ asset('frontend-assets/images/product/product-1.jpg') }}"
                                                    alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
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
                                            {{-- <li>
                                                        <a href="{{ route('product.detail', $product->id) }}"
                                                            data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                            class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Quick View</span>
                                                        </a>
                                                    </li> --}}
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="box-title">
                                            <div class="d-flex flex-column">
                                                <p class="caption text-main-2 font-2">
                                                    {{ optional($product->warehouseProduct->parentCategorie)->name ?? 'Category' }}
                                                </p>
                                                <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                    class="name-product body-md-2 fw-semibold text-secondary link text-truncate"
                                                    style="max-width: 230px;">
                                                    {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                </a>
                                            </div>
                                            <p class="price-wrap fw-medium">
                                                @if ($product->warehouseProduct && $product->warehouseProduct->discount_price > 0)
                                                    <span
                                                        class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->final_price ?? 0, 0) }}</span>
                                                    <span
                                                        class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->final_price + $product->warehouseProduct->discount_price, 2) }}</span>
                                                @else
                                                    <span
                                                        class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 0) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">No trending products available</p>
                    @endif
                </div>
                <div class="d-flex d-lg-none sw-dot-default sw-pagination-products justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Product Trend -->

    <!-- Banner Product -->
    <section>
        <div class="container">
            <a href="{{ route('shop') }}" class="banner-image-product-2 hover-img d-block">
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
            </div>
            <div class="swiper tf-sw-products" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1"
                data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1" data-pagination-sm="2"
                data-pagination-md="3" data-pagination-lg="4">
                <div class="swiper-wrapper">
                    @if (isset($bestSellerProducts) && $bestSellerProducts->count() > 0)
                        @foreach ($bestSellerProducts as $index => $product)
                            <div class="swiper-slide">
                                <ul class="product-list-wrap wow fadeInUp" data-wow-delay="{{ $index * 0.1 }}s">
                                    <li>
                                        <div class="card-product style-row row-small-2 ">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                    class="product-img">
                                                    @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                                        <img class="img-product lazyload"
                                                            src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                            alt="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                        @if (!empty($product->warehouseProduct->additional_product_images))
                                                            @php
                                                                $images =
                                                                    $product->warehouseProduct
                                                                        ->additional_product_images;

                                                                // agar string hai to array bana do
                                                                if (!is_array($images)) {
                                                                    $decoded = json_decode($images, true);

                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        $images = $decoded; // JSON string -> array
                                                                    } else {
                                                                        $images = $images ? [$images] : []; // normal string -> array
                                                                    }
                                                                }
                                                            @endphp

                                                            @if (count($images) > 0)
                                                                <img class="img-hover lazyload"
                                                                    src="{{ asset($images[0]) }}"
                                                                    data-src="{{ asset($images[0]) }}"
                                                                    alt="{{ $product->warehouseProduct->product_name }}">
                                                            @endif
                                                        @else
                                                            <img class="img-hover lazyload"
                                                                src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                                alt="image-product">
                                                        @endif
                                                    @else
                                                        <img class="img-product lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                                            alt="Product Image">
                                                        <img class="img-hover lazyload"
                                                            src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                                            alt="image-product">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-product-info">
                                                <div class="box-title">
                                                    <div class="relative z-5">
                                                        <p class="caption text-main-2 font-2">
                                                            {{ $product->warehouseProduct->brand->name ?? 'Brand' }}
                                                        </p>
                                                        <a href="{{ route('ecommerce.product.detail', $product->id) }}"
                                                            class="name-product body-md-2 fw-semibold text-secondary link">
                                                            {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                                        </a>
                                                    </div>

                                                    <div class="group-btn">
                                                        <p class="price-wrap fw-medium">
                                                            @if ($product->warehouseProduct && $product->warehouseProduct->discount_price > 0)
                                                                <span
                                                                    class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->final_price ?? 0, 0) }}</span>
                                                                <span
                                                                    class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->final_price + $product->warehouseProduct->discount_price, 2) }}</span>
                                                            @else
                                                                <span
                                                                    class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 0) }}</span>
                                                            @endif
                                                        </p>

                                                        <ul class="list-product-btn flex-row">
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
                                                            {{-- <li>
                                                                <a href="{{ route('product.detail', $product->id) }}"
                                                                    data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                                    class="box-icon quickview btn-icon-action hover-tooltip tooltip-left">
                                                                    <span class="icon icon-view"></span>
                                                                    <span class="tooltip">Quick View</span>
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
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
                <span class="icon-close icon-close-popup link btn-hide-popup" data-bs-dismiss="modal"></span>
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

        });

        $(document).ready(function() {
            // CSRF token setup for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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

            // Add to Cart button handler for shop page (Toggle: add if not in cart, remove if in cart)
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();

                const $button = $(this);
                const productId = $button.data('product-id');
                const quantity = 1;

                // Show loading state
                const originalHtml = $button.html();
                $button.html('<i class="fa-solid fa-spinner fa-spin"></i>');
                $button.prop('disabled', true);

                // Make AJAX request to toggle cart (add if not in cart, remove if in cart)
                $.ajax({
                    url: '{{ route('cart.toggle') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            // Update button state based on action
                            if (response.action === 'added') {
                                $button.html('<i class="icon-cart-2"></i>');
                                $button.addClass('in-cart');
                            } else {
                                $button.html(
                                    '<span class="icon icon-cart2"></span><span class="tooltip">Add to Cart</span>'
                                );
                                $button.removeClass('in-cart');
                            }

                            // Update cart count and sidebar
                            updateCartCount();
                            updateCartSidebar();
                        } else {
                            showNotification(response.message, 'error');
                            $button.html(originalHtml);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON
                            .requires_auth) {
                            showLoginModal();
                        } else {
                            showNotification('Error updating cart. Please try again.', 'error');
                        }
                        $button.html(originalHtml);
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
            });

            // Add to Wishlist button handler for shop page (Toggle: add if not in wishlist, remove if in wishlist)
            $(document).on('click', '.add-to-wishlist-btn', function(e) {
                e.preventDefault();

                const $button = $(this);
                const productId = $button.data('product-id');

                // Show loading state
                const originalHtml = $button.html();
                $button.html('<i class="fa-solid fa-spinner fa-spin"></i>');
                $button.prop('disabled', true);

                // Make AJAX request to toggle wishlist
                $.ajax({
                    url: '{{ route('wishlist.toggle') }}',
                    method: 'POST',
                    data: {
                        ecommerce_product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            // Update button state based on action
                            if (response.action === 'added') {
                                $button.addClass('in-wishlist');
                                $button.find('i').removeClass('fa-heart').addClass(
                                    'fa-solid fa-heart');
                            } else {
                                $button.removeClass('in-wishlist');
                                $button.find('i').removeClass('fa-solid fa-heart').addClass(
                                    'fa-heart');
                            }

                            // Update wishlist count
                            updateWishlistCount();
                        } else {
                            showNotification(response.message, 'error');
                            $button.html(originalHtml);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON
                            .requires_auth) {
                            showLoginModal();
                        } else {
                            showNotification('Error updating wishlist. Please try again.',
                                'error');
                        }
                        $button.html(originalHtml);
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
            });

            // Compare button handler for shop page
            $(document).on('click', '.compare-btn', function(e) {
                e.preventDefault();

                const $button = $(this);
                const productId = $button.data('product-id');

                // Show loading state
                const originalHtml = $button.html();
                $button.html('<i class="fa-solid fa-spinner fa-spin"></i>');
                $button.prop('disabled', true);

                // Make AJAX request to toggle compare
                $.ajax({
                    url: '{{ route('compare.add') }}',
                    method: 'POST',
                    data: {
                        ecommerce_product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            // Update button state based on action
                            if (response.action === 'added') {
                                $button.addClass('in-compare');
                            } else {
                                $button.removeClass('in-compare');
                            }

                            // Update compare count
                            updateCompareCount();
                        } else {
                            showNotification(response.message, 'error');
                            $button.html(originalHtml);
                        }
                    },
                    error: function(xhr) {
                        showNotification('Error updating compare list. Please try again.',
                            'error');
                        $button.html(originalHtml);
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
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
                                // Check if user is authenticated
                                @if (!auth('customer_web'))
                                    showNotification(
                                        'Please login to add products to your wishlist.',
                                        'warning');
                                    return;
                                @endif

                                // Show loading state
                                const originalText = $button.html();
                                $button.html(
                                    '<i class="spinner-border spinner-border-sm me-2"></i>'
                                );
                                $button.prop('disabled', true);

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
                                            showNotification(response
                                                .message,
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
                                            showNotification(response
                                                .message,
                                                'error');
                                            // Reset button state
                                            $button.html(originalText);
                                        }
                                    },
                                    error: function(xhr) {
                                        if (xhr.status === 401 && xhr
                                            .responseJSON && xhr
                                            .responseJSON
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
                                    <p class="caption text-main-2">(${product.total_sold || 0})</p>
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

            // Add to Wishlist functionality
            $('.add-to-wishlist-btn').on('click', function(e) {
                e.preventDefault();

                const $button = $(this);
                const productId = $button.data('product-id');
                const productName = $button.data('product-name');

                // Check if user is authenticated
                @if (!auth('customer_web'))
                    showNotification('Please login to add products to your wishlist.', 'warning');
                    return;
                @endif

                // Show loading state
                const originalIcon = $button.find('.icon').attr('class');
                const originalTooltip = $button.find('.tooltip').text();

                $button.find('.icon').attr('class', 'icon icon-loading');
                $button.find('.tooltip').text('Adding...');
                $button.prop('disabled', true);

                // Make AJAX request
                $.ajax({
                    url: '{{ route('wishlist.toggle') }}',
                    method: 'POST',
                    data: {
                        ecommerce_product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            // Update button state based on action
                            if (response.action === 'added') {
                                $button.find('.icon').attr('class', 'icon icon-heart-fill');
                                $button.find('.tooltip').text('In Wishlist');
                                $button.addClass('in-wishlist');
                            } else if (response.action === 'removed') {
                                $button.find('.icon').attr('class', 'icon icon-heart2');
                                $button.find('.tooltip').text('Add to Wishlist');
                                $button.removeClass('in-wishlist');
                            }

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
                        let message = 'An error occurred while updating the wishlist.';

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

        });
    </script>
@endsection
