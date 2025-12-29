@extends('frontend/layout/master')

@section('style')
<style>
    .about-section {
      padding: 60px 0;
    }

    .about-us-section{
        padding: 0 50px;
    }

    .image-wrapper {
      position: relative;
      width: 100%;
    }

    .main-img {
      width: 100%;
      border-radius: 20px;
    }

    .sub-img {
      position: absolute;
      bottom: -20px;
      left: -30px;
      width: 50%;
      border-radius: 20px;
      border: 5px solid #1987FF;
    }

    .counter-badge {
      position: absolute;
      bottom: -10px;
      right: -15px;
      background-color: #1987FF;
      color: #fff;
      padding: 10px 20px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 14px;
    }

    .section-title {
      font-weight: 700;
    }

    .feature-box {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .feature-icon {
      background-color:rgba(25, 136, 255, 0.2);
      color: #1987FF;
      font-size: 18px;
      padding: 12px;
      border-radius: 50%;
      margin-right: 15px;
    }

    .stats-box {
      text-align: center;
    }

    .stats-box h4 {
      font-weight: 700;
      color: #1987FF;
    }

    .stats-box p {
      margin: 0;
      color: #333;
    }

    .info-card {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        height: 100%;
    }
  </style>
  @endsection

@section('main-content')

<!-- Breakcrumbs -->
<div class="tf-sp-1 pb-0">
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
                <span class="body-small">About</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->


<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Image Section -->
            <div class="col-lg-6 mb-5 mb-lg-0 about-us-section">
                <div class="image-wrapper">
                    <img src="{{ asset('frontend-assets/images/banner/about.jpg') }}" alt="Main" class="main-img">
                    <img src="{{ asset('frontend-assets/images/banner/about2.jpg') }}" alt="Sub" class="sub-img">
                    <div class="counter-badge">1,485+ <br> Trusted Clients</div>
                </div>
            </div>

            <!-- Text Section -->
            <div class="col-lg-6">
                <p class="text-uppercase text-primary fw-semibold mb-2">About US</p>
                <h3 class="section-title mb-3">Lorem ipsum dolor, sit amet consectetur elit.</h3>
                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

                <div class="feature-box">
                    <div class="feature-icon"><i class="fa-solid fa-handshake"></i></div>
                    <div>
                        <h6 class="mb-1 fw-semibold">Trusted Partner</h6>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-icon"><i class="fa-solid fa-handshake"></i></div>
                    <div>
                        <h6 class="mb-1 fw-semibold">Fastpace Platform</h6>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-icon"><i class="fa-solid fa-handshake"></i></div>
                    <div>
                        <h6 class="mb-1 fw-semibold">Tested Reliability</h6>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row text-center mt-5">
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-box info-card">
                    <h4 class="counter mb-2" data-target="25">0</h4>
                    <p>Years Of Experience</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-box info-card">
                    <h4 class="counter mb-2" data-target="3452">0</h4>
                    <p>Total Transaction</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-box info-card">
                    <h4 class="counter mb-2" data-target="751">0</h4>
                    <p>Active User</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-box info-card">
                    <h4 class="counter mb-2" data-target="592">0</h4>
                    <p>Positive Reviews</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Iconbox -->
<div class="tf-sp-2">
    <div class="container">
        <div class="swiper tf-sw-iconbox" data-preview="5" data-tablet="3" data-mobile-sm="2" data-mobile="1"
            data-space-lg="20" data-space-md="20" data-space="15">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="tf-icon-box wow fadeInLeft" data-wow-delay="0s">
                        <div class="icon-box">
                            <img src="{{ asset('frontend-assets/images/icons/icon-1.png') }}"
                                alt="icon">
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
                            <img src="{{ asset('frontend-assets/images/icons/icon-2.png') }}"
                                alt="icon">
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
                            <img src="{{ asset('frontend-assets/images/icons/icon-3.png') }}"
                                alt="icon">
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
                            <img src="{{ asset('frontend-assets/images/icons/icon-4.png') }}"
                                alt="icon">
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
                            <img src="{{ asset('frontend-assets/images/icons/icon-5.png') }}"
                                alt="icon">
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

<!-- Testimonial -->
<section class="tf-sp-2">
    <div class="container">
        <div class="flat-title wow fadeInUp">
            <h5 class="fw-semibold">Customer Review</h5>
            <div class="box-btn-slide relative">
                <div class="swiper-button-prev nav-swiper nav-prev-products">
                    <i class="icon-arrow-left-lg"></i>
                </div>
                <div class="swiper-button-next nav-swiper nav-next-products">
                    <i class="icon-arrow-right-lg"></i>
                </div>
            </div>
        </div>
        <div class="swiper tf-sw-products" data-preview="3" data-tablet="2" data-mobile-sm="1" data-mobile="1"
            data-space-lg="30" data-space-md="15" data-space="15" data-pagination="1" data-pagination-sm="1"
            data-pagination-md="2" data-pagination-lg="3">
            <div class="swiper-wrapper">
                <!-- item 1 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInUp">
                        <div class="entry_image">
                            <img src="{{ asset('frontend-assets/images/item/person.avif') }}" data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
                                class="lazyload">
                        </div>
                        <div class="content">
                            <div class="box-title">
                                <a href="#" class="entry_name product-title link fw-semibold">
                                    Cameron Williamson
                                </a>
                                <ul class="entry_meta">
                                    <li>
                                        <p class="body-small text-main-2">Color: Black</p>
                                    </li>
                                    <li class="br-line"></li>
                                    <li>
                                        <p class="body-small text-main-2 fw-semibold">Verified Purchase</p>
                                    </li>
                                </ul>
                                <ul class="list-star">
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                </ul>
                            </div>
                            <p class="entry_text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla iaculis
                                velit,
                                pharetra aliquet urna faucibus et. Vivamus blandit vulputate risus. Praesent at
                                justo sed
                                nibh interdum viverra at non magna
                            </p>
                            <p class="entry_date body-small">
                                December 14, 2020 at 17:20
                            </p>
                        </div>
                    </div>
                </div>
                <!-- item 2 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInUp" data-wow-delay="0.1s">
                        <div class="entry_image">
                            <img src="{{ asset('frontend-assets/images/item/person.avif') }}" data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
                                class="lazyload">
                        </div>
                        <div class="content">
                            <div class="box-title">
                                <a href="#" class="entry_name product-title link fw-semibold">
                                    Cameron Williamson
                                </a>
                                <ul class="entry_meta">
                                    <li>
                                        <p class="body-small text-main-2">Color: Black</p>
                                    </li>
                                    <li class="br-line"></li>
                                    <li>
                                        <p class="body-small text-main-2 fw-semibold">Verified Purchase</p>
                                    </li>
                                </ul>
                                <ul class="list-star">
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                </ul>
                            </div>
                            <p class="entry_text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla iaculis
                                velit,
                                pharetra aliquet urna faucibus et. Vivamus blandit vulputate risus. Praesent at
                                justo sed
                                nibh interdum viverra at non magna
                            </p>
                            <p class="entry_date body-small">
                                December 14, 2020 at 17:20
                            </p>
                        </div>
                    </div>
                </div>
                <!-- item 3 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInUp" data-wow-delay="0.2s">
                        <div class="entry_image">
                            <img src="{{ asset('frontend-assets/images/item/person.avif') }}" data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
                                class="lazyload">
                        </div>
                        <div class="content">
                            <div class="box-title">
                                <a href="#" class="entry_name product-title link fw-semibold">
                                    Cameron Williamson
                                </a>
                                <ul class="entry_meta">
                                    <li>
                                        <p class="body-small text-main-2">Color: Black</p>
                                    </li>
                                    <li class="br-line"></li>
                                    <li>
                                        <p class="body-small text-main-2 fw-semibold">Verified Purchase</p>
                                    </li>
                                </ul>
                                <ul class="list-star">
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                </ul>
                            </div>
                            <p class="entry_text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla iaculis
                                velit,
                                pharetra aliquet urna faucibus et. Vivamus blandit vulputate risus. Praesent at
                                justo sed
                                nibh interdum viverra at non magna
                            </p>
                            <p class="entry_date body-small">
                                December 14, 2020 at 17:20
                            </p>
                        </div>
                    </div>
                </div>
                <!-- item 4 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial">
                        <div class="entry_image">
                            <img src="{{ asset('frontend-assets/images/item/person.avif') }}" data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
                                class="lazyload">
                        </div>
                        <div class="content">
                            <div class="box-title">
                                <a href="#" class="entry_name product-title link fw-semibold">
                                    Cameron Williamson
                                </a>
                                <ul class="entry_meta">
                                    <li>
                                        <p class="body-small text-main-2">Color: Black</p>
                                    </li>
                                    <li class="br-line"></li>
                                    <li>
                                        <p class="body-small text-main-2 fw-semibold">Verified Purchase</p>
                                    </li>
                                </ul>
                                <ul class="list-star">
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                    <li><i class="icon-star"></i></li>
                                </ul>
                            </div>
                            <p class="entry_text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla iaculis
                                velit,
                                pharetra aliquet urna faucibus et. Vivamus blandit vulputate risus. Praesent at
                                justo sed
                                nibh interdum viverra at non magna
                            </p>
                            <p class="entry_date body-small">
                                December 14, 2020 at 17:20
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sw-dot-default sw-pagination-products justify-content-center"></div>
        </div>
    </div>
</section>
<!-- /Testimonial -->

<!-- Brand -->
<!-- <div class="">
            <div class="line-bt line-tp">
                <div class="infiniteslide tf-brand">
                    <div class="brand-item">
                        <img src="images/brand/lead-ecommerce.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/global-brand.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/great-deal.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/walmart.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/rodem.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/fabric.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/sudo.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/ctaecom.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/amazon.svg" alt="brand">
                    </div>
                    <div class="brand-item">
                        <img src="images/brand/bestbuy.svg" alt="brand">
                    </div>
                </div>
            </div>
        </div> -->
<!-- /Brand -->


<script>
  const counters = document.querySelectorAll('.counter');

  counters.forEach(counter => {
    const updateCount = () => {
      const target = +counter.getAttribute('data-target');
      const count = +counter.innerText;
      const increment = target / 200;

      if (count < target) {
        counter.innerText = Math.ceil(count + increment);
        setTimeout(updateCount, 10);
      } else {
        counter.innerText = target + ' +';
      }
    };

    updateCount();
  });
</script>

@endsection