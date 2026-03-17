<!-- Reward Modal -->
<div class="modal fade" id="rewardModal" tabindex="-1" aria-labelledby="rewardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <!-- Success Content (shown after claiming) -->
                <div id="rewardSuccessContent" style="display: none;">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" viewBox="0 0 256 256">
                            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,109.66Z"></path>
                        </svg>
                    </div>
                    <h4 class="text-success mb-2">Congratulations!</h4>
                    <p class="text-muted mb-4">You have successfully claimed your reward coupon!</p>
                    
                    <div class="reward-coupon-display bg-light rounded p-4 mb-4">
                        <div class="mb-3">
                            <span class="text-muted small">Coupon Code</span>
                            <h3 class="fw-bold text-primary mb-0" id="rewardCouponCode"></h3>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-success fs-6" id="rewardDiscountValue"></span>
                        </div>
                        
                        <!-- Coupon Details -->
                        <div class="text-start mt-4">
                            <h6 class="fw-bold mb-3">Coupon Details</h6>
                            
                            <!-- Minimum Purchase -->
                            <div class="d-flex justify-content-between mb-2" id="rewardMinPurchaseRow">
                                <span class="text-muted">Minimum Purchase:</span>
                                <span class="fw-bold" id="rewardMinPurchase"></span>
                            </div>
                            
                            <!-- Maximum Discount -->
                            <div class="d-flex justify-content-between mb-2" id="rewardMaxDiscountRow">
                                <span class="text-muted">Maximum Discount:</span>
                                <span class="fw-bold" id="rewardMaxDiscount"></span>
                            </div>
                            
                            <!-- Applicable Categories -->
                            <div class="mb-2" id="rewardCategoriesRow">
                                <span class="text-muted d-block mb-1">Applicable Categories:</span>
                                <div id="rewardCategories"></div>
                            </div>
                            
                            <!-- Applicable Brands -->
                            <div class="mb-2" id="rewardBrandsRow">
                                <span class="text-muted d-block mb-1">Applicable Brands:</span>
                                <div id="rewardBrands"></div>
                            </div>
                            
                            <!-- Excluded Products -->
                            <div class="mb-2" id="rewardExcludedRow">
                                <span class="text-muted d-block mb-1">Excluded Products:</span>
                                <div id="rewardExcludedProducts"></div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-muted small mb-0">
                        Use this coupon on your next order to avail the discount. 
                        Valid for future purchases only.
                    </p>
                </div>
                
                <!-- Error Content -->
                <div id="rewardErrorContent" style="display: none;">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#dc3545" viewBox="0 0 256 256">
                            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
                        </svg>
                    </div>
                    <h4 class="text-danger mb-2">Oops!</h4>
                    <p class="text-muted mb-0" id="rewardErrorMessage"></p>
                </div>
                
                <!-- Loading Content -->
                <div id="rewardLoadingContent">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Claiming your reward...</p>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="rewardCloseBtn" style="display: none;">Close</button>
                <button type="button" class="btn btn-primary" id="rewardClaimBtn">Claim Your Reward</button>
            </div>
        </div>
    </div>
</div>
