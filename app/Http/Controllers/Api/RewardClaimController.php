<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\Reward;
use App\Models\Brand;
use App\Models\ParentCategory;
use App\Models\SubCategory;
use App\Models\EcommerceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RewardClaimController extends Controller
{
    /**
     * Eligible order statuses for reward claim
     */
    const ELIGIBLE_STATUSES = ['delivered'];

    /**
     * Claim reward coupon for an order
     * POST /api/orders/{id}/claim-reward
     */
    public function claimReward(Request $request, $order_id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:customers,id',
            'role_id' => 'required|in:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $customerId = $request->user_id;

        // Find the order
        $order = Order::find($order_id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        // Verify order belongs to authenticated customer
        if ($order->customer_id != $customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this order.'
            ], 403);
        }

        // Check if reward already exists for this order
        $existingReward = Reward::where('customer_id', $customerId)
            ->where('order_id', $order_id)
            ->first();

        if ($existingReward) {
            // Return existing reward details
            return $this->returnExistingReward($existingReward);
        }

        // Check if order status is eligible for reward
        if (!in_array($order->status, self::ELIGIBLE_STATUSES)) {
            return response()->json([
                'success' => false,
                'message' => 'Order is not eligible for reward. Order must be delivered.',
                'order_status' => $order->status,
                'eligible_statuses' => self::ELIGIBLE_STATUSES
            ], 400);
        }

        // Find a valid coupon for the customer
        $coupon = $this->findValidCouponForCustomer($customerId);

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'No valid coupon available for reward at this time. Please try again later.'
            ], 400);
        }

        // Create reward record
        try {
            $reward = DB::transaction(function () use ($coupon, $customerId, $order_id) {
                $reward = Reward::create([
                    'coupon_id' => $coupon->id,
                    'customer_id' => $customerId,
                    'order_id' => $order_id,
                    'service_request_id' => null,
                    'start_date' => $coupon->start_date,
                    'end_date' => $coupon->end_date,
                    'status' => Reward::STATUS_ACTIVE,
                ]);

                return $reward;
            });

            return $this->returnNewReward($reward);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create reward. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Find a valid random coupon for the customer
     * Checks:
     * 1. Coupon is active
     * 2. Coupon is within valid date range
     * 3. Coupon usage limit not exhausted
     * 4. Coupon not already used by customer in coupon_usages
     * 5. Coupon not already assigned to customer in rewards
     */
    private function findValidCouponForCustomer(int $customerId): ?Coupon
    {
        $now = Carbon::now();

        // Get all active coupons within valid date range and not exhausted
        $availableCoupons = Coupon::where('status', 'active')
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            })
            ->get();

        if ($availableCoupons->isEmpty()) {
            return null;
        }

        // Filter out coupons already used or assigned to this customer
        $validCoupons = $availableCoupons->filter(function ($coupon) use ($customerId) {
            // Check if already used by customer in coupon_usages
            $usedInUsages = CouponUsage::where('coupon_id', $coupon->id)
                ->where('customer_id', $customerId)
                ->exists();

            if ($usedInUsages) {
                return false;
            }

            // Check if already assigned to customer in rewards
            $assignedInRewards = Reward::where('coupon_id', $coupon->id)
                ->where('customer_id', $customerId)
                ->exists();

            if ($assignedInRewards) {
                return false;
            }

            // Check usage per customer limit
            if ($coupon->usage_per_customer && $coupon->usage_per_customer > 0) {
                $userUsageCount = CouponUsage::where('coupon_id', $coupon->id)
                    ->where('customer_id', $customerId)
                    ->count();

                if ($userUsageCount >= $coupon->usage_per_customer) {
                    return false;
                }
            }

            return true;
        });

        if ($validCoupons->isEmpty()) {
            return null;
        }

        // Randomly select a coupon
        return $validCoupons->random();
    }

    /**
     * Return newly created reward details
     */
    private function returnNewReward(Reward $reward)
    {
        $coupon = $reward->coupon;

        return response()->json([
            'success' => true,
            'message' => 'Reward claimed successfully!',
            'order_id' => $reward->order_id,
            'reward_claimed' => true,
            'reward_details' => [
                'reward_id' => $reward->id,
                'customer_id' => $reward->customer_id,
                'order_id' => $reward->order_id,
                'service_request_id' => $reward->service_request_id,
                'reward_status' => $reward->status,
                'reward_start_date' => $reward->start_date,
                'reward_end_date' => $reward->end_date,
                'used_at' => $reward->used_at,
                'used_order_id' => $reward->used_order_id,
                'used_service_request_id' => $reward->used_service_request_id,
                'created_at' => $reward->created_at,
            ],
            'coupon_details' => [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'title' => $coupon->title,
                'description' => $coupon->description,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->discount_value,
                'min_purchase_amount' => $coupon->min_purchase_amount,
                'start_date' => $coupon->start_date,
                'end_date' => $coupon->end_date,
                'usage_limit' => $coupon->usage_limit,
                'used_count' => $coupon->used_count,
                'usage_per_customer' => $coupon->usage_per_customer,
                'status' => $coupon->status,
                // 'applicable_categories' => $this->getApplicableCategoriesData($coupon),
                // 'applicable_brands' => $this->getApplicableBrandsData($coupon),
                // 'excluded_products' => $this->getExcludedProductsData($coupon),
            ]
        ], 200);
    }

    /**
     * Get applicable categories with full data
     */
    private function getApplicableCategoriesData(Coupon $coupon): array
    {
        $categoryIds = $coupon->applicable_categories ?? [];
        
        if (empty($categoryIds)) {
            return [];
        }
        
        $categories = [];
        
        foreach ($categoryIds as $id) {
            // Try to find in ParentCategory first
            $parentCategory = ParentCategory::find($id);
            if ($parentCategory) {
                $categories[] = [
                    'id' => $parentCategory->id,
                    'type' => 'parent_category',
                    'name' => $parentCategory->name,
                    'slug' => $parentCategory->slug,
                ];
                continue;
            }
            
            // Try to find in SubCategory
            $subCategory = SubCategory::find($id);
            if ($subCategory) {
                $categories[] = [
                    'id' => $subCategory->id,
                    'type' => 'sub_category',
                    'name' => $subCategory->name,
                    'slug' => $subCategory->slug,
                    'parent_category_id' => $subCategory->parent_category_id,
                ];
            }
        }
        
        return $categories;
    }

    /**
     * Get applicable brands with full data
     */
    private function getApplicableBrandsData(Coupon $coupon): array
    {
        $brandIds = $coupon->applicable_brands ?? [];
        
        if (empty($brandIds)) {
            return [];
        }
        
        $brands = Brand::whereIn('id', $brandIds)->get(['id', 'name', 'slug']);
        
        return $brands->toArray();
    }

    /**
     * Get excluded products with full data
     */
    private function getExcludedProductsData(Coupon $coupon): array
    {
        $productIds = $coupon->excluded_products ?? [];
        
        if (empty($productIds)) {
            return [];
        }
        
        $products = EcommerceProduct::whereIn('id', $productIds)
            ->with(['warehouseProduct:id,product_name,sku,brand_id,parent_category_id,sub_category_id'])
            ->get(['id', 'sku', 'product_id']);
        
        $result = [];
        foreach ($products as $product) {
            $item = [
                'id' => $product->id,
                'sku' => $product->sku,
                'product_id' => $product->product_id,
            ];
            
            if ($product->warehouseProduct) {
                $item['product_name'] = $product->warehouseProduct->product_name;
                $item['brand_id'] = $product->warehouseProduct->brand_id;
                $item['parent_category_id'] = $product->warehouseProduct->parent_category_id;
                $item['sub_category_id'] = $product->warehouseProduct->sub_category_id;
            }
            
            $result[] = $item;
        }
        
        return $result;
    }

    /**
     * Return existing reward details
     */
    private function returnExistingReward(Reward $reward)
    {
        $coupon = $reward->coupon;

        return response()->json([
            'success' => true,
            'message' => 'Reward already claimed for this order.',
            'order_id' => $reward->order_id,
            'reward_claimed' => true,
            'reward_details' => [
                'reward_id' => $reward->id,
                'customer_id' => $reward->customer_id,
                'order_id' => $reward->order_id,
                'service_request_id' => $reward->service_request_id,
                'reward_status' => $reward->status,
                'reward_start_date' => $reward->start_date,
                'reward_end_date' => $reward->end_date,
                'used_at' => $reward->used_at,
                'used_order_id' => $reward->used_order_id,
                'used_service_request_id' => $reward->used_service_request_id,
                'created_at' => $reward->created_at,
            ],
            'coupon_details' => [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'title' => $coupon->title,
                'description' => $coupon->description,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->discount_value,
                'min_purchase_amount' => $coupon->min_purchase_amount,
                'start_date' => $coupon->start_date,
                'end_date' => $coupon->end_date,
                'usage_limit' => $coupon->usage_limit,
                'used_count' => $coupon->used_count,
                'usage_per_customer' => $coupon->usage_per_customer,
                'status' => $coupon->status,
                'applicable_categories' => $this->getApplicableCategoriesData($coupon),
                'applicable_brands' => $this->getApplicableBrandsData($coupon),
                'excluded_products' => $this->getExcludedProductsData($coupon),
            ]
        ], 200);
    }

    /**
     * Check if reward is available for an order
     */
    public function checkRewardAvailability(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:customers,id',
            'role_id' => 'required|in:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $customerId = $request->user_id;

        // Find the order
        $order = Order::find($order_id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        // Verify order belongs to authenticated customer
        if ($order->customer_id != $customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this order.'
            ], 403);
        }

        // Check if reward already exists
        $existingReward = Reward::where('customer_id', $customerId)
            ->where('order_id', $order_id)
            ->first();

        // Check if order status is eligible
        $isEligible = in_array($order->status, self::ELIGIBLE_STATUSES);

        // Check if any valid coupon is available
        $couponAvailable = $this->findValidCouponForCustomer($customerId) !== null;

        return response()->json([
            'success' => true,
            'order_id' => $order_id,
            'order_status' => $order->status,
            'reward_available' => $isEligible && $couponAvailable,
            'reward_claimed' => $existingReward !== null,
            'reward_id' => $existingReward?->id,
            'eligible_statuses' => self::ELIGIBLE_STATUSES,
            'message' => $existingReward 
                ? 'Reward already claimed for this order.'
                : ($isEligible 
                    ? ($couponAvailable ? 'Reward is available to claim.' : 'Order eligible but no coupon available.')
                    : 'Order is not eligible for reward.')
        ], 200);
    }

    /**
     * Get all rewards for a customer
     * GET /api/rewards
     */
    public function listRewards(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:customers,id',
            'role_id' => 'required|in:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $customerId = $request->user_id;

        // Get all rewards for this customer with coupon details
        $rewards = Reward::with('coupon')
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        $rewardsList = [];
        
        foreach ($rewards as $reward) {
            $coupon = $reward->coupon;
            
            $rewardItem = [
                'reward_id' => $reward->id,
                'order_id' => $reward->order_id,
                'service_request_id' => $reward->service_request_id,
                'reward_status' => $reward->status,
                'reward_start_date' => $reward->start_date,
                'reward_end_date' => $reward->end_date,
                'used_at' => $reward->used_at,
                'used_order_id' => $reward->used_order_id,
                'used_service_request_id' => $reward->used_service_request_id,
                'created_at' => $reward->created_at,
            ];
            
            if ($coupon) {
                $rewardItem['coupon_details'] = [
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $coupon->code,
                    'title' => $coupon->title,
                    'description' => $coupon->description,
                    'discount_type' => $coupon->type,
                    'discount_value' => $coupon->discount_value,
                    'min_purchase_amount' => $coupon->min_purchase_amount,
                    'start_date' => $coupon->start_date,
                    'end_date' => $coupon->end_date,
                    'usage_limit' => $coupon->usage_limit,
                    'used_count' => $coupon->used_count,
                    'usage_per_customer' => $coupon->usage_per_customer,
                    'status' => $coupon->status,
                    'applicable_categories' => $this->getApplicableCategoriesData($coupon),
                    'applicable_brands' => $this->getApplicableBrandsData($coupon),
                    'excluded_products' => $this->getExcludedProductsData($coupon),
                ];
            }
            
            $rewardsList[] = $rewardItem;
        }

        return response()->json([
            'success' => true,
            'total_rewards' => $rewards->count(),
            'rewards' => $rewardsList,
        ], 200);
    }
}
