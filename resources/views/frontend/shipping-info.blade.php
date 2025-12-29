@extends('frontend/layout/master')

@section('main-content')

<!-- Breakcrumbs -->
<div class="tf-sp-1 pb-3">
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
                <span class="body-small">Shipping Policy</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->

<section class="s-search-faq">
    <div class="wrap">
        <div class="container">
            <div class="content">
                <div class="box-title text-center">
                    <h2 class="title fw-semibold text-white" style="filter: drop-shadow(2px 4px 6px black);"> Shipping Policy</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-image">
        <img src="{{ asset('frontend-assets/images/banner/shipping.png') }}" data-src="{{ asset('frontend-assets/images/banner/shipping.png') }}" alt=""
            class="lazyload effect-paralax">
    </div>
</section>

<!-- Privacy -->
<section class="tf-sp-2">
    <div class="container">
        <div class="privary-wrap">
            <div class="entry-privary">
                <div class="wrap">
                    <!-- <h5 class="fw-semibold">Welcome to Our Electronics Store</h5> -->
                    <p class="title-sidebar-2 text-main-2">We aim to deliver your electronics quickly and safely.</p>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Delivery Time:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Orders are typically processed within 1-2 business days.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Estimated delivery: 3–7 business days, depending on location.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Shipping Charges:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Free shipping on orders above 499.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                A nominal fee applies to lower-value orders.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Tracking:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                You will receive a tracking number once the order is dispatched.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Responsibility:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                We are not liable for delays caused by courier services or natural events.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                In case of failed delivery, our team will coordinate a redelivery or refund.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Privacy -->


@endsection