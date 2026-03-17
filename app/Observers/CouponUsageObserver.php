<?php

namespace App\Observers;

use App\Models\CouponUsage;
use App\Models\Reward;
use Illuminate\Support\Facades\Log;

class CouponUsageObserver
{
    /**
     * Handle the CouponUsage "created" event.
     * When a coupon is used, update the corresponding reward status to 'used'
     */
    public function created(CouponUsage $couponUsage): void
    {
        try {
            // Find the reward for this customer and coupon
            $reward = Reward::where('coupon_id', $couponUsage->coupon_id)
                ->where('customer_id', $couponUsage->customer_id)
                ->where('status', Reward::STATUS_ACTIVE)
                ->first();

            if ($reward) {
                // Update the reward status to used
                $reward->markAsUsed(
                    $couponUsage->order_id,
                    null // Will be null for order usage
                );

                Log::info('Reward status updated to used', [
                    'reward_id' => $reward->id,
                    'coupon_id' => $couponUsage->coupon_id,
                    'customer_id' => $couponUsage->customer_id,
                    'order_id' => $couponUsage->order_id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating reward status on coupon usage: ' . $e->getMessage(), [
                'coupon_usage_id' => $couponUsage->id,
                'coupon_id' => $couponUsage->coupon_id,
                'customer_id' => $couponUsage->customer_id,
            ]);
        }
    }

    /**
     * Handle the CouponUsage "deleted" event.
     * If a coupon usage is deleted, we may need to revert the reward status
     * Note: This is optional and depends on business logic
     */
    public function deleted(CouponUsage $couponUsage): void
    {
        try {
            // Find the reward for this customer and coupon
            $reward = Reward::where('coupon_id', $couponUsage->coupon_id)
                ->where('customer_id', $couponUsage->customer_id)
                ->where('status', Reward::STATUS_USED)
                ->first();

            if ($reward) {
                // Check if there are any other usages for this coupon by this customer
                $otherUsages = CouponUsage::where('coupon_id', $couponUsage->coupon_id)
                    ->where('customer_id', $couponUsage->customer_id)
                    ->count();

                if ($otherUsages === 0) {
                    // Revert to active if no other usages exist
                    $reward->status = Reward::STATUS_ACTIVE;
                    $reward->used_order_id = null;
                    $reward->used_service_request_id = null;
                    $reward->used_at = null;
                    $reward->save();

                    Log::info('Reward status reverted to active after coupon usage deletion', [
                        'reward_id' => $reward->id,
                        'coupon_id' => $couponUsage->coupon_id,
                        'customer_id' => $couponUsage->customer_id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error reverting reward status on coupon usage deletion: ' . $e->getMessage(), [
                'coupon_usage_id' => $couponUsage->id,
                'coupon_id' => $couponUsage->coupon_id,
                'customer_id' => $couponUsage->customer_id,
            ]);
        }
    }
}
