@extends('frontend/layout/master')

@section('main-content')
    <!-- Breakcrumbs -->
    <div class="tf-sp-3 pb-0">
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
                    <span class="body-small"> Check Out</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Check Out Cart -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="checkout-status tf-sp-2 pt-0">
                <div class="checkout-wrap">
                    <span class="checkout-bar next"></span>
                    <div class="step-payment ">
                        <span class="icon">
                            <i class="icon-shop-cart-1"></i>
                        </span>
                        <a href="" class="link body-text-3">Shopping Cart</a>
                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-2"></i>
                        </span>
                        <a href="" class="text-secondary link body-text-3">Shopping & Checkout</a>

                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-3"></i>
                        </span>
                        <a href="" class="link body-text-3">Confirmation</a>
                    </div>
                </div>
            </div>

            <!-- Error/Success Messages -->
            <div id="checkout-messages" class="mb-3" style="display: none;">
                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                <div id="success-message" class="alert alert-success" style="display: none;"></div>
            </div>
            <form id="checkout-form" class="row d-flex justify-content-between" method="POST">
                @csrf
                <input type="hidden" name="source" value="{{ $checkoutData['source'] }}">
                @if ($checkoutData['source'] === 'buy_now')
                    <input type="hidden" name="product_id" value="{{ $checkoutData['product_id'] }}">
                    <input type="hidden" name="quantity" value="{{ $checkoutData['quantity'] }}">
                @endif

                <div class="tf-checkout-wrap flex-lg-nowrap col-8">
                    <div class="page-checkout">
                        <!-- Contact Information -->
                        <div class="wrap">
                            <h5 class="title fw-semibold">Contact Information</h5>
                            <div class="form-checkout-contact">
                                <label class="body-md-2 fw-semibold">Email</label>
                                <input class="def" type="email" name="email" placeholder="Your email address"
                                    required value="{{ $user->email }}" readonly>
                                <p class="caption text-main-2 font-2">Order information will be sent to your email</p>
                            </div>
                        </div>

                        <!-- Previous Address Selection -->
                        @if ($userAddresses->count() > 0)
                            <div class="wrap">
                                <h5 class="title fw-semibold">Previous Addresses</h5>
                                <div class="form-checkout-contact">
                                    <fieldset>
                                        <label>Choose Address</label>
                                        <div class="tf-select">
                                            <select id="previous-address-select" name="previous_address">
                                                <option value="">Select your previous address</option>
                                                @foreach ($userAddresses as $address)
                                                    <option value="{{ $address->id }}"
                                                        data-first-name="{{ $address->first_name }}"
                                                        data-last-name="{{ $address->last_name }}"
                                                        data-country="{{ $address->country }}"
                                                        data-state="{{ $address->state }}" data-city="{{ $address->city }}"
                                                        data-zipcode="{{ $address->zipcode }}"
                                                        data-address-line-1="{{ $address->address_line_1 }}"
                                                        data-address-line-2="{{ $address->address_line_2 }}"
                                                        data-phone="{{ $address->phone }}">
                                                        {{ $address->label ?? 'Address ' . $address->id }} -
                                                        {{ $address->formatted_address }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        @endif

                        <!-- Shipping Address -->
                        <div class="wrap">
                            <h5 class="title fw-semibold">Shipping Address</h5>
                            <div class="def">
                                <div class="cols">
                                    <fieldset>
                                        <label>First name</label>
                                        <input type="text" name="shipping_first_name" placeholder="e.g. John" required>
                                    </fieldset>
                                    <fieldset>
                                        <label>Last name</label>
                                        <input type="text" name="shipping_last_name" placeholder="e.g. Doe" required>
                                    </fieldset>
                                </div>
                                <div class="cols">
                                    <fieldset>
                                        <label>Country/Region</label>
                                        <div class="tf-select">
                                            <select name="shipping_country" required>
                                                <option value="">Select your Country/Region</option>
                                                <option value="India" selected>India</option>
                                                <option value="USA">United States</option>
                                                <option value="UK">United Kingdom</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Australia">Australia</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label>Phone Number</label>
                                        <input type="tel" name="shipping_phone" placeholder="e.g. +91 98765 43210"
                                            required>
                                    </fieldset>
                                </div>
                                <div class="cols">
                                    <fieldset>
                                        <label>State</label>
                                        <input type="text" name="shipping_state" placeholder="e.g. Maharashtra"
                                            required>
                                    </fieldset>
                                    <fieldset>
                                        <label>City</label>
                                        <input type="text" name="shipping_city" placeholder="e.g. Mumbai" required>
                                    </fieldset>
                                    <fieldset>
                                        <label>ZIP code</label>
                                        <input type="text" name="shipping_zipcode" placeholder="e.g. 400056" required>
                                    </fieldset>
                                </div>
                                <fieldset>
                                    <label>Address Line 1</label>
                                    <input type="text" name="shipping_address_line_1"
                                        placeholder="Your detailed address" required>
                                </fieldset>
                                <fieldset>
                                    <label>Address Line 2</label>
                                    <input type="text" name="shipping_address_line_2"
                                        placeholder="Apartment, suite, etc. (optional)">
                                </fieldset>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="wrap">
                            <h5 class="title fw-semibold">Billing Address</h5>

                            <!-- Same as shipping checkbox -->
                            <div class="payment-item mb-3">
                                <label for="billing-same-as-shipping" class="payment-header radio-item">
                                    <input type="checkbox" name="billing_same_as_shipping" value="1"
                                        class="tf-check-rounded" id="billing-same-as-shipping" checked>
                                    <span class="body-text-3">Same as shipping address</span>
                                </label>
                            </div>

                            <!-- Billing address form (hidden by default) -->
                            <div id="billing-address-form" class="def" style="display: none;">
                                <div class="cols">
                                    <fieldset>
                                        <label>First name</label>
                                        <input type="text" name="billing_first_name" placeholder="e.g. John">
                                    </fieldset>
                                    <fieldset>
                                        <label>Last name</label>
                                        <input type="text" name="billing_last_name" placeholder="e.g. Doe">
                                    </fieldset>
                                </div>
                                <div class="cols">
                                    <fieldset>
                                        <label>Country/Region</label>
                                        <div class="tf-select">
                                            <select name="billing_country">
                                                <option value="">Select your Country/Region</option>
                                                <option value="India" selected>India</option>
                                                <option value="USA">United States</option>
                                                <option value="UK">United Kingdom</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Australia">Australia</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label>Phone Number</label>
                                        <input type="tel" name="billing_phone" placeholder="e.g. +91 98765 43210">
                                    </fieldset>
                                </div>
                                <div class="cols">
                                    <fieldset>
                                        <label>State</label>
                                        <input type="text" name="billing_state" placeholder="e.g. Maharashtra">
                                    </fieldset>
                                    <fieldset>
                                        <label>City</label>
                                        <input type="text" name="billing_city" placeholder="e.g. Mumbai">
                                    </fieldset>
                                    <fieldset>
                                        <label>ZIP code</label>
                                        <input type="text" name="billing_zipcode" placeholder="e.g. 400056">
                                    </fieldset>
                                </div>
                                <fieldset>
                                    <label>Address Line 1</label>
                                    <input type="text" name="billing_address_line_1"
                                        placeholder="Your detailed address">
                                </fieldset>
                                <fieldset>
                                    <label>Address Line 2</label>
                                    <input type="text" name="billing_address_line_2"
                                        placeholder="Apartment, suite, etc. (optional)">
                                </fieldset>

                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="wrap">
                            <h5 class="title fw-semibold">Payment Method</h5>
                            <div class="form-payment">
                                <div class="payment-box" id="payment-box">
                                    <!-- Mastercard Payment -->
                                    <div class="payment-item payment-choose-card">
                                        <label for="credit-card-method" class="payment-header" data-bs-toggle="collapse"
                                            data-bs-target="#credit-card-payment" aria-controls="credit-card-payment"
                                            aria-expanded="false">
                                            <input type="radio" name="payment_method" value="mastercard"
                                                class="tf-check-rounded" id="credit-card-method">
                                            <span class="body-md-2 fw-semibold">Mastercard</span>
                                        </label>
                                        <div id="credit-card-payment" class="collapse" data-bs-parent="#payment-box">
                                            <div class="payment-body">
                                                <fieldset>
                                                    <label>Credit Card number</label>
                                                    <input type="text" name="card_number" class="number-credit-card"
                                                        placeholder="1234 5678 9012 3456" maxlength="19">
                                                </fieldset>
                                                <div class="cols">
                                                    <fieldset>
                                                        <label>Expiration date</label>
                                                        <input type="text" name="card_expiry" placeholder="MM/YY"
                                                            maxlength="5">
                                                    </fieldset>
                                                    <fieldset>
                                                        <label>CVV</label>
                                                        <input type="text" name="card_cvv" placeholder="123"
                                                            maxlength="4">
                                                    </fieldset>
                                                </div>
                                                <fieldset>
                                                    <label>Name on card</label>
                                                    <input type="text" name="card_name" placeholder="e.g. JOHN DOE">
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cash on Delivery -->
                                    <div class="payment-item">
                                        <label for="cod-method" class="payment-header radio-item">
                                            <input type="radio" name="payment_method" value="cod"
                                                class="tf-check-rounded" id="cod-method" checked>
                                            <span class="body-text-3">Cash on Delivery</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Place Order Button -->
                                <div class="box-btn">
                                    <button type="submit" class="tf-btn w-100" id="place-order-btn">
                                        <span class="text-white">Place Order</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order Summary Sidebar -->
                <div class="flat-sidebar-checkout col-4" style="height: fit-content;">
                    <div class="sidebar-checkout-content">
                        <h5 class="fw-semibold">Order Summary</h5>

                        <!-- Product List -->
                        <ul class="list-product">
                            @foreach ($checkoutData['items'] as $item)
                                @php
                                    $product = $item->ecommerceProduct;
                                    $warehouseProduct = $product->warehouseProduct;
                                    $itemTotal = $warehouseProduct->selling_price * $item->quantity;
                                @endphp
                                <li class="item-product {{ !$loop->last ? 'border-bottom pb-2' : 'pb-2' }}">
                                    <a href="{{ route('product.detail', $product->id) }}" class="img-product">
                                        <img src="{{ $warehouseProduct->main_product_image ? asset($warehouseProduct->main_product_image) : asset('frontend-assets/images/new-products/2-1-1.png') }}"
                                            alt="{{ $warehouseProduct->product_name }}">
                                    </a>
                                    <div class="content-box">
                                        <a href="{{ route('product.detail', $product->id) }}"
                                            class="link-secondary body-md-2 fw-semibold">
                                            {{ Str::limit($warehouseProduct->product_name, 60) }}
                                        </a>
                                        <p class="price-quantity price-text fw-semibold">
                                            ₹{{ number_format($warehouseProduct->selling_price, 2) }}
                                            <span class="body-md-2 text-main-2 fw-normal">X{{ $item->quantity }}</span>
                                        </p>
                                        @if ($warehouseProduct->color)
                                            <p class="body-md-2 text-main-2">{{ $warehouseProduct->color }}</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Discount Code Section -->
                        <div class="mt-3">
                            <p class="body-md-2 fw-semibold sub-type">Discount code</p>
                            <div class="ip-discount-code style-2">
                                <div class="d-flex gap-2">
                                    <input type="text" id="coupon_code" class="def" placeholder="Enter coupon code"
                                           value="{{ session('applied_coupon.code') ?? '' }}">
                                    <button type="button" id="apply_coupon" class="tf-btn btn-primary">
                                        <span>Apply</span>
                                    </button>
                                </div>
                                @if(session('applied_coupon'))
                                    <div class="mt-2">
                                        <small class="text-success">
                                            <i class="icon-check"></i>
                                            Coupon "{{ session('applied_coupon.code') }}" applied successfully!
                                        </small>
                                        <button type="button" id="remove_coupon" class="btn btn-sm btn-outline-danger ms-2">
                                            Remove
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div id="coupon_message" class="mt-2" style="display: none;"></div>
                        </div>

                        <!-- Price Summary -->
                        <ul class="sec-total-price">
                            <li>
                                <span class="body-text-3">Subtotal</span>
                                <span class="body-text-3"
                                    id="subtotal-amount">₹{{ number_format($totals['subtotal'], 2) }}</span>
                            </li>
                            <li>
                                <span class="body-text-3">Shipping</span>
                                <span class="body-text-3" id="shipping-amount">
                                    @if ($totals['has_free_shipping'])
                                        Free shipping
                                    @else
                                        ₹{{ number_format($totals['shipping_charges'], 2) }}
                                    @endif
                                </span>
                            </li>
                            @if(session('applied_coupon'))
                                <li>
                                    <span class="body-text-3 text-success">Discount ({{ session('applied_coupon.code') }})</span>
                                    <span class="body-text-3 text-success" id="discount-amount">
                                        -₹{{ number_format(session('applied_coupon.discount_amount'), 2) }}
                                    </span>
                                </li>
                            @endif
                            <li>
                                <span class="body-md-2 fw-semibold">Total</span>
                                <span class="body-md-2 fw-semibold text-primary"
                                    id="total-amount">₹{{ number_format($totals['total'], 2) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
        </div>
        </form>
        </div>
        </div>
    </section>
    <!-- /Check Out Cart -->

    <!-- Loading Overlay -->
    <div id="loading-overlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
        <div
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Processing your order...</p>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Previous address selection
            $('#previous-address-select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                if (selectedOption.val()) {
                    // Fill shipping address fields
                    $('input[name="shipping_first_name"]').val(selectedOption.data('first-name'));
                    $('input[name="shipping_last_name"]').val(selectedOption.data('last-name'));
                    $('select[name="shipping_country"]').val(selectedOption.data('country'));
                    $('input[name="shipping_state"]').val(selectedOption.data('state'));
                    $('input[name="shipping_city"]').val(selectedOption.data('city'));
                    $('input[name="shipping_zipcode"]').val(selectedOption.data('zipcode'));
                    $('input[name="shipping_address_line_1"]').val(selectedOption.data('address-line-1'));
                    $('input[name="shipping_address_line_2"]').val(selectedOption.data('address-line-2'));
                    $('input[name="shipping_phone"]').val(selectedOption.data('phone'));
                }
            });

            // Billing same as shipping toggle
            $('#billing-same-as-shipping').on('change', function() {
                const billingForm = $('#billing-address-form');
                const billingInputs = billingForm.find('input, select');

                if ($(this).is(':checked')) {
                    billingForm.hide();
                    billingInputs.prop('required', false);
                    // Copy shipping data to billing fields (for form submission)
                    copyShippingToBilling();
                } else {
                    billingForm.show();
                    billingInputs.filter(
                        '[name$="_first_name"], [name$="_last_name"], [name$="_country"], [name$="_state"], [name$="_city"], [name$="_zipcode"], [name$="_address_line_1"], [name$="_phone"]'
                    ).prop('required', true);
                }
            });

            // Function to copy shipping address to billing address
            function copyShippingToBilling() {
                $('input[name="billing_first_name"]').val($('input[name="shipping_first_name"]').val());
                $('input[name="billing_last_name"]').val($('input[name="shipping_last_name"]').val());
                $('select[name="billing_country"]').val($('select[name="shipping_country"]').val());
                $('input[name="billing_state"]').val($('input[name="shipping_state"]').val());
                $('input[name="billing_city"]').val($('input[name="shipping_city"]').val());
                $('input[name="billing_zipcode"]').val($('input[name="shipping_zipcode"]').val());
                $('input[name="billing_address_line_1"]').val($('input[name="shipping_address_line_1"]').val());
                $('input[name="billing_address_line_2"]').val($('input[name="shipping_address_line_2"]').val());
                $('input[name="billing_phone"]').val($('input[name="shipping_phone"]').val());
            }

            // Copy shipping to billing when shipping fields change (if checkbox is checked)
            $('input[name^="shipping_"], select[name^="shipping_"]').on('input change', function() {
                if ($('#billing-same-as-shipping').is(':checked')) {
                    copyShippingToBilling();
                }
            });

            // Payment method toggle
            $('input[name="payment_method"]').on('change', function() {
                const cardFields = $('#credit-card-payment');
                const cardInputs = cardFields.find('input');

                if ($(this).val() === 'mastercard') {
                    cardFields.collapse('show');
                    cardInputs.prop('required', true);
                } else {
                    cardFields.collapse('hide');
                    cardInputs.prop('required', false);
                }
            });

            // Credit card number formatting
            $('input[name="card_number"]').on('input', function() {
                let value = $(this).val().replace(/\s/g, '').replace(/[^0-9]/gi, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                if (formattedValue.length > 19) formattedValue = formattedValue.substr(0, 19);
                $(this).val(formattedValue);
            });

            // Card expiry formatting
            $('input[name="card_expiry"]').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                $(this).val(value);
            });

            // CVV formatting
            $('input[name="card_cvv"]').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(value);
            });

            // Coupon functionality
            $('#apply_coupon').on('click', function() {
                const couponCode = $('#coupon_code').val().trim();
                if (!couponCode) {
                    showCouponMessage('Please enter a coupon code', 'error');
                    return;
                }

                $.ajax({
                    url: '{{ route("cart.apply-coupon") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        coupon_code: couponCode
                    },
                    success: function(response) {
                        if (response.success) {
                            showCouponMessage(response.message, 'success');
                            // Reload page to update totals
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showCouponMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error applying coupon. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showCouponMessage(errorMessage, 'error');
                    }
                });
            });

            $('#remove_coupon').on('click', function() {
                $.ajax({
                    url: '{{ route("cart.remove-coupon") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showCouponMessage(response.message, 'success');
                            // Reload page to update totals
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showCouponMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        showCouponMessage('Error removing coupon. Please try again.', 'error');
                    }
                });
            });

            function showCouponMessage(message, type) {
                const messageDiv = $('#coupon_message');
                messageDiv.removeClass('text-success text-danger')
                    .addClass(type === 'success' ? 'text-success' : 'text-danger')
                    .html('<small>' + message + '</small>')
                    .show();

                setTimeout(function() {
                    messageDiv.hide();
                }, 5000);
            }

            // Form submission
            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();

                // Show loading
                // $('#loading-overlay').show();
                // $('#place-order-btn').prop('disabled', true);

                // Hide previous messages
                $('#checkout-messages').hide();
                $('#error-message, #success-message').hide();

                $.ajax({
                    url: '{{ route('checkout.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            console.log(response);
                            alert(response.message);
                            $('#success-message').text(response.message).show();
                            $('#checkout-messages').show();

                            // Redirect to order details
                            if (response.redirect) {
                                setTimeout(function() {
                                    window.location.href = response.redirect;
                                }, 2000);
                            }
                        } else {
                            alert(response.error);
                            console.log(response);
                            $('#error-message').text(response.message || 'An error occurred')
                                .show();
                            $('#checkout-messages').show();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message);
                        alert(xhr.responseJSON.message);
                        let errorMessage = 'An error occurred while processing your order.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('<br>');
                        }

                        $('#error-message').html(errorMessage).show();
                        $('#checkout-messages').show();
                    },
                    complete: function() {
                        $('#loading-overlay').hide();
                        $('#place-order-btn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
