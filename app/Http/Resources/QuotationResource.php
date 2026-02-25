<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $status = 'pending';
        if ($this->status == 'sent') {
            $status = 'pending';
        } elseif ($this->status == 'accepted') {
            $status = 'accepted';
        } elseif ($this->status == 'rejected') {
            $status = 'rejected';
        } elseif ($this->status == 'converted') {
            $status = 'converted';
        } else {
            $status = 'pending';
        }

        return [
            'id' => $this->id,
            'quote_id' => $this->id ?? null,
            'lead_id' => $this->lead_id ?? null,
            'lead_number' => $this->lead_number ?? null,
            'quote_number' => $this->quote_number ?? null,
            'quote_date' => $this->quote_date ?? null,
            'expiry_date' => $this->expiry_date ?? null,
            'total_items' => $this->total_items ?? null,
            'total_amount' => $this->total_amount ?? null,
            'status' => $status,
            'products' => $this->whenLoaded('products') ? $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'hsn' => $product->hsn ?? null,
                    'sku' => $product->sku ?? null,
                    'unit_price' => $product->unit_price ?? null,
                    'quantity' => $product->quantity ?? null,
                    'tax_rate' => $product->tax_rate ?? null,
                    'line_total' => $product->line_total ?? null,
                ];
            }) : [],
            'leadDetails' => $this->whenLoaded('leadDetails') ? [
                'id' => $this->leadDetails->id,
                'lead_number' => $this->leadDetails->lead_number ?? null,
                'customer_name' => $this->leadDetails->customer ? ($this->leadDetails->customer->first_name . ' ' . $this->leadDetails->customer->last_name) : null,
                'phone' => $this->leadDetails->customer->phone ?? null,
                'email' => $this->leadDetails->customer->email ?? null,
            ] : null,
        ];
    }
}
