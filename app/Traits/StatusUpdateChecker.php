<?php

namespace App\Traits;

use App\Helpers\StatusUpdateHelper;

/**
 * Trait for handling service request and product status updates
 *
 * Use this trait in controllers that update statuses in:
 * - service_request_products
 * - service_request_product_returns
 * - service_request_product_pickups
 */
trait StatusUpdateChecker
{
    /**
     * Check and update status after product status change
     */
    protected function checkProductStatusUpdate(int $productId): array
    {
        return StatusUpdateHelper::checkProductStatusCompletion($productId);
    }

    /**
     * Check and update status after return status change
     */
    protected function checkReturnStatusUpdate(int $returnId): array
    {
        return StatusUpdateHelper::checkReturnStatusCompletion($returnId);
    }

    /**
     * Check and update status after pickup status change
     */
    protected function checkPickupStatusUpdate(int $pickupId): array
    {
        return StatusUpdateHelper::checkPickupStatusCompletion($pickupId);
    }

    /**
     * Check and update all status conditions for a service request
     */
    protected function checkAllStatusUpdates(int $serviceRequestId): array
    {
        return StatusUpdateHelper::checkAllStatusConditions($serviceRequestId);
    }
}
