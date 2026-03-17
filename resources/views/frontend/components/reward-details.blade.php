<!-- Reward Details Section -->
<div class="reward-details-section mt-4" id="rewardDetailsSection">
    <div class="card border-success">
        <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <i class="icon icon-gift me-2"></i>Your Reward
            </h5>
            <span class="badge bg-light text-success" id="rewardStatusBadge">
                @if($reward->status === 'active')
                    Active
                @elseif($reward->status === 'used')
                    Used
                @elseif($reward->status === 'expired')
                    Expired
                @endif
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="reward-coupon-display bg-light rounded p-4 h-100">
                        <div class="mb-3">
                            <span class="text-muted small">Coupon Code</span>
                            <h3 class="fw-bold text-primary mb-0">{{ $coupon->code }}</h3>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-success fs-6">
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->discount_value }}% OFF
                                @else
                                    ₹{{ number_format($coupon->discount_value, 2) }} OFF
                                @endif
                            </span>
                        </div>
                        
                        <!-- Coupon Details -->
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Coupon Details</h6>
                            
                            <!-- Minimum Purchase -->
                            @if($coupon->min_purchase_amount)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Minimum Purchase:</span>
                                <span class="fw-bold">₹{{ number_format($coupon->min_purchase_amount, 2) }}</span>
                            </div>
                            @endif
                            
                            <!-- Maximum Discount -->
                            @if($coupon->max_discount)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Maximum Discount:</span>
                                <span class="fw-bold">₹{{ number_format($coupon->max_discount, 2) }}</span>
                            </div>
                            @endif
                            
                            <!-- Applicable Categories -->
                            @if(!empty($coupon->applicable_categories))
                            <div class="mb-2">
                                <span class="text-muted d-block mb-1">Applicable Categories:</span>
                                @php
                                    $categoryIds = is_array($coupon->applicable_categories) ? $coupon->applicable_categories : json_decode($coupon->applicable_categories, true);
                                    $categories = \App\Models\ParentCategory::whereIn('id', $categoryIds)->pluck('name')->toArray();
                                @endphp
                                @foreach($categories as $category)
                                    <span class="badge bg-info me-1">{{ $category }}</span>
                                @endforeach
                            </div>
                            @endif
                            
                            <!-- Applicable Brands -->
                            @if(!empty($coupon->applicable_brands))
                            <div class="mb-2">
                                <span class="text-muted d-block mb-1">Applicable Brands:</span>
                                @php
                                    $brandIds = is_array($coupon->applicable_brands) ? $coupon->applicable_brands : json_decode($coupon->applicable_brands, true);
                                    $brands = \App\Models\Brand::whereIn('id', $brandIds)->pluck('name')->toArray();
                                @endphp
                                @foreach($brands as $brand)
                                    <span class="badge bg-warning text-dark me-1">{{ $brand }}</span>
                                @endforeach
                            </div>
                            @endif
                            
                            <!-- Excluded Products -->
                            @if(!empty($coupon->excluded_products))
                            <div class="mb-2">
                                <span class="text-muted d-block mb-1">Excluded Products:</span>
                                @php
                                    $productIds = is_array($coupon->excluded_products) ? $coupon->excluded_products : json_decode($coupon->excluded_products, true);
                                    $excludedProducts = \App\Models\EcommerceProduct::whereIn('id', $productIds)->get()
                                        ->map(function($product) {
                                            if ($product->warehouseProduct) {
                                                return $product->warehouseProduct->product_name;
                                            }
                                            return 'Product #' . $product->id;
                                        })
                                        ->take(5)
                                        ->toArray();
                                @endphp
                                @foreach($excludedProducts as $product)
                                    <span class="badge bg-danger me-1">{{ $product }}</span>
                                @endforeach
                                @if(count($productIds) > 5)
                                    <span class="text-muted small">+{{ count($productIds) - 5 }} more</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="h-100 d-flex flex-column justify-content-center">
                        <div class="text-center mb-4">
                            <div class="reward-status-icon mb-3">
                                @if($reward->status === 'active')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" viewBox="0 0 256 256">
                                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,109.66Z"></path>
                                    </svg>
                                @elseif($reward->status === 'used')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#6c757d" viewBox="0 0 256 256">
                                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#dc3545" viewBox="0 0 256 256">
                                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
                                    </svg>
                                @endif
                            </div>
                            @if($reward->status === 'active')
                                <h5 class="text-success">Your reward is active!</h5>
                                <p class="text-muted mb-0">Use this coupon on your next order to avail the discount.</p>
                            @elseif($reward->status === 'used')
                                <h5 class="text-muted">This reward has been used</h5>
                                <p class="text-muted mb-0">Thank you for using your reward coupon.</p>
                            @else
                                <h5 class="text-danger">This reward has expired</h5>
                                <p class="text-muted mb-0">The validity period of this coupon has ended.</p>
                            @endif
                        </div>
                        
                        @if($reward->status === 'active' && $reward->end_date)
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="text-center">
                                <span class="text-muted d-block">Valid Until</span>
                                <strong class="text-danger">{{ \App\Helpers\DateFormat::formatDate($reward->end_date) }}</strong>
                            </div>
                        </div>
                        @endif
                        
                        @if($reward->used_at)
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="text-center">
                                <span class="text-muted d-block">Used On</span>
                                <strong>{{ $reward->used_at->format('F j, Y') }}</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
