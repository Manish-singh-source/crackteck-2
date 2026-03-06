<?php

namespace App\Observers;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestQuotation;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestProductRequestPart;

class ServiceRequestObserver
{
    /**
     * Handle the ServiceRequest "created" event.
     */
    public function created(ServiceRequest $serviceRequest): void
    {
        $this->createOrUpdateQuotation($serviceRequest);
    }

    /**
     * Handle the ServiceRequest "updated" event.
     */
    public function updated(ServiceRequest $serviceRequest): void
    {
        // If customer_address_id is updated, update the quotation as well
        if ($serviceRequest->isDirty('customer_address_id')) {
            $this->updateQuotationAddresses($serviceRequest);
        }
    }

    /**
     * Create or update a quotation for the service request.
     */
    public function createOrUpdateQuotation(ServiceRequest $serviceRequest): void
    {
        // Get all service_request_products for this request
        $serviceRequestProducts = ServiceRequestProduct::where('service_requests_id', $serviceRequest->id)->get();
        
        // Get all request parts with specific statuses (used in service)
        // Statuses that indicate the part is being used: used, delivered, customer_approved
        $requestParts = ServiceRequestProductRequestPart::where('request_id', $serviceRequest->id)
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
        $quotation = ServiceRequestQuotation::where('request_id', $serviceRequest->id)->first();
        
        if (!$quotation) {
            // Generate unique invoice number
            $invoiceNumber = $this->generateInvoiceNumber($serviceRequest->id);

            // Create quotation
            $quotation = ServiceRequestQuotation::create([
                'request_id' => $serviceRequest->id,
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
     * Update quotation addresses when service request is updated.
     */
    private function updateQuotationAddresses(ServiceRequest $serviceRequest): void
    {
        $quotation = ServiceRequestQuotation::where('request_id', $serviceRequest->id)->first();
        
        if ($quotation) {
            $quotation->update([
                'billing_address_id' => $serviceRequest->customer_address_id,
                'shipping_address_id' => $serviceRequest->customer_address_id,
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
