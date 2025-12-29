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
                <span class="body-small">Terms & Conditions</span>
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
                    <h2 class="title fw-semibold text-white" style="filter: drop-shadow(2px 4px 6px black);"> Terms & Conditions</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-image">
        <img src="{{ asset('frontend-assets/images/banner/t&c.png') }}" data-src="{{ asset('frontend-assets/images/banner/t&c.png') }}" alt=""
            class="lazyload effect-paralax">
    </div>
</section>

<!-- Privacy -->
<section class="tf-sp-2">
    <div class="container">
        <div class="privary-wrap">
            <div class="entry-privary">
                <div class="wrap">
                    <h5 class="fw-semibold">Welcome to Our Electronics Store</h5>
                    <p class="title-sidebar-2 text-main-2">By accessing and using our website, you agree to be bound by the following Terms and Conditions. Please read them carefully before making a purchase.</p>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Use of the Website</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                You agree to use this site only for lawful purposes.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                You must not misuse our website by introducing viruses or attempting unauthorized access.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Product Information</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                We strive to display accurate product descriptions and images.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Product specifications and availability are subject to change without notice.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Pricing</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                All prices are listed in [Currency] and include applicable taxes unless stated otherwise.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Prices and promotions are subject to change without prior notice.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Orders & Payments</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Orders are confirmed only after payment is successfully processed.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                We reserve the right to cancel orders due to pricing errors or stock unavailability.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Intellectual Property</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                All content, logos, images, and designs are the property of our store and may not be reproduced without permission.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Privacy</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Your data is handled in accordance with our <a href="{{ route('privacy') }}">Privacy Police</a>.
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