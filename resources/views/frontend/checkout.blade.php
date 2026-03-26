@extends('frontend/layout/master')

<style>
    /* Coupon Wrapper */
    .coupon-box {
        width: 100%;
    }

    /* Input + Button Row */
    .coupon-input-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Input */
    .coupon-input {
        flex: 1;
        height: 45px;
        border-radius: 8px;
        padding: 0 12px;
        font-size: 14px;
    }

    /* Button */
    .coupon-btn {
        height: 45px;
        padding: 0 18px;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* Success Section */
    .coupon-success {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f0fff4;
        border: 1px solid #c6f6d5;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .coupon-input-group {
            flex-direction: column;
        }

        .coupon-btn {
            width: 100%;
        }

        .coupon-success {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
    }
</style>

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
                                                    @if (!$address)
                                                        @continue
                                                    @endif

                                                    <option value="{{ $address->id }}"
                                                        data-first-name="{{ $address->customer->first_name ?? '' }}"
                                                        data-last-name="{{ $address->customer->last_name ?? '' }}"
                                                        data-country="{{ $address->country }}"
                                                        data-state="{{ $address->state }}" data-city="{{ $address->city }}"
                                                        data-zipcode="{{ $address->pincode }}"
                                                        data-address-line-1="{{ $address->address1 }}"
                                                        data-address-line-2="{{ $address->address2 }}"
                                                        data-phone="{{ $address->customer->phone ?? '' }}">
                                                        {{ $address->label ?? 'Address ' . $address->id }} -
                                                        {{ $address->address1 }}, {{ $address->city }},
                                                        {{ $address->state }}, {{ $address->country }} -
                                                        {{ $address->pincode }}
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
                                    <!-- Razorpay Payment -->
                                    <div class="payment-item">
                                        <label for="credit-card-method" class="payment-header radio-item">
                                            <input type="radio" name="payment_method" value="mastercard"
                                                class="tf-check-rounded" id="credit-card-method" checked>
                                            <span class="body-text-3">Pay Online with Razorpay</span>
                                        </label>
                                        <p class="caption text-main-2 font-2 ps-4 mb-0">Cards, UPI, netbanking and wallets
                                            are available in the Razorpay popup.</p>
                                    </div>

                                    <!-- Cash on Delivery -->
                                    <div class="payment-item">
                                        <label for="cod-method" class="payment-header radio-item">
                                            <input type="radio" name="payment_method" value="cod"
                                                class="tf-check-rounded" id="cod-method"  
                                                @if($totals['total'] >= 6000) disabled @endif>
                                            <span class="body-text-3">Cash on Delivery</span>
                                            @if($totals['total'] >= 6000) 
                                                <span class="text-danger">You can not use Cash on Delivery for oder below ₹6000</span>
                                            @endif
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
                            @php $lastItem = null; @endphp
                            @foreach ($checkoutData['items'] as $item)
                                @php
                                    $product = $item->ecommerceProduct;
                                    $warehouseProduct = $product->warehouseProduct;
                                    $itemTotal = $warehouseProduct->final_price * $item->quantity;
                                    $lastItem = $item;
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
                                            ₹{{ number_format($warehouseProduct->final_price, 2) }}
                                            <span class="body-md-2 text-main-2 fw-normal">X{{ $item->quantity }}</span>
                                        </p>
                                        <span>
                                            Installation:
                                            <span
                                                class="body-md-2 text-main-2 fw-normal">{{ ucfirst($warehouseProduct->installation) }}</span>
                                        </span>
                                        @if ($warehouseProduct->color)
                                            <p class="body-md-2 text-main-2">{{ $warehouseProduct->color }}</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                            @php
                                // Get last item's warehouse product for tax display
                                $lastWarehouseProduct = $lastItem
                                    ? $lastItem->ecommerceProduct->warehouseProduct
                                    : null;
                            @endphp
                        </ul>
                        <!-- Discount Code Section -->
                        <div class="mt-3">
                            <p class="body-md-2 fw-semibold sub-type">Discount Code</p>

                            <div class="coupon-box">
                                <div class="coupon-input-group">
                                    <input type="text" id="coupon_code" class="form-control coupon-input"
                                        placeholder="Enter coupon code"
                                        value="{{ session('applied_coupon.code') ?? '' }}">

                                    <button type="button" id="apply_coupon" class="btn btn-primary coupon-btn">
                                        Apply
                                    </button>
                                </div>

                                @if (session('applied_coupon'))
                                    <div class="coupon-success">
                                        <span>
                                            ✅ Coupon "<strong>{{ session('applied_coupon.code') }}</strong>" applied
                                            successfully!
                                        </span>

                                        <button type="button" id="remove_coupon" class="btn btn-sm btn-outline-danger">
                                            Remove
                                        </button>
                                    </div>
                                @endif

                                <div id="coupon_message" class="mt-2" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <ul class="sec-total-price">
                            <li>
                                <span class="body-text-3">Subtotal</span>
                                <span class="body-text-3"
                                    id="subtotal-amount">₹{{ number_format($totals['subtotal'], 2) }}</span>
                            </li>
                            <li>
                                <span class="body-text-3">Tax</span>
                                <span class="body-text-3">{{ $lastWarehouseProduct->tax ?? 0 }}%</span>
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
                            @if (session('applied_coupon'))
                                <li>
                                    <span class="body-text-3 text-success">Discount
                                        ({{ session('applied_coupon.code') }})</span>
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
            </form>
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
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(document).ready(function() {
            const checkoutForm = $('#checkout-form');
            const checkoutMessages = $('#checkout-messages');
            const errorMessage = $('#error-message');
            const successMessage = $('#success-message');
            const loadingOverlay = $('#loading-overlay');
            const placeOrderButton = $('#place-order-btn');
            const razorpayOrderRouteTemplate = @json(route('checkout.razorpay.order', ['order' => '__ORDER_ID__']));
            const razorpayVerifyRoute = @json(route('checkout.razorpay.verify'));
            const csrfToken = @json(csrf_token());

            function setLoadingState(isLoading) {
                loadingOverlay.toggle(isLoading);
                placeOrderButton.prop('disabled', isLoading);
            }

            function resetCheckoutMessages() {
                checkoutMessages.hide();
                errorMessage.hide().html('');
                successMessage.hide().text('');
            }

            function showCheckoutError(message) {
                errorMessage.html(message).show();
                checkoutMessages.show();
            }

            function showCheckoutSuccess(message) {
                successMessage.text(message).show();
                checkoutMessages.show();
            }

            function buildErrorMessage(xhr, fallbackMessage) {
                let message = fallbackMessage;

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    if (xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }

                    if (xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                } else if (xhr.responseText) {
                    message = xhr.responseText;
                }

                return message;
            }

            function redirectToOrderDetails(url) {
                if (url) {
                    window.location.href = url;
                }
            }

            function createRazorpayOrder(orderId) {
                return $.ajax({
                    url: razorpayOrderRouteTemplate.replace('__ORDER_ID__', orderId),
                    method: 'POST',
                    data: {
                        _token: csrfToken
                    }
                });
            }

            function verifyRazorpayPayment(payload) {
                return $.ajax({
                    url: razorpayVerifyRoute,
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        order_id: payload.order_id,
                        razorpay_order_id: payload.razorpay_order_id,
                        razorpay_payment_id: payload.razorpay_payment_id,
                        razorpay_signature: payload.razorpay_signature
                    }
                });
            }

            function openRazorpayCheckout(orderResponse, checkoutResponse) {
                const shippingFirstName = $('input[name="shipping_first_name"]').val() || '';
                const shippingLastName = $('input[name="shipping_last_name"]').val() || '';
                const shippingPhone = $('input[name="shipping_phone"]').val() || '';
                const customerEmail = $('input[name="email"]').val() || '';
                const fullName = [shippingFirstName, shippingLastName].join(' ').trim();
                const razorpayData = orderResponse.data.razorpay;

                const options = {
                    key: razorpayData.key_id,
                    amount: razorpayData.amount,
                    currency: razorpayData.currency,
                    name: 'Crackteck',
                    description: 'Order #' + checkoutResponse.order_number,
                    order_id: razorpayData.order_id,
                    handler: function(response) {
                        setLoadingState(true);

                        verifyRazorpayPayment({
                            order_id: checkoutResponse.order_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature
                        }).done(function(verificationResponse) {
                            if (verificationResponse.success) {
                                showCheckoutSuccess(verificationResponse.message ||
                                    'Payment verified successfully.');
                                redirectToOrderDetails(verificationResponse.data?.redirect ||
                                    checkoutResponse.redirect);
                                return;
                            }

                            showCheckoutError(verificationResponse.message ||
                                'Payment verification failed.');
                        }).fail(function(xhr) {
                            showCheckoutError(buildErrorMessage(xhr,
                                'Payment verification failed. Please contact support if the amount was debited.'
                                ));
                        }).always(function() {
                            setLoadingState(false);
                        });
                    },
                    prefill: {
                        name: fullName,
                        email: customerEmail,
                        contact: shippingPhone
                    },
                    theme: {
                        color: '#0d6efd'
                    },
                    modal: {
                        ondismiss: function() {
                            setLoadingState(false);
                            showCheckoutError(
                                'Payment was not completed. Your order is created in pending state; you can retry the payment from the order details page.'
                            );
                        }
                    }
                };

                const razorpay = new Razorpay(options);
                razorpay.on('payment.failed', function(response) {
                    setLoadingState(false);
                    const failureMessage = response.error && response.error.description ? response.error
                        .description :
                        'Payment failed. Please try again.';
                    showCheckoutError(failureMessage);
                });
                razorpay.open();
            }

            $('#previous-address-select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                if (selectedOption.val()) {
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

            $('#billing-same-as-shipping').on('change', function() {
                const billingForm = $('#billing-address-form');
                const billingInputs = billingForm.find('input, select');

                if ($(this).is(':checked')) {
                    billingForm.hide();
                    billingInputs.prop('required', false);
                    copyShippingToBilling();
                } else {
                    billingForm.show();
                    billingInputs.filter(
                        '[name$="_first_name"], [name$="_last_name"], [name$="_country"], [name$="_state"], [name$="_city"], [name$="_zipcode"], [name$="_address_line_1"], [name$="_phone"]'
                    ).prop('required', true);
                }
            });

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

            $('input[name^="shipping_"], select[name^="shipping_"]').on('input change', function() {
                if ($('#billing-same-as-shipping').is(':checked')) {
                    copyShippingToBilling();
                }
            });

            $('#apply_coupon').on('click', function() {
                const couponCode = $('#coupon_code').val().trim();
                if (!couponCode) {
                    showCouponMessage('Please enter a coupon code', 'error');
                    return;
                }

                $.ajax({
                    url: '{{ route('cart.apply-coupon') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        coupon_code: couponCode,
                        @if (isset($checkoutData['product_id']) && $checkoutData['product_id'])
                            product_id: {{ $checkoutData['product_id'] }}
                        @endif
                    },
                    success: function(response) {
                        if (response.success) {
                            showCouponMessage(response.message, 'success');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showCouponMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let couponErrorMessage = 'Error applying coupon. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            couponErrorMessage = xhr.responseJSON.message;
                        }
                        showCouponMessage(couponErrorMessage, 'error');
                    }
                });
            });

            $('#remove_coupon').on('click', function() {
                $.ajax({
                    url: '{{ route('cart.remove-coupon') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showCouponMessage(response.message, 'success');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showCouponMessage(response.message, 'error');
                        }
                    },
                    error: function() {
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

            checkoutForm.on('submit', function(e) {
                e.preventDefault();
                resetCheckoutMessages();
                setLoadingState(true);

                $.ajax({
                    url: '{{ route('checkout.store') }}',
                    method: 'POST',
                    data: checkoutForm.serialize(),
                    success: function(response) {
                        if (!response.success) {
                            setLoadingState(false);
                            showCheckoutError(response.message ||
                                'An error occurred while processing your order.');
                            return;
                        }

                        if (response.payment_method === 'mastercard') {
                            createRazorpayOrder(response.order_id).done(function(
                            orderResponse) {
                                if (!orderResponse.success) {
                                    showCheckoutError(orderResponse.message ||
                                        'Unable to initialize Razorpay payment.');
                                    setLoadingState(false);
                                    return;
                                }

                                setLoadingState(false);
                                showCheckoutSuccess(response.message);
                                openRazorpayCheckout(orderResponse, response);
                            }).fail(function(xhr) {
                                showCheckoutError(buildErrorMessage(xhr,
                                    'Unable to initialize Razorpay payment. Please try again.'
                                    ));
                                setLoadingState(false);
                            });

                            return;
                        }

                        showCheckoutSuccess(response.message);
                        setTimeout(function() {
                            redirectToOrderDetails(response.redirect);
                        }, 1200);
                    },
                    error: function(xhr) {
                        setLoadingState(false);
                        showCheckoutError(buildErrorMessage(xhr,
                            'An error occurred while processing your order.'));
                    },
                    complete: function() {
                        setLoadingState(false);
                    }
                });
            });
        });
    </script>
@endsection
