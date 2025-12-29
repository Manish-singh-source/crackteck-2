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
                <a href="{{ route('shop') }}" class="body-small link">
                    Shop
                </a>
            </li>
            <li class="d-flex align-items-center">
                <i class="icon icon-arrow-right"></i>
            </li>
            <li>
                <span class="body-small">Product Detail</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->
<!-- Product Main -->


<section>
    <div class="tf-main-product section-image-zoom border-bt">
        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <!-- Product Image -->
                    <div class="tf-product-media-wrap thumbs-default sticky-top">
                        <div class="thumbs-slider">
                            <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" data-color="gray">
                                        <a href="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}" target="_blank"
                                            class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom ls-is-cached lazyload"
                                                src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}"
                                                data-zoom="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}"
                                                data-src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="swiper-slide" data-color="gray">
                                        <a href="{{ asset('frontend-assets/images/product/product-detail-2.jpg') }}" target="_blank"
                                            class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload"
                                                data-zoom="{{ asset('frontend-assets/images/product/product-detail-2.jpg') }}"
                                                data-src="{{ asset('frontend-assets/images/product/product-detail-2.jpg') }}"
                                                src="{{ asset('frontend-assets/images/product/product-detail-2.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="swiper-slide" data-color="gray">
                                        <a href="{{ asset('frontend-assets/images/product/product-detail-3.jpg') }}" target="_blank"
                                            class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload"
                                                data-zoom="{{ asset('frontend-assets/images/product/product-detail-3.jpg') }}"
                                                data-src="{{ asset('frontend-assets/images/product/product-detail-3.jpg') }}"
                                                src="{{ asset('frontend-assets/images/product/product-detail-3.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="swiper-slide" data-color="gray">
                                        <a href="{{ asset('frontend-assets/images/product/product-detail-4.jpg') }}" target="_blank"
                                            class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload"
                                                data-zoom="{{ asset('frontend-assets/images/product/product-detail-4.jpg') }}"
                                                data-src="{{ asset('frontend-assets/images/product/product-detail-4.jpg') }}"
                                                src="{{ asset('frontend-assets/images/product/product-detail-4.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="swiper-slide" data-color="beige">
                                        <a href="{{ asset('frontend-assets/images/product/product-detail-5.jpg') }}" target="_blank"
                                            class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload"
                                                data-zoom="{{ asset('frontend-assets/images/product/product-detail-5.jpg') }}"
                                                data-src="{{ asset('frontend-assets/images/product/product-detail-5.jpg') }}"
                                                src="{{ asset('frontend-assets/images/product/product-detail-5.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="swiper-slide" data-color="beige">
                                        <a href="{{ asset('frontend-assets/images/product/product-detail-6.jpg') }}" target="_blank"
                                            class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload"
                                                data-zoom="{{ asset('frontend-assets/images/product/product-detail-6.jpg') }}"
                                                data-src="{{ asset('frontend-assets/images/product/product-detail-6.jpg') }}"
                                                src="{{ asset('frontend-assets/images/product/product-detail-6.jpg') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="container-swiper">
                                <div class="swiper tf-product-media-thumbs other-image-zoom"
                                    data-direction="horizontal">
                                    <div class="swiper-wrapper stagger-wrap">
                                        <div class="swiper-slide stagger-item" data-color="gray">
                                            <div class="item">
                                                <img class="lazyload"
                                                    data-src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}"
                                                    src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide stagger-item" data-color="gray">
                                            <div class="item">
                                                <img class="lazyload"
                                                    data-src="{{ asset('frontend-assets/images/new-products/product-detail-2.webp') }}"
                                                    src="{{ asset('frontend-assets/images/new-products/product-detail-2.webp') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide stagger-item" data-color="gray">
                                            <div class="item">
                                                <img class="lazyload"
                                                    data-src="{{ asset('frontend-assets/images/new-products/product-detail-4.webp') }}"
                                                    src="{{ asset('frontend-assets/images/new-products/product-detail-4.webp') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide stagger-item" data-color="gray">
                                            <div class="item">
                                                <img class="lazyload"
                                                    data-src="{{ asset('frontend-assets/images/new-products/product-detail-7.webp') }}"
                                                    src="{{ asset('frontend-assets/images/new-products/product-detail-7.webp') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide stagger-item" data-color="beige">
                                            <div class="item">
                                                <img class="lazyload"
                                                    data-src="{{ asset('frontend-assets/images/new-products/product-detail-5.webp') }}"
                                                    src="{{ asset('frontend-assets/images/new-products/product-detail-5.webp') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide stagger-item" data-color="beige">
                                            <div class="item">
                                                <img class="lazyload"
                                                    data-src="{{ asset('frontend-assets/images/new-products/product-detail-6.webp') }}"
                                                    src="{{ asset('frontend-assets/images/new-products/product-detail-6.webp') }}" alt="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Image -->
                </div>
                <div class="col-md-6">
                    <!-- Product Infor -->
                    <div class="tf-product-info-wrap position-relative">
                        <div class="tf-zoom-main"></div>
                        <div class="tf-product-info-list style-2">
                            <div class="tf-product-info-content">
                                <div class="infor-heading">
                                    <p class="caption">Categories:
                                        CCTV
                                    </p>
                                    <h5 class="product-info-name fw-semibold lh-base">
                                        Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p <br> WiFi CCTV 2 Way Talk Night Vision Security Camera
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
                                        <h4 class="text-primary">₹18.99</h4>
                                        <span class="price-text text-main-2 old-price">₹20.99</span>
                                        <p>
                                            <i class="icon-delivery-2"></i>
                                            Free shipping
                                        </p>
                                    </div>
                                    <div class="product-delivery">
                                        <div class="shipping-to">
                                            <p class="body-md-2">
                                                Shipping to:
                                            </p>
                                            <div class="tf-cur">
                                                <div class="tf-cur-item">
                                                    <select
                                                        class="select-default cs-pointer fw-semibold body-md-2">
                                                        <option selected="">Metro Manila</option>
                                                        <option>Metro Manila </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
                                    <li>
                                        <p class="body-md-2 fw-semibold">Brand</p>
                                        <span class="body-text-3">Elite Gourmet</span>
                                    </li>
                                    <li>
                                        <p class="body-md-2 fw-semibold">Color</p>
                                        <span class="body-text-3">Black</span>
                                    </li>
                                    <li>
                                        <p class="body-md-2 fw-semibold">Capacity</p>
                                        <span class="body-text-3">1 </span>
                                    </li>
                                    <li>
                                        <p class="body-md-2 fw-semibold">Material</p>
                                        <span class="body-text-3">Glass</span>
                                    </li>
                                    <li>
                                        <p class="body-md-2 fw-semibold">Wattage</p>
                                        <span class="body-text-3">1100 watts</span>
                                    </li>
                                </ul>
                                <div class="">
                                    <div class="tf-product-info-choose-option flex-xl-nowrap">
                                        <div class="product-color">
                                            <p class=" title body-text-3">
                                                Color
                                            </p>
                                            <div class="tf-select-color ">
                                                <select class="select-color">
                                                    <option selected="">Graphite Black</option>
                                                    <option>Graphite Blue </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="product-box-btn">
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="tf-btn text-white">
                                        Add to cart
                                        <i class="icon-cart-2"></i>
                                    </a>
                                    <a href="{{ route('checkout' , ['source' => 'buy_now']) }}" class="tf-btn text-white btn-gray">
                                        Buy now
                                    </a>
                                </div>
                                    </div>
                                </div>
                                <div class="infor-bottom">
                                    <h6 class="fw-semibold">About this item</h6>
                                    <ul class="product-about-list">
                                        <li>
                                            <p class="body-text-3">
                                                Here’s the quickest way to enjoy your delicious hot tea
                                                every
                                                single day.
                                            </p>
                                        </li>
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
                                                So easy & convenient that everyone can use it
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
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /Product Infor -->

                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Product Main -->

<!-- Product Description Tab -->
<section class="tf-sp-4 ">
    <div class="container">
        <div class="flat-animate-tab flat-title-tab-product-des">
            <div class=" flat-title-tab text-center">
                <ul class="menu-tab-line" role="tablist">
                    <!-- <li class="nav-tab-item" role="presentation">
                        <a href="#prd-usually" class="tab-link product-title fw-semibold "
                            data-bs-toggle="tab">Usually Bought
                            Together</a>
                    </li> -->
                    <li class="nav-tab-item" role="presentation">
                        <a href="#prd-infor" class="tab-link product-title fw-semibold active"
                            data-bs-toggle="tab">Product
                            information</a>
                    </li>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#prd-des" class="tab-link product-title fw-semibold"
                            data-bs-toggle="tab">Description</a>
                    </li>
                    
                    <li class="nav-tab-item" role="presentation">
                        <a href="#prd-review" class="tab-link product-title fw-semibold"
                            data-bs-toggle="tab">Reviews</a>
                    </li>

                </ul>
            </div>
            <div class="tab-content">
                
                <div class="tab-pane active show" id="prd-infor" role="tabpanel">
                    <div class="tab-main tab-info">
                        <ul class="list-feature">
                            <li>
                                <p class="name-feature">Package Dimensions</p>
                                <p class="property">8 x 8 x 6.7 inches</p>
                            </li>
                            <li>
                                <p class="name-feature">Item Weight</p>
                                <p class="property">2.2 pounds</p>
                            </li>
                            <li>
                                <p class="name-feature">Manufacturer</p>
                                <p class="property">Elite Gourmet</p>
                            </li>
                            <li>
                                <p class="name-feature">ASIN</p>
                                <p class="property">B09H3LWKYQ</p>
                            </li>
                            <li>
                                <p class="name-feature">Country of Origin</p>
                                <p class="property">China</p>
                            </li>

                            <li>
                                <p class="name-feature">Item model number</p>
                                <p class="property">EKT1001B</p>
                            </li>
                            <li>
                                <p class="name-feature">Customer Reviews</p>
                                <div class="w-100 star-review flex-wrap">
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
                                </div>
                            </li>
                            <li>
                                <p class="name-feature">Date First Available</p>
                                <p class="property"> September 24, 2021</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane " id="prd-des" role="tabpanel">
                    <div class="tab-main tab-des">
                        <p class="body-text-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tristique nisi id
                            leo
                            mollis egestas. Ut ac ante tincidunt dolor viverra vestibulum. Fusce eget
                            pharetra
                            lorem. Pellentesque ac feugiat nisi. Nulla sollicitudin cursus neque, dapibus
                            aliquet nulla congue congue. In eget sagittis metus, nec semper tortor. Etiam in
                            nunc dui. Sed nibh ante, maximus eu commodo ac, mattis quis elit. Maecenas
                            cursus
                            libero et risus sollicitudin mollis. Sed ultricies sagittis sem, vel iaculis
                            sapien
                            dapibus non. Vivamus facilisis, diam et condimentum sagittis, lectus enim
                            iaculis
                            ipsum, eu finibus urna tellus sit amet ex. Aliquam eget rhoncus lorem. Duis ut
                            metus
                            eget sapien lobortis varius id vel arcu. Sed hendrerit, arcu eget ullamcorper
                            efficitur, enim magna tempus erat, id pretium libero ligula vitae tortor.
                            Aliquam
                            vehicula eleifend sem nec maximus. Aenean ultricies ipsum et laoreet tincidunt.
                        </p>
                        <div class="image">
                            <img src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}"
                                data-src="{{ asset('frontend-assets/images/new-products/product-detail-1.png') }}" alt="" class="lazyload">
                        </div>
                        <p class="body-text-3">
                            Morbi interdum purus id justo pellentesque feugiat. Sed malesuada facilisis
                            enim,
                            volutpat ultrices nulla commodo ut. Proin pulvinar pharetra lacinia. Nulla massa
                            massa, elementum vel gravida nec, fermentum vel risus. Cras eu ipsum id metus
                            sollicitudin scelerisque. Maecenas libero dui, faucibus vel pharetra non,
                            eleifend
                            sit amet felis. Etiam metus nibh, auctor non orci in, consectetur pretium enim
                        </p>
                        <div class="image">
                            <img src="{{ asset('frontend-assets/images/new-products/product-detail-2.png') }}"
                                data-src="{{ asset('frontend-assets/images/new-products/product-detail-2.png') }}" alt="" class="lazyload">
                        </div>
                        <p class="body-text-3">
                            Pellentesque quis efficitur leo. Maecenas accumsan est in nibh interdum, quis
                            dignissim neque scelerisque. Ut suscipit et leo sit amet lacinia. Sed a laoreet
                            leo,
                            ut tristique risus. Integer a est ut est semper fermentum nec quis nunc.
                            Phasellus
                            aliquam neque eget quam gravida, quis venenatis turpis tristique. Mauris id
                            congue
                            augue. Pellentesque hendrerit porttitor purus, vel porttitor sem blandit vel. Ut
                            auctor, nibh tempus volutpat porttitor, urna ligula gravida lacus, non mollis
                            purus
                            neque ac lorem. Morbi sodales convallis laoreet. Mauris efficitur convallis odio
                            sed
                            congue.
                        </p>
                    </div>
                </div>
                
                <div class="tab-pane" id="prd-review" role="tabpanel">
                    <div class="tab-main tab-review flex-lg-nowrap">
                        <div class="tab-rating-wrap">
                            <div class="rating-percent">
                                <p class="rate-percent">4.8 <span>/ 5</span></p>
                                <ul class="list-star justify-content-center">
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
                                <p class="text-cl-3">
                                    Based on 1.738 reviews
                                </p>
                            </div>
                            <ul class="rating-progress-list">
                                <li>
                                    <p class="start-number body-text-3">5<i class="icon-star text-third"></i>
                                    </p>

                                    <div class="rating-progress">
                                        <div class="progress style-2" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%;"></div>
                                        </div>
                                    </div>
                                    <p class="count-review body-text-3">100</p>
                                </li>
                                <li>
                                    <p class="start-number body-text-3">4<i class="icon-star text-third"></i>
                                    </p>
                                    <div class="rating-progress">
                                        <div class="progress style-2" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar" style="width: 80%;"></div>
                                        </div>
                                    </div>
                                    <p class="count-review body-text-3">87</p>
                                </li>
                                <li>
                                    <p class="start-number body-text-3">3<i class="icon-star text-third"></i>
                                    </p>
                                    <div class="rating-progress">
                                        <div class="progress style-2" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar" style="width: 60%;"></div>
                                        </div>
                                    </div>
                                    <p class="count-review body-text-3">32</p>
                                </li>
                                <li>
                                    <p class="start-number body-text-3">2<i class="icon-star text-third"></i>
                                    </p>
                                    <div class="rating-progress">
                                        <div class="progress style-2" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar" style="width: 40%;"></div>
                                        </div>
                                    </div>
                                    <p class="count-review body-text-3">24</p>
                                </li>
                                <li>
                                    <p class="start-number body-text-3">1<i class="icon-star text-third"></i>
                                    </p>
                                    <div class="rating-progress">
                                        <div class="progress style-2" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%;"></div>
                                        </div>
                                    </div>
                                    <p class="count-review body-text-3">0</p>
                                </li>
                            </ul>
                            <div class="rating-filter-wrap">
                                <p class="title-sidebar fw-bold">Filter by</p>
                                <ul class="rating-filter-list">
                                    <li><a href="#" class="active">All</a></li>
                                    <li><a href="#">5 sao (8)</a></li>
                                    <li><a href="#">4 sao (12)</a></li>
                                    <li><a href="#">3 sao (23)</a></li>
                                    <li><a href="#">2 sao (10)</a></li>
                                    <li><a href="#">1 sao (0)</a></li>
                                </ul>
                            </div>
                            <div class="add-comment-wrap">
                                <h5 class="fw-semibold">Add your comment</h5>
                                <div>
                                    <form class="form-add-comment">
                                        <fieldset class="rate">
                                            <label>Rating:</label>
                                            <ul class="list-star justify-content-start">
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
                                        </fieldset>
                                        <fieldset>
                                            <label>Name:</label>
                                            <input type="text" placeholder="Your name" required="">
                                        </fieldset>
                                        <fieldset>
                                            <label>Email:</label>
                                            <input type="text" placeholder="Your email" required="">
                                        </fieldset>
                                        <fieldset class="align-items-sm-start">
                                            <label>Comment:</label>
                                            <textarea placeholder="Message"></textarea>
                                        </fieldset>
                                        <div class="btn-submit">
                                            <button type="submit" class="tf-btn btn-gray btn-large-2">
                                                <span class="text-white">Add Review</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-review-wrap">
                            <ul class="review-list">
                                <li class="box-review">
                                    <div class="avt">
                                        <img src="{{ asset('frontend-assets/images/item/person.avif') }}" alt="">
                                    </div>
                                    <div class="review-content">
                                        <div class="author-wrap">
                                            <h6 class="name fw-semibold">
                                                <a href="#" class="link">Cameron Williamson</a>
                                            </h6>
                                            <ul class="verified">
                                                <li class="body-small">Color: Black</li>
                                                <li class="body-small fw-semibold text-main-2">
                                                    Verified Purchase
                                                </li>
                                            </ul>
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
                                        </div>
                                        <p class="text-review">
                                            Bought this nice little electric hot water kettle for an
                                            overnight
                                            date. She enjoyed tea and the hotel did not offer tea in the
                                            room.
                                            Problem solved! This kettle did its job, through the evening and
                                            into the morning we enjoyed many cups of nice, loose leaf tea.
                                            Too
                                            bad she ended up not liking me and eventually ghosted me. But,
                                            the
                                            tea was great thanks to this electric kettle. Highly recommend!
                                        </p>
                                        <p class="date-review body-small">
                                            14/12/2020 lúc 17:20
                                        </p>
                                    </div>
                                </li>
                                <li class="box-review">
                                    <div class="avt">
                                        <img src="{{ asset('frontend-assets/images/item/person.avif') }}" alt="">
                                    </div>
                                    <div class="review-content">
                                        <div class="author-wrap">
                                            <h6 class="name fw-semibold">
                                                <a href="#" class="link">Cameron Williamson</a>
                                            </h6>
                                            <ul class="verified">
                                                <li class="body-small">Color: Black</li>
                                                <li class="body-small fw-semibold text-main-2">
                                                    Verified Purchase
                                                </li>
                                            </ul>
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
                                        </div>
                                        <p class="text-review">
                                            Nullam ornare a magna quis aliquet. Duis suscipit eros in
                                            suscipit
                                            venenatis. Pellentesque quis efficitur leo. Maecenas accumsan
                                            est in
                                            nibh interdum, quis dignissim neque scelerisque. Ut suscipit et
                                            leo
                                            sit amet lacinia. Sed a laoreet leo, ut tristique risus. Integer
                                            a
                                            est ut est semper fermentum nec quis nunc. Phasellus aliquam
                                            neque
                                            eget quam gravida, quis venenatis turpis tristique. Mauris id
                                            congue
                                            augue. Pellentesque hendrerit porttitor purus, vel porttitor sem
                                            blandit vel.
                                        </p>
                                        <p class="date-review body-small">
                                            14/12/2020 lúc 17:20
                                        </p>
                                    </div>
                                </li>
                                <li class="box-review">
                                    <div class="avt">
                                        <img src="{{ asset('frontend-assets/images/item/person.avif') }}" alt="">
                                    </div>
                                    <div class="review-content">
                                        <div class="author-wrap">
                                            <h6 class="name fw-semibold">
                                                <a href="#" class="link">Cameron Williamson</a>
                                            </h6>
                                            <ul class="verified">
                                                <li class="body-small">Color: Black</li>
                                                <li class="body-small fw-semibold text-main-2">
                                                    Verified Purchase
                                                </li>
                                            </ul>
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
                                        </div>
                                        <p class="text-review">
                                            Suspendisse efficitur velit quis sodales facilisis. Aenean id
                                            enim
                                            nec purus interdum semper. In hac habitasse platea dictumst.
                                            Nulla
                                            posuere ac ligula sit amet posuere. Curabitur ultricies non dui
                                            ut
                                            blandit. In quis nulla nec tellus rutrum porttitor. Sed pharetra
                                            magna diam, et lacinia tortor congue ut.
                                        </p>
                                        <p class="date-review body-small">
                                            14/12/2020 lúc 17:20
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Product Description Tab -->

<!-- Discover -->
<section class="tf-sp-2 pt-0">
    <div class="container">
        <div class="flat-title">
            <h5 class="fw-semibold">Recently Viewed</h5>
            <!-- <div class="box-btn-slide relative">
                <div class="swiper-button-prev nav-swiper nav-prev-products">
                    <i class="icon-arrow-left-lg"></i>
                </div>
                <div class="swiper-button-next nav-swiper nav-next-products">
                    <i class="icon-arrow-right-lg"></i>
                </div>
            </div> -->
        </div>
        <div class="swiper tf-sw-products" data-preview="5" data-tablet="4" data-mobile-sm="3" data-mobile="2"
            data-space-lg="30" data-space-md="20" data-space="15" data-pagination="2" data-pagination-sm="3"
            data-pagination-md="4" data-pagination-lg="5">
            <div class="swiper-wrapper">
                <!-- item 1 -->
                <div class="swiper-slide">
                    <div class="card-product style-img-border wow fadeInLeft" data-wow-delay="0s">
                        <div class="card-product-wrapper">
                            <a href="{{ route('product-detail') }}" class="product-img">
                                <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-5-1.png') }}" alt="image-product">
                                <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-5-2.png') }}" alt="image-product">
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
                                <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-3-1.png') }}" alt="image-product">
                                <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-3-2.png') }}" alt="image-product">
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
                                        RICH POLO Biometric RS 9w with WiFi Access Control, Time & Attendance (Fingerprint)
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
                                <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-1-1.png') }}" alt="image-product">
                                <img class="img-hover lazyload"
                                    src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-1-2.png') }}" alt="image-product">
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
                                        Qubo Smart Cam 360 Q100 by HERO GROUP 3MP 1296p WiFi CCTV 2 Way Talk Night Vision Security Camera (1 Channel)
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
                                <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-2-1.png') }}" alt="image-product">
                                <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-2-2.png') }}" alt="image-product">
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
                                        HP MFP 1188W Multi-function WiFi Monochrome Laser Printer (Toner Cartridge, 1 Ink Bottle Included)
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
                                <img class="img-product lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-4-1.png') }}" alt="image-product">
                                <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}"
                                    data-src="{{ asset('frontend-assets/images/new-products/2-4-2.png') }}" alt="image-product">
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
                                        HP Victus Intel Core i5 13th Gen 13420H - (16 GB/512 GB SSD/Windows 11 Home/6 GB Graphics/NVIDIA GeForce RTX 4050/144 Hz) fa1278TX Gaming Laptop
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
                        <div class="card-product-wrapper">
                            <a href="{{ route('product-detail') }}" class="product-img">
                                <img class="img-product lazyload" src="{{ asset('frontend-assets/images/product/product-11.jpg') }}"
                                    data-src="{{ asset('frontend-assets/images/product/product-11.jpg') }}" alt="image-product">
                                <img class="img-hover lazyload" src="{{ asset('frontend-assets/images/product/product-38.jpg') }}"
                                    data-src="{{ asset('frontend-assets/images/product/product-38.jpg') }}" alt="image-product">
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
            <div class="d-flex d-lg-none sw-dot-default sw-pagination-products justify-content-center">
            </div>
        </div>
    </div>
</section>
<!-- /Discover -->

<!-- Iconbox -->
<!-- <div class="tf-sp-2 pt-0">
            <div class="container">
                <div class="swiper tf-sw-iconbox" data-preview="5" data-tablet="3.5" data-mobile-sm="2.5"
                    data-mobile="1" data-space-lg="20" data-space-md="20" data-space="15" data-pagination="1"
                    data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box">
                                    <i class="icon icon-delivery"></i>
                                </div>
                                <div class="content">
                                    <p class="body-text fw-semibold">Free delivery</p>
                                    <p class="body-text-3">Velit ullamco elit et aliqua magna</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box">
                                    <i class="icon icon-check-2"></i>
                                </div>
                                <div class="content">
                                    <p class="body-text fw-semibold">Support 24/7</p>
                                    <p class="body-text-3">Velit ullamco elit et aliqua magna</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box">
                                    <i class="icon icon-money-bag"></i>
                                </div>
                                <div class="content">
                                    <p class="body-text fw-semibold">Payment</p>
                                    <p class="body-text-3">Velit ullamco elit et aliqua magna</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box">
                                    <i class="icon icon-shield"></i>
                                </div>
                                <div class="content">
                                    <p class="body-text fw-semibold">Reliable</p>
                                    <p class="body-text-3">Velit ullamco elit et aliqua magna</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box">
                                    <i class="icon icon-accept"></i>
                                </div>
                                <div class="content">
                                    <p class="body-text fw-semibold">Guarantee</p>
                                    <p class="body-text-3">Velit ullamco elit et aliqua magna</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-iconbox sw-dot-default justify-content-center"></div>
                </div>
            </div>
        </div> -->
<!-- /Iconbox -->


@endsection