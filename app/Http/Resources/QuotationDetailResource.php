<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $products = $this->whenLoaded('products') ? $this->products : ($this->products ?? collect());
        $amcDetail = $this->whenLoaded('amcData') ? $this->amcData : ($this->amcData ?? collect());
        $leadDetails = $this->whenLoaded('leadDetails') ? $this->leadDetails : ($this->leadDetails ?? collect());

        return [
            'id' => $this->id,
            'quote_id' => $this->quote_id,
            'lead_id' => $this->lead_id,
            'customer_id' => $leadDetails->customer_id,
            'quote_date' => $this->quote_date,
            'expiry_date' => $this->expiry_date,
            'quote_number' => $this->quote_number,
            'total_items' => $this->total_items,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'products' => $products ?? collect(),
            'amc_detail' => $amcData ?? collect(),
            'lead_details' => $leadDetails ?? collect(),
        ];
    }
}
