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
        .amc-plan-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #e8e8e8;
            position: relative;
            overflow: hidden;
        }

        .amc-plan-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(25, 135, 255, 0.25);
            border-color: #1987FF;
        }

        .amc-plan-card.recommended {
            border: 2px solid #1987FF;
            background: linear-gradient(180deg, #fff 0%, #f0f7ff 100%);
        }

        .amc-plan-card.recommended::before {
            content: "BEST VALUE";
            position: absolute;
            top: 18px;
            right: -28px;
            background: linear-gradient(135deg, #1987FF 0%, #00d4ff 100%);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 5px 35px;
            transform: rotate(45deg);
            letter-spacing: 0.5px;
            box-shadow: 0 2px 10px rgba(25, 135, 255, 0.3);
        }

        .plan-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }

        .plan-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .plan-code {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
        }

        .plan-price {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #1987FF 0%, #00d4ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .plan-price .currency {
            font-size: 18px;
            vertical-align: top;
            margin-right: 2px;
        }

        .plan-price .period {
            font-size: 13px;
            color: #888;
            font-weight: 500;
        }

        .plan-details {
            flex: 1;
        }

        .plan-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        .plan-detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 13px;
            font-weight: 500;
        }

        .detail-value {
            color: #1a1a1a;
            font-size: 13px;
            font-weight: 600;
        }

        .covered-items-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 12px;
            margin: 12px 0;
        }

        .covered-items-title {
            font-size: 12px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .covered-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #555;
            margin-bottom: 6px;
        }

        .covered-item:last-child {
            margin-bottom: 0;
        }

        .covered-item i {
            color: #27ae60;
            font-size: 12px;
        }

        .plan-description {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .plan-action {
            margin-top: 15px;
        }

        .plan-action .btn {
            width: 100%;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .plan-action .btn-primary {
            background: linear-gradient(135deg, #1987FF 0%, #00d4ff 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(25, 135, 255, 0.3);
        }

        .plan-action .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(25, 135, 255, 0.4);
        }

        .pay-terms {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 8px;
        }

        .no-plans {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .no-plans h4 {
            color: #333;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .amc-plan-card {
                padding: 20px 18px;
            }

            .plan-price {
                font-size: 28px;
            }

            .plan-name {
                font-size: 18px;
            }
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

            @if ($annualPlans && $annualPlans->count() > 0)
                <div class="row g-4 justify-content-center mt-4">
                    @foreach ($annualPlans as $index => $plan)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="amc-plan-card {{ $index === 1 ? 'recommended' : '' }}">
                                <div class="plan-header">
                                    <h4 class="plan-name">{{ $plan->plan_name }}</h4>
                                    {{-- <span class="plan-code">{{ $plan->plan_code }}</span> --}}
                                    <div class="plan-price">
                                        <span class="currency">₹</span>{{ number_format($plan->total_cost) }}
                                        <span class="period">/ {{ $plan->duration }}</span>
                                    </div>
                                    @if ($plan->pay_terms)
                                        <div class="pay-terms">{{ $plan->pay_terms }}</div>
                                    @endif
                                </div>

                                <div class="plan-details">
                                    @if ($plan->description)
                                        <p class="plan-description">{{ $plan->description }}</p>
                                    @endif

                                    <div class="plan-detail-item">
                                        <span class="detail-label">Plan Code</span>
                                        <span class="detail-value">{{ $plan->plan_code }}</span>
                                    </div>
                                    <div class="plan-detail-item">
                                        <span class="detail-label">Duration</span>
                                        <span class="detail-value">{{ $plan->duration }} Months</span>
                                    </div>
                                    <div class="plan-detail-item">
                                        <span class="detail-label">Total Visits</span>
                                        <span class="detail-value">{{ $plan->total_visits }}</span>
                                    </div>
                                    <div class="plan-detail-item">
                                        <span class="detail-label">Plan Cost</span>
                                        <span class="detail-value">₹{{ number_format($plan->plan_cost) }}</span>
                                    </div>
                                    @if ($plan->tax)
                                        <div class="plan-detail-item">
                                            <span class="detail-label">Tax</span>
                                            <span class="detail-value">₹{{ number_format($plan->tax) }}</span>
                                        </div>
                                    @endif

                                    @php $coveredItems = $plan->coveredItems()->get(); @endphp
                                    @if ($coveredItems && $coveredItems->count() > 0)
                                        <div class="covered-items-section">
                                            <div class="covered-items-title">
                                                <i class="fas fa-shield-alt me-2"></i> Covered Items
                                            </div>
                                            @foreach ($coveredItems as $item)
                                                <div class="covered-item">
                                                    <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                                                    <span>{{ $item->service_name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- <div class="plan-action">
                                    <button class="btn btn-primary" onclick="selectPlan({{ $plan->id }}, '{{ $plan->plan_name }}')">
                                        Select Plan
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-plans">
                    <h4>No AMC Plans Available</h4>
                    <p>Please check back later or contact us for custom AMC solutions.</p>
                </div>
            @endif

        </div>
    </section>

    <script>
        function selectPlan(planId, planName) {
            // Scroll to the form section
            const formSection = document.querySelector('.container-contact-form');
            if (formSection) {
                formSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
            // You can also set the selected plan in a hidden field
            console.log('Selected plan: ' + planName + ' (ID: ' + planId + ')');
        }

        function updatePlanDetails() {
            const planSelect = document.getElementById('amc_plan_id');
            const durationInput = document.getElementById('plan_duration');
            const costInput = document.getElementById('plan_cost_display');

            const selectedOption = planSelect.options[planSelect.selectedIndex];

            if (selectedOption && selectedOption.value) {
                const duration = selectedOption.getAttribute('data-duration');
                const cost = selectedOption.getAttribute('data-cost');

                durationInput.value = duration || '';
                costInput.value = cost ? '₹ ' + parseInt(cost).toLocaleString('en-IN') : '';
            } else {
                durationInput.value = '';
                costInput.value = '';
            }
        }
    </script>

    <h4 class="d-flex d-md-none justify-content-center align-item-center">AMC Service Request Form</h4>

    <div class="container container-contact-form">
        <div class="sidebar d-none d-md-flex flex-column">
            <h5 class="mb-5 d-flex justify-content-center text-center">AMC Service Request Form</h5>
            <div class="step active" id="step1">1. Customer Details</div>
            <div class="step" id="step2">2. Customer Address</div>
            <div class="step" id="step3">3. Company Details</div>
            <div class="step" id="step4">4. AMC Plan Selection</div>
            <div class="step" id="step5">5. Product Information</div>
            <div class="step" id="step6">6. Review & Submit</div>
        </div>


        <div class="form-content">
            <form id="requestForm">
                @csrf
                <!-- Hidden field for logged in customer -->
                <input type="hidden" id="is_logged_in" name="is_logged_in" value="0">
                <input type="hidden" id="customer_id" name="customer_id" value="">
                <input type="hidden" id="selected_address_id" name="selected_address_id" value="">
                <input type="hidden" id="source_type" name="source_type" value="ecommerce">

                <!-- Step 1: Customer Details -->
                <div class="form-section active" id="section1">
                    <h3 class="mb-5">Customer Details</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="first_name" name="first_name"
                                placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="last_name" name="last_name"
                                placeholder="Last Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number <span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                placeholder="Email Address" required>
                            <div class="invalid-feedback" id="email-error" style="display: none;"></div>
                        </div>
                        <input type="hidden" id="customer_type" name="customer_type" value="both">
                    </div>
                    <div class="alert alert-info mt-3" id="login-notice" style="display: none;">
                        <i class="fas fa-info-circle me-2"></i>
                        <span id="login-notice-text">You are logged in. Your details will be prefilled.</span>
                    </div>
                </div>

                <!-- Step 2: Customer Address -->
                <div class="form-section" id="section2">
                    <h3 class="mb-3">Customer Address</h3>
                    <p class="text-muted mb-4">Please provide the service address for AMC.</p>
                    
                    <!-- Address Dropdown for logged in users with multiple addresses -->
                    <div class="row g-3" id="address-selection-row" style="display: none;">
                        <div class="col-12">
                            <label for="address_selector" class="form-label">Select Address</label>
                            <select class="form-select form-control-lg" id="address_selector">
                                <option value="">Select an address</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="address1" class="form-label">Address Line 1 <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="address1" name="address1"
                                placeholder="Address Line 1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="address2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control form-control-lg" id="address2" name="address2"
                                placeholder="Address Line 2">
                        </div>
                        <div class="col-md-4">
                            <label for="branch_name" class="form-label">Branch Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="branch_name"
                                name="branch_name" placeholder="Branch Name" required>
                        </div>
                        <div class="col-md-3">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="city" name="city"
                                placeholder="City" required>
                        </div>
                        <div class="col-md-3">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="state" name="state"
                                placeholder="State" required>
                        </div>
                        <div class="col-md-3">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="country" name="country"
                                placeholder="Country" value="India" required>
                        </div>
                        <div class="col-md-3">
                            <label for="pincode" class="form-label">Pin Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="pincode" name="pincode"
                                placeholder="Pin Code" required>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Company Details (Optional) -->
                <div class="form-section" id="section3">
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
                            <label for="gst_no" class="form-label">GST No</label>
                            <input type="text" class="form-control form-control-lg" id="gst_no" name="gst_no"
                                placeholder="GST Number">
                        </div>
                        <div class="col-md-6">
                            <label for="comp_address1" class="form-label">Company Address Line 1</label>
                            <input type="text" class="form-control form-control-lg" id="comp_address1"
                                name="comp_address1" placeholder="Company Address Line 1">
                        </div>
                        <div class="col-md-6">
                            <label for="comp_address2" class="form-label">Company Address Line 2</label>
                            <input type="text" class="form-control form-control-lg" id="comp_address2"
                                name="comp_address2" placeholder="Company Address Line 2">
                        </div>
                        <div class="col-md-3">
                            <label for="comp_city" class="form-label">Company City</label>
                            <input type="text" class="form-control form-control-lg" id="comp_city" name="comp_city"
                                placeholder="Company City">
                        </div>
                        <div class="col-md-3">
                            <label for="comp_state" class="form-label">Company State</label>
                            <input type="text" class="form-control form-control-lg" id="comp_state" name="comp_state"
                                placeholder="Company State">
                        </div>
                        <div class="col-md-3">
                            <label for="comp_country" class="form-label">Company Country</label>
                            <input type="text" class="form-control form-control-lg" id="comp_country"
                                name="comp_country" placeholder="Company Country" value="India">
                        </div>
                        <div class="col-md-3">
                            <label for="comp_pincode" class="form-label">Company Pin Code</label>
                            <input type="text" class="form-control form-control-lg" id="comp_pincode"
                                name="comp_pincode" placeholder="Company Pin Code">
                        </div>
                    </div>
                </div>

                <!-- Step 4: AMC Plan Selection -->
                <div class="form-section" id="section4">
                    <h3 class="mb-5">AMC Plan Selection</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="amc_plan_id" class="form-label">AMC Plan <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control-lg" id="amc_plan_id" name="amc_plan_id" required
                                onchange="updatePlanDetails()">
                                <option value="">Select AMC Plan</option>
                                @if ($annualPlans && $annualPlans->count() > 0)
                                    @foreach ($annualPlans as $plan)
                                        <option value="{{ $plan->id }}" data-duration="{{ $plan->duration }}"
                                            data-cost="{{ $plan->total_cost }}" data-pay-terms="{{ $plan->pay_terms }}">
                                            {{ $plan->plan_name }} ({{ $plan->plan_code }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="plan_duration" class="form-label">Plan Duration (Months)</label>
                            <input type="text" class="form-control form-control-lg" id="plan_duration"
                                name="plan_duration" placeholder="Duration will be auto-filled" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="plan_cost_display" class="form-label">Plan Cost (₹)</label>
                            <input type="text" class="form-control form-control-lg" id="plan_cost_display"
                                name="plan_cost" placeholder="Cost will be auto-filled" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="preferred_start_date" class="form-label">Preferred Start Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg" id="preferred_start_date"
                                name="preferred_start_date" required>
                        </div>

                    </div>
                </div>

                <!-- Step 5: Product Information -->
                <div class="form-section" id="section5">
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
                                        <input type="text" class="form-control form-control-lg product-type"
                                            placeholder="Product Type" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Brand Name</label>
                                        <input type="text" class="form-control form-control-lg product-brand"
                                            placeholder="Brand Name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Model Number</label>
                                        <input type="text" class="form-control form-control-lg product-model"
                                            placeholder="Model Number" required>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <label class="form-label">Serial Number</label>
                                        <input type="text" class="form-control form-control-lg product-serial"
                                            placeholder="Serial Number">
                                    </div> --}}
                                    <div class="col-md-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" class="form-control form-control-lg product-sku"
                                            placeholder="SKU">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">HSN Code</label>
                                        <input type="text" class="form-control form-control-lg product-hsn"
                                            placeholder="HSN Code">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Purchase Date</label>
                                        <input type="date" class="form-control form-control-lg product-purchase-date"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                        <div class="col-md-12" id="review-address-section">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Customer Address</h6>
                                    <div id="review-address-info">
                                        <!-- Address details will be populated here -->
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
                                    <h6 class="card-title">AMC Plan Details</h6>
                                    <div id="review-plan-info">
                                        <!-- Plan details will be populated here -->
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

    <!-- Login Required Modal -->
    <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="loginRequiredModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Email Already Exists
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4 mb-3">
                    <p class="mb-3">The email address you entered is already registered in our system.</p>
                    <p class="mb-4">Please login to continue with your existing account.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#log" data-bs-toggle="modal" class="btn btn-primary" onclick="$('#loginRequiredModal').modal('hide');">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Use Different Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show login required modal
        function showLoginRequiredModal() {
            const modal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
            modal.show();
        }

        // Show login modal (placeholder for actual login modal)
        function showLoginModal() {
            const modal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
            modal.show();
        }
    </script>
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
                const categoriesResponse = await fetch('/demo/api/amc/categories');
                const categoriesResult = await categoriesResponse.json();
                if (categoriesResult.success) {
                    categoriesData = categoriesResult.data;
                    populateDropdown('product_type', categoriesData, 'id', 'name');
                }

                // Load brands
                const brandsResponse = await fetch('/demo/api/amc/brands');
                const brandsResult = await brandsResponse.json();
                if (brandsResult.success) {
                    brandsData = brandsResult.data;
                    populateDropdown('brand_name', brandsData, 'id', 'name');
                }

                // Load AMC plans
                const plansResponse = await fetch('/demo/api/amc/plans');
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

                const response = await fetch('/demo/api/amc/submit', {
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
        let isLoggedIn = false; // Track if customer is logged in
        let customerData = null; // Store customer data if logged in
        let customerAddresses = []; // Store customer addresses for dropdown

        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            loadDropdownData();
            checkCustomerLogin();
            updateNavigationButtons();

            // Set minimum date for preferred start date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('preferred_start_date').setAttribute('min', today);
        });

        // Check if customer is logged in
        async function checkCustomerLogin() {
            try {
                const response = await fetch('/demo/api/customer/check-login', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                const result = await response.json();

                if (result.logged_in) {
                    isLoggedIn = true;
                    customerData = result.customer;
                    document.getElementById('is_logged_in').value = '1';
                    document.getElementById('customer_id').value = customerData.id;

                    // Prefill customer details
                    document.getElementById('first_name').value = customerData.first_name || '';
                    document.getElementById('last_name').value = customerData.last_name || '';
                    document.getElementById('phone').value = customerData.phone || '';
                    document.getElementById('email').value = customerData.email || '';
                    document.getElementById('customer_type').value = customerData.customer_type || '';

                    // Show login notice
                    document.getElementById('login-notice').style.display = 'block';
                    document.getElementById('login-notice-text').textContent =
                        'You are logged in. Your details have been prefilled.';

                    // Handle addresses - result.addresses is directly accessible
                    const addresses = result.addresses || [];
                    customerAddresses = addresses; // Store for later use
                    const addressSelectorRow = document.getElementById('address-selection-row');
                    const addressSelector = document.getElementById('address_selector');
                    
                    console.log('Customer addresses:', addresses); // Debug log
                    if (addresses.length > 0) {
                        if (addresses.length === 1) {
                            // Single address - prefill and hide dropdown
                            const address = addresses[0];
                            document.getElementById('branch_name').value = address.branch_name || '';
                            document.getElementById('address1').value = address.address1 || '';
                            document.getElementById('address2').value = address.address2 || '';
                            document.getElementById('city').value = address.city || '';
                            document.getElementById('state').value = address.state || '';
                            document.getElementById('country').value = address.country || 'India';
                            document.getElementById('pincode').value = address.pincode || '';
                            // Set selected address ID for single address
                            document.getElementById('selected_address_id').value = address.id || '';
                            addressSelectorRow.style.display = 'none';
                        } else {
                            // Multiple addresses - show dropdown
                            addressSelectorRow.style.display = 'block';
                            addressSelector.innerHTML = '<option value="">Select an address</option>';
                            
                            addresses.forEach((address, index) => {
                                const option = document.createElement('option');
                                option.value = address.id; // Use actual address ID
                                const addressText = address.branch_name || address.address1 || `Address ${index + 1}`;
                                option.textContent = addressText + (address.city ? `, ${address.city}` : '');
                                addressSelector.appendChild(option);
                            });
                            
                            // Pre-select first address
                            addressSelector.value = addresses[0].id;
                            document.getElementById('selected_address_id').value = addresses[0].id || '';
                            populateAddressFields(addresses[0]);
                        }
                        
                        // Add change event listener for address dropdown
                        addressSelector.addEventListener('change', function() {
                            const selectedId = this.value;
                            if (selectedId !== "") {
                                const selectedAddress = addresses.find(addr => addr.id == selectedId);
                                if (selectedAddress) {
                                    populateAddressFields(selectedAddress);
                                    document.getElementById('selected_address_id').value = selectedId;
                                }
                            }
                        });
                    }

                    // If customer has company details, load them - result.company_details is directly accessible
                    if (result.company_details) {
                        const company = result.company_details;
                        document.getElementById('company_name').value = company.company_name || '';
                        document.getElementById('comp_address1').value = company.comp_address1 || '';
                        document.getElementById('comp_address2').value = company.comp_address2 || '';
                        document.getElementById('comp_city').value = company.comp_city || '';
                        document.getElementById('comp_state').value = company.comp_state || '';
                        document.getElementById('comp_country').value = company.comp_country || 'India';
                        document.getElementById('comp_pincode').value = company.comp_pincode || '';
                        document.getElementById('gst_no').value = company.gst_no || '';
                    }

                    // Make fields readonly for logged in users
                    document.getElementById('first_name').readOnly = true;
                    document.getElementById('last_name').readOnly = true;
                    document.getElementById('phone').readOnly = true;
                    document.getElementById('email').readOnly = true;
                }
            } catch (error) {
                console.error('Error checking customer login:', error);
            }
        }
        
        // Function to populate address fields
        function populateAddressFields(address) {
            document.getElementById('branch_name').value = address.branch_name || '';
            document.getElementById('address1').value = address.address1 || '';
            document.getElementById('address2').value = address.address2 || '';
            document.getElementById('city').value = address.city || '';
            document.getElementById('state').value = address.state || '';
            document.getElementById('country').value = address.country || 'India';
            document.getElementById('pincode').value = address.pincode || '';
        }

        // Check email exists in database
        async function checkEmailExists(email) {
            try {
                const response = await fetch('/demo/api/amc/check-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        email: email
                    })
                });
                const result = await response.json();
                return result;
            } catch (error) {
                console.error('Error checking email:', error);
                return {
                    success: false,
                    exists: false
                };
            }
        }

        // Load dropdown data from API
        async function loadDropdownData() {
            try {
                const categoriesResponse = await fetch('/demo/api/amc/categories');
                const categoriesResult = await categoriesResponse.json();
                if (categoriesResult.success) {
                    categoriesData = categoriesResult.data;
                    populateAllProductDropdowns();
                }

                const brandsResponse = await fetch('/demo/api/amc/brands');
                const brandsResult = await brandsResponse.json();
                if (brandsResult.success) {
                    brandsData = brandsResult.data;
                    populateAllProductDropdowns();
                }

                const plansResponse = await fetch('/demo/api/amc/plans');
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
                    <div class="col-md-3">
                        <label class="form-label">Model Number</label>
                        <input type="text" class="form-control form-control-lg product-model"
                            placeholder="Model Number" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-control form-control-lg product-sku"
                            placeholder="SKU">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">HSN Code</label>
                        <input type="text" class="form-control form-control-lg product-hsn"
                            placeholder="HSN Code">
                    </div>
                    <div class="col-md-3">
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
        nextBtn.addEventListener('click', async function() {
            if (validateCurrentStep()) {
                // Check email when moving from step 1 (Customer Details)
                if (currentStep === 0 && !isLoggedIn) {
                    const email = document.getElementById('email').value;
                    if (email) {
                        const emailCheck = await checkEmailExists(email);
                        if (emailCheck.exists) {
                            // Show login required message
                            const loginNotice = document.getElementById('login-notice');
                            loginNotice.className = 'alert alert-warning mt-3';
                            loginNotice.style.display = 'block';
                            loginNotice.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' +
                                '<strong>Email already exists!</strong> Please <a href="#" onclick="showLoginModal(); return false;">login</a> to continue with your existing account, or use a different email address.';

                            // Show login modal
                            showLoginRequiredModal();
                            return;
                        }
                    }
                }

                saveCurrentStepData();

                if (currentStep < totalSteps - 1) {
                    // Skip company details automatically only if Individual customer
                    // From step 1 (Customer Address), skip step 2 (Company Details) and go to step 3 (AMC Plan)
                    if (currentStep === 1 && shouldSkipCompanyDetails()) {
                        currentStep += 2; // Skip company details (step 2)
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
                // When going back from step 3 (AMC Plan), skip company details if Individual
                if (currentStep === 3 && shouldSkipCompanyDetails()) {
                    currentStep -= 2; // Go back to step 1 (Customer Address)
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
            // Show skip button on Company Details step (step 2)
            skipBtn.style.display = currentStep === 2 ? 'inline-block' : 'none';
            if (currentStep === totalSteps - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                submitBtn.style.display = 'none';
            }
        }

        // Skip company details check - always show company details since customer_type is now 'both'
        function shouldSkipCompanyDetails() {
            return false; // Always show company details section
        }

        // Validation
        function validateCurrentStep() {
            const currentSection = sections[currentStep];
            let isValid = true;

            // Special handling for product information step (step 4 now)
            if (currentStep === 4) { // Product Information step
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

            // Special handling for product information step (step 4 now)
            if (currentStep === 4) { // Product Information step
                productsData = [];
                const productEntries = document.querySelectorAll('.product-entry');

                productEntries.forEach((entry, index) => {
                    const product = {
                        product_name: entry.querySelector('.product-name').value,
                        product_type: entry.querySelector('.product-type').value,
                        brand_name: entry.querySelector('.product-brand').value,
                        model_number: entry.querySelector('.product-model').value,
                        sku: entry.querySelector('.product-sku').value,
                        hsn: entry.querySelector('.product-hsn').value,
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
                        !input.classList.contains('product-sku') &&
                        !input.classList.contains('product-hsn') &&
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
                <p><strong>Address:</strong> ${formData.comp_address1 || ''} ${formData.comp_address2 || ''}</p>
                <p><strong>City:</strong> ${formData.comp_city || ''}, ${formData.comp_state || ''} ${formData.comp_pincode || ''}</p>
                <p><strong>GST No:</strong> ${formData.gst_no || ''}</p>
            `;
                document.getElementById('review-company-info').innerHTML = companyInfo;
                document.getElementById('review-company-section').style.display = 'block';
            }

            // Customer Address
            const addressInfo = `
            <p><strong>Branch:</strong> ${formData.branch_name || ''}</p>
            <p><strong>Address:</strong> ${formData.address1 || ''} ${formData.address2 || ''}</p>
            <p><strong>City:</strong> ${formData.city || ''}, ${formData.state || ''} ${formData.pincode || ''}</p>
        `;
            document.getElementById('review-address-info').innerHTML = addressInfo;

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

                let selected_address_id = document.getElementById('selected_address_id') ? document.getElementById('selected_address_id').value : null;
                // Combine form data with products data
                const submitData = {
                    ...formData,
                    products: productsData,
                    selected_address_id: selected_address_id    
                };
                console.log('Submitting data:', submitData);

                const response = await fetch('/demo/api/amc/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify(submitData)
                });

                const result = await response.json();

                console.log('Submission result:', result);
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
                    let errorMsg = result.message || 'Something went wrong';
                    if (result.errors) {
                        errorMsg += '\n\nValidation Errors:\n';
                        for (const [field, errors] of Object.entries(result.errors)) {
                            errorMsg += `- ${field}: ${errors.join(', ')}\n`;
                        }
                    }
                    if (result.debug) {
                        errorMsg += '\n(Debug: ' + result.debug + ')';
                    }
                    if (result.file) {
                        errorMsg += '\n(File: ' + result.file + ':' + result.line + ')';
                    }
                    alert('Error: ' + errorMsg);
                }
            } catch (error) {
                console.error('Submission error:', error);
                console.log('Error details:', error.message);
                alert('Error submitting form. Please try again. Check console for details.');
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
