<?php

namespace App\Observers;

use App\Models\ServiceRequestProductRequestPart;
use App\Models\ServiceRequestQuotation;
use App\Models\ServiceRequestProduct;

class ServiceRequestProductRequestPartObserver
{
    /**
     * Handle the ServiceRequestProductRequestPart "created" event.
     */
    public function created(ServiceRequestProductRequestPart $requestPart): void
    {
        if ($requestPart->request_id) {
            $this->updateQuotation($requestPart->request_id);
        }
    }

    /**
     * Handle the ServiceRequestProductRequestPart "updated" event.
     */
    public function updated(ServiceRequestProductRequestPart $requestPart): void
    {
        // If status changes to used, delivered, or customer_approved, update the quotation
        $relevantStatuses = ['used', 'delivered', 'customer_approved'];

        if ($requestPart->isDirty('status')) {
            $newStatus = $requestPart->status;
            $oldStatus = $requestPart->getOriginal('status');

            // If status changed to or from a relevant status, update quotation
            if (in_array($newStatus, $relevantStatuses) || in_array($oldStatus, $relevantStatuses)) {
                $this->updateQuotation($requestPart->request_id);
            }
        }
    }

    /**
     * Handle the ServiceRequestProductRequestPart "deleted" event.
     */
    public function deleted(ServiceRequestProductRequestPart $requestPart): void
    {
        $this->updateQuotation($requestPart->request_id);
    }

    /**
     * Update the quotation for a service request.
     */
    private function updateQuotation(int $serviceRequestId): void
    {
        // Get the service request to access customer_address_id
        $serviceRequest = \App\Models\ServiceRequest::find($serviceRequestId);

        if (!$serviceRequest) {
            return;
        }

        // Get all service_request_products for this request
        $serviceRequestProducts = ServiceRequestProduct::where('service_requests_id', $serviceRequestId)->get();

        // Get all request parts with specific statuses (used in service)
        $requestParts = ServiceRequestProductRequestPart::where('request_id', $serviceRequestId)
            ->whereIn('status', ['used', 'delivered', 'customer_approved'])
            ->with('product')
            ->get();

        // Calculate counts and totals
        $requestPartCount = $serviceRequestProducts->count();
        $serviceChargeTotal = $serviceRequestProducts->sum('service_charge');

        $partCount = $requestParts->count();
        $productPriceTotal = $requestParts->sum(function ($part) {
            return $part->product->final_price ?? 0;
        });

        // Calculate subtotal and grand_total
        $subtotal = $serviceChargeTotal + $productPriceTotal;
        $deliveryCharge = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        $roundOff = 0;
        $grandTotal = $subtotal + $deliveryCharge - $totalDiscount + $totalTax + $roundOff;

        // Get existing quotation or create new one
        $quotation = ServiceRequestQuotation::where('request_id', $serviceRequestId)->first();

        if (!$quotation) {
            // Generate unique invoice number
            $invoiceNumber = $this->generateInvoiceNumber($serviceRequestId);

            // Create quotation
            ServiceRequestQuotation::create([
                'request_id' => $serviceRequestId,
                'request_part_count' => $requestPartCount,
                'service_charge_total' => $serviceChargeTotal,
                'part_count' => $partCount,
                'product_price_total' => $productPriceTotal,
                'subtotal' => $subtotal,
                'delivery_charge' => $deliveryCharge,
                'total_discount' => $totalDiscount,
                'total_tax' => $totalTax,
                'round_off' => $roundOff,
                'grand_total' => $grandTotal,
                'currency' => 'INR',
                'paid_amount' => 0,
                'payment_status' => 'unpaid',
                'payment_method' => null,
                'paid_at' => null,
                'billing_address_id' => $serviceRequest->customer_address_id,
                'shipping_address_id' => $serviceRequest->customer_address_id,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => null,
                'due_date' => null,
                'invoice_pdf' => null,
            ]);
        } else {
            // Update existing quotation
            $quotation->update([
                'request_part_count' => $requestPartCount,
                'service_charge_total' => $serviceChargeTotal,
                'part_count' => $partCount,
                'product_price_total' => $productPriceTotal,
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
            ]);
        }
    }

    /**
     * Generate a unique invoice number.
     */
    private function generateInvoiceNumber(int $requestId): string
    {
        $prefix = 'SRQ';
        $year = date('Y');
        $month = date('m');
        $uniqueId = str_pad($requestId, 6, '0', STR_PAD_LEFT);

        return "{$prefix}/{$year}/{$month}/{$uniqueId}";
    }
}
