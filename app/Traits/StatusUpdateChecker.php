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
     *
     * @param int $productId
     * @return array
     */
    protected function checkProductStatusUpdate(int $productId): array
    {
        return StatusUpdateHelper::checkProductStatusCompletion($productId);
    }

    /**
     * Check and update status after return status change
     *
     * @param int $returnId
     * @return array
     */
    protected function checkReturnStatusUpdate(int $returnId): array
    {
        return StatusUpdateHelper::checkReturnStatusCompletion($returnId);
    }

    /**
     * Check and update status after pickup status change
     *
     * @param int $pickupId
     * @return array
     */
    protected function checkPickupStatusUpdate(int $pickupId): array
    {
        return StatusUpdateHelper::checkPickupStatusCompletion($pickupId);
    }

    /**
     * Check and update all status conditions for a service request
     *
     * @param int $serviceRequestId
     * @return array
     */
    protected function checkAllStatusUpdates(int $serviceRequestId): array
    {
        return StatusUpdateHelper::checkAllStatusConditions($serviceRequestId);
    }
}
