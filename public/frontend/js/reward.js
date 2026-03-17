/**
 * Reward System JavaScript
 * Handles reward button click, AJAX calls, and modal behavior
 */

$(document).ready(function() {
    // Check eligibility on page load
    checkRewardEligibility();
    
    // Handle reward claim button click
    $('#rewardClaimBtn').on('click', function() {
        claimReward();
    });
    
    // Handle modal close - refresh page after close if reward was claimed
    $('#rewardModal').on('hidden.bs.modal', function() {
        if (window.rewardClaimed) {
            window.location.reload();
        }
    });
});

/**
 * Check if customer is eligible for reward
 */
function checkRewardEligibility() {
    const orderId = window.orderId;
    const rewardType = window.rewardType || 'order';
    
    if (!orderId) {
        console.log('No order ID found');
        return;
    }
    
    const url = rewardType === 'order' 
        ? '/reward/check-order-eligibility' 
        : '/reward/check-service-eligibility';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            order_id: orderId,
            service_request_id: orderId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                if (response.has_reward) {
                    // Reward already claimed, show details section
                    $('#rewardButtonSection').hide();
                    loadRewardDetails(orderId, rewardType);
                } else if (response.eligible) {
                    // Show reward button
                    $('#rewardButtonSection').show();
                    $('#rewardDetailsSection').hide();
                } else {
                    // Not eligible, hide reward button
                    $('#rewardButtonSection').hide();
                    $('#rewardDetailsSection').hide();
                }
            }
        },
        error: function(xhr) {
            console.log('Error checking eligibility:', xhr);
            $('#rewardButtonSection').hide();
        }
    });
}

/**
 * Load reward details for display
 */
function loadRewardDetails(id, type) {
    const url = type === 'order' 
        ? '/reward/order-details' 
        : '/reward/service-details';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            order_id: id,
            service_request_id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                displayRewardDetails(response.reward, response.coupon);
            }
        },
        error: function(xhr) {
            console.log('Error loading reward details:', xhr);
        }
    });
}

/**
 * Display reward details in the section
 */
function displayRewardDetails(reward, coupon) {
    const detailsHtml = `
        <div class="reward-details-section mt-4" id="rewardDetailsSection">
            <div class="card border-success">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="icon icon-gift me-2"></i>Your Reward
                    </h5>
                    <span class="badge bg-light text-success">${reward.status.charAt(0).toUpperCase() + reward.status.slice(1)}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="reward-coupon-display bg-light rounded p-4 h-100">
                                <div class="mb-3">
                                    <span class="text-muted small">Coupon Code</span>
                                    <h3 class="fw-bold text-primary mb-0">${coupon.code}</h3>
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-success fs-6">${coupon.discount_value} OFF</span>
                                </div>
                                
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Coupon Details</h6>
                                    
                                    ${coupon.min_purchase_amount ? `
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Minimum Purchase:</span>
                                        <span class="fw-bold">₹${parseFloat(coupon.min_purchase_amount).toFixed(2)}</span>
                                    </div>
                                    ` : ''}
                                    
                                    ${coupon.max_discount ? `
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Maximum Discount:</span>
                                        <span class="fw-bold">₹${parseFloat(coupon.max_discount).toFixed(2)}</span>
                                    </div>
                                    ` : ''}
                                    
                                    ${coupon.applicable_categories && coupon.applicable_categories.length ? `
                                    <div class="mb-2">
                                        <span class="text-muted d-block mb-1">Applicable Categories:</span>
                                        ${coupon.applicable_categories.map(cat => `<span class="badge bg-info me-1">${cat}</span>`).join('')}
                                    </div>
                                    ` : ''}
                                    
                                    ${coupon.applicable_brands && coupon.applicable_brands.length ? `
                                    <div class="mb-2">
                                        <span class="text-muted d-block mb-1">Applicable Brands:</span>
                                        ${coupon.applicable_brands.map(brand => `<span class="badge bg-warning text-dark me-1">${brand}</span>`).join('')}
                                    </div>
                                    ` : ''}
                                    
                                    ${coupon.excluded_products && coupon.excluded_products.length ? `
                                    <div class="mb-2">
                                        <span class="text-muted d-block mb-1">Excluded Products:</span>
                                        ${coupon.excluded_products.map(prod => `<span class="badge bg-danger me-1">${prod}</span>`).join('')}
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <div class="text-center mb-4">
                                    <div class="reward-status-icon mb-3">
                                        ${getStatusIcon(reward.status)}
                                    </div>
                                    <h5 class="${reward.status === 'active' ? 'text-success' : reward.status === 'used' ? 'text-muted' : 'text-danger'}">
                                        ${getStatusMessage(reward.status)}
                                    </h5>
                                    <p class="text-muted mb-0">${getStatusDescription(reward.status)}</p>
                                </div>
                                
                                ${reward.status === 'active' && reward.end_date ? `
                                <div class="mt-3 p-3 bg-light rounded">
                                    <div class="text-center">
                                        <span class="text-muted d-block">Valid Until</span>
                                        <strong class="text-danger">${formatDate(reward.end_date)}</strong>
                                    </div>
                                </div>
                                ` : ''}
                                
                                ${reward.used_at ? `
                                <div class="mt-3 p-3 bg-light rounded">
                                    <div class="text-center">
                                        <span class="text-muted d-block">Used On</span>
                                        <strong>${formatDate(reward.used_at)}</strong>
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#rewardDetailsContainer').html(detailsHtml).show();
    $('#rewardButtonSection').hide();
}

/**
 * Get status icon SVG
 */
function getStatusIcon(status) {
    if (status === 'active') {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" viewBox="0 0 256 256">
            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,109.66Z"></path>
        </svg>`;
    } else if (status === 'used') {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#6c757d" viewBox="0 0 256 256">
            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
        </svg>`;
    } else {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#dc3545" viewBox="0 0 256 256">
            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
        </svg>`;
    }
}

/**
 * Get status message
 */
function getStatusMessage(status) {
    if (status === 'active') return 'Your reward is active!';
    if (status === 'used') return 'This reward has been used';
    return 'This reward has expired';
}

/**
 * Get status description
 */
function getStatusDescription(status) {
    if (status === 'active') return 'Use this coupon on your next order to avail the discount.';
    if (status === 'used') return 'Thank you for using your reward coupon.';
    return 'The validity period of this coupon has ended.';
}

/**
 * Format date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

/**
 * Claim reward
 */
function claimReward() {
    const orderId = window.orderId;
    const rewardType = window.rewardType || 'order';
    
    if (!orderId) {
        showError('Invalid request. Please try again.');
        return;
    }
    
    const url = rewardType === 'order' 
        ? '/reward/claim-order' 
        : '/reward/claim-service';
    
    // Show loading state
    showLoading();
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            order_id: orderId,
            service_request_id: orderId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                window.rewardClaimed = true;
                showSuccess(response.coupon);
            } else {
                showError(response.message || 'Failed to claim reward. Please try again.');
            }
        },
        error: function(xhr) {
            let message = 'An error occurred. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            showError(message);
        }
    });
}

/**
 * Show loading state in modal
 */
function showLoading() {
    $('#rewardLoadingContent').show();
    $('#rewardSuccessContent').hide();
    $('#rewardErrorContent').hide();
    $('#rewardClaimBtn').hide();
    $('#rewardCloseBtn').hide();
}

/**
 * Show success state in modal
 */
function showSuccess(coupon) {
    $('#rewardLoadingContent').hide();
    $('#rewardSuccessContent').show();
    $('#rewardErrorContent').hide();
    $('#rewardClaimBtn').hide();
    $('#rewardCloseBtn').show();
    
    // Populate coupon details
    $('#rewardCouponCode').text(coupon.code);
    $('#rewardDiscountValue').text(coupon.discount_value + (coupon.discount_type === 'percentage' ? '% OFF' : ' OFF'));
    
    // Minimum purchase
    if (coupon.min_purchase_amount) {
        $('#rewardMinPurchaseRow').show();
        $('#rewardMinPurchase').text('₹' + parseFloat(coupon.min_purchase_amount).toFixed(2));
    } else {
        $('#rewardMinPurchaseRow').hide();
    }
    
    // Maximum discount
    if (coupon.max_discount) {
        $('#rewardMaxDiscountRow').show();
        $('#rewardMaxDiscount').text('₹' + parseFloat(coupon.max_discount).toFixed(2));
    } else {
        $('#rewardMaxDiscountRow').hide();
    }
    
    // Categories
    if (coupon.applicable_categories && coupon.applicable_categories.length) {
        $('#rewardCategoriesRow').show();
        $('#rewardCategories').html(coupon.applicable_categories.map(cat => `<span class="badge bg-info me-1">${cat}</span>`).join(''));
    } else {
        $('#rewardCategoriesRow').hide();
    }
    
    // Brands
    if (coupon.applicable_brands && coupon.applicable_brands.length) {
        $('#rewardBrandsRow').show();
        $('#rewardBrands').html(coupon.applicable_brands.map(brand => `<span class="badge bg-warning text-dark me-1">${brand}</span>`).join(''));
    } else {
        $('#rewardBrandsRow').hide();
    }
    
    // Excluded products
    if (coupon.excluded_products && coupon.excluded_products.length) {
        $('#rewardExcludedRow').show();
        $('#rewardExcludedProducts').html(coupon.excluded_products.map(prod => `<span class="badge bg-danger me-1">${prod}</span>`).join(''));
    } else {
        $('#rewardExcludedRow').hide();
    }
}

/**
 * Show error state in modal
 */
function showError(message) {
    $('#rewardLoadingContent').hide();
    $('#rewardSuccessContent').hide();
    $('#rewardErrorContent').show();
    $('#rewardClaimBtn').hide();
    $('#rewardCloseBtn').show();
    $('#rewardErrorMessage').text(message);
}
