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
                <p class="body-small">
                    Track Your Order
                </p>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->

<!-- Track Order -->
<section class="s-track-order tf-sp-2">
    <div class="container">
        <div class="position-relative">
            <div class="parallax-image">
                <img src="https://img.freepik.com/free-photo/flat-lay-hand-holding-compass_23-2149617650.jpg?t=st=1751353442~exp=1751357042~hmac=b7071a8abf34ed561b10ab3fc0b5d980294c8168273c491c3535080eaae59ad4&w=2000" data-src="https://img.freepik.com/free-photo/flat-lay-hand-holding-compass_23-2149617650.jpg?t=st=1751353442~exp=1751357042~hmac=b7071a8abf34ed561b10ab3fc0b5d980294c8168273c491c3535080eaae59ad4&w=2000" alt=""
                    class="lazyload effect-paralax">
            </div>
            <div class="wrap">
                <div class="box-title">
                    <h5 class="fw-semibold">Track your order</h5>
                    <p class="body-text-3">To track your order, please enter your order ID in the box below
                        and
                        press the "Track" button. The ID has been sent to you on your receipt and in the
                        confirmation email you received.</p>
                </div>
                <form class="form-trackorder def" id="trackOrderForm">
                    @csrf
                    <fieldset>
                        <label>Order ID</label>
                        <input class="def" type="text" name="order_id" id="order_id"
                               placeholder="Enter your order ID" required>
                    </fieldset>
                    <div class="box-btn">
                        <button type="submit" class="tf-btn w-100" id="trackBtn">
                            <span class="text-white">Track Order</span>
                        </button>
                    </div>
                </form>

                <!-- Loading State -->
                <div id="loadingState" class="text-center mt-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Searching for your order...</p>
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="alert alert-danger mt-4" style="display: none;">
                    <i class="icon icon-alert-circle me-2"></i>
                    <span id="errorText"></span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Track Order -->

<!-- Order Results -->
<section id="orderResults" class="tf-sp-2" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="icon icon-package me-2"></i>
                            Order Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Order Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Order ID:</strong></td>
                                        <td id="orderIdDisplay"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Date:</strong></td>
                                        <td id="orderDate"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span id="orderStatus" class="badge"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Method:</strong></td>
                                        <td id="paymentMethod"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Order Summary</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Subtotal:</strong></td>
                                        <td>₹<span id="subtotal"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping:</strong></td>
                                        <td>₹<span id="shippingCharges"></span></td>
                                    </tr>
                                    <tr id="discountRow" style="display: none;">
                                        <td><strong>Discount:</strong></td>
                                        <td class="text-success">-₹<span id="discountAmount"></span></td>
                                    </tr>
                                    <tr class="border-top">
                                        <td><strong>Total Amount:</strong></td>
                                        <td class="fw-bold text-primary">₹<span id="totalAmount"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-4">
                            <h6 class="fw-bold">Order Items</h6>
                            <div id="orderItems" class="row">
                                <!-- Order items will be populated here -->
                            </div>
                        </div>

                        <!-- Shipping & Billing Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Shipping Address</h6>
                                <div class="border p-3 rounded">
                                    <p class="mb-1"><strong id="shippingName"></strong></p>
                                    <p class="mb-1" id="shippingPhone"></p>
                                    <p class="mb-0" id="shippingAddress"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Billing Address</h6>
                                <div class="border p-3 rounded">
                                    <div id="billingDetails">
                                        <p class="mb-1"><strong id="billingName"></strong></p>
                                        <p class="mb-1" id="billingPhone"></p>
                                        <p class="mb-0" id="billingAddress"></p>
                                    </div>
                                    <div id="sameBillingMessage" style="display: none;">
                                        <p class="text-muted mb-0">Same as shipping address</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Order Results -->

@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#trackOrderForm').on('submit', function(e) {
        e.preventDefault();

        const orderId = $('#order_id').val().trim();

        if (!orderId) {
            showError('Please enter an Order ID');
            return;
        }

        // Show loading state
        showLoading();
        hideError();
        hideResults();

        // Make AJAX request
        $.ajax({
            url: '{{ route("track-order.search") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                order_id: orderId
            },
            success: function(response) {
                hideLoading();
                if (response.success) {
                    displayOrderDetails(response.order);
                } else {
                    showError(response.message || 'Order not found');
                }
            },
            error: function(xhr) {
                hideLoading();
                const response = xhr.responseJSON;
                showError(response?.message || 'Order ID not found. Please check and try again.');
            }
        });
    });

    function showLoading() {
        $('#loadingState').show();
        $('#trackBtn').prop('disabled', true);
    }

    function hideLoading() {
        $('#loadingState').hide();
        $('#trackBtn').prop('disabled', false);
    }

    function showError(message) {
        $('#errorText').text(message);
        $('#errorMessage').show();
    }

    function hideError() {
        $('#errorMessage').hide();
    }

    function hideResults() {
        $('#orderResults').hide();
    }

    function displayOrderDetails(order) {
        // Populate order information
        $('#orderIdDisplay').text(order.order_id);
        $('#orderDate').text(order.order_date);
        $('#paymentMethod').text(order.payment_method);

        // Set status with appropriate badge color
        const statusBadge = $('#orderStatus');
        statusBadge.text(order.status);
        statusBadge.removeClass('bg-primary bg-warning bg-success bg-danger');

        

        switch(order.status.toLowerCase()) {
            case 'pending':
                statusBadge.addClass('bg-warning');
                break;
            case 'confirmed':
                statusBadge.addClass('bg-info');
                break;
            case 'processing':
                statusBadge.addClass('bg-warning');
                break;
            case 'shipped':
                statusBadge.addClass('bg-primary');
                break;
            case 'delivered':
                statusBadge.addClass('bg-success');
                break;
            case 'cancelled':
                statusBadge.addClass('bg-danger');
                break;
            default:
                statusBadge.addClass('bg-secondary');
        }

        // Populate order summary
        $('#subtotal').text(parseFloat(order.subtotal).toFixed(2));
        $('#shippingCharges').text(parseFloat(order.shipping_charges).toFixed(2));
        $('#totalAmount').text(parseFloat(order.total_amount).toFixed(2));

        // Show/hide discount row
        if (order.discount_amount > 0) {
            $('#discountAmount').text(parseFloat(order.discount_amount).toFixed(2));
            $('#discountRow').show();
        } else {
            $('#discountRow').hide();
        }

        // Populate order items
        displayOrderItems(order.items);

        // Populate addresses
        $('#shippingName').text(order.shipping.name);
        $('#shippingPhone').text(order.shipping.phone);
        $('#shippingAddress').text(order.shipping.address);

        if (order.billing.same_as_shipping) {
            $('#billingDetails').hide();
            $('#sameBillingMessage').show();
        } else {
            $('#billingName').text(order.billing.name);
            $('#billingPhone').text(order.billing.phone);
            $('#billingAddress').text(order.billing.address);
            $('#billingDetails').show();
            $('#sameBillingMessage').hide();
        }

        // Show results
        $('#orderResults').show();

        // Scroll to results
        $('html, body').animate({
            scrollTop: $('#orderResults').offset().top - 100
        }, 500);
    }

    function displayOrderItems(items) {
        const container = $('#orderItems');
        container.empty();

        items.forEach(function(item) {
            console.log(item);
            const itemHtml = `
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    ${item.product_image ?
                                        `<img src="${item.product_image}" alt="${item.product_name}" class="img-fluid rounded" style="max-height: 80px;">` :
                                        `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px; width: 80px;"><i class="icon icon-image text-muted"></i></div>`
                                    }
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">${item.product_name}</h6>
                                    <small class="text-muted">
                                        <strong>SKU:</strong> ${item.sku}<br>
                                        <strong>Brand:</strong> ${item.brand}<br>
                                        <strong>Model:</strong> ${item.model_no}
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">
                                        <strong>HSN Code:</strong> ${item.hsn_code}<br>
                                        <strong>Serial No:</strong> ${item.serial_no}<br>
                                        <strong>Category:</strong> ${item.category}<br>
                                        <strong>Warranty:</strong> ${item.brand_warranty}
                                    </small>
                                </div>
                                <div class="col-md-3 text-end">
                                    <p class="mb-1"><strong>Qty:</strong> ${item.quantity}</p>
                                    <p class="mb-1"><strong>Price:</strong> ₹${parseFloat(item.unit_price).toFixed(2)}</p>
                                    <p class="mb-0 fw-bold text-primary"><strong>Total:</strong> ₹${parseFloat(item.total_price).toFixed(2)}</p>
                                </div>
                            </div>
                            ${item.technical_specifications !== 'N/A' ?
                                `<div class="row mt-2">
                                    <div class="col-12">
                                        <small><strong>Technical Specifications:</strong> ${item.technical_specifications}</small>
                                    </div>
                                </div>` : ''
                            }
                        </div>
                    </div>
                </div>
            `;
            container.append(itemHtml);
        });
    }
});
</script>
@endsection
