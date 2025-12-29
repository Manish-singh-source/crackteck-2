@extends('frontend/layout/master')

@section('main-content')

    <!-- Breakcrumbs -->
    <div class="tf-sp-3 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li><a href="{{ route('website') }}" class="body-small link">Home</a></li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li><span class="body-small">Cart</span></li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Shopping Cart -->
    <div class="s-shoping-cart tf-sp-2">
        <div class="container">
            <div class="checkout-status tf-sp-2 pt-0">
                <div class="checkout-wrap">
                    <span class="checkout-bar first"></span>
                    <div class="step-payment ">
                        <span class="icon">
                            <i class="icon-shop-cart-1"></i>
                        </span>
                        <a href="" class="text-secondary body-text-3">Shopping Cart</a>
                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-2"></i>
                        </span>
                        <a href="" class="link-secondary body-text-3">Shopping & Checkout</a>

                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-3"></i>
                        </span>
                        <a href="" class="link-secondary body-text-3">Confirmation</a>
                    </div>
                </div>
            </div>
            <form class="form-discount">
                <div class="overflow-x-auto">
                    <table class="tf-table-page-cart">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cartItems && $cartItems->count() > 0)
                                @foreach ($cartItems as $item)
                                    @php
                                        $product = $item->ecommerceProduct;
                                        $warehouseProduct = $product->warehouseProduct ?? null;

                                        // Ensure price is numeric and not null
                                        $price = 0;
                                        if ($warehouseProduct && isset($warehouseProduct->selling_price)) {
                                            $price = is_numeric($warehouseProduct->selling_price)
                                                ? (float) $warehouseProduct->selling_price
                                                : 0;
                                        }

                                        $total = $price * $item->quantity;

                                        // Get product name safely
                                        $productName = 'Product';
                                        if ($warehouseProduct && $warehouseProduct->product_name) {
                                            $productName = $warehouseProduct->product_name;
                                        }

                                        // Get product image safely
                                        $productImage = asset('frontend-assets/images/new-products/default.png');
                                        if ($warehouseProduct && $warehouseProduct->main_product_image) {
                                            $productImage = $warehouseProduct->main_product_image;
                                        }

                                        // Get brand safely
                                        $productBrand = 'Brand';
                                        if (
                                            $warehouseProduct &&
                                            $warehouseProduct->brand &&
                                            $warehouseProduct->brand->brand_title
                                        ) {
                                            $productBrand = $warehouseProduct->brand->brand_title;
                                        }
                                    @endphp
                                    <tr class="tf-cart-item" data-cart-id="{{ $item->id }}">
                                        <td class="tf-cart-item_product">
                                            <a href="#" class="img-box">
                                                <img src="{{ $productImage }}" alt="{{ $productName }}">
                                            </a>
                                            <div class="cart-info">
                                                <a href="#" class="cart-title body-md-2 fw-semibold link">
                                                    {{ $productName }}
                                                </a>
                                                @if ($warehouseProduct && $warehouseProduct->brand)
                                                    <div class="variant-box">
                                                        <p class="body-text-3">Brand:
                                                            {{ $productBrand }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-cart-title="Price" class="tf-cart-item_price">
                                            <p class="cart-price price-on-sale price-text fw-medium"
                                                data-price="{{ $price }}">
                                                ₹{{ number_format($price, 2) }}</p>
                                        </td>
                                        <td data-cart-title="Quantity" class="tf-cart-item_quantity">
                                            <div class="wg-quantity">
                                                <span class="btn-quantity btn-decrease" data-cart-id="{{ $item->id }}">
                                                    <i class="icon-minus"></i>
                                                </span>
                                                <input class="quantity-product" type="text" name="number"
                                                    value="{{ $item->quantity }}" data-cart-id="{{ $item->id }}"
                                                    min="1">
                                                <span class="btn-quantity btn-increase" data-cart-id="{{ $item->id }}">
                                                    <i class="icon-plus"></i>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-cart-title="Total" class="tf-cart-item_total">
                                            <p><span class="cart-total total-price price-text fw-medium"
                                                    data-total="{{ $total }}">₹{{ number_format($total, 2) }}</span>
                                            </p>
                                        </td>
                                        <td data-cart-title="Remove" class="remove-cart text-xxl-end">
                                            <span class="remove icon icon-close link cart-remove-btn"
                                                data-cart-id="{{ $item->id }}"></span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-cart-message">
                                            <h4>Your cart is empty</h4>
                                            <p>Add some products to your cart to see them here.</p>
                                            <a href="{{ route('shop') }}" class="tf-btn btn-primary mt-3">
                                                <span>Continue Shopping</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                <div class="cart-bottom">
                    <!-- Coupon Application Section -->
                    <div class="row mb-3 justify-content-end">

                        <div class="col-md-6 text-end">
                            <!-- Cart Totals -->
                            <div class="cart-totals">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="cart_subtotal">₹{{ number_format($subtotal ?? 0, 2) }}</span>
                                </div>
                                <div id="discount_row" class="d-flex justify-content-between mb-2 text-success"
                                    style="display: none;">
                                    <span>Discount:</span>
                                    <span id="cart_discount">-₹0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="last-total-price main-title fw-semibold">Total:</span>
                                    <span id="cart_total"
                                        class="last-total-price main-title fw-semibold">₹{{ number_format($subtotal ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="box-btn">
                <a href="{{ route('shop') }}" class="tf-btn btn-gray"><span class="text-white">Continue
                        shopping</span></a>
                <a href="{{ route('checkout', ['source' => 'cart']) }}" class="tf-btn"><span class="text-white">Proceed to
                        checkout</span></a>
            </div>

        </div>
    </div>
    <!-- /Shopping Cart -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Check for applied coupon on page load
            checkAppliedCoupon();

            // Apply coupon functionality
            $('#apply_coupon').on('click', function() {
                const couponCode = $('#coupon_code').val().trim();

                if (!couponCode) {
                    showNotification('Please enter a coupon code', 'error');
                    return;
                }

                const $button = $(this);
                const originalText = $button.find('span').text();

                // Show loading state
                $button.find('span').text('Applying...');
                $button.prop('disabled', true);

                $.ajax({
                    url: '{{ route('cart.apply-coupon') }}',
                    method: 'POST',
                    data: {
                        coupon_code: couponCode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            displayAppliedCoupon(response.coupon);
                            updateCartTotals(response.cart_total);
                            $('#coupon_code').val('');
                        } else {
                            showNotification(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showNotification(response?.message || 'Error applying coupon', 'error');
                    },
                    complete: function() {
                        $button.find('span').text(originalText);
                        $button.prop('disabled', false);
                    }
                });
            });

            // Remove coupon functionality
            $(document).on('click', '#remove_coupon', function() {
                $.ajax({
                    url: '{{ route('cart.remove-coupon') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            hideAppliedCoupon();
                            updateCartTotalsAfterRemoval(response.cart_total);
                        }
                    },
                    error: function() {
                        showNotification('Error removing coupon', 'error');
                    }
                });
            });

            // Allow Enter key to apply coupon
            $('#coupon_code').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#apply_coupon').click();
                }
            });

            // Check for applied coupon
            function checkAppliedCoupon() {
                $.ajax({
                    url: '{{ route('cart.applied-coupon') }}',
                    method: 'GET',
                    success: function(response) {
                        if (response.success && response.applied_coupon) {
                            displayAppliedCoupon(response.applied_coupon);
                            // Update totals to show discount
                            const subtotal = parseFloat($('#cart_subtotal').text().replace(/[₹,]/g,
                            ''));
                            const discount = response.applied_coupon.discount_amount;
                            updateCartTotals({
                                subtotal: subtotal,
                                discount: discount,
                                total: subtotal - discount
                            });
                        }
                    }
                });
            }

            // Display applied coupon
            function displayAppliedCoupon(coupon) {
                $('#coupon_title').text(coupon.title || 'Coupon Applied');
                $('#coupon_code_display').text(coupon.code);
                $('#coupon_discount').text(coupon.formatted_discount || '₹' + parseFloat(coupon.discount_amount)
                    .toFixed(2));
                $('#applied_coupon_display').show();
            }

            // Hide applied coupon
            function hideAppliedCoupon() {
                $('#applied_coupon_display').hide();
            }

            // Update cart totals with discount
            function updateCartTotals(totals) {
                if (totals.formatted) {
                    $('#cart_subtotal').text(totals.formatted.subtotal);
                    $('#cart_discount').text('-' + totals.formatted.discount);
                    $('#cart_total').text(totals.formatted.total);
                } else {
                    $('#cart_subtotal').text('₹' + parseFloat(totals.subtotal).toFixed(2));
                    $('#cart_discount').text('-₹' + parseFloat(totals.discount).toFixed(2));
                    $('#cart_total').text('₹' + parseFloat(totals.total).toFixed(2));
                }

                if (totals.discount > 0) {
                    $('#discount_row').show();
                } else {
                    $('#discount_row').hide();
                }
            }

            // Update cart totals after coupon removal
            function updateCartTotalsAfterRemoval(cartTotal) {
                $('#cart_subtotal').text('₹' + parseFloat(cartTotal).toFixed(2));
                $('#cart_total').text('₹' + parseFloat(cartTotal).toFixed(2));
                $('#discount_row').hide();
            }

            // Show notification function
            function showNotification(message, type) {
                // Create notification element
                const notification = $(`
            <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                // Add to body
                $('body').append(notification);

                // Auto remove after 5 seconds
                setTimeout(function() {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    </script>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // CSRF token setup for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Use .off() first to prevent multiple bindings
            $('.btn-increase').off('click').on('click', function() {
                const cartId = $(this).data('cart-id');
                const $input = $(this).siblings('.quantity-product');
                const currentQuantity = parseInt($input.val());
                const newQuantity = currentQuantity + 1;

                updateCartQuantity(cartId, newQuantity, $input);
            });

            $('.btn-decrease').off('click').on('click', function() {
                const cartId = $(this).data('cart-id');
                const $input = $(this).siblings('.quantity-product');
                const currentQuantity = parseInt($input.val());

                if (currentQuantity > 1) {
                    const newQuantity = currentQuantity - 1;
                    updateCartQuantity(cartId, newQuantity, $input);
                }
            });

            $('.quantity-product').off('change blur').on('change blur', function() {
                const cartId = $(this).data('cart-id');
                const $input = $(this);
                const newQuantity = parseInt($input.val());
                const originalQuantity = parseInt($input.data('original-value')) || 1;

                if (isNaN(newQuantity) || newQuantity < 1) {
                    $input.val(originalQuantity);
                    showNotification('Please enter a valid quantity (minimum 1)', 'error');
                    return;
                }

                if (newQuantity > 100) {
                    $input.val(originalQuantity);
                    showNotification('Maximum quantity allowed is 100', 'error');
                    return;
                }

                if (newQuantity !== originalQuantity) {
                    updateCartQuantity(cartId, newQuantity, $input);
                }
            });


            // Handle cart item removal
            $('.cart-remove-btn').on('click', function(e) {
                e.preventDefault();

                const cartId = $(this).data('cart-id');
                const $cartRow = $(this).closest('.tf-cart-item');

                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    $.ajax({
                        url: '{{ route('cart.remove', ':id') }}'.replace(':id', cartId),
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // Remove row from table
                                $cartRow.fadeOut(300, function() {
                                    $(this).remove();

                                    // Check if cart is empty
                                    if ($('.tf-cart-item').length === 0) {
                                        location.reload(); // Reload to show empty state
                                    } else {
                                        // Update total immediately
                                        updateCartTotal();
                                    }
                                });

                                showNotification(response.message, 'success');
                            } else {
                                showNotification(response.message || 'Error removing item',
                                    'error');
                            }
                        },
                        error: function() {
                            showNotification('Error removing item from cart', 'error');
                        }
                    });
                }
            });

            // Function to update cart quantity
            function updateCartQuantity(cartId, quantity, $input) {
                $.ajax({
                    url: '{{ route('cart.update', ':id') }}'.replace(':id', cartId),
                    method: 'PUT',
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update input value and store new original value
                            $input.val(quantity);
                            $input.data('original-value', quantity);

                            // Update row total
                            const $row = $input.closest('.tf-cart-item');
                            const price = parseFloat(response.item_price) || 0;
                            const total = price * quantity;

                            // Update the data attribute and display text
                            $row.find('.total-price').attr('data-total', total.toFixed(2));
                            $row.find('.total-price').text('₹' + total.toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));

                            // Update cart total
                            updateCartTotal();

                            showNotification('Cart updated successfully', 'success');
                        } else {
                            showNotification(response.message || 'Error updating cart', 'error');
                            // Reset input to original value
                            $input.val($input.data('original-value') || 1);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error updating cart';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showNotification(errorMessage, 'error');
                        // Reset input to original value
                        $input.val($input.data('original-value') || 1);
                    }
                });
            }

            // Function to update cart total
            function updateCartTotal() {
                let total = 0;

                $('.total-price').each(function() {
                    // Use data attribute if available, otherwise parse text
                    let priceValue = $(this).attr('data-total');
                    if (priceValue) {
                        total += parseFloat(priceValue) || 0;
                    } else {
                        // Fallback to parsing text
                        let priceText = $(this).text().replace(/₹|,|\s/g, '').trim();
                        total += parseFloat(priceText) || 0;
                    }
                });

                // Update grand total with ₹ and proper decimal formatting
                $('.last-total-price').text('Total: ₹' + total.toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }



            // Function to show notifications
            function showNotification(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                $('body').append(notification);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.alert('close');
                }, 3000);
            }

            // Store original values for inputs and initialize totals
            $('.quantity-product').each(function() {
                $(this).data('original-value', $(this).val());
            });

            // Initialize cart total calculation on page load
            updateCartTotal();
        });
    </script>
@endsection
