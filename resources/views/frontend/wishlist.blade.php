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
                <span class="body-small"> Wishlist</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breakcrumbs -->

<!-- Wishlist -->
<div class="tf-sp-2">
    <div class="container">
        <div class="tf-wishlist">
            <table class="tf-table-wishlist">
                <thead>
                    <tr>
                        <th class="wishlist-item_remove"></th>
                        <th class="wishlist-item_image"></th>
                        <th class="wishlist-item_info">
                            <p class="product-title fw-semibold">Product Name</p>
                        </th>
                        <th class="wishlist-item_price">
                            <p class="product-title fw-semibold">Unit Price</p>
                        </th>
                        <th class="wishlist-item_stock">
                            <p class="product-title fw-semibold">Stock Status</p>
                        </th>
                        <th class="wishlist-item_action"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishlistItems as $item)
                    <tr class="wishlist-item" data-wishlist-id="{{ $item->id }}">
                        <td class="wishlist-item_remove">
                            <i class="icon-close remove link cs-pointer remove-wishlist-btn"
                               data-wishlist-id="{{ $item->id }}"
                               data-product-name="{{ $item->ecommerceProduct->warehouseProduct->product_name ?? 'Product' }}"></i>
                        </td>
                        <td class="wishlist-item_image">
                            <a href="{{ route('product.detail', $item->ecommerceProduct->id) }}">
                                @if($item->ecommerceProduct->warehouseProduct && $item->ecommerceProduct->warehouseProduct->main_product_image)
                                    <img src="{{ asset($item->ecommerceProduct->warehouseProduct->main_product_image) }}"
                                         data-src="{{ asset($item->ecommerceProduct->warehouseProduct->main_product_image) }}"
                                         alt="{{ $item->ecommerceProduct->warehouseProduct->product_name }}" class="lazyload">
                                @else
                                    <img src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                         data-src="{{ asset('frontend-assets/images/placeholder-product.png') }}"
                                         alt="No Image" class="lazyload">
                                @endif
                            </a>
                        </td>
                        <td class="wishlist-item_info">
                            <a class="text-line-clamp-2 body-md-2 fw-semibold text-secondary link"
                                href="{{ route('product.detail', $item->ecommerceProduct->id) }}">
                                {{ $item->ecommerceProduct->warehouseProduct->product_name ?? 'Product Name' }}
                            </a>
                        </td>
                        <td class="wishlist-item_price">
                            <p class="price-wrap fw-medium flex-nowrap">
                                @if($item->ecommerceProduct->warehouseProduct)
                                    @if($item->ecommerceProduct->warehouseProduct->discount_price && $item->ecommerceProduct->warehouseProduct->selling_price > 0)
                                        <span class="new-price price-text fw-medium mb-0">₹{{ number_format($item->ecommerceProduct->warehouseProduct->selling_price, 2) }}</span>
                                        <span class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($item->ecommerceProduct->warehouseProduct->cost_price, 2) }}</span>
                                    @else
                                        <span class="new-price price-text fw-medium mb-0">₹{{ number_format($item->ecommerceProduct->warehouseProduct->cost_price, 2) }}</span>
                                    @endif
                                @else
                                    <span class="new-price price-text fw-medium mb-0">₹0.00</span>
                                @endif
                            </p>
                        </td>
                        <td class="wishlist-item_stock">
                            @if($item->ecommerceProduct->warehouseProduct)
                                @if($item->ecommerceProduct->warehouseProduct->stock_status === 'In Stock' && $item->ecommerceProduct->warehouseProduct->stock_quantity > 0)
                                    <span class="wishlist-stock-status text-success">In Stock</span>
                                @else
                                    <span class="wishlist-stock-status text-danger">Out of Stock</span>
                                @endif
                            @else
                                <span class="wishlist-stock-status text-danger">Unavailable</span>
                            @endif
                        </td>
                        <td class="wishlist-item_action">
                            @if($item->ecommerceProduct->warehouseProduct && $item->ecommerceProduct->warehouseProduct->stock_status === 'In Stock' && $item->ecommerceProduct->warehouseProduct->stock_quantity > 0)
                                <button class="tf-btn btn-gray move-to-cart-btn"
                                        data-wishlist-id="{{ $item->id }}"
                                        data-product-name="{{ $item->ecommerceProduct->warehouseProduct->product_name ?? 'Product' }}">
                                    <span class="text-white">Add To Cart</span>
                                </button>
                            @else
                                <button class="tf-btn btn-gray" disabled>
                                    <span class="text-white">Out of Stock</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
                <tfoot class="{{ $wishlistItems->count() > 0 ? 'd-none' : '' }}">
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-wishlist">
                                <i class="icon icon-heart2" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                                <h4 class="mb-3">Your wishlist is empty</h4>
                                <p class="text-muted mb-4">Start adding products to your wishlist by clicking the heart icon on products you love.</p>
                                <a href="{{ route('shop') }}" class="tf-btn">
                                    <span class="text-white">Continue Shopping</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- /Wishlist -->

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

    // Remove from Wishlist functionality
    $('.remove-wishlist-btn').on('click', function(e) {
        e.preventDefault();

        const $button = $(this);
        const wishlistId = $button.data('wishlist-id');
        const productName = $button.data('product-name');
        const $row = $button.closest('tr');

        // Confirm removal
        if (!confirm(`Are you sure you want to remove "${productName}" from your wishlist?`)) {
            return;
        }

        // Show loading state
        $button.removeClass('icon-close').addClass('icon-loading');

        // Make AJAX request
        $.ajax({
            url: `/wishlist/${wishlistId}`,
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Remove the row with animation
                    $row.fadeOut(300, function() {
                        $(this).remove();

                        // Check if wishlist is now empty
                        if ($('.wishlist-item').length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    });

                    // Update wishlist count
                    updateWishlistCount();
                } else {
                    showNotification(response.message, 'error');
                    $button.removeClass('icon-loading').addClass('icon-close');
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while removing the product from your wishlist.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showNotification(message, 'error');
                $button.removeClass('icon-loading').addClass('icon-close');
            }
        });
    });

    // Move to Cart functionality
    $('.move-to-cart-btn').on('click', function(e) {
        e.preventDefault();

        const $button = $(this);
        const wishlistId = $button.data('wishlist-id');
        const productName = $button.data('product-name');
        const $row = $button.closest('tr');

        // Show loading state
        const originalText = $button.html();
        $button.html('<span class="text-white">Moving...</span>');
        $button.prop('disabled', true);

        // Make AJAX request
        $.ajax({
            url: `/wishlist/${wishlistId}/move-to-cart`,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Remove the row with animation
                    $row.fadeOut(300, function() {
                        $(this).remove();

                        // Check if wishlist is now empty
                        if ($('.wishlist-item').length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    });

                    // Update both wishlist and cart counts since item moved from wishlist to cart
                    updateWishlistCount();
                    updateCartCount();

                    // Optionally redirect to cart if specified
                    if (response.redirect_to_cart) {
                        setTimeout(function() {
                            // You can redirect to cart page here if needed
                            // window.location.href = '{{ route("shop-cart") }}';
                        }, 1500);
                    }
                } else {
                    showNotification(response.message, 'error');
                    $button.html(originalText);
                    $button.prop('disabled', false);
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while moving the product to cart.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showNotification(message, 'error');
                $button.html(originalText);
                $button.prop('disabled', false);
            }
        });
    });

    // Function to show notifications
    function showNotification(message, type) {
        // Create notification element
        const notification = $(`
            <div class="notification notification-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : type === 'warning' ? '#ffc107' : '#dc3545'};
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                max-width: 300px;
                word-wrap: break-word;
            ">
                ${message}
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

        // Allow manual close on click
        notification.on('click', function() {
            $(this).fadeOut(300, function() {
                $(this).remove();
            });
        });
    }

    // Wishlist count function is now global in master layout
});
</script>
@endsection
