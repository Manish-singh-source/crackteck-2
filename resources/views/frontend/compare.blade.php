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
                    <span class="body-small"> Compare</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Compare -->
    <div class="tf-sp-2">
        <div class="container">
            @if(count($products) < 2)
                <div class="text-center py-5">
                    <h4>Compare Products</h4>
                    <p class="text-muted">You need at least 2 products to compare. Please add more products to your compare list.</p>
                    <a href="{{ route('shop') }}" class="tf-btn btn-primary">
                        <span class="text-white">Continue Shopping</span>
                    </a>
                </div>
            @else
                <div class="tf-compare">
                    <table class="tf-table-compare">
                        <tbody>
                            <tr class="tf-compare-row row-info">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Product Name</h6>
                                </td>
                                @foreach($products as $product)
                                    {{-- {{ $product}} --}}
                                    <td class="tf-compare-col tf-compare-info">
                                        <div class="compare-item_info">
                                            <a href="{{ route('product.detail', $product->id) }}" class="text-line-clamp-2 body-md-2 fw-semibold text-secondary link">
                                                {{ $product->warehouseProduct->product_name ?? 'Product Name' }}
                                            </a>
                                            <span class="icon">
                                                <i class="icon-close remove link cs-pointer compare-remove-btn" data-product-id="{{ $product->id }}"></i>
                                            </span>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row row-image">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Image</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col tf-compare-image">
                                        <a href="{{ route('product.detail', $product->id) }}" class="image">
                                            <img src="{{ $product->warehouseProduct->main_product_image ? asset($product->warehouseProduct->main_product_image) : asset('frontend-assets/images/placeholder-product.png') }}"
                                                 data-src="{{ $product->warehouseProduct->main_product_image ? asset($product->warehouseProduct->main_product_image) : asset('frontend-assets/images/placeholder-product.png') }}"
                                                 alt="{{ $product->warehouseProduct->product_name ?? 'Product Image' }}" class="lazyload">
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">SKU</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->sku ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Selling Price</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <p class="price-wrap fw-medium flex-nowrap">
                                            @if($product->warehouseProduct->discount_price && $product->warehouseProduct->selling_price > $product->warehouseProduct->discount_price)
                                                <span class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price, 2) }}</span>
                                                <span class="old-price body-md-2 text-main-2 fw-normal">₹{{ number_format($product->warehouseProduct->cost_price, 2) }}</span>
                                            @else
                                                <span class="new-price price-text fw-medium mb-0">₹{{ number_format($product->warehouseProduct->selling_price ?? 0, 2) }}</span>
                                            @endif
                                        </p>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">HSN Code</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->hsn_code ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Brand</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->brand->brand_title ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Model No</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->model_no ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Serial No</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->serial_no ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Category</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->parentCategorie->parent_categories ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Technical Specifications</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span class="text-wrap">{!! $product->warehouseProduct->technical_specification ?? 'N/A' !!}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Brand Warranty</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <span>{{ $product->warehouseProduct->brand_warranty ?? 'N/A' }}</span>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="tf-compare-row">
                                <td class="tf-compare-col">
                                    <h6 class="fw-semibold">Add To Cart</h6>
                                </td>
                                @foreach($products as $product)
                                    <td class="tf-compare-col">
                                        <a href="#;" class="tf-btn btn-gray text-nowrap add-to-cart-btn"
                                           data-product-id="{{ $product->id }}"
                                           data-product-name="{{ $product->warehouseProduct->product_name ?? 'Product' }}">
                                            <span class="text-white">Add To Cart</span>
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <!-- /Compare -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Quantity selector functionality
            $('.btn-quantity-decrease').on('click', function() {
                const input = $(this).siblings('.quantity-input');
                const currentValue = parseInt(input.val());
                const minValue = parseInt(input.attr('min')) || 1;

                if (currentValue > minValue) {
                    input.val(currentValue - 1);
                    updatePriceDisplay();
                }
            });

            $('.btn-quantity-increase').on('click', function() {
                const input = $(this).siblings('.quantity-input');
                const currentValue = parseInt(input.val());
                const maxValue = parseInt(input.attr('max'));

                if (!maxValue || currentValue < maxValue) {
                    input.val(currentValue + 1);
                    updatePriceDisplay();
                }
            });

            $('.quantity-input').on('change', function() {
                const minValue = parseInt($(this).attr('min')) || 1;
                const maxValue = parseInt($(this).attr('max'));
                let currentValue = parseInt($(this).val());

                if (currentValue < minValue) {
                    $(this).val(minValue);
                } else if (maxValue && currentValue > maxValue) {
                    $(this).val(maxValue);
                }

                updatePriceDisplay();
            });

            // Update price display based on quantity
            function updatePriceDisplay() {
                const quantity = parseInt($('.quantity-input').val()) || 1;
                const basePrice = parseFloat($('.current-price').text().replace('₹', '').replace(',', '')) || 0;
                const totalPrice = basePrice * quantity;

                $('.price-display').text('- ₹' + totalPrice.toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }

            // Add to Cart functionality
            $('.add-to-cart-btn, .add-to-cart').on('click', function(e) {
                e.preventDefault();

                const $button = $(this);
                const productId = $button.data('product-id');
                const quantity = $('.quantity-input').val() || 1;

                // Check if user is authenticated
                @guest
                    // Show login modal for unauthenticated users
                    showLoginModal();
                    return;
                @endguest

                // Show loading state
                const originalText = $button.html();
                $button.addClass('text-white');
                $button.html('<i class="spinner-border spinner-border-sm me-2 text-white"></i>Adding...');
                $button.prop('disabled', true);

                // Make AJAX request
                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: {
                        ecommerce_product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');

                            // Update button state
                            $button.html('Added to Cart <i class="icon-cart-2"></i>');
                            $button.addClass('in-cart');
                            $button.addClass('text-white');

                            // Update cart count and sidebar
                            updateCartCount();
                            updateCartSidebar();
                        } else {
                            showNotification(response.message, 'error');
                            // Reset button state
                            $button.html(originalText);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON.requires_auth) {
                            showLoginModal();
                        } else {
                            showNotification('Error adding product to cart. Please try again.', 'error');
                            // Reset button state
                            $button.html(originalText);
                        }
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                    }
                });
            });

            // Buy Now functionality
            $('.buy-now-btn').on('click', function(e) {
                e.preventDefault();

                const productId = $(this).data('product-id');
                const quantity = $('.quantity-input').val() || 1;

                // Show loading state
                const originalText = $(this).html();
                $(this).html('<i class="spinner-border spinner-border-sm me-2"></i>Processing...');
                $(this).prop('disabled', true);

                // Redirect to checkout with buy_now parameters
                const checkoutUrl = '{{ route("checkout") }}' + '?source=buy_now&product_id=' + productId + '&quantity=' + quantity;

                showNotification('Redirecting to checkout...', 'info');

                // Small delay for user feedback, then redirect
                setTimeout(() => {
                    window.location.href = checkoutUrl;
                }, 500);
            });

            // Wishlist functionality
            $('.wishlist-btn').on('click', function(e) {
                e.preventDefault();

                const productId = $(this).data('product-id');
                const $button = $(this);
                const $icon = $button.find('i');
                const $text = $button.find('.wishlist-text');

                // Toggle wishlist state
                if ($button.hasClass('in-wishlist')) {
                    // Remove from wishlist
                    $icon.removeClass('fas').addClass('far');
                    $button.removeClass('in-wishlist btn-danger').addClass('btn-outline-secondary');
                    if ($text.length) {
                        $text.text('Add to Wishlist');
                    }
                    showNotification('Removed from wishlist', 'info');
                } else {
                    // Add to wishlist
                    $icon.removeClass('far').addClass('fas');
                    $button.addClass('in-wishlist btn-danger').removeClass('btn-outline-secondary');
                    if ($text.length) {
                        $text.text('In Wishlist');
                    }
                    showNotification('Added to wishlist!', 'success');
                }
            });

            // Image zoom functionality (if not already implemented)
            $('.tf-image-zoom').on('mouseenter', function() {
                $(this).css('transform', 'scale(1.2)');
            }).on('mouseleave', function() {
                $(this).css('transform', 'scale(1)');
            });

            // Tab switching with URL hash support
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('data-bs-target');
                window.location.hash = target;
            });

            // Load tab from URL hash on page load
            if (window.location.hash) {
                const hash = window.location.hash;
                const tabButton = $('button[data-bs-target="' + hash + '"]');
                if (tabButton.length) {
                    tabButton.tab('show');
                }
            }

            // Smooth scroll to tabs when clicking from external links
            $('.scroll-to-tabs').on('click', function(e) {
                e.preventDefault();
                const target = $(this).attr('href');
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100
                }, 500);
            });

            // Recently viewed products hover effects
            $('.product-card-hover').on('mouseenter', function() {
                $(this).find('.img-hover').css('opacity', '1');
                $(this).find('.img-product').css('opacity', '0');
            }).on('mouseleave', function() {
                $(this).find('.img-hover').css('opacity', '0');
                $(this).find('.img-product').css('opacity', '1');
            });

            // Utility functions
            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = $(`
            <div class="alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                // Add to body
                $('body').append(notification);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.alert('close');
                }, 3000);
            }

            // Cart count function is now global in master layout

            // Initialize tooltips
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Initialize product image gallery swiper if not already done
            if (typeof Swiper !== 'undefined') {
                // Main gallery swiper
                const galleryMain = new Swiper('.tf-product-media-main', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.thumbs-next',
                        prevEl: '.thumbs-prev',
                    },
                    thumbs: {
                        swiper: {
                            el: '.tf-product-media-thumbs',
                            spaceBetween: 10,
                            slidesPerView: 4,
                            freeMode: true,
                            watchSlidesProgress: true,
                        }
                    }
                });

                // Recently viewed products swiper
                const recentlyViewedSwiper = new Swiper('.recently-viewed-products .tf-sw-products', {
                    slidesPerView: 2,
                    spaceBetween: 15,
                    navigation: {
                        nextEl: '.recently-viewed-products .swiper-button-next',
                        prevEl: '.recently-viewed-products .swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 4,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 30,
                        },
                    }
                });
            }
        });

        // Load more reviews functionality
        function loadMoreReviews() {
            // Implement AJAX call to load more reviews
            showNotification('Loading more reviews...', 'info');

            // Simulate loading delay
            setTimeout(() => {
                showNotification('More reviews loaded!', 'success');
            }, 1500);
        }

        // Quick view functionality for recently viewed products
        function quickView(productId) {
            // Implement quick view modal
            showNotification('Opening quick view...', 'info');
        }

        // Cart count function is now global in master layout

        // Function to update cart sidebar
        function updateCartSidebar() {
            $.ajax({
                url: '{{ route("cart.data") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Update cart sidebar content
                        updateCartSidebarContent(response);
                    }
                },
                error: function() {
                    console.log('Error updating cart sidebar');
                }
            });
        }

        // Function to show login modal
        function showLoginModal() {
            // Create and show login modal
            const modalHtml = `
                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Please login to add products to your cart.</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('ecommerce.login') }}" class="btn btn-primary">Login</a>
                                    <a href="{{ route('ecommerce.signup') }}" class="btn btn-outline-primary">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            $('#loginModal').remove();

            // Add modal to body and show
            $('body').append(modalHtml);
            $('#loginModal').modal('show');
        }
    </script>
@endsection
