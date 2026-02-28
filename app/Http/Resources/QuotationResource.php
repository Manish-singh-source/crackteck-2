<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        
        $quotation = $this->whenLoaded('quotation') ? $this->quotation : null;
        $products = $this->whenLoaded('quotation.products') ? $this->quotation?->products : null;
        $customer = $this->whenLoaded('customer') ? $this->customer : null;
        
        
        $status = 'pending';
        if ($quotation->status == 'sent') {
            $status = 'pending';
        } elseif ($quotation->status == 'accepted') {
            $status = 'accepted';
        } elseif ($quotation->status == 'rejected') {
            $status = 'rejected';
        } elseif ($quotation->status == 'converted') {
            $status = 'converted';
        } else {
            $status = 'pending';
        }

        return [
            'id' => $quotation->id,
            'quote_id' => $quotation->id ?? null,
            'lead_id' => $this->id ?? null,
            
            'lead_number' => $this->lead_number ?? null,
            'customer_name' => $customer->first_name ?? null,
            'phone' => $customer->phone ?? null,
            'email' => $customer->email ?? null,

            'quote_number' => $quotation->quote_number ?? null,
            'quote_date' => $quotation->quote_date ?? null,
            'expiry_date' => $quotation->expiry_date ?? null,
            'total_items' => $quotation->products_count ?? null,
            'total_amount' => $quotation->total_amount ?? null,
            'status' => $status,

            'products' => $products ? $products?->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name ?? null,
                    'type' => $product->type ?? null,
                    'model_no' => $product->model_no ?? null,
                    'hsn' => $product->hsn ?? null,
                    'purchase_date' => $product->purchase_date ?? null,
                    'brand' => $product->brand ?? null,
                    'description' => $product->description ?? null,
                    'images' => $product->images ?? null,
                ];
            }) : [],
        ];
    }
}
