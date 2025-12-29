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

    <style>
        .non-amc-section {
            background: linear-gradient(90deg, #7a6fff 70%, #a18aff 100%);
            border-radius: 2rem;
            box-shadow: 0 6px 36px 0 rgba(95, 60, 255, 0.08);
            min-height: 180px;
            position: relative;
            overflow: hidden;
            padding: 0 10rem;
            border: 1.5px solid #e6e8ec;
            display: flex;
            align-items: center;
        }

        .non-amc-headline {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.75rem;
            letter-spacing: -1px;
            color: #fff;
        }

        .non-amc-subtext {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.125rem;
        }

        .non-amc-btn {
            font-weight: 600;
            border-radius: 2rem;
            padding: 0.7rem 2rem;
            transition:
                background 0.16s,
                color 0.16s,
                box-shadow 0.2s,
                transform 0.2s;
            box-shadow: 0 2px 10px 0 rgba(100, 70, 255, 0.08);
            border: none;
        }

        .book-call-btn {
            background: rgba(34, 34, 34, 0.95);
            color: #fff;
        }

        .book-call-btn:hover,
        .book-call-btn:focus {
            background: #fff;
            color: #222;
            box-shadow: 0 4px 18px 0 rgba(80, 80, 80, 0.17);
            transform: translateY(-3px) scale(1.05);
            outline: none;
        }

        .request-nonamc-btn {
            background: rgba(34, 34, 34, 0.95);
            color: #fff;
        }

        .request-nonamc-btn:hover,
        .request-nonamc-btn:focus {
            background: #fff;
            color: #222;
            box-shadow: 0 4px 18px 0 rgba(80, 80, 80, 0.17);
            transform: translateY(-3px) scale(1.05);
            outline: none;
        }

        .non-amc-circle {
            position: absolute;
            top: -58px;
            right: -68px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.14);
            border-radius: 50%;
            z-index: 1;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .non-amc-section {
                flex-direction: column;
                padding: 2rem 1rem;
                min-height: unset;
            }

            .non-amc-circle {
                width: 80px;
                height: 80px;
                top: -20px;
                right: -30px;
            }
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
                    <span class="body-small">AMC</span>
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

    <section class="pricing-section text-center">
        <div class="container">
            <h3>Pricing</h3>
            <p>Choose the perfect AMC plan for your business needs. All plans include professional support and maintenance
                services.</p>

            <div class="toggle-buttons">
                <button class="active" id="monthlyBtn">Monthly</button>
                <button id="annuallyBtn">Annually</button>
            </div>

            <!-- Monthly Plans Section -->
            <div id="monthlyPlans" class="pricing-plans-section">
                @if ($monthlyPlans->count() > 0)
                    <h4 class="mt-4 mb-4">Monthly Plans</h4>
                    <div class="row g-4 md-mt-3 align-items-center justify-content-center">
                        @foreach ($monthlyPlans as $index => $plan)
                            <div class="col-md-6 col-lg-3">
                                <div class="price-card h-100 {{ $index == 1 ? 'recommended' : '' }}">
                                    <h4>{{ $plan->plan_name }}</h4>
                                    <div class="price">₹ {{ number_format($plan->total_cost, 0) }} <small
                                            class="text-muted">/mo</small></div>
                                    <div class="pricing-features">
                                        <h6 class="text-primary my-3">{{ $plan->description }}</h6>
                                        <div class="feature">Duration<span>{{ $plan->duration }}</span></div>
                                        <div class="feature">Plan Cost<span>₹
                                                {{ number_format($plan->plan_cost, 0) }}</span></div>
                                        <div class="feature">Tax ({{ $plan->tax }}%)<span>₹
                                                {{ number_format(($plan->plan_cost * $plan->tax) / 100, 0) }}</span></div>
                                        <div class="feature">Total Visits<span>{{ $plan->total_visits }} visits</span>
                                        </div>
                                        <div class="feature">Support Type<span>{{ $plan->support_type }}</span></div>
                                        @if ($plan->items)
                                            @php
                                                $items = json_decode($plan->items);
                                            @endphp
                                            @if (is_array($items) && count($items) > 0)
                                                <div class="feature">Services<span>{{ count($items) }} services
                                                        included</span></div>
                                            @endif
                                        @endif
                                    </div>
                                    {{-- <button class="btn btn-outline-dark w-100">Get Started</button> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        <h5>No Monthly Plans Available</h5>
                        <p>Currently, there are no monthly AMC plans available. Please check our annual plans or contact us
                            for custom solutions.</p>
                    </div>
                @endif
            </div>
            {{-- {{ dd($monthlyPlans) }} --}}

            <!-- Annual Plans Section -->
            <div id="annualPlans" class="pricing-plans-section" style="display: none;">
                @if ($annualPlans->count() > 0)
                    <h4 class="mt-4 mb-4">Annual Plans</h4>
                    <div class="row g-4 md-mt-3 align-items-center justify-content-center">
                        @foreach ($annualPlans as $index => $plan)
                            <div class="col-md-6 col-lg-3">
                                <div class="price-card h-100 {{ $index == 1 ? 'recommended' : '' }}">
                                    <h4>{{ $plan->plan_name }}</h4>
                                    <div class="price">₹ {{ number_format($plan->total_cost, 0) }} <small
                                            class="text-muted">/year</small></div>
                                    <div class="pricing-features">
                                        <h6 class="text-primary my-3">{{ $plan->description }}</h6>
                                        <div class="feature">Duration<span>{{ $plan->duration }}</span></div>
                                        <div class="feature">Plan Cost<span>₹
                                                {{ number_format($plan->plan_cost, 0) }}</span></div>
                                        <div class="feature">Tax ({{ $plan->tax }}%)<span>₹
                                                {{ number_format(($plan->plan_cost * $plan->tax) / 100, 0) }}</span></div>
                                        <div class="feature">Total Visits<span>{{ $plan->total_visits }} visits</span>
                                        </div>
                                        <div class="feature">Support Type<span>{{ $plan->support_type }}</span></div>
                                        @if ($plan->items)
                                            @php
                                                $items = json_decode($plan->items);
                                            @endphp
                                            @if (is_array($items) && count($items) > 0)
                                                <div class="feature">Services<span>{{ count($items) }} services
                                                        included</span></div>
                                            @endif
                                        @endif
                                    </div>
                                    {{-- <button class="btn btn-outline-dark w-100">Get Started</button> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        <h5>No Annual Plans Available</h5>
                        <p>Currently, there are no annual AMC plans available. Please check our monthly plans or contact us
                            for custom solutions.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <h4 class="d-flex d-md-none justify-content-center align-item-center">AMC Service Request Form</h4>

    <div class="container container-contact-form">
        <div class="sidebar d-none d-md-flex flex-column">
            <h5 class="mb-5 d-flex justify-content-center text-center">AMC Service Request Form</h5>
            <div class="step active" id="step1">1. Customer Details</div>
            <div class="step" id="step2">2. Company Details</div>
            <div class="step" id="step3">3. Product Information</div>
            <div class="step" id="step4">4. AMC Plan Selection</div>
            <div class="step" id="step5">5. Additional Information</div>
            <div class="step" id="step6">6. Review & Submit</div>
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
                        <div class="col-md-6">
                            <input type="hidden" class="form-control form-control-lg" id="source_type_label" name="source_type_label" value="ecommerce_amc_page" readonly>
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
                            <input type="text" class="form-control form-control-lg" id="company_name"
                                name="company_name" placeholder="Company Name">
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

                <!-- Step 4: AMC Plan Selection -->
                <div class="form-section" id="section4">
                    <h3 class="mb-5">AMC Plan Selection</h3>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Select Plan Type:</label><br>
                            <div class="form-check form-check-inline align-item-center">
                                <input class="form-check-input" type="radio" name="plan_type" id="monthly"
                                    value="Monthly" required>
                                <label class="form-check-label ms-2" for="monthly">Monthly</label>
                            </div>
                            <div class="form-check form-check-inline align-item-center">
                                <input class="form-check-input" type="radio" name="plan_type" id="annually"
                                    value="Annually">
                                <label class="form-check-label ms-2" for="annually">Annually</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="amc_plan_id" class="form-label">AMC Plan</label>
                            <select class="form-select form-control-lg" id="amc_plan_id" name="amc_plan_id" required>
                                <option value="">Select AMC Plan</option>
                                <!-- Options will be loaded dynamically based on plan type -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="plan_duration" class="form-label">Plan Duration</label>
                            <select class="form-select form-control-lg" id="plan_duration" name="plan_duration" required>
                                <option value="">Select Duration</option>
                                <!-- Options will be loaded dynamically based on selected plan -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="preferred_start_date" class="form-label">Preferred Start Date</label>
                            <input type="date" class="form-control form-control-lg" id="preferred_start_date"
                                name="preferred_start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="plan_cost_display" class="form-label">Plan Cost</label>
                            <input type="text" class="form-control form-control-lg" id="plan_cost_display"
                                placeholder="Select a plan to see cost" readonly>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Additional Information -->
                <div class="form-section" id="section5">
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

                <!-- Step 6: Review & Submit -->
                <div class="form-section" id="section6">
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

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">AMC Plan Details</h6>
                                    <div id="review-plan-info">
                                        <!-- Plan details will be populated here -->
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
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        <button type="button" class="btn btn-success" id="submitBtn" style="display: none;">
                            <i class="fas fa-check me-2"></i>Submit Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 non-amc-section">
                <!-- Left Side: Headline -->
                <div class="flex-grow-1">
                    <h2 class="non-amc-headline">
                        Get the Non AMC for your product
                    </h2>
                    <p class="non-amc-subtext mb-0">
                        Hassle-free service, premium support, and maximum peace of mind.
                    </p>
                </div>
                <!-- Right Side: Buttons -->
                <div class="d-flex flex-column flex-md-row gap-3 align-items-center ms-4">
                    <a href="tel:+918080803374" class="font-gray">
                        <button class="non-amc-btn book-call-btn">
                            Book a Call
                        </button>
                    </a>
                    <a href="{{ route('non-amc') }}" class="font-gray">
                    <button class="non-amc-btn request-nonamc-btn">
                        Request Non AMC
                    </button>
                    </a>
                </div>
                <!-- Top-right floating soft circle accent -->
                <span class="non-amc-circle"></span>
            </div>
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
    {{-- <script>
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
        let categoriesData = [];
        let brandsData = [];
        let plansData = {};

        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            loadDropdownData();
            updateNavigationButtons();
        });

        // Load dropdown data from API
        async function loadDropdownData() {
            try {
                // Load categories
                const categoriesResponse = await fetch('/api/amc/categories');
                const categoriesResult = await categoriesResponse.json();
                if (categoriesResult.success) {
                    categoriesData = categoriesResult.data;
                    populateDropdown('product_type', categoriesData, 'id', 'name');
                }

                // Load brands
                const brandsResponse = await fetch('/api/amc/brands');
                const brandsResult = await brandsResponse.json();
                if (brandsResult.success) {
                    brandsData = brandsResult.data;
                    populateDropdown('brand_name', brandsData, 'id', 'name');
                }

                // Load AMC plans
                const plansResponse = await fetch('/api/amc/plans');
                const plansResult = await plansResponse.json();
                if (plansResult.success) {
                    plansData = plansResult.data;
                }
            } catch (error) {
                console.error('Error loading dropdown data:', error);
            }
        }

        // Populate dropdown with data
        function populateDropdown(selectId, data, valueField, textField) {
            const select = document.getElementById(selectId);
            const defaultOption = select.querySelector('option[value=""]');

            // Clear existing options except default
            select.innerHTML = '';
            if (defaultOption) {
                select.appendChild(defaultOption);
            }

            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueField];
                option.textContent = item[textField];
                select.appendChild(option);
            });
        }

        // Plan type change handler
        document.addEventListener('change', function(e) {
            if (e.target.name === 'plan_type') {
                const planType = e.target.value;
                const amcPlanSelect = document.getElementById('amc_plan_id');

                // Clear existing options
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

        // AMC plan change handler
        document.addEventListener('change', function(e) {
            if (e.target.id === 'amc_plan_id') {
                const selectedOption = e.target.selectedOptions[0];
                if (selectedOption && selectedOption.value) {
                    // Update duration
                    const durationSelect = document.getElementById('plan_duration');
                    durationSelect.innerHTML = '<option value="">Select Duration</option>';

                    const duration = selectedOption.dataset.duration;
                    if (duration) {
                        const option = document.createElement('option');
                        option.value = duration;
                        option.textContent = duration;
                        durationSelect.appendChild(option);
                        durationSelect.value = duration;
                    }

                    // Update cost display
                    const costDisplay = document.getElementById('plan_cost_display');
                    const cost = selectedOption.dataset.cost;
                    if (cost) {
                        costDisplay.value = '₹ ' + parseFloat(cost).toLocaleString();
                    }
                }
            }
        });

        // Navigation button handlers
        nextBtn.addEventListener('click', function() {
            if (validateCurrentStep()) {
                saveCurrentStepData();

                if (currentStep < totalSteps - 1) {
                    // Move to next step
                    if (currentStep === 1 && shouldSkipCompanyDetails()) {
                        // Skip company details if individual customer
                        currentStep += 2;
                    } else {
                        currentStep++;
                    }

                    if (currentStep === totalSteps - 1) {
                        // Last step - populate review
                        populateReviewSection();
                    }

                    showStep(currentStep);
                    updateNavigationButtons();
                }
            }
        });

        backBtn.addEventListener('click', function() {
            if (currentStep > 0) {
                // Check if we skipped company details when going forward
                if (currentStep === 3 && shouldSkipCompanyDetails()) {
                    currentStep -= 2; // Go back to step 1
                } else {
                    currentStep--;
                }
                showStep(currentStep);
                updateNavigationButtons();
            }
        });

        skipBtn.addEventListener('click', function() {
            if (currentStep === 1) { // Company details step
                saveCurrentStepData();
                currentStep++;
                showStep(currentStep);
                updateNavigationButtons();
            }
        });

        submitBtn.addEventListener('click', function() {
            if (validateCurrentStep()) {
                saveCurrentStepData();
                submitForm();
            }
        });

        // Show specific step
        function showStep(stepIndex) {
            sections.forEach((section, index) => {
                section.classList.toggle('active', index === stepIndex);
            });

            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });
        }

        // Update navigation buttons visibility
        function updateNavigationButtons() {
            // Back button
            backBtn.style.display = currentStep > 0 ? 'inline-block' : 'none';

            // Skip button (only show on company details step)
            skipBtn.style.display = currentStep === 1 ? 'inline-block' : 'none';

            // Next/Submit buttons
            if (currentStep === totalSteps - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                submitBtn.style.display = 'none';
            }
        }

        // Check if company details should be skipped
        function shouldSkipCompanyDetails() {
            const customerType = document.getElementById('customer_type').value;
            return customerType === 'Individual';
        }

        // Validate current step
        function validateCurrentStep() {
            const currentSection = sections[currentStep];
            const requiredFields = currentSection.querySelectorAll('[required]');
            let isValid = true;

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

            return isValid;
        }

        // Save current step data
        function saveCurrentStepData() {
            const currentSection = sections[currentStep];
            const inputs = currentSection.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    if (input.checked) {
                        formData[input.name] = input.value;
                    }
                } else if (input.type === 'checkbox') {
                    formData[input.name] = input.checked ? input.value : '';
                } else {
                    formData[input.name] = input.value;
                }
            });
        }

        // Populate review section
        function populateReviewSection() {
            // Customer info
            const customerInfo = `
                <p><strong>Name:</strong> ${formData.first_name || ''} ${formData.last_name || ''}</p>
                <p><strong>Email:</strong> ${formData.email || ''}</p>
                <p><strong>Phone:</strong> ${formData.phone || ''}</p>
                <p><strong>Customer Type:</strong> ${formData.customer_type || ''}</p>
            `;
            document.getElementById('review-customer-info').innerHTML = customerInfo;

            // Company info (if provided)
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

            // Product info
            const productInfo = `
                <p><strong>Product Type:</strong> ${getSelectedText('product_type')}</p>
                <p><strong>Brand:</strong> ${getSelectedText('brand_name')}</p>
                <p><strong>Model:</strong> ${formData.model_number || ''}</p>
                <p><strong>Serial Number:</strong> ${formData.serial_number || ''}</p>
                <p><strong>Purchase Date:</strong> ${formData.purchase_date || ''}</p>
            `;
            document.getElementById('review-product-info').innerHTML = productInfo;

            // Plan info
            const planInfo = `
                <p><strong>Plan Type:</strong> ${formData.plan_type || ''}</p>
                <p><strong>Plan:</strong> ${getSelectedText('amc_plan_id')}</p>
                <p><strong>Duration:</strong> ${formData.plan_duration || ''}</p>
                <p><strong>Start Date:</strong> ${formData.preferred_start_date || ''}</p>
                <p><strong>Cost:</strong> ${document.getElementById('plan_cost_display').value || ''}</p>
            `;
            document.getElementById('review-plan-info').innerHTML = planInfo;
        }

        // Get selected text from dropdown
        function getSelectedText(selectId) {
            const select = document.getElementById(selectId);
            return select.selectedOptions[0] ? select.selectedOptions[0].textContent : '';
        }

        // Submit form
        async function submitForm() {
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';

                const response = await fetch('/api/amc/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    alert(`Success! Your service request has been submitted. Service ID: ${result.service_id}`);
                    document.getElementById('requestForm').reset();
                    currentStep = 0;
                    showStep(currentStep);
                    updateNavigationButtons();
                    formData = {};
                } else {
                    alert('Error: ' + (result.message || 'Something went wrong'));
                }
            } catch (error) {
                console.error('Submission error:', error);
                alert('Error submitting form. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Submit Request';
            }
        }

        // Pricing toggle functionality (existing)
        document.getElementById('monthlyBtn').addEventListener('click', function() {
            document.getElementById('monthlyBtn').classList.add('active');
            document.getElementById('annuallyBtn').classList.remove('active');
            document.getElementById('monthlyPlans').style.display = 'block';
            document.getElementById('annualPlans').style.display = 'none';
        });

        document.getElementById('annuallyBtn').addEventListener('click', function() {
            document.getElementById('annuallyBtn').classList.add('active');
            document.getElementById('monthlyBtn').classList.remove('active');
            document.getElementById('monthlyPlans').style.display = 'none';
            document.getElementById('annualPlans').style.display = 'block';
        });
    </script> --}}

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

        // AMC plan change handler
        document.addEventListener('change', function(e) {
            if (e.target.id === 'amc_plan_id') {
                const selectedOption = e.target.selectedOptions[0];
                if (selectedOption && selectedOption.value) {
                    const durationSelect = document.getElementById('plan_duration');
                    durationSelect.innerHTML = '<option value="">Select Duration</option>';

                    const duration = selectedOption.dataset.duration;
                    if (duration) {
                        const option = document.createElement('option');
                        option.value = duration;
                        option.textContent = duration;
                        durationSelect.appendChild(option);
                        durationSelect.value = duration;
                    }

                    const costDisplay = document.getElementById('plan_cost_display');
                    const cost = selectedOption.dataset.cost;
                    if (cost) {
                        costDisplay.value = '₹ ' + parseFloat(cost).toLocaleString();
                    }
                }
            }
        });

        // Next button
        nextBtn.addEventListener('click', function() {
            if (validateCurrentStep()) {
                saveCurrentStepData();

                if (currentStep < totalSteps - 1) {
                    // Skip company details automatically only if Individual customer
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
                        brand_name: entry.querySelector('.product-brand').value,
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
                const brandName = getTextFromData(brandsData, product.brand_name, 'id', 'name');

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

            const planInfo = `
            <p><strong>Plan Type:</strong> ${formData.plan_type || ''}</p>
            <p><strong>Plan:</strong> ${getSelectedText('amc_plan_id')}</p>
            <p><strong>Duration:</strong> ${formData.plan_duration || ''}</p>
            <p><strong>Start Date:</strong> ${formData.preferred_start_date || ''}</p>
            <p><strong>Cost:</strong> ${document.getElementById('plan_cost_display').value || ''}</p>
        `;
            document.getElementById('review-plan-info').innerHTML = planInfo;
        }

        function getSelectedText(selectId) {
            const select = document.getElementById(selectId);
            return select.selectedOptions[0] ? select.selectedOptions[0].textContent : '';
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

                const response = await fetch('/api/amc/submit', {
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
                    alert('Error: ' + (result.message || 'Something went wrong'));
                }
            } catch (error) {
                console.error('Submission error:', error);
                console.log(error);
                alert('Error submitting form. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Submit Request';
            }
        }

        // Pricing toggle functionality (existing)
        document.getElementById('monthlyBtn').addEventListener('click', function() {
            document.getElementById('monthlyBtn').classList.add('active');
            document.getElementById('annuallyBtn').classList.remove('active');
            document.getElementById('monthlyPlans').style.display = 'block';
            document.getElementById('annualPlans').style.display = 'none';
        });

        document.getElementById('annuallyBtn').addEventListener('click', function() {
            document.getElementById('annuallyBtn').classList.add('active');
            document.getElementById('monthlyBtn').classList.remove('active');
            document.getElementById('monthlyPlans').style.display = 'none';
            document.getElementById('annualPlans').style.display = 'block';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
