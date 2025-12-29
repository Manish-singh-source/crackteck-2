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
                <span class="body-small">Return & Refund Policy</span>
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
                    <h2 class="title fw-semibold text-white" style="filter: drop-shadow(2px 4px 6px black);">Return & Refund Policy</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-image">
        <img src="{{ asset('frontend-assets/images/banner/return.png') }}" data-src="{{ asset('frontend-assets/images/banner/return.png') }}" alt=""
            class="lazyload effect-paralax">
    </div>
</section>

<!-- Privacy -->
<section class="tf-sp-2">
    <div class="container">
        <div class="privary-wrap">
            <div class="entry-privary">
                <div class="wrap">
                    <h5 class="fw-semibold">Return Policy</h5>
                    <p class="title-sidebar-2 text-main-2">We want you to be completely satisfied with your purchase. If you're not, we’re here to help.</p>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Eligibility:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Returns are accepted within 7 days of delivery.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Products must be unused, in original condition, with all tags, manuals, and packaging intact.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Non-Returnable Items:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Products damaged due to misuse or negligence.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Software, warranty cards, or gift cards.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Process:</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Contact our support team with your order ID and reason for return.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Once approved, we will schedule a reverse pickup or share return instructions.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Refund Policy</h5>
                    <p class="title-sidebar-2 text-main-2">Once your return is received and inspected:</p>
                </div>
                <div class="wrap">
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Refunds will be initiated within 5-7 business days.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                The amount will be credited back to your original payment method.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <p class="fw-semibold">Note: For Cash on Delivery (COD) orders, refunds will be processed to your bank account or issued as store credit.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Privacy -->

@endsection