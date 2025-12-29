/**
 * Product Actions - Cart, Wishlist, Compare Toggle Functionality
 * Handles add/remove toggling with icon state management
 */

(function($) {
    'use strict';

    // Initialize product action buttons on page load
    function initProductActions() {
        checkAllProductStates();
        bindProductActionEvents();
    }

    /**
     * Check initial state of all products on the page
     */
    function checkAllProductStates() {
        const productIds = [];
        
        // Collect all unique product IDs from buttons
        $('.add-to-cart-btn, .add-to-wishlist-btn, .compare-btn').each(function() {
            const productId = $(this).data('product-id');
            if (productId && !productIds.includes(productId)) {
                productIds.push(productId);
            }
        });

        // Check status for each product
        productIds.forEach(function(productId) {
            checkProductStatus(productId);
        });
    }

    /**
     * Check status of a single product (cart, wishlist, compare)
     */
    function checkProductStatus(productId) {
        // Check cart status
        $.ajax({
            url: '/cart/check-status',
            method: 'POST',
            data: { product_id: productId },
            success: function(response) {
                if (response.in_cart) {
                    updateCartButtonState(productId, true);
                }
            }
        });

        // Check wishlist status
        $.ajax({
            url: '/wishlist/check-status',
            method: 'POST',
            data: { ecommerce_product_id: productId },
            success: function(response) {
                if (response.in_wishlist) {
                    updateWishlistButtonState(productId, true);
                }
            }
        });

        // Check compare status
        $.ajax({
            url: '/compare/check-status',
            method: 'POST',
            data: { ecommerce_product_id: productId },
            success: function(response) {
                if (response.in_compare) {
                    updateCompareButtonState(productId, true);
                }
            }
        });
    }

    /**
     * Update cart button state
     */
    function updateCartButtonState(productId, inCart) {
        const $buttons = $(`.add-to-cart-btn[data-product-id="${productId}"]`);
        
        $buttons.each(function() {
            const $button = $(this);
            if (inCart) {
                $button.addClass('in-cart');
                $button.find('.icon').removeClass('icon-cart2').addClass('icon-check');
                $button.find('.tooltip').text('Remove from Cart');
            } else {
                $button.removeClass('in-cart');
                $button.find('.icon').removeClass('icon-check').addClass('icon-cart2');
                $button.find('.tooltip').text('Add to Cart');
            }
        });
    }

    /**
     * Update wishlist button state
     */
    function updateWishlistButtonState(productId, inWishlist) {
        const $buttons = $(`.add-to-wishlist-btn[data-product-id="${productId}"]`);
        
        $buttons.each(function() {
            const $button = $(this);
            const $icon = $button.find('.icon');
            
            if (inWishlist) {
                $button.addClass('in-wishlist');
                $icon.removeClass('icon-heart2').addClass('icon-heart');
                $button.find('.tooltip').text('Remove from Wishlist');
                // Add red color for filled heart
                $button.addClass('text-danger');
            } else {
                $button.removeClass('in-wishlist text-danger');
                $icon.removeClass('icon-heart').addClass('icon-heart2');
                $button.find('.tooltip').text('Add to Wishlist');
            }
        });
    }

    /**
     * Update compare button state
     */
    function updateCompareButtonState(productId, inCompare) {
        const $buttons = $(`.compare-btn[data-product-id="${productId}"]`);
        
        $buttons.each(function() {
            const $button = $(this);
            if (inCompare) {
                $button.addClass('in-compare');
                $button.find('.icon').removeClass('icon-compare1').addClass('icon-check');
                $button.find('.tooltip').text('Remove from Compare');
            } else {
                $button.removeClass('in-compare');
                $button.find('.icon').removeClass('icon-check').addClass('icon-compare1');
                $button.find('.tooltip').text('Compare');
            }
        });
    }

    /**
     * Bind event handlers for product action buttons
     */
    function bindProductActionEvents() {
        // Add to Cart Toggle
        $(document).on('click', '.add-to-cart-btn', handleCartToggle);

        // Add to Wishlist Toggle
        $(document).on('click', '.add-to-wishlist-btn', handleWishlistToggle);

        // Compare Toggle
        $(document).on('click', '.compare-btn', handleCompareToggle);
    }

    /**
     * Handle Add to Cart Toggle
     */
    function handleCartToggle(e) {
        e.preventDefault();

        const $button = $(this);
        const productId = $button.data('product-id');
        const productName = $button.data('product-name');
        const isInCart = $button.hasClass('in-cart');

        // Disable button during request
        $button.prop('disabled', true);
        const originalIcon = $button.find('.icon').attr('class');
        $button.find('.icon').attr('class', 'icon icon-loading');

        $.ajax({
            url: '/cart/toggle',
            method: 'POST',
            data: {
                ecommerce_product_id: productId,
                quantity: 1
            },
            success: function(response) {
                if (response.success) {
                    // Update button state
                    updateCartButtonState(productId, response.action === 'added');

                    // Show notification
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, 'success');
                    }

                    // Update cart count and sidebar
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }
                    if (typeof updateCartSidebar === 'function') {
                        updateCartSidebar();
                    }
                } else {
                    // Restore original state
                    $button.find('.icon').attr('class', originalIcon);
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, 'error');
                    }
                }
            },
            error: function(xhr) {
                // Restore original state
                $button.find('.icon').attr('class', originalIcon);

                if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON.requires_auth) {
                    if (typeof showLoginModal === 'function') {
                        showLoginModal();
                    } else {
                        if (typeof showNotification === 'function') {
                            showNotification('Please login to add items to cart.', 'error');
                        }
                    }
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification('Error updating cart. Please try again.', 'error');
                    }
                }
            },
            complete: function() {
                $button.prop('disabled', false);
            }
        });
    }

    /**
     * Handle Add to Wishlist Toggle
     */
    function handleWishlistToggle(e) {
        e.preventDefault();

        const $button = $(this);
        const productId = $button.data('product-id');
        const productName = $button.data('product-name');
        const isInWishlist = $button.hasClass('in-wishlist');

        // Disable button during request
        $button.prop('disabled', true);
        const originalIcon = $button.find('.icon').attr('class');
        $button.find('.icon').attr('class', 'icon icon-loading');

        $.ajax({
            url: '/wishlist/toggle',
            method: 'POST',
            data: {
                ecommerce_product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Update button state
                    updateWishlistButtonState(productId, response.action === 'added');

                    // Show notification
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, 'success');
                    }

                    // Update wishlist count
                    if (typeof updateWishlistCount === 'function') {
                        updateWishlistCount();
                    }
                } else {
                    // Restore original state
                    $button.find('.icon').attr('class', originalIcon);
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, 'error');
                    }
                }
            },
            error: function(xhr) {
                // Restore original state
                $button.find('.icon').attr('class', originalIcon);

                if (xhr.status === 401 && xhr.responseJSON && xhr.responseJSON.requires_auth) {
                    if (typeof showLoginModal === 'function') {
                        showLoginModal();
                    } else {
                        if (typeof showNotification === 'function') {
                            showNotification('Please login to manage your wishlist.', 'error');
                        }
                    }
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification('Error updating wishlist. Please try again.', 'error');
                    }
                }
            },
            complete: function() {
                $button.prop('disabled', false);
            }
        });
    }

    /**
     * Handle Compare Toggle
     */
    function handleCompareToggle(e) {
        e.preventDefault();

        const $button = $(this);
        const productId = $button.data('product-id');
        const productName = $button.data('product-name');
        const isInCompare = $button.hasClass('in-compare');

        // Disable button during request
        $button.prop('disabled', true);
        const originalIcon = $button.find('.icon').attr('class');
        $button.find('.icon').attr('class', 'icon icon-loading');

        $.ajax({
            url: '/compare/add',
            method: 'POST',
            data: {
                ecommerce_product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Update button state
                    updateCompareButtonState(productId, response.action === 'added');

                    // Show notification
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, 'success');
                    }

                    // Update compare count
                    if (typeof updateCompareCount === 'function') {
                        updateCompareCount();
                    }
                    if (typeof updateCompareSidebar === 'function') {
                        updateCompareSidebar();
                    }
                } else {
                    // Restore original state
                    $button.find('.icon').attr('class', originalIcon);
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, 'error');
                    }
                }
            },
            error: function(xhr) {
                // Restore original state
                $button.find('.icon').attr('class', originalIcon);

                if (typeof showNotification === 'function') {
                    showNotification('Error updating compare list. Please try again.', 'error');
                }
            },
            complete: function() {
                $button.prop('disabled', false);
            }
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        initProductActions();
    });

    // Re-initialize after dynamic content loads (e.g., AJAX product loading)
    window.reinitProductActions = function() {
        checkAllProductStates();
    };

})(jQuery);

