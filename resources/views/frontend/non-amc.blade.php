@extends('frontend/layout/master')

@section('style')
    <style>
        .pricing-section {
            padding: 30px 0;
        }

        .pricing-section h3 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .pricing-section p {
            color: #666;
            font-size: 15px;
        }

        .toggle-buttons {
            display: inline-flex;
            background-color: #e0f3ed;
            border-radius: 8px;
            overflow: hidden;
            margin: 30px 0;
        }

        .toggle-buttons button {
            background: none;
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            color: #111;
        }

        .toggle-buttons .active {
            background-color: #1987FF;
            color: #fff;
        }

        .price-card {
            background-color: #fff;
            border: none;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.07);
            transition: 0.3s;
        }

        .price-card:hover {
            transform: translateY(-5px);
        }

        .price-card h4 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .price-card .price {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .price-card ul {
            padding-left: 0;
            list-style: none;
            color: #555;
            font-size: 15px;
            line-height: 1.8;
        }

        .price-card ul li::before {
            content: "✔";
            color: #27c4*;
            margin-right: 8px;
        }

        .price-card .btn {
            margin-top: 20px;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 5px;
        }

        .recommended {
            border: 2px solid #1987FF;
            position: relative;
        }

        .recommended::before {
            content: "RECOMMENDED";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #1987FF;
            color: rgb(0, 0, 0);
            font-size: 12px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .feature {
            display: flex;
            justify-content: space-between;
        }




        .testimonial-heading {
            text-align: center;
            padding: 60px 0 30px;
        }

        .testimonial-heading h6 {
            color: #1987FF;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .testimonial-heading h3 {
            font-weight: 700;
        }

        .testimonial-heading span {
            color: #1987FF;
        }

        .testimonial-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            margin: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.06);
            position: relative;
            transition: transform 0.3s ease-in-out;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .testimonial-stars {
            color: #1987FF;
            margin-bottom: 10px;
        }

        .testimonial-text {
            font-size: 15px;
            color: #333;
            margin-bottom: 15px;
        }

        .testimonial-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .testimonial-user img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .testimonial-user-info h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .testimonial-user-info small {
            font-size: 13px;
            color: #888;
        }

        .badge-top {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #1987FF;
            color: #fff;
            font-weight: bold;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Carousel arrows */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #1987FF;
            border-radius: 50%;
            padding: 10px;
        }

        .carousel-item {
            height: 30vh;
            color: #000000;
            position: relative;
            background-size: cover;
            background-position: top;
        }

        .form-container {
            max-width: 1196px;
        }

        .tf-sp-2 {
            padding-top: 20px;
            padding-bottom: 0px;
        }






        .container-contact-form {
            display: flex;
            /* max-width: 1000px; */
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            width: 250px;
            background: #EBEBEB;
            padding: 40px 20px;
        }

        .sidebar h2 {
            margin-bottom: 40px;
        }

        .step {
            margin-bottom: 30px;
            color: #999;
            font-weight: bold;
        }

        .step.active {
            color: #000;
        }

        .form-content {
            flex: 1;
            padding: 40px;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        /* input,
                              select,
                              textarea {
                                width: 100%;
                                padding: 12px;
                                margin: 10px 0 20px;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                              } */

        .btn {
            padding: 10px 20px;
            background: #1987FF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            padding: 10px 20px;
            background: rgb(56, 219, 192);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #000000;
        }

        .btn:disabled {
            background: #ccc;
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
                    <span class="body-small">Non AMC</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <div class="page-content md-mb-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tf-sp-2">
                        <img src="{{ asset('frontend-assets/images/banner/AMC.png') }}" style="width: 100%;" alt="">
                        <div class="container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="d-flex d-md-none justify-content-center align-item-center">Non-AMC Service Request Form</h4>

    <div class="container container-contact-form">
        <div class="sidebar d-none d-md-flex flex-column">
            <h5 class="mb-5 d-flex justify-content-center text-center">Non-AMC Service Request Form</h5>
            <div class="step active" id="step1">1. Customer Details</div>
            <div class="step" id="step2">2. Company Details</div>
            <div class="step" id="step3">3. Product Information</div>
            <div class="step" id="step4">4. Additional Information</div>
            <div class="step" id="step5">5. Review & Submit</div>
        </div>


        <div class="form-content">
            <form id="requestForm">
                <!-- Step 1: Customer Details -->
                <div class="form-section active" id="section1">
                    <h3 class="mb-5">Customer Details</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-lg" id="first_name" name="first_name"
                                placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-lg" id="last_name" name="last_name"
                                placeholder="Last Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                placeholder="Email Address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pan_no" class="form-label">Pan No</label>
                            <input type="text" class="form-control form-control-lg" id="pan_no" name="pan_no"
                                placeholder="Pan No" required>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_type" class="form-label">Customer Type</label>
                            <select class="form-select form-control-lg" id="customer_type" name="customer_type" required>
                                <option value="">Select Customer Type</option>
                                <option value="Individual">Individual</option>
                                <option value="Corporate">Corporate</option>
                                <option value="SME">SME</option>
                            </select>
                        </div>
                        {{-- Source Type  --}}
                        <div class="col-md-6">
                            <input type="hidden" class="form-control form-control-lg" id="source_type_label" name="source_type_label" value="ecommerce_non_amc_page" readonly>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Company Details (Optional) -->
                <div class="form-section" id="section2">
                    <h3 class="mb-3">Company Details</h3>
                    <p class="text-muted mb-4">This section is optional. You can skip it if you're an individual customer.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control form-control-lg" id="company_name" name="company_name"
                                placeholder="Company Name">
                        </div>
                        <div class="col-md-6">
                            <label for="branch_name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control form-control-lg" id="branch_name"
                                name="branch_name" placeholder="Branch Name">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control form-control-lg" id="city" name="city"
                                placeholder="City">
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control form-control-lg" id="state" name="state"
                                placeholder="State">
                        </div>
                        <div class="col-md-4">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control form-control-lg" id="country" name="country"
                                placeholder="Country" value="India">
                        </div>
                        <div class="col-md-6">
                            <label for="pin_code" class="form-label">Pin Code</label>
                            <input type="text" class="form-control form-control-lg" id="pin_code" name="pin_code"
                                placeholder="Pin Code">
                        </div>
                        <div class="col-md-6">
                            <label for="gst_no" class="form-label">GST No</label>
                            <input type="text" class="form-control form-control-lg" id="gst_no" name="gst_no"
                                placeholder="GST Number">
                        </div>
                        <div class="col-md-6">
                            <label for="address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control form-control-lg" id="address_line1"
                                name="address_line1" placeholder="Address Line 1">
                        </div>
                        <div class="col-md-6">
                            <label for="address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control form-control-lg" id="address_line2"
                                name="address_line2" placeholder="Address Line 2">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Product Information -->
                <div class="form-section" id="section3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Product Information</h3>
                        <button type="button" class="btn btn-primary" id="addProductBtn">
                            <i class="fas fa-plus me-2"></i>Add Product
                        </button>
                    </div>

                    <!-- Products Container -->
                    <div id="productsContainer">
                        <!-- First product (default) -->
                        <div class="product-entry card mb-3" data-product-index="0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Product #1</h5>
                                    <button type="button" class="btn btn-sm btn-danger remove-product-btn"
                                        style="display: none;">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control form-control-lg product-name"
                                            placeholder="Product Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Product Type</label>
                                        <select class="form-select form-control-lg product-type" required>
                                            <option value="">Select Product Type</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Brand Name</label>
                                        <select class="form-select form-control-lg product-brand" required>
                                            <option value="">Select Brand</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Model Number</label>
                                        <input type="text" class="form-control form-control-lg product-model"
                                            placeholder="Model Number" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Serial Number</label>
                                        <input type="text" class="form-control form-control-lg product-serial"
                                            placeholder="Serial Number" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Purchase Date</label>
                                        <input type="date" class="form-control form-control-lg product-purchase-date"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Additional Information -->
                <div class="form-section" id="section4">
                    <h3 class="mb-5">Additional Information</h3>
                    <div class="mb-3">
                        <label for="additional_notes" class="form-label">Additional Notes (Optional)</label>
                        <textarea class="form-control" id="additional_notes" name="additional_notes" rows="4"
                            placeholder="Any additional notes or instructions..."></textarea>
                    </div>

                    <div class="form-check mb-4 align-item-center">
                        <input class="form-check-input" type="checkbox" id="terms_agreed" name="terms_agreed"
                            value="1" required>
                        <label class="form-check-label ms-2" for="terms_agreed">
                            I agree to the <a href="#" target="_blank">terms and conditions</a>.
                        </label>
                    </div>
                </div>

                <!-- Step 5: Review & Submit -->
                <div class="form-section" id="section5">
                    <h3 class="mb-5">Review & Submit</h3>
                    <div class="alert alert-info">
                        <h5>Please review your information before submitting:</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Customer Information</h6>
                                    <div id="review-customer-info">
                                        <!-- Customer details will be populated here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="review-company-section" style="display: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Company Information</h6>
                                    <div id="review-company-info">
                                        <!-- Company details will be populated here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Product Information</h6>
                                    <div id="review-product-info">
                                        <!-- Product details will be populated here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <button type="button" class="btn btn-secondary" id="backBtn" style="display: none;">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary me-2" id="skipBtn"
                            style="display: none;">
                            Skip
                        </button>
                        <button type="button" class="btn btn-primary" id="nextBtn">
                            Next <i class="fas fa-arrow-right ms-2"></i>
                        </button>

                        <button type="button" class="btn btn-success" id="submitBtn" style="display: none;">
                            <i class="fas fa-check me-2"></i>Submit Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Testimonial -->
    <section class="tf-sp-2 mb-5">
        <div class="container">
            <div class="flat-title wow fadeInUp">
                <h5 class="fw-semibold">Customer Review</h5>
                <!-- <div class="box-btn-slide relative">
                                    <div class="swiper-button-prev nav-swiper nav-prev-products">
                                      <i class="icon-arrow-left-lg"></i>
                                    </div>
                                    <div class="swiper-button-next nav-swiper nav-next-products">
                                      <i class="icon-arrow-right-lg"></i>
                                    </div>
                                  </div> -->
            </div>
            <div class="swiper tf-sw-products" data-preview="3" data-tablet="2" data-mobile-sm="1" data-mobile="1"
                data-space-lg="30" data-space-md="15" data-space="15" data-pagination="1" data-pagination-sm="1"
                data-pagination-md="2" data-pagination-lg="3">
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="wg-testimonial wow fadeInUp">
                            <div class="entry_image">
                                <img src="{{ asset('frontend-assets/images/item/person.avif') }}"
                                    data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
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
                                <img src="{{ asset('frontend-assets/images/item/person.avif') }}"
                                    data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
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
                                <img src="{{ asset('frontend-assets/images/item/person.avif') }}"
                                    data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
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
                                <img src="{{ asset('frontend-assets/images/item/person.avif') }}"
                                    data-src="{{ asset('frontend-assets/images/item/person.avif') }}" alt=""
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
@endsection

@section('script')
    <script>
        // Form navigation variables
        const sections = document.querySelectorAll('.form-section');
        const steps = document.querySelectorAll('.step');
        let currentStep = 0;
        const totalSteps = sections.length;

        // Button elements
        const backBtn = document.getElementById('backBtn');
        const nextBtn = document.getElementById('nextBtn');
        const skipBtn = document.getElementById('skipBtn');
        const submitBtn = document.getElementById('submitBtn');

        // Form data storage
        let formData = {};
        let productsData = []; // Array to store multiple products
        let categoriesData = [];
        let brandsData = [];
        let plansData = {};
        let productCounter = 1; // Counter for product numbering

        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            loadDropdownData();
            updateNavigationButtons();
        });

        // Load dropdown data from API
        async function loadDropdownData() {
            try {
                const categoriesResponse = await fetch('/api/amc/categories');
                const categoriesResult = await categoriesResponse.json();
                if (categoriesResult.success) {
                    categoriesData = categoriesResult.data;
                    populateAllProductDropdowns();
                }

                const brandsResponse = await fetch('/api/amc/brands');
                const brandsResult = await brandsResponse.json();
                if (brandsResult.success) {
                    brandsData = brandsResult.data;
                    populateAllProductDropdowns();
                }

                const plansResponse = await fetch('/api/amc/plans');
                const plansResult = await plansResponse.json();
                if (plansResult.success) {
                    plansData = plansResult.data;
                }
            } catch (error) {
                console.error('Error loading dropdown data:', error);
            }
        }

        // Populate all product dropdowns (for all product entries)
        function populateAllProductDropdowns() {
            document.querySelectorAll('.product-entry').forEach(entry => {
                const typeSelect = entry.querySelector('.product-type');
                const brandSelect = entry.querySelector('.product-brand');

                if (typeSelect && categoriesData.length > 0) {
                    populateSelectElement(typeSelect, categoriesData, 'id', 'name');
                }

                if (brandSelect && brandsData.length > 0) {
                    populateSelectElement(brandSelect, brandsData, 'id', 'name');
                }
            });
        }

        // Populate a single select element
        function populateSelectElement(selectElement, data, valueField, textField) {
            const currentValue = selectElement.value;
            selectElement.innerHTML = '<option value="">Select Option</option>';

            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueField];
                option.textContent = item[textField];
                selectElement.appendChild(option);
            });

            if (currentValue) {
                selectElement.value = currentValue;
            }
        }

        // Add Product Button Handler
        document.getElementById('addProductBtn').addEventListener('click', function() {
            productCounter++;
            const productsContainer = document.getElementById('productsContainer');

            const newProductEntry = document.createElement('div');
            newProductEntry.className = 'product-entry card mb-3';
            newProductEntry.setAttribute('data-product-index', productCounter - 1);
            newProductEntry.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Product #${productCounter}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-product-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control form-control-lg product-name"
                            placeholder="Product Name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Product Type</label>
                        <select class="form-select form-control-lg product-type" required>
                            <option value="">Select Product Type</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Brand Name</label>
                        <select class="form-select form-control-lg product-brand" required>
                            <option value="">Select Brand</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Model Number</label>
                        <input type="text" class="form-control form-control-lg product-model"
                            placeholder="Model Number" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Serial Number</label>
                        <input type="text" class="form-control form-control-lg product-serial"
                            placeholder="Serial Number" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" class="form-control form-control-lg product-purchase-date" required>
                    </div>
                </div>
            </div>
        `;

            productsContainer.appendChild(newProductEntry);

            // Populate dropdowns for the new product
            populateAllProductDropdowns();

            // Update remove button visibility
            updateRemoveButtonsVisibility();

            // Add animation
            newProductEntry.style.opacity = '0';
            setTimeout(() => {
                newProductEntry.style.transition = 'opacity 0.3s';
                newProductEntry.style.opacity = '1';
            }, 10);
        });

        // Remove Product Handler (Event Delegation)
        document.getElementById('productsContainer').addEventListener('click', function(e) {
            if (e.target.closest('.remove-product-btn')) {
                const productEntry = e.target.closest('.product-entry');
                productEntry.style.transition = 'opacity 0.3s';
                productEntry.style.opacity = '0';

                setTimeout(() => {
                    productEntry.remove();
                    updateProductNumbers();
                    updateRemoveButtonsVisibility();
                }, 300);
            }
        });

        // Update product numbers after removal
        function updateProductNumbers() {
            const productEntries = document.querySelectorAll('.product-entry');
            productEntries.forEach((entry, index) => {
                entry.setAttribute('data-product-index', index);
                entry.querySelector('h5').textContent = `Product #${index + 1}`;
            });
            productCounter = productEntries.length;
        }

        // Update remove button visibility (hide if only one product)
        function updateRemoveButtonsVisibility() {
            const productEntries = document.querySelectorAll('.product-entry');
            const removeButtons = document.querySelectorAll('.remove-product-btn');

            if (productEntries.length === 1) {
                removeButtons.forEach(btn => btn.style.display = 'none');
            } else {
                removeButtons.forEach(btn => btn.style.display = 'inline-block');
            }
        }

        // Plan type change handler
        document.addEventListener('change', function(e) {
            if (e.target.name === 'plan_type') {
                const planType = e.target.value;
                const amcPlanSelect = document.getElementById('amc_plan_id');
                amcPlanSelect.innerHTML = '<option value="">Select AMC Plan</option>';

                if (plansData[planType]) {
                    plansData[planType].forEach(plan => {
                        const option = document.createElement('option');
                        option.value = plan.id;
                        option.textContent = plan.plan_name;
                        option.dataset.duration = plan.duration;
                        option.dataset.cost = plan.total_cost;
                        option.dataset.description = plan.description;
                        amcPlanSelect.appendChild(option);
                    });
                }
            }
        });


        // Next button
        nextBtn.addEventListener('click', function() {
            console.log('Next button clicked');
            if (validateCurrentStep()) {
                saveCurrentStepData();

                if (currentStep < totalSteps - 1) {
                    if (currentStep === 0 && shouldSkipCompanyDetails()) {
                        currentStep += 2;
                    } else {
                        currentStep++;
                    }

                    if (currentStep === totalSteps - 1) {
                        populateReviewSection();
                    }

                    showStep(currentStep);
                    updateNavigationButtons();
                }
            }
        });

        // Back button
        backBtn.addEventListener('click', function() {
            if (currentStep > 0) {
                if (currentStep === 2 && shouldSkipCompanyDetails()) {
                    currentStep -= 2;
                } else {
                    currentStep--;
                }
                showStep(currentStep);
                updateNavigationButtons();
            }
        });

        // ✅ Fixed Skip button (skip only current section)
        skipBtn.addEventListener('click', function() {
            saveCurrentStepData(); // optional if you want to retain partially filled data
            if (currentStep < totalSteps - 1) {
                currentStep++; // move one step forward only
                showStep(currentStep);
                updateNavigationButtons();
            }
        });

        // Submit button
        submitBtn.addEventListener('click', function() {
            console.log('Submit button clicked');
            if (validateCurrentStep()) {
                saveCurrentStepData();
                submitForm();
            }
        });

        // Show section
        function showStep(stepIndex) {
            sections.forEach((section, index) => {
                section.classList.toggle('active', index === stepIndex);
            });

            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });
        }

        // Update navigation
        function updateNavigationButtons() {
            backBtn.style.display = currentStep > 0 ? 'inline-block' : 'none';
            skipBtn.style.display = currentStep === 1 ? 'inline-block' : 'none';
            if (currentStep === totalSteps - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                submitBtn.style.display = 'none';
            }
        }

        // Skip company details check
        function shouldSkipCompanyDetails() {
            const customerType = document.getElementById('customer_type').value;
            return customerType === 'Individual';
        }

        // Validation
        function validateCurrentStep() {
            const currentSection = sections[currentStep];
            let isValid = true;

            // Special handling for product information step
            if (currentStep === 2) { // Product Information step
                const productEntries = document.querySelectorAll('.product-entry');

                if (productEntries.length === 0) {
                    alert('Please add at least one product.');
                    return false;
                }

                productEntries.forEach((entry, index) => {
                    const requiredFields = entry.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                });

                if (!isValid) {
                    alert('Please fill in all required fields for all products.');
                }
            } else {
                // Standard validation for other steps
                const requiredFields = currentSection.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    alert('Please fill in all required fields.');
                }
            }

            return isValid;
        }

        // Save data
        function saveCurrentStepData() {
            const currentSection = sections[currentStep];

            // Special handling for product information step
            if (currentStep === 2) { // Product Information step
                productsData = [];
                const productEntries = document.querySelectorAll('.product-entry');

                productEntries.forEach((entry, index) => {
                    const product = {
                        product_name: entry.querySelector('.product-name').value,
                        product_type: entry.querySelector('.product-type').value,
                        product_brand: entry.querySelector('.product-brand').value,
                        model_number: entry.querySelector('.product-model').value,
                        serial_number: entry.querySelector('.product-serial').value,
                        purchase_date: entry.querySelector('.product-purchase-date').value
                    };
                    productsData.push(product);
                });
            } else {
                // Standard data saving for other steps
                const inputs = currentSection.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    // Skip product-related fields as they're handled separately
                    if (!input.classList.contains('product-name') &&
                        !input.classList.contains('product-type') &&
                        !input.classList.contains('product-brand') &&
                        !input.classList.contains('product-model') &&
                        !input.classList.contains('product-serial') &&
                        !input.classList.contains('product-purchase-date')) {

                        if (input.type === 'radio') {
                            if (input.checked) formData[input.name] = input.value;
                        } else if (input.type === 'checkbox') {
                            formData[input.name] = input.checked ? input.value : '';
                        } else {
                            formData[input.name] = input.value;
                        }
                    }
                });
            }
        }

        // Review section
        function populateReviewSection() {
            const customerInfo = `
            <p><strong>Name:</strong> ${formData.first_name || ''} ${formData.last_name || ''}</p>
            <p><strong>Email:</strong> ${formData.email || ''}</p>
            <p><strong>Phone:</strong> ${formData.phone || ''}</p>
            <p><strong>Customer Type:</strong> ${formData.customer_type || ''}</p>
        `;
            document.getElementById('review-customer-info').innerHTML = customerInfo;

            if (formData.company_name) {
                const companyInfo = `
                <p><strong>Company:</strong> ${formData.company_name || ''}</p>
                <p><strong>Branch:</strong> ${formData.branch_name || ''}</p>
                <p><strong>Address:</strong> ${formData.address_line1 || ''} ${formData.address_line2 || ''}</p>
                <p><strong>City:</strong> ${formData.city || ''}, ${formData.state || ''} ${formData.pin_code || ''}</p>
                <p><strong>GST No:</strong> ${formData.gst_no || ''}</p>
            `;
                document.getElementById('review-company-info').innerHTML = companyInfo;
                document.getElementById('review-company-section').style.display = 'block';
            }

            // Display all products
            let productInfoHtml = '';
            productsData.forEach((product, index) => {
                const productTypeName = getTextFromData(categoriesData, product.product_type, 'id', 'name');
                const brandName = getTextFromData(brandsData, product.product_brand, 'id', 'name');

                productInfoHtml += `
                <div class="mb-3 ${index > 0 ? 'border-top pt-3' : ''}">
                    <h6 class="text-primary">Product #${index + 1}: ${product.product_name}</h6>
                    <p class="mb-1"><strong>Product Type:</strong> ${productTypeName}</p>
                    <p class="mb-1"><strong>Brand:</strong> ${brandName}</p>
                    <p class="mb-1"><strong>Model:</strong> ${product.model_number || ''}</p>
                    <p class="mb-1"><strong>Serial Number:</strong> ${product.serial_number || ''}</p>
                    <p class="mb-1"><strong>Purchase Date:</strong> ${product.purchase_date || ''}</p>
                </div>
            `;
            });
            document.getElementById('review-product-info').innerHTML = productInfoHtml;

        }

        
        function getTextFromData(dataArray, value, valueField, textField) {
            const item = dataArray.find(d => d[valueField] == value);
            return item ? item[textField] : value;
        }

        // Submit form
        async function submitForm() {
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';

                // Combine form data with products data
                const submitData = {
                    ...formData,
                    products: productsData
                };
                
                const response = await fetch('/api/non-amc/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(submitData)
                });

                const result = await response.json();

                if (result.success) {
                    alert(`Success! Your service request has been submitted. Service ID: ${result.service_id}`);

                    // Reset form
                    document.getElementById('requestForm').reset();

                    // Reset products to single entry
                    const productsContainer = document.getElementById('productsContainer');
                    const allProducts = productsContainer.querySelectorAll('.product-entry');
                    allProducts.forEach((product, index) => {
                        if (index > 0) product.remove();
                    });

                    // Reset counters and data
                    productCounter = 1;
                    productsData = [];
                    formData = {};
                    currentStep = 0;
                    showStep(currentStep);
                    updateNavigationButtons();
                    updateRemoveButtonsVisibility();
                } else {
                    console.log(result);
                    alert('Error: ' + (result.message || 'Something went wrong'));
                }
            } catch (error) {
                console.log(error);
                alert('Error submitting form. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Submit Request';
            }
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
