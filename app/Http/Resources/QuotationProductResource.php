<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quotation_id' => $this->quotation_id,
            'product_name' => $this->product_name,
            'hsn_code' => $this->hsn_code,
            'sku' => $this->sku,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'tax' => $this->tax,
            'total' => $this->total,
        ];
    }
}
