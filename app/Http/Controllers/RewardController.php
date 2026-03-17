<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Reward;
use App\Models\ServiceRequest;
use App\Services\RewardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RewardController extends Controller
{
    protected $rewardService;

    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    /**
     * Get the authenticated customer
     */
    protected function getCustomer()
    {
        return Auth::guard('customer_web')->user();
    }

    /**
     * Check if customer is authenticated
     */
    protected function isAuthenticated(): bool
    {
        return Auth::guard('customer_web')->check();
    }

    /**
     * Claim reward for an order
     * This is called via AJAX when customer clicks the reward button
     */
    public function claimOrderReward(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to claim your reward.',
            ], 401);
        }

        $customer = $this->getCustomer();

        // Validate request
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        // Verify ownership
        if ($order->customer_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to claim a reward for this order.',
            ], 403);
        }

        // Check if order is delivered
        if ($order->status !== Order::STATUS_DELIVERED) {
            return response()->json([
                'success' => false,
                'message' => 'You can only claim a reward after your order is delivered.',
            ], 400);
        }

        // Check if reward already exists
        $existingReward = $this->rewardService->getOrderReward($customer->id, $order->id);
        if ($existingReward) {
            return response()->json([
                'success' => false,
                'message' => 'You have already claimed a reward for this order.',
            ], 400);
        }

        // Create the reward
        $result = $this->rewardService->createOrderReward($order, $customer->id);

        if ($result['success']) {
            $coupon = $result['coupon'];
            $couponDetails = $this->rewardService->getCouponDisplayDetails($coupon);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'reward' => [
                    'id' => $result['reward']->id,
                    'status' => $result['reward']->status,
                    'start_date' => $result['reward']->start_date,
                    'end_date' => $result['reward']->end_date,
                ],
                'coupon' => $couponDetails,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    /**
     * Claim reward for a service request
     * This is called via AJAX when customer clicks the reward button
     */
    public function claimServiceReward(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to claim your reward.',
            ], 401);
        }

        $customer = $this->getCustomer();

        // Validate request
        $validator = Validator::make($request->all(), [
            'service_request_id' => 'required|integer|exists:service_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $serviceRequestId = $request->input('service_request_id');
        $serviceRequest = ServiceRequest::find($serviceRequestId);

        // Verify ownership
        if ($serviceRequest->customer_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to claim a reward for this service request.',
            ], 403);
        }

        // Check if service request is completed
        // Adjust the status check based on your actual status values
        if ($serviceRequest->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'You can only claim a reward after your service request is completed.',
            ], 400);
        }

        // Check if reward already exists
        $existingReward = $this->rewardService->getServiceReward($customer->id, $serviceRequest->id);
        if ($existingReward) {
            return response()->json([
                'success' => false,
                'message' => 'You have already claimed a reward for this service request.',
            ], 400);
        }

        // Create the reward
        $result = $this->rewardService->createServiceReward($serviceRequest, $customer->id);

        if ($result['success']) {
            $coupon = $result['coupon'];
            $couponDetails = $this->rewardService->getCouponDisplayDetails($coupon);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'reward' => [
                    'id' => $result['reward']->id,
                    'status' => $result['reward']->status,
                    'start_date' => $result['reward']->start_date,
                    'end_date' => $result['reward']->end_date,
                ],
                'coupon' => $couponDetails,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    /**
     * Get reward details for an order
     */
    public function getOrderReward(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view your reward.',
            ], 401);
        }

        $customer = $this->getCustomer();

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        // Verify ownership
        if ($order->customer_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this reward.',
            ], 403);
        }

        $reward = $this->rewardService->getOrderReward($customer->id, $orderId);

        if (!$reward) {
            return response()->json([
                'success' => false,
                'message' => 'No reward found for this order.',
            ], 404);
        }

        // Sync status with coupon usage
        $reward->syncStatusWithCouponUsage();
        $reward->refresh();

        $couponDetails = $this->rewardService->getCouponDisplayDetails($reward->coupon);

        return response()->json([
            'success' => true,
            'reward' => [
                'id' => $reward->id,
                'status' => $reward->status,
                'start_date' => $reward->start_date,
                'end_date' => $reward->end_date,
                'used_at' => $reward->used_at,
            ],
            'coupon' => $couponDetails,
        ]);
    }

    /**
     * Get reward details for a service request
     */
    public function getServiceReward(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view your reward.',
            ], 401);
        }

        $customer = $this->getCustomer();

        $validator = Validator::make($request->all(), [
            'service_request_id' => 'required|integer|exists:service_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $serviceRequestId = $request->input('service_request_id');
        $serviceRequest = ServiceRequest::find($serviceRequestId);

        // Verify ownership
        if ($serviceRequest->customer_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this reward.',
            ], 403);
        }

        $reward = $this->rewardService->getServiceReward($customer->id, $serviceRequestId);

        if (!$reward) {
            return response()->json([
                'success' => false,
                'message' => 'No reward found for this service request.',
            ], 404);
        }

        // Sync status with coupon usage
        $reward->syncStatusWithCouponUsage();
        $reward->refresh();

        $couponDetails = $this->rewardService->getCouponDisplayDetails($reward->coupon);

        return response()->json([
            'success' => true,
            'reward' => [
                'id' => $reward->id,
                'status' => $reward->status,
                'start_date' => $reward->start_date,
                'end_date' => $reward->end_date,
                'used_at' => $reward->used_at,
            ],
            'coupon' => $couponDetails,
        ]);
    }

    /**
     * Check if customer is eligible for reward on an order
     */
    public function checkOrderEligibility(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => 'Please login to check eligibility.',
            ], 401);
        }

        $customer = $this->getCustomer();

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => 'Invalid request.',
            ], 422);
        }

        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        // Verify ownership
        if ($order->customer_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => 'You are not authorized to check this order.',
            ], 403);
        }

        $eligible = $this->rewardService->isEligibleForOrderReward($order, $customer->id);
        $hasReward = $this->rewardService->getOrderReward($customer->id, $orderId) !== null;

        return response()->json([
            'success' => true,
            'eligible' => $eligible,
            'has_reward' => $hasReward,
            'order_status' => $order->status,
        ]);
    }

    /**
     * Check if customer is eligible for reward on a service request
     */
    public function checkServiceEligibility(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => 'Please login to check eligibility.',
            ], 401);
        }

        $customer = $this->getCustomer();

        $validator = Validator::make($request->all(), [
            'service_request_id' => 'required|integer|exists:service_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => 'Invalid request.',
            ], 422);
        }

        $serviceRequestId = $request->input('service_request_id');
        $serviceRequest = ServiceRequest::find($serviceRequestId);

        // Verify ownership
        if ($serviceRequest->customer_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => 'You are not authorized to check this service request.',
            ], 403);
        }

        $eligible = $this->rewardService->isEligibleForServiceReward($serviceRequest, $customer->id);
        $hasReward = $this->rewardService->getServiceReward($customer->id, $serviceRequestId) !== null;

        return response()->json([
            'success' => true,
            'eligible' => $eligible,
            'has_reward' => $hasReward,
            'service_status' => $serviceRequest->status,
        ]);
    }

    /**
     * Sync all rewards status (admin function)
     */
    public function syncRewardsStatus()
    {
        $count = $this->rewardService->syncAllRewardsStatus();
        
        return response()->json([
            'success' => true,
            'message' => "Successfully synced {$count} rewards.",
        ]);
    }

    /**
     * Mark expired rewards (admin function)
     */
    public function markExpiredRewards()
    {
        $count = $this->rewardService->markExpiredRewards();
        
        return response()->json([
            'success' => true,
            'message' => "Successfully marked {$count} rewards as expired.",
        ]);
    }
}
