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
                <span class="body-small">Privacy</span>
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
                    <h2 class="title fw-semibold text-white" style="filter: drop-shadow(2px 4px 6px black);">Privacy</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-image">
        <img src="{{ asset('frontend-assets/images/banner/privacy.png') }}" data-src="{{ asset('frontend-assets/images/banner/privacy.png') }}" alt=""
            class="lazyload effect-paralax">
    </div>
</section>

<!-- Privacy -->
<section class="tf-sp-2">
    <div class="container">
        <div class="privary-wrap">
            <div class="entry-privary">
                <div class="wrap">
                    <h5 class="fw-semibold">Who we are</h5>
                    <p class="title-sidebar-2 text-main-2"><span class="fw-medium">Suggested text:</span> Our
                        website address is:
                        http://example.com</p>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Comments (If Applicable)</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                When visitors leave comments on the site, we collect the data shown in the
                                comments form, and also the visitor's IP address and browser user agent string
                                to help spam detection.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                An anonymized string created from your email address (also called a hash) may be
                                provided to the Gravatar service to see if you are using it. The Gravatar
                                service privacy policy is available here:
                                <a href="{{ route('privacy') }}" class="link text-secondary fw-semibold"
                                    target="_blank">Privacy</a>.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                After approval of your comment, your profile picture is visible to the public in
                                the context of your comment.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Please note that customer reviews may be used for promotional purposes, without
                                disclosing personal information.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Media (Product Images)</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you upload product images to the website, you should avoid uploading images
                                with embedded location data (EXIF GPS) included. Visitors to the website can
                                download and extract any location data from images on the website.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Customers' product images could be used for warranty purposes, or for dealing
                                with product-related issues.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Cookies</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you leave a comment on our site, you may opt-in to saving your name, email
                                address, and website in cookies. These are for your convenience so that you do
                                not have to fill in your details again when you leave another comment. These
                                cookies will last for one year.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you visit our login page, we will set a temporary cookie to determine if your
                                browser accepts cookies. This cookie contains no personal data and is discarded
                                when you close your browser.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                When you log in, we will also set up several cookies to save your login
                                information and your screen display choices. Login cookies last for two days,
                                and screen options cookies last for a year. If you select "Remember Me", your
                                login will persist for two weeks. If you log out of your account, the login
                                cookies will be removed.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you edit or publish an article, an additional cookie will be saved in your
                                browser. This cookie includes no personal data and simply indicates the post ID
                                of the article you just edited. It expires after 1 day.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                This electronic store website uses cookies to save the customer's shopping cart
                                information and to store what products a client has viewed, to recommend related
                                products.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Embedded Content From Other Websites</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Articles on this site may include embedded content (e.g., videos, images,
                                articles, etc.). Embedded content from other websites behaves in the exact same
                                way as if the visitor has visited the other website.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                These websites may collect data about you, use cookies, embed additional
                                third-party tracking, and monitor your interaction with that embedded content,
                                including tracking your interaction with the embedded content if you have an
                                account and are logged in to that website.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Who We Share Your Data With</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you request a password reset, your IP address will be included in the reset
                                email.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Customer information will be shared with shipping services in order to deliver
                                products.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Customer information could be shared with product suppliers in order to support
                                warranties.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Information could be shared with payment processors in order to process
                                transactions.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">How Long We Retain Your Data</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you leave a comment, the comment and its metadata are retained indefinitely.
                                This is so we can recognize and approve any follow-up comments automatically
                                instead of holding them in a moderation queue.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                For users that register on our website (if any), we also store the personal
                                information they provide in their user profile. All users can see, edit, or
                                delete their personal information at any time (except they cannot change their
                                username). Website administrators can also see and edit that information.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Purchase information is retained to support warranties and customer support.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">What Rights You Have Over Your Data</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If you have an account on this site, or have left comments, you can request to
                                receive an exported file of the personal data we hold about you, including any
                                data you have provided to us.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                You can also request that we erase any personal data we hold about you. This
                                does not include any data we are obliged to keep for administrative, legal, or
                                security purposes.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="wrap">
                    <h5 class="fw-semibold">Additional Notes for an Electronics Store</h5>
                    <ul class="text-list">
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Customer information is used for warranty and technical support purposes to
                                ensure proper service and assistance.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                If necessary, we may collect computer or laptop configuration details to provide
                                accurate support services.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                Customer information may be used for marketing purposes, such as promotional
                                emails and product recommendations. Customers have the option to opt out at any
                                time.
                            </p>
                        </li>
                        <li>
                            <p class="title-sidebar-2 text-main-2">
                                We implement security measures, including data encryption, to protect customer
                                information and ensure privacy.
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