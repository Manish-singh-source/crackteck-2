@extends('frontend/layout/master')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('website') }}" class="body-small link" itemprop="item">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1" />
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="icon icon-arrow-right"></i>
                    </li>
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('shop') }}" class="body-small link" itemprop="item">
                            <span itemprop="name">Shop</span>
                        </a>
                        <meta itemprop="position" content="2" />
                    </li>
                    @if ($product->warehouseProduct && $product->warehouseProduct->parentCategorie)
                        <li class="d-flex align-items-center">
                            <i class="icon icon-arrow-right"></i>
                        </li>
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope
                            itemtype="https://schema.org/ListItem">
                            <a href="{{ route('shop') }}?category={{ $product->warehouseProduct->parentCategorie->id }}"
                                class="body-small link" itemprop="item">
                                <span
                                    itemprop="name">{{ $product->warehouseProduct->parentCategorie->parent_categories }}</span>
                            </a>
                            <meta itemprop="position" content="3" />
                        </li>
                    @endif
                    <li class="d-flex align-items-center">
                        <i class="icon icon-arrow-right"></i>
                    </li>
                    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <span class="body-small"
                            itemprop="name">{{ $product->warehouseProduct->product_name ?? 'Product Detail' }}</span>
                        <meta itemprop="position" content="4" />
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- /Breadcrumbs -->

    <!-- Product Main -->
    <section>
        <div class="tf-main-product section-image-zoom border-bt mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Product Image -->
                        <div class="tf-product-media-wrap thumbs-default sticky-top">
                            <div class="thumbs-slider">
                                <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                                    <div class="swiper-wrapper">
                                        @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                            <!-- Main Product Image -->
                                            <div class="swiper-slide" data-color="main">
                                                <a href="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                    target="_blank" class="item" data-pswp-width="600px"
                                                    data-pswp-height="800px">
                                                    <img class="tf-image-zoom ls-is-cached lazyload"
                                                        src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                        data-zoom="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                        data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                        alt="{{ $product->warehouseProduct->product_name }}">
                                                </a>
                                            </div>

                                            @if (
                                                $product->warehouseProduct->additional_product_images &&
                                                    count($product->warehouseProduct->additional_product_images) > 0)
                                                @foreach ($product->warehouseProduct->additional_product_images as $index => $image)
                                                    <div class="swiper-slide" data-color="additional-{{ $index }}">
                                                        <a href="{{ asset($image) }}" target="_blank" class="item"
                                                            data-pswp-width="600px" data-pswp-height="800px">
                                                            <img class="tf-image-zoom lazyload"
                                                                data-zoom="{{ asset($image) }}"
                                                                data-src="{{ asset($image) }}" src="{{ asset($image) }}"
                                                                alt="{{ $product->warehouseProduct->product_name }} - Image {{ $index + 1 }}">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <!-- Placeholder Image -->
                                            <div class="swiper-slide" data-color="placeholder">
                                                <a href="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                    target="_blank" class="item" data-pswp-width="600px"
                                                    data-pswp-height="800px">
                                                    <img class="tf-image-zoom ls-is-cached lazyload"
                                                        src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                        data-zoom="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                        data-src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                        alt="No Image Available">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="swiper-button-next button-style-arrow thumbs-next"></div>
                                    <div class="swiper-button-prev button-style-arrow thumbs-prev"></div>
                                </div>
                                <div class="swiper tf-product-media-thumbs" id="gallery-thumbs-started">
                                    <div class="swiper-wrapper stagger-wrap">
                                        @if ($product->warehouseProduct && $product->warehouseProduct->main_product_image)
                                            <!-- Main Image Thumbnail -->
                                            <div class="swiper-slide stagger-item" data-color="main">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                        src="{{ asset($product->warehouseProduct->main_product_image) }}"
                                                        alt="{{ $product->warehouseProduct->product_name }}">
                                                </div>
                                            </div>

                                            @if (
                                                $product->warehouseProduct->additional_product_images &&
                                                    count($product->warehouseProduct->additional_product_images) > 0)
                                                @foreach ($product->warehouseProduct->additional_product_images as $index => $image)
                                                    <div class="swiper-slide stagger-item"
                                                        data-color="additional-{{ $index }}">
                                                        <div class="item">
                                                            <img class="lazyload" data-src="{{ asset($image) }}"
                                                                src="{{ asset($image) }}"
                                                                alt="{{ $product->warehouseProduct->product_name }} - Thumbnail {{ $index + 1 }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <!-- Placeholder Thumbnail -->
                                            <div class="swiper-slide stagger-item" data-color="placeholder">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                        src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                        alt="No Image Available">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Image -->
                    </div>
                    <div class="col-md-6">
                        <div class="tf-product-info-wrap position-relative">
                            <div class="tf-zoom-main"></div>
                            <div class="tf-product-info-list style-2">
                                <div class="tf-product-info-content">
                                    <div class="infor-heading">
                                        <!-- Category Badge -->
                                        @if ($product->warehouseProduct && $product->warehouseProduct->parentCategorie)
                                            <div class="caption mb-2">
                                                <span class="">
                                                    {{ $product->warehouseProduct->parentCategorie->parent_categories }}
                                                    @if ($product->warehouseProduct->subCategorie)
                                                        > {{ $product->warehouseProduct->subCategorie->sub_categorie }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif

                                        <h5 class="product-info-name fw-semibold lh-base">
                                            {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                        </h5>

                                        {{-- <ul class="product-info-rate-wrap">
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
                                            <a href="shop.php" class="caption text-secondary link">View
                                                shop</a>
                                        </li>
                                    </ul> --}}

                                        <!-- Rating and Reviews -->
                                        <div class="product-rating-section mb-0">
                                            <div class="d-flex align-items-center flex-wrap gap-3">
                                                <div class="star-rating">
                                                    <ul class="list-star">
                                                        <li><i class="icon-star text-warning"></i></li>
                                                        <li><i class="icon-star text-warning"></i></li>
                                                        <li><i class="icon-star text-warning"></i></li>
                                                        <li><i class="icon-star text-warning"></i></li>
                                                        <li><i class="icon-star text-muted"></i></li>
                                                    </ul>
                                                    {{-- <span class="rating-text ms-2">4.5 ★★★★☆</span> --}}
                                                </div>
                                                <div class="review-count">
                                                    <span class="caption text-main-2">(127 reviews)</span>
                                                </div>
                                                <div class="sold-count">
                                                    <span class="caption text-main-2">{{ $product->total_sold ?? 0 }}
                                                        sold</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="infor-center">
                                        <div class="product-info-price">
                                            @if ($product->warehouseProduct)
                                                @if ($product->warehouseProduct->selling_price)
                                                    <h4 class="text-primary">
                                                        ₹{{ number_format($product->warehouseProduct->selling_price, 2) }}
                                                    </h4>
                                                    @if (
                                                        $product->warehouseProduct->cost_price &&
                                                            $product->warehouseProduct->cost_price > $product->warehouseProduct->selling_price)
                                                        <span
                                                            class="price-text text-main-2 old-price">₹{{ number_format($product->warehouseProduct->cost_price, 2) }}</span>
                                                    @endif
                                                @endif
                                            @else
                                                <span class="new-price price-text fw-medium">₹0.00</span>
                                            @endif
                                            <!-- Shipping Information -->
                                            <div class="shipping-info d-flex align-items-center gap-2">
                                                <i class="icon-delivery-2 text-success"></i>
                                                @if ($product->shipping_charges && $product->shipping_charges > 0)
                                                    <span class="text-muted">Shipping:
                                                        ₹{{ number_format($product->shipping_charges, 2) }}</span>
                                                @else
                                                    <span class="text-success fw-semibold">Free shipping</span>
                                                @endif
                                                <span class="text-muted">• Delivery in 2-5 business days</span>
                                            </div>


                                        </div>
                                        <div class="product-delivery">
                                            <div class="tf-product-info-choose-option flex-xl-nowrap my-2">
                                                <div class="product-quantity">
                                                    <p class=" title body-text-3">
                                                        Quantity
                                                    </p>
                                                    <div class="wg-quantity">
                                                        <button class="btn-quantity btn-decrease">
                                                            <i class="icon-minus"></i>
                                                        </button>
                                                        <input class="quantity-product" type="text" name="number"
                                                            value="1">
                                                        <button class="btn-quantity btn-increase">
                                                            <i class="icon-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="product-fearture-list">
                                        @if ($product->warehouseProduct && $product->warehouseProduct->brand)
                                            <li>
                                                <p class="body-md-2 fw-semibold">Brand</p>
                                                <span
                                                    class="body-text-3">{{ $product->warehouseProduct->brand->brand_title }}</span>
                                            </li>
                                        @endif

                                        @if ($product->warehouseProduct && $product->warehouseProduct->model_no)
                                            <li>
                                                <p class="body-md-2 fw-semibold">Model</p>
                                                <span
                                                    class="body-text-3">{{ $product->warehouseProduct->model_no }}</span>
                                            </li>
                                        @endif

                                        @if ($product->warehouseProduct && $product->warehouseProduct->sku)
                                            <li>
                                                <p class="body-md-2 fw-semibold">SKU</p>
                                                <span class="body-text-3">{{ $product->warehouseProduct->sku }}</span>
                                            </li>
                                        @endif

                                        @if ($product->product_weight)
                                            <li>
                                                <p class="body-md-2 fw-semibold">Weight</p>
                                                <span class="body-text-3">{{ $product->product_weight }}</span>
                                            </li>
                                        @endif

                                        @if ($product->product_dimensions)
                                            <li>
                                                <p class="body-md-2 fw-semibold">Dimensions</p>
                                                <span class="body-text-3">{{ $product->product_dimensions }}</span>
                                            </li>
                                        @endif

                                        @if ($product->company_warranty)
                                            <li>
                                                <p class="body-md-2 fw-semibold">Warranty</p>
                                                <span class="body-text-3">{{ $product->company_warranty }}</span>
                                            </li>
                                        @endif

                                        @if ($product->warehouseProduct && $product->warehouseProduct->stock_quantity)
                                            <li>
                                                <p class="body-md-2 fw-semibold">Availability</p>
                                                <span class="body-text-3">{{ $product->warehouseProduct->stock_quantity }}
                                                    in stock</span>
                                            </li>
                                        @endif
                                    </ul>

                                    <div class="">
                                        <div class="tf-product-info-choose-option flex-xl-nowrap">
                                            {{-- <div class="product-color">
                                                <p class=" title body-text-3">
                                                    Color
                                                </p>
                                                <div class="tf-select-color ">
                                                    <select class="select-color">
                                                        <option selected="">Graphite Black</option>
                                                        <option>Graphite Blue </option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <div class="product-box-btn">
                                                <a href="#;" class="tf-btn text-white add-to-cart-btn"
                                                   data-product-id="{{ $product->id }}"
                                                   data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                    Add to cart
                                                    <i class="icon-cart-2"></i>
                                                </a>
                                                <a href="#;" class="tf-btn text-white btn-gray buy-now-btn"
                                                   data-product-id="{{ $product->id }}"
                                                   data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                                    Buy now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="infor-bottom">
                                        <h6 class="fw-semibold">About this item</h6>
                                        @if (!empty($productFeatures))
                                            <ul class="product-features-list">
                                                @foreach ($productFeatures as $feature)
                                                    <li class="feature-item d-flex align-items-start mb-3">
                                                        <i class="icon-check text-success me-3 mt-1"></i>
                                                        <span>{{ $feature }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{-- <ul class="product-about-list">
                                                @if ($product->warehouseProduct && $product->warehouseProduct->brand)
                                                    <li>
                                                        <p class="body-text-3">
                                                            Genuine {{ $product->warehouseProduct->brand->brand_title }}
                                                            product with
                                                            authentic warranty
                                                        </p>
                                                    </li>
                                                @endif
                                                <li>
                                                    <p class="body-text-3">
                                                        100% BPA - Free premium design meets excellent
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="body-text-3">
                                                        No more messy accidents or spills
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="body-text-3">
                                                        So easy &amp; convenient that everyone can use it
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="body-text-3">
                                                        This powerful 900-1100-Watt kettle has convenient capacity
                                                        markings on the body lets you accurately
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="body-text-3">
                                                        1 year limited warranty and us-based customer support team
                                                        lets
                                                        you buy with confidence.
                                                    </p>
                                                </li>
                                            </ul> --}}
                                            <!-- Fallback features if none extracted -->
                                            <ul class="product-features-list">
                                                @if ($product->warehouseProduct && $product->warehouseProduct->brand)
                                                    <li class="feature-item d-flex align-items-start mb-3">
                                                        <i class="icon-check text-success me-3 mt-1"></i>
                                                        <span>Genuine {{ $product->warehouseProduct->brand->brand_title }}
                                                            product with
                                                            authentic warranty</span>
                                                    </li>
                                                @endif
                                                @if ($product->company_warranty)
                                                    <li class="feature-item d-flex align-items-start mb-3">
                                                        <i class="icon-check text-success me-3 mt-1"></i>
                                                        <span>{{ $product->company_warranty }} warranty coverage
                                                            included</span>
                                                    </li>
                                                @endif
                                                @if ($product->shipping_charges == 0 || !$product->shipping_charges)
                                                    <li class="feature-item d-flex align-items-start mb-3">
                                                        <i class="icon-check text-success me-3 mt-1"></i>
                                                        <span>Free shipping and fast delivery available</span>
                                                    </li>
                                                @endif
                                                @if ($product->warehouseProduct && $product->warehouseProduct->stock_quantity > 0)
                                                    <li class="feature-item d-flex align-items-start mb-3">
                                                        <i class="icon-check text-success me-3 mt-1"></i>
                                                        <span>In stock and ready to ship immediately</span>
                                                    </li>
                                                @endif
                                                <li class="feature-item d-flex align-items-start mb-3">
                                                    <i class="icon-check text-success me-3 mt-1"></i>
                                                    <span>Professional customer support and technical assistance</span>
                                                </li>
                                                <li class="feature-item d-flex align-items-start mb-3">
                                                    <i class="icon-check text-success me-3 mt-1"></i>
                                                    <span>Secure payment options and buyer protection</span>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description -->
    <section class="flat-spacing-17 pt_0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Enhanced Tabbed Information Section -->
                    <div class="product-info-tabs">
                        <ul class="nav nav-tabs" id="productInfoTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="product-info-tab" data-bs-toggle="tab"
                                    data-bs-target="#product-info" type="button" role="tab"
                                    aria-controls="product-info" aria-selected="true">
                                    Product Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="technical-info-tab" data-bs-toggle="tab"
                                    data-bs-target="#technical-info" type="button" role="tab"
                                    aria-controls="technical-info" aria-selected="false">
                                    Technical Specifications
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab"
                                    aria-controls="description" aria-selected="false">
                                    Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                    type="button" role="tab" aria-controls="reviews" aria-selected="false">
                                    Reviews (127)
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="productInfoTabsContent">
                            <!-- Product Information Tab -->
                            <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                                aria-labelledby="product-info-tab">
                                <div class="product-specifications">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                @if ($product->warehouseProduct && $product->warehouseProduct->brand)
                                                    <tr>
                                                        <td class="fw-semibold" style="width: 30%;">Brand</td>
                                                        <td>{{ $product->warehouseProduct->brand->brand_title }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->warehouseProduct && $product->warehouseProduct->model_no)
                                                    <tr>
                                                        <td class="fw-semibold">Model Number</td>
                                                        <td>{{ $product->warehouseProduct->model_no }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->warehouseProduct && $product->warehouseProduct->sku)
                                                    <tr>
                                                        <td class="fw-semibold">SKU</td>
                                                        <td>{{ $product->warehouseProduct->sku }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->product_weight)
                                                    <tr>
                                                        <td class="fw-semibold">Weight</td>
                                                        <td>{{ $product->product_weight }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->product_dimensions)
                                                    <tr>
                                                        <td class="fw-semibold">Dimensions</td>
                                                        <td>{{ $product->product_dimensions }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->company_warranty)
                                                    <tr>
                                                        <td class="fw-semibold">Warranty</td>
                                                        <td>{{ $product->company_warranty }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->shipping_class)
                                                    <tr>
                                                        <td class="fw-semibold">Shipping Class</td>
                                                        <td>{{ $product->shipping_class }}</td>
                                                    </tr>
                                                @endif
                                                @if ($product->warehouseProduct && $product->warehouseProduct->parentCategorie)
                                                    <tr>
                                                        <td class="fw-semibold">Category</td>
                                                        <td>
                                                            {{ $product->warehouseProduct->parentCategorie->parent_categories }}
                                                            @if ($product->warehouseProduct->subCategorie)
                                                                >
                                                                {{ $product->warehouseProduct->subCategorie->sub_categorie }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Tab -->
                            <div class="tab-pane fade" id="technical-info" role="tabpanel"
                                aria-labelledby="technical-info-tab">
                                <div class="technical-info">
                                    @if (
                                        $product->ecommerce_technical_specification ||
                                            ($product->warehouseProduct && $product->warehouseProduct->technical_specification))
                                        <div class="technical-specifications mt-4">
                                            <h6 class="fw-semibold mb-3">Technical Specifications</h6>
                                            <div class="specifications-content">
                                                @if ($product->ecommerce_technical_specification)
                                                    {!! $product->ecommerce_technical_specification !!}
                                                @elseif($product->warehouseProduct && $product->warehouseProduct->technical_specification)
                                                    {!! $product->warehouseProduct->technical_specification !!}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Description Tab -->
                            <div class="tab-pane fade" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="product-description">
                                    @if ($product->ecommerce_full_description)
                                        {!! $product->ecommerce_full_description !!}
                                    @elseif($product->warehouseProduct && $product->warehouseProduct->full_description)
                                        {!! $product->warehouseProduct->full_description !!}
                                    @else
                                        <div class="no-description">
                                            <p class="text-muted">No detailed description available for this product.</p>
                                            @if ($product->ecommerce_short_description)
                                                <div class="short-description mt-3">
                                                    <h6>Product Summary:</h6>
                                                    {!! $product->ecommerce_short_description !!}
                                                </div>
                                            @elseif($product->warehouseProduct && $product->warehouseProduct->short_description)
                                                <div class="short-description mt-3">
                                                    <h6>Product Summary:</h6>
                                                    {!! $product->warehouseProduct->short_description !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Reviews Tab -->
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="product-reviews">
                                    <!-- Reviews Summary -->
                                    <div class="reviews-summary mb-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="rating-overview text-center">
                                                    <div class="average-rating">
                                                        <h2 class="rating-number">4.5</h2>
                                                        <div class="stars mb-2">
                                                            <i class="icon-star text-warning"></i>
                                                            <i class="icon-star text-warning"></i>
                                                            <i class="icon-star text-warning"></i>
                                                            <i class="icon-star text-warning"></i>
                                                            <i class="icon-star text-muted"></i>
                                                        </div>
                                                        <p class="text-muted">Based on 127 reviews</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="rating-breakdown">
                                                    <div class="rating-bar d-flex align-items-center mb-2">
                                                        <span class="rating-label">5 stars</span>
                                                        <div class="progress flex-grow-1 mx-3">
                                                            <div class="progress-bar bg-warning" style="width: 70%"></div>
                                                        </div>
                                                        <span class="rating-count">89</span>
                                                    </div>
                                                    <div class="rating-bar d-flex align-items-center mb-2">
                                                        <span class="rating-label">4 stars</span>
                                                        <div class="progress flex-grow-1 mx-3">
                                                            <div class="progress-bar bg-warning" style="width: 20%"></div>
                                                        </div>
                                                        <span class="rating-count">25</span>
                                                    </div>
                                                    <div class="rating-bar d-flex align-items-center mb-2">
                                                        <span class="rating-label">3 stars</span>
                                                        <div class="progress flex-grow-1 mx-3">
                                                            <div class="progress-bar bg-warning" style="width: 8%"></div>
                                                        </div>
                                                        <span class="rating-count">10</span>
                                                    </div>
                                                    <div class="rating-bar d-flex align-items-center mb-2">
                                                        <span class="rating-label">2 stars</span>
                                                        <div class="progress flex-grow-1 mx-3">
                                                            <div class="progress-bar bg-warning" style="width: 2%"></div>
                                                        </div>
                                                        <span class="rating-count">2</span>
                                                    </div>
                                                    <div class="rating-bar d-flex align-items-center">
                                                        <span class="rating-label">1 star</span>
                                                        <div class="progress flex-grow-1 mx-3">
                                                            <div class="progress-bar bg-warning" style="width: 1%"></div>
                                                        </div>
                                                        <span class="rating-count">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Individual Reviews -->
                                    <div class="reviews-list">
                                        <div class="review-item border-bottom pb-4 mb-4">
                                            <div class="d-flex align-items-start">
                                                <div class="reviewer-avatar me-3">
                                                    <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px; border-radius: 50%;">
                                                        <span class="fw-bold">JD</span>
                                                    </div>
                                                </div>
                                                <div class="review-content flex-grow-1">
                                                    <div class="reviewer-info mb-2">
                                                        <h6 class="reviewer-name mb-1">John Doe</h6>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="review-rating">
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                            </div>
                                                            <span class="review-date text-muted small">2 weeks ago</span>
                                                            <span class="verified-badge badge bg-success small">Verified
                                                                Purchase</span>
                                                        </div>
                                                    </div>
                                                    <p class="review-text">Excellent product! Works exactly as described.
                                                        Fast shipping and great customer service. Highly recommended for
                                                        anyone looking for quality equipment.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="review-item border-bottom pb-4 mb-4">
                                            <div class="d-flex align-items-start">
                                                <div class="reviewer-avatar me-3">
                                                    <div class="avatar-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px; border-radius: 50%;">
                                                        <span class="fw-bold">AS</span>
                                                    </div>
                                                </div>
                                                <div class="review-content flex-grow-1">
                                                    <div class="reviewer-info mb-2">
                                                        <h6 class="reviewer-name mb-1">Alice Smith</h6>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="review-rating">
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-muted"></i>
                                                            </div>
                                                            <span class="review-date text-muted small">1 month ago</span>
                                                            <span class="verified-badge badge bg-success small">Verified
                                                                Purchase</span>
                                                        </div>
                                                    </div>
                                                    <p class="review-text">Good value for money. The build quality is solid
                                                        and it performs well. Delivery was prompt and packaging was secure.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="review-item">
                                            <div class="d-flex align-items-start">
                                                <div class="reviewer-avatar me-3">
                                                    <div class="avatar-circle bg-info text-white d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px; border-radius: 50%;">
                                                        <span class="fw-bold">MJ</span>
                                                    </div>
                                                </div>
                                                <div class="review-content flex-grow-1">
                                                    <div class="reviewer-info mb-2">
                                                        <h6 class="reviewer-name mb-1">Mike Johnson</h6>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="review-rating">
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                                <i class="icon-star text-warning"></i>
                                                            </div>
                                                            <span class="review-date text-muted small">3 weeks ago</span>
                                                            <span class="verified-badge badge bg-success small">Verified
                                                                Purchase</span>
                                                        </div>
                                                    </div>
                                                    <p class="review-text">Outstanding product! Exceeded my expectations.
                                                        The quality is top-notch and it's been working flawlessly. Will
                                                        definitely buy from this seller again.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Load More Reviews Button -->
                                    <div class="text-center mt-4">
                                        <button class="btn btn-outline-primary">Load More Reviews</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recently Viewed Products Section -->
    @if ($recentlyViewed && $recentlyViewed->count() > 0)
        <section class="flat-spacing-17 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="recently-viewed-section">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-semibold">Recently Viewed Products</h4>
                                <a href="{{ route('shop') }}" class="btn btn-outline-primary btn-sm">View All
                                    Products</a>
                            </div>

                            <div class="recently-viewed-products">
                                <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3"
                                    data-mobile="2" data-space-lg="30" data-space-md="20" data-space="15"
                                    data-pagination="2" data-pagination-sm="3" data-pagination-md="4"
                                    data-pagination-lg="5">
                                    <div class="swiper-wrapper">
                                        @foreach ($recentlyViewed as $recentProduct)
                                            <div class="swiper-slide">
                                                <div class="card-product style-img-border product-card-hover">
                                                    <div class="card-product-wrapper">
                                                        <a href="{{ route('product.detail', $recentProduct->id) }}"
                                                            class="product-img">
                                                            @if ($recentProduct->warehouseProduct && $recentProduct->warehouseProduct->main_product_image)
                                                                <img class="img-product lazyload"
                                                                    src="{{ asset($recentProduct->warehouseProduct->main_product_image) }}"
                                                                    data-src="{{ asset($recentProduct->warehouseProduct->main_product_image) }}"
                                                                    alt="{{ $recentProduct->warehouseProduct->product_name }}">
                                                                @if (
                                                                    $recentProduct->warehouseProduct->additional_product_images &&
                                                                        count($recentProduct->warehouseProduct->additional_product_images) > 0)
                                                                    <img class="img-hover lazyload"
                                                                        src="{{ asset($recentProduct->warehouseProduct->additional_product_images[0]) }}"
                                                                        data-src="{{ asset($recentProduct->warehouseProduct->additional_product_images[0]) }}"
                                                                        alt="{{ $recentProduct->warehouseProduct->product_name }}">
                                                                @endif
                                                            @else
                                                                <img class="img-product lazyload"
                                                                    src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                                    data-src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                                                    alt="No Image Available">
                                                            @endif
                                                        </a>

                                                        <!-- Product Action Buttons Overlay -->
                                                        <div class="list-product-btn">
                                                            <a href="#"
                                                                class="box-icon add-to-cart btn-icon-action hover-tooltip tooltip-left"
                                                                data-product-id="{{ $recentProduct->id }}"
                                                                data-tooltip="Add to Cart">
                                                                <span class="icon icon-cart2"></span>
                                                            </a>
                                                            <a href="#"
                                                                class="box-icon wishlist-btn btn-icon-action hover-tooltip tooltip-left"
                                                                data-product-id="{{ $recentProduct->id }}"
                                                                data-tooltip="Add to Wishlist">
                                                                <span class="icon icon-heart"></span>
                                                            </a>
                                                            <a href="{{ route('product.detail', $recentProduct->id) }}"
                                                                class="box-icon btn-icon-action hover-tooltip tooltip-left"
                                                                data-tooltip="Quick View">
                                                                <span class="icon icon-eye"></span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="card-product-info">
                                                        <a href="{{ route('product.detail', $recentProduct->id) }}"
                                                            class="title link">
                                                            {{ Str::limit($recentProduct->warehouseProduct->product_name ?? 'Product Name', 50) }}
                                                        </a>

                                                        <div class="price-container mt-2">
                                                            @if ($recentProduct->warehouseProduct)
                                                                @php
                                                                    $currentPrice =
                                                                        $recentProduct->warehouseProduct
                                                                            ->discount_price &&
                                                                        $recentProduct->warehouseProduct
                                                                            ->discount_price <
                                                                            $recentProduct->warehouseProduct
                                                                                ->selling_price
                                                                            ? $recentProduct->warehouseProduct
                                                                                ->discount_price
                                                                            : $recentProduct->warehouseProduct
                                                                                ->selling_price;
                                                                    $originalPrice =
                                                                        $recentProduct->warehouseProduct->cost_price ??
                                                                        $recentProduct->warehouseProduct->selling_price;
                                                                @endphp

                                                                <span
                                                                    class="price text-primary fw-semibold">₹{{ number_format($currentPrice, 2) }}</span>
                                                                @if ($originalPrice > $currentPrice)
                                                                    <span
                                                                        class="price-old text-muted text-decoration-line-through ms-2">₹{{ number_format($originalPrice, 2) }}</span>
                                                                @endif
                                                            @else
                                                                <span class="price text-primary fw-semibold">₹0.00</span>
                                                            @endif
                                                        </div>

                                                        @if ($recentProduct->warehouseProduct && $recentProduct->warehouseProduct->brand)
                                                            <div class="brand-name text-muted small mt-1">
                                                                {{ $recentProduct->warehouseProduct->brand->brand_title }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next button-style-arrow"></div>
                                    <div class="swiper-button-prev button-style-arrow"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection

@section('style')
    <style>
        /* Product Detail Page Custom Styles */
        .product-category-badge .badge {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        .product-rating-section .list-star {
            display: flex;
            gap: 2px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .product-rating-section .list-star li {
            font-size: 1.1rem;
        }

        .rating-text {
            font-weight: 600;
            color: #333;
        }

        .price-container {
            align-items: baseline;
        }

        .current-price {
            font-size: 2rem;
            color: #007bff !important;
        }

        .original-price {
            font-size: 1.2rem;
        }

        .discount-badge {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        .product-attributes .table td {
            padding: 0.75rem 0.5rem;
            border: none;
            border-bottom: 1px solid #eee;
        }

        .quantity-input-group {
            max-width: 200px;
        }

        .quantity-input {
            border-left: none;
            border-right: none;
        }

        .btn-quantity-decrease,
        .btn-quantity-increase {
            border: 1px solid #ced4da;
            background: #f8f9fa;
            width: 40px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-quantity-decrease:hover,
        .btn-quantity-increase:hover {
            background: #e9ecef;
        }

        .product-action-buttons .btn {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .product-action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .about-this-item-section {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 12px;
        }

        .product-features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-item {
            font-size: 1rem;
            line-height: 1.6;
        }

        .feature-item i {
            font-size: 1.1rem;
            margin-top: 2px;
        }

        .product-info-tabs .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .product-info-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        .product-info-tabs .nav-link.active {
            color: #007bff;
            border-bottom-color: #007bff;
            background: none;
        }

        .product-info-tabs .nav-link:hover {
            color: #007bff;
            border-color: transparent;
        }

        .product-specifications .table {
            margin-bottom: 0;
        }

        .product-specifications .table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #eee;
        }

        .reviews-summary {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 12px;
        }

        .rating-overview .rating-number {
            font-size: 3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .rating-breakdown .rating-label {
            width: 60px;
            font-size: 0.875rem;
        }

        .rating-breakdown .progress {
            height: 8px;
        }

        .rating-breakdown .rating-count {
            width: 30px;
            text-align: right;
            font-size: 0.875rem;
        }

        .review-item .avatar-circle {
            font-size: 1.1rem;
        }

        .review-rating {
            font-size: 0.9rem;
        }

        .recently-viewed-section {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 2rem;
        }

        .product-card-hover {
            transition: all 0.3s ease;
        }

        .product-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .list-product-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card-hover:hover .list-product-btn {
            opacity: 1;
        }

        .btn-icon-action {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-icon-action:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        @media (max-width: 768px) {
            .current-price {
                font-size: 1.5rem;
            }

            .about-this-item-section {
                padding: 1.5rem;
            }

            .reviews-summary {
                padding: 1.5rem;
            }

            .recently-viewed-section {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Quantity selector functionality
            $('.btn-quantity-decrease').on('click', function() {
                const input = $(this).siblings('.quantity-input');
                const currentValue = parseInt(input.val());
                const minValue = parseInt(input.attr('min')) || 1;

                if (currentValue > minValue) {
                    input.val(currentValue - 1);
                    updatePriceDisplay();
                }
            });

            $('.btn-quantity-increase').on('click', function() {
                const input = $(this).siblings('.quantity-input');
                const currentValue = parseInt(input.val());
                const maxValue = parseInt(input.attr('max'));

                if (!maxValue || currentValue < maxValue) {
                    input.val(currentValue + 1);
                    updatePriceDisplay();
                }
            });

            $('.quantity-input').on('change', function() {
                const minValue = parseInt($(this).attr('min')) || 1;
                const maxValue = parseInt($(this).attr('max'));
                let currentValue = parseInt($(this).val());

                if (currentValue < minValue) {
                    $(this).val(minValue);
                } else if (maxValue && currentValue > maxValue) {
                    $(this).val(maxValue);
                }

                updatePriceDisplay();
            });

            // Update price display based on quantity
            function updatePriceDisplay() {
                const quantity = parseInt($('.quantity-input').val()) || 1;
                const basePrice = parseFloat($('.current-price').text().replace('₹', '').replace(',', '')) || 0;
                const totalPrice = basePrice * quantity;

                $('.price-display').text('- ₹' + totalPrice.toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }

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
                const originalText = $button.html();
                $button.html('<i class="spinner-border spinner-border-sm me-2"></i>Adding...');
                $button.prop('disabled', true);

                // Make AJAX request
                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: {
                        ecommerce_product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            // Update button state
                            $button.html('Added to Cart <i class="icon-cart-2"></i>');
                            $button.addClass('in-cart');

                            // Update cart count and sidebar
                            updateCartCount();
                            updateCartSidebar();
                        } else {
                            showNotification(response.message, 'error');
                            // Reset button state
                            $button.html(originalText);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON.requires_auth) {
                            showLoginModal();
                        } else {
                            showNotification('Error adding product to cart. Please try again.', 'error');
                            // Reset button state
                            $button.html(originalText);
                        }
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
            });

            // Buy Now functionality
            $('.buy-now-btn').on('click', function(e) {
                e.preventDefault();

                const productId = $(this).data('product-id');
                const quantity = $('.quantity-input').val() || 1;

                // Show loading state
                const originalText = $(this).html();
                $(this).html('<i class="spinner-border spinner-border-sm me-2"></i>Processing...');
                $(this).prop('disabled', true);

                // Redirect to checkout with buy_now parameters
                const checkoutUrl = '{{ route("checkout") }}' + '?source=buy_now&product_id=' + productId + '&quantity=' + quantity;

                showNotification('Redirecting to checkout...', 'info');

                // Small delay for user feedback, then redirect
                setTimeout(() => {
                    window.location.href = checkoutUrl;
                }, 500);
            });

            // Wishlist functionality
            $('.wishlist-btn').on('click', function(e) {
                e.preventDefault();

                const productId = $(this).data('product-id');
                const $button = $(this);
                const $icon = $button.find('i');
                const $text = $button.find('.wishlist-text');

                // Toggle wishlist state
                if ($button.hasClass('in-wishlist')) {
                    // Remove from wishlist
                    $icon.removeClass('fas').addClass('far');
                    $button.removeClass('in-wishlist btn-danger').addClass('btn-outline-secondary');
                    if ($text.length) {
                        $text.text('Add to Wishlist');
                    }
                    showNotification('Removed from wishlist', 'info');
                } else {
                    // Add to wishlist
                    $icon.removeClass('far').addClass('fas');
                    $button.addClass('in-wishlist btn-danger').removeClass('btn-outline-secondary');
                    if ($text.length) {
                        $text.text('In Wishlist');
                    }
                    showNotification('Added to wishlist!', 'success');
                }
            });

            // Image zoom functionality (if not already implemented)
            $('.tf-image-zoom').on('mouseenter', function() {
                $(this).css('transform', 'scale(1.2)');
            }).on('mouseleave', function() {
                $(this).css('transform', 'scale(1)');
            });

            // Tab switching with URL hash support
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('data-bs-target');
                window.location.hash = target;
            });

            // Load tab from URL hash on page load
            if (window.location.hash) {
                const hash = window.location.hash;
                const tabButton = $('button[data-bs-target="' + hash + '"]');
                if (tabButton.length) {
                    tabButton.tab('show');
                }
            }

            // Smooth scroll to tabs when clicking from external links
            $('.scroll-to-tabs').on('click', function(e) {
                e.preventDefault();
                const target = $(this).attr('href');
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100
                }, 500);
            });

            // Recently viewed products hover effects
            $('.product-card-hover').on('mouseenter', function() {
                $(this).find('.img-hover').css('opacity', '1');
                $(this).find('.img-product').css('opacity', '0');
            }).on('mouseleave', function() {
                $(this).find('.img-hover').css('opacity', '0');
                $(this).find('.img-product').css('opacity', '1');
            });

            // Utility functions
            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = $(`
            <div class="alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                // Add to body
                $('body').append(notification);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.alert('close');
                }, 3000);
            }

            // Cart count function is now global in master layout

            // Initialize tooltips
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Initialize product image gallery swiper if not already done
            if (typeof Swiper !== 'undefined') {
                // Main gallery swiper
                const galleryMain = new Swiper('.tf-product-media-main', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.thumbs-next',
                        prevEl: '.thumbs-prev',
                    },
                    thumbs: {
                        swiper: {
                            el: '.tf-product-media-thumbs',
                            spaceBetween: 10,
                            slidesPerView: 4,
                            freeMode: true,
                            watchSlidesProgress: true,
                        }
                    }
                });

                // Recently viewed products swiper
                const recentlyViewedSwiper = new Swiper('.recently-viewed-products .tf-sw-products', {
                    slidesPerView: 2,
                    spaceBetween: 15,
                    navigation: {
                        nextEl: '.recently-viewed-products .swiper-button-next',
                        prevEl: '.recently-viewed-products .swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 4,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 30,
                        },
                    }
                });
            }
        });

        // Load more reviews functionality
        function loadMoreReviews() {
            // Implement AJAX call to load more reviews
            showNotification('Loading more reviews...', 'info');

            // Simulate loading delay
            setTimeout(() => {
                showNotification('More reviews loaded!', 'success');
            }, 1500);
        }

        // Quick view functionality for recently viewed products
        function quickView(productId) {
            // Implement quick view modal
            showNotification('Opening quick view...', 'info');
        }

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
    </script>
@endsection
