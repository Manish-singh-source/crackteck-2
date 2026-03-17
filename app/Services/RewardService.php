<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Reward;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RewardService
{
    /**
     * Check if customer is eligible for reward based on order
     * Order must be delivered
     */
    public function isEligibleForOrderReward(Order $order, int $customerId): bool
    {
        // Check if customer owns the order
        if ($order->customer_id !== $customerId) {
            return false;
        }

        // Check if order status is delivered
        if ($order->status !== Order::STATUS_DELIVERED) {
            return false;
        }

        // Check if reward already exists for this order
        if (Reward::existsForCustomerOrder($customerId, $order->id)) {
            return false;
        }

        return true;
    }

    /**
     * Check if customer is eligible for reward based on service request
     * Service request must be completed
     */
    public function isEligibleForServiceReward(ServiceRequest $serviceRequest, int $customerId): bool
    {
        // Check if customer owns the service request
        if ($serviceRequest->customer_id !== $customerId) {
            return false;
        }

        // Check if service request status is completed
        // You'll need to adjust this based on your actual status values
        if ($serviceRequest->status !== 'completed') {
            return false;
        }

        // Check if reward already exists for this service request
        if (Reward::existsForCustomerServiceRequest($customerId, $serviceRequest->id)) {
            return false;
        }

        return true;
    }

    /**
     * Get eligible coupons for a customer
     * Filters:
     * - Active status
     * - Valid date range
     * - Not already used by the customer
     * - Not already assigned to the customer
     * - Has not reached total usage limit
     */
    public function getEligibleCoupons(int $customerId): \Illuminate\Database\Eloquent\Collection
    {
        $now = Carbon::today();

        return Coupon::active()
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereNull('start_date')
                        ->orWhere('start_date', '<=', $now);
                })
                ->where(function ($q) use ($now) {
                    $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', $now);
                });
            })
            ->where(function ($query) use ($customerId) {
                // Exclude coupons already used by this customer
                $usedCouponIds = CouponUsage::where('customer_id', $customerId)
                    ->pluck('coupon_id')
                    ->toArray();

                // Exclude coupons already assigned to this customer
                $assignedCouponIds = Reward::where('customer_id', $customerId)
                    ->pluck('coupon_id')
                    ->toArray();

                $excludeIds = array_unique(array_merge($usedCouponIds, $assignedCouponIds));

                if (!empty($excludeIds)) {
                    $query->whereNotIn('id', $excludeIds);
                }
            })
            ->where(function ($query) {
                // Exclude coupons that have reached their total usage limit
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            })
            ->get();
    }

    /**
     * Select a random eligible coupon for a customer
     * Returns null if no eligible coupon found
     */
    public function selectRandomCoupon(int $customerId): ?Coupon
    {
        $eligibleCoupons = $this->getEligibleCoupons($customerId);

        if ($eligibleCoupons->isEmpty()) {
            return null;
        }

        return $eligibleCoupons->random();
    }

    /**
     * Create a reward for an order
     * This is called when customer clicks the reward button
     */
    public function createOrderReward(Order $order, int $customerId): array
    {
        try {
            return DB::transaction(function () use ($order, $customerId) {
                // Validate eligibility
                if (!$this->isEligibleForOrderReward($order, $customerId)) {
                    return [
                        'success' => false,
                        'message' => 'You are not eligible for a reward on this order.',
                    ];
                }

                // Select random coupon
                $coupon = $this->selectRandomCoupon($customerId);

                if (!$coupon) {
                    return [
                        'success' => false,
                        'message' => 'No eligible coupon available at the moment. Please try again later.',
                    ];
                }

                // Check if coupon was already used/assigned by the time we got here (race condition)
                if ($this->isCouponUsedOrAssigned($customerId, $coupon->id)) {
                    // Try to get another coupon
                    $coupon = $this->selectRandomCoupon($customerId);
                    
                    if (!$coupon) {
                        return [
                            'success' => false,
                            'message' => 'No eligible coupon available at the moment. Please try again later.',
                        ];
                    }
                }

                // Create the reward
                $reward = Reward::create([
                    'coupon_id' => $coupon->id,
                    'customer_id' => $customerId,
                    'start_date' => $coupon->start_date,
                    'end_date' => $coupon->end_date,
                    'order_id' => $order->id,
                    'service_request_id' => null,
                    'status' => Reward::STATUS_ACTIVE,
                    'used_order_id' => null,
                    'used_service_request_id' => null,
                    'used_at' => null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Reward claimed successfully!',
                    'reward' => $reward,
                    'coupon' => $coupon,
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error creating order reward: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'customer_id' => $customerId,
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while claiming your reward. Please try again.',
            ];
        }
    }

    /**
     * Create a reward for a service request
     * This is called when customer clicks the reward button
     */
    public function createServiceReward(ServiceRequest $serviceRequest, int $customerId): array
    {
        try {
            return DB::transaction(function () use ($serviceRequest, $customerId) {
                // Validate eligibility
                if (!$this->isEligibleForServiceReward($serviceRequest, $customerId)) {
                    return [
                        'success' => false,
                        'message' => 'You are not eligible for a reward on this service request.',
                    ];
                }

                // Select random coupon
                $coupon = $this->selectRandomCoupon($customerId);

                if (!$coupon) {
                    return [
                        'success' => false,
                        'message' => 'No eligible coupon available at the moment. Please try again later.',
                    ];
                }

                // Check if coupon was already used/assigned by the time we got here (race condition)
                if ($this->isCouponUsedOrAssigned($customerId, $coupon->id)) {
                    // Try to get another coupon
                    $coupon = $this->selectRandomCoupon($customerId);
                    
                    if (!$coupon) {
                        return [
                            'success' => false,
                            'message' => 'No eligible coupon available at the moment. Please try again later.',
                        ];
                    }
                }

                // Create the reward
                $reward = Reward::create([
                    'coupon_id' => $coupon->id,
                    'customer_id' => $customerId,
                    'start_date' => $coupon->start_date,
                    'end_date' => $coupon->end_date,
                    'order_id' => null,
                    'service_request_id' => $serviceRequest->id,
                    'status' => Reward::STATUS_ACTIVE,
                    'used_order_id' => null,
                    'used_service_request_id' => null,
                    'used_at' => null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Reward claimed successfully!',
                    'reward' => $reward,
                    'coupon' => $coupon,
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error creating service reward: ' . $e->getMessage(), [
                'service_request_id' => $serviceRequest->id,
                'customer_id' => $customerId,
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while claiming your reward. Please try again.',
            ];
        }
    }

    /**
     * Check if a coupon has been used or assigned to a customer
     */
    public function isCouponUsedOrAssigned(int $customerId, int $couponId): bool
    {
        // Check in coupon_usages
        $used = CouponUsage::where('customer_id', $customerId)
            ->where('coupon_id', $couponId)
            ->exists();

        if ($used) {
            return true;
        }

        // Check in rewards
        $assigned = Reward::where('customer_id', $customerId)
            ->where('coupon_id', $couponId)
            ->exists();

        return $assigned;
    }

    /**
     * Get reward for an order if it exists
     */
    public function getOrderReward(int $customerId, int $orderId): ?Reward
    {
        return Reward::getForOrder($customerId, $orderId);
    }

    /**
     * Get reward for a service request if it exists
     */
    public function getServiceReward(int $customerId, int $serviceRequestId): ?Reward
    {
        return Reward::getForServiceRequest($customerId, $serviceRequestId);
    }

    /**
     * Sync all rewards status with coupon_usages
     * This should be called periodically or when viewing rewards
     */
    public function syncAllRewardsStatus(): int
    {
        $syncedCount = 0;

        $activeRewards = Reward::active()->get();

        foreach ($activeRewards as $reward) {
            $reward->syncStatusWithCouponUsage();
            if ($reward->status !== Reward::STATUS_ACTIVE) {
                $syncedCount++;
            }
        }

        return $syncedCount;
    }

    /**
     * Mark expired rewards
     * This should be called periodically
     */
    public function markExpiredRewards(): int
    {
        return Reward::active()
            ->where('end_date', '<', Carbon::today())
            ->update(['status' => Reward::STATUS_EXPIRED]);
    }

    /**
     * Get formatted coupon details for display
     */
    public function getCouponDisplayDetails(Coupon $coupon): array
    {
        $details = [
            'code' => $coupon->code,
            'discount_value' => $coupon->formatted_discount,
            'discount_type' => $coupon->type,
            'min_purchase_amount' => $coupon->min_purchase_amount,
            'max_discount' => $coupon->max_discount,
        ];

        // Get category names
        if (!empty($coupon->applicable_categories)) {
            $categoryIds = $coupon->applicable_categories;
            $categories = \App\Models\ParentCategory::whereIn('id', $categoryIds)->pluck('name')->toArray();
            $details['applicable_categories'] = $categories;
        }

        // Get brand names
        if (!empty($coupon->applicable_brands)) {
            $brandIds = $coupon->applicable_brands;
            $brands = \App\Models\Brand::whereIn('id', $brandIds)->pluck('name')->toArray();
            $details['applicable_brands'] = $brands;
        }

        // Get excluded product names - try ecommerce_products first, then fallback to products
        if (!empty($coupon->excluded_products)) {
            $productIds = $coupon->excluded_products;
            
            // Try to get from ecommerce_products table
            $excludedProducts = \App\Models\EcommerceProduct::whereIn('id', $productIds)
                ->get()
                ->map(function($product) {
                    // Try to get name from related Product model
                    if ($product->warehouseProduct) {
                        return $product->warehouseProduct->product_name;
                    }
                    return 'Product #' . $product->id;
                })
                ->toArray();
            
            $details['excluded_products'] = $excludedProducts;
        }

        return $details;
    }
}
