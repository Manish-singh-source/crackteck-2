<?php

namespace App\Helpers;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestProductPickup;
use App\Models\ServiceRequestProductReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatusUpdateHelper
{
    /**
     * Condition 1: Check if all products of a service have diagnosis_completed status
     * If yes, update all product statuses to completed
     *
     * @param int $serviceRequestId
     * @return bool
     */
    public static function checkAndUpdateProductStatusToCompleted(int $serviceRequestId): bool
    {
        try {
            // Get all products for this service request
            $products = ServiceRequestProduct::where('service_requests_id', $serviceRequestId)->get();

            if ($products->isEmpty()) {
                return false;
            }

            // Check if all products have diagnosis_completed status
            $allDiagnosisCompleted = $products->every(function ($product) {
                return $product->status === 'diagnosis_completed';
            });

            // If all products have diagnosis_completed status, update all to completed
            if ($allDiagnosisCompleted) {
                ServiceRequestProduct::where('service_requests_id', $serviceRequestId)
                    ->update(['status' => 'completed']);

                Log::info('All products status updated to completed', [
                    'service_request_id' => $serviceRequestId,
                    'product_count' => $products->count()
                ]);

                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Error in checkAndUpdateProductStatusToCompleted', [
                'service_request_id' => $serviceRequestId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Condition 2: Check if service request should be marked as completed
     * Conditions:
     * 1. Service exists in service_request_product_returns with status 'delivered'
     * 2. Same service in service_request_product_pickups has status 'returned'
     * 3. All products in service_request_products have status 'completed'
     *
     * @param int $serviceRequestId
     * @return bool
     */
    public static function checkAndUpdateServiceRequestStatus(int $serviceRequestId): bool
    {
        try {
            $serviceRequest = ServiceRequest::find($serviceRequestId);

            if (!$serviceRequest) {
                return false;
            }

            // Check if service has any returns with delivered status
            $hasDeliveredReturns = ServiceRequestProductReturn::where('request_id', $serviceRequestId)
                ->where('status', 'delivered')
                ->exists();

            if (!$hasDeliveredReturns) {
                return false;
            }

            // Check if service has any pickups with returned status
            $hasReturnedPickups = ServiceRequestProductPickup::where('request_id', $serviceRequestId)
                ->where('status', 'completed')
                ->exists();

            if (!$hasReturnedPickups) {
                return false;
            }

            // Check if all products have completed status
            $allProductsCompleted = ServiceRequestProduct::where('service_requests_id', $serviceRequestId)
                ->get()
                ->every(function ($product) {
                    return $product->status === 'completed';
                });

            if (!$allProductsCompleted) {
                return false;
            }

            // Update service request status to completed
            $serviceRequest->status = 'completed';
            $serviceRequest->save();

            Log::info('Service request status updated to completed', [
                'service_request_id' => $serviceRequestId,
                'has_delivered_returns' => $hasDeliveredReturns,
                'has_returned_pickups' => $hasReturnedPickups,
                'all_products_completed' => $allProductsCompleted
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error in checkAndUpdateServiceRequestStatus', [
                'service_request_id' => $serviceRequestId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Combined check: Run both status update conditions
     * Should be called after any status update in:
     * - service_request_products
     * - service_request_product_returns
     * - service_request_product_pickups
     *
     * @param int $serviceRequestId
     * @return array
     */
    public static function checkAllStatusConditions(int $serviceRequestId): array
    {
        $results = [
            'products_updated' => false,
            'service_request_updated' => false,
        ];

        DB::transaction(function () use ($serviceRequestId, &$results) {
            // Check condition 1: Update product statuses if all diagnosis_completed
            $results['products_updated'] = self::checkAndUpdateProductStatusToCompleted($serviceRequestId);

            // Check condition 2: Update service request status if conditions met
            $results['service_request_updated'] = self::checkAndUpdateServiceRequestStatus($serviceRequestId);
        });

        return $results;
    }

    /**
     * Check status completion for a specific service request product
     * Call this after updating product status
     *
     * @param int $productId
     * @return array
     */
    public static function checkProductStatusCompletion(int $productId): array
    {
        $product = ServiceRequestProduct::find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        $serviceRequestId = $product->service_requests_id;
        $results = self::checkAllStatusConditions($serviceRequestId);

        return [
            'success' => true,
            'product_id' => $productId,
            'service_request_id' => $serviceRequestId,
            'results' => $results
        ];
    }

    /**
     * Check status completion for a return request
     * Call this after updating return status
     *
     * @param int $returnId
     * @return array
     */
    public static function checkReturnStatusCompletion(int $returnId): array
    {
        $return = ServiceRequestProductReturn::find($returnId);

        if (!$return) {
            return ['success' => false, 'message' => 'Return request not found'];
        }

        $serviceRequestId = $return->request_id;
        $results = self::checkAllStatusConditions($serviceRequestId);

        return [
            'success' => true,
            'return_id' => $returnId,
            'service_request_id' => $serviceRequestId,
            'results' => $results
        ];
    }

    /**
     * Check status completion for a pickup request
     * Call this after updating pickup status
     *
     * @param int $pickupId
     * @return array
     */
    public static function checkPickupStatusCompletion(int $pickupId): array
    {
        $pickup = ServiceRequestProductPickup::find($pickupId);

        if (!$pickup) {
            return ['success' => false, 'message' => 'Pickup request not found'];
        }

        $serviceRequestId = $pickup->request_id;
        $results = self::checkAllStatusConditions($serviceRequestId);

        return [
            'success' => true,
            'pickup_id' => $pickupId,
            'service_request_id' => $serviceRequestId,
            'results' => $results
        ];
    }
}
