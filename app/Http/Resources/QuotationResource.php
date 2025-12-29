<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'lead_id' => $this->lead_id,
            'quote_id' => $this->quote_id,
            'quote_date' => $this->quote_date,
            'expiry_date' => $this->expiry_date,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            // Return product list correctly
            'products' => QuotationProductResource::collection(
                $this->whenLoaded('products')
            ),
        ];
    }
}
