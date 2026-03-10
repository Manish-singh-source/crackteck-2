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
                    <span class="body-small">Refunds & Cancellation Policy</span>
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
                        <h2 class="title fw-semibold text-white" style="filter: drop-shadow(2px 4px 6px black);">Refunds &
                            Cancellation Policy</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax-image">
            <img src="{{ asset('frontend-assets/images/banner/bg-banner-1.jpg') }}"
                data-src="{{ asset('frontend-assets/images/banner/bg-banner-1.jpg') }}" alt=""
                class="lazyload effect-paralax">
        </div>
    </section>

    <!-- Terms & Conditions -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="privary-wrap">
                <div class="entry-privary">

                    <!-- Introduction Card -->
                    <div class="policy-card mb-4">
                        <div class="policy-icon">
                            <i class="icon icon-document"></i>
                        </div>
                        <div class="policy-content">
                            <h5 class="fw-semibold">Refunds & Cancellation Policy</h5>
                            <p class="text-muted mb-0">This refund and cancellation policy outlines how you can cancel or
                                seek a refund for a product / service that you have purchased through the Platform. Under
                                this policy:</p>
                        </div>
                    </div>

                    <!-- Terms List -->
                    <div class="terms-section">
                        <div class="term-item">
                            <div class="term-number">1</div>
                            <div class="term-content">
                                {{-- <h6 class="fw-semibold mb-2">Electronic Record</h6> --}}
                                <p class="text-muted mb-0">
                                    Cancellations will only be considered if the request is made 3 days of placing the
                                    order. However, cancellation requests may not be entertained if the orders have been
                                    communicated to such sellers / merchant(s) listed on the Platform and they have
                                    initiated the process of shipping them, or the product is out for delivery. In such an
                                    event, you may choose to reject the product at the doorstep.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">2</div>
                            <div class="term-content">
                                {{-- <h6 class="fw-semibold mb-2">Platform Ownership</h6> --}}
                                <p class="text-muted mb-0">
                                    9607788836 does not accept cancellation requests for perishable items like flowers,
                                    eatables, etc. However, the refund / replacement can be made if the user establishes
                                    that the quality of the product delivered is not good.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">3</div>
                            <div class="term-content">
                                {{-- <h6 class="fw-semibold mb-2">Company Information</h6> --}}
                                <p class="text-muted mb-0">
                                    In case of receipt of damaged or defective items, please report to our customer service
                                    team. The request would be entertained once the seller/ merchant listed on the Platform,
                                    has checked and determined the same at its own end. This should be reported within 3
                                    days of receipt of products. In case you feel that the product received is not as shown
                                    on the site or as per your expectations, you must bring it to the notice of our customer
                                    service within 3 days of receiving the product. The customer service team after looking
                                    into your complaint will take an appropriate decision.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">4</div>
                            <div class="term-content">
                                {{-- <h6 class="fw-semibold mb-2">User Agreement</h6> --}}
                                <p class="text-muted mb-0">
                                    In case of complaints regarding the products that come with a warranty from the
                                    manufacturers, please refer the issue to them.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">5</div>
                            <div class="term-content">
                                {{-- <h6 class="fw-semibold mb-2">Acceptance of Terms</h6> --}}
                                <p class="text-muted mb-0">
                                    In case of any refunds approved by 9607788836, it will take 7 days for the refund to be
                                    processed to you.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Terms & Conditions -->

    <style>
        /* .policy-card {
                    display: flex;
                    align-items: flex-start;
                    gap: 16px;
                    padding: 24px;
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                } */


        .policy-card.bg-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        }

        .policy-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-color, #5oo9e8);
            border-radius: 10px;
            font-size: 20px;
            color: #fff;
        }

        .policy-icon.bg-primary {
            background: #5c6bc0 !important;
        }

        .policy-content h5,
        .policy-content h6 {
            color: #333;
        }

        .terms-section {
            display: flex;
            flex-direction: column;
            /* gap: 16px; */
        }

        .term-item {
            display: flex;
            gap: 16px;
            padding: 10px 20px;
            background: #fff;
            border-radius: 10px;
            /* box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06); */
            transition: all 0.3s ease;
        }

        /* .term-item:hover {
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            } */

        /* .term-number {
                width: 36px;
                height: 36px;
                min-width: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #5c6bc0 0%, #3949ab 100%);
                border-radius: 50%;
                font-weight: 600;
                font-size: 14px;
                color: #fff;
            } */

        .term-content h6 {
            color: #2c3e50;
            font-size: 15px;
        }

        .term-content p {
            font-size: 14px;
            line-height: 1.6;
            color: #6c757d;
        }

        .btn-primary {
            background: #5c6bc0;
            border-color: #5c6bc0;
        }

        .btn-primary:hover {
            background: #3949ab;
            border-color: #3949ab;
        }

        @media (max-width: 768px) {
            .policy-card {
                flex-direction: column;
                padding: 16px;
            }

            /* .term-item {
                flex-direction: column;
                padding: 16px;
            } */

            .term-number {
                width: 32px;
                height: 32px;
                min-width: 32px;
                font-size: 12px;
            }

            .tf-sp-2 {
                padding-top: 0px;
                padding-bottom: 0px;
            }

            .entry-privary {
                display: grid;
                gap: 0px;
            }

            .s-search-faq .parallax-image {
                height: 200px;
            }

            .term-item {
                display: flex;
                gap: 0px;
                padding: 10px 0px;
                background: #fff;
                border-radius: 10px;
                /* box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06); */
                transition: all 0.3s ease;
            }
        }
    </style>
@endsection
