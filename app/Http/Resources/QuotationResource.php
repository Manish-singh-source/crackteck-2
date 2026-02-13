<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $quotation = $this->whenLoaded('quotation') ? $this->quotation : ($this->quotation ?? collect());

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
        };


        return [
            'lead_id' => $this->id,
            'quote_id' => $quotation->id ?? null,
            'lead_number' => $this->lead_number ?? null,
            'quote_number' => $quotation->quote_number ?? null,
            'quote_date' => $quotation->quote_date ?? null,
            'expiry_date' => $quotation->expiry_date ?? null,
            'total_items' => $quotation->total_items ?? null,
            'total_amount' => $quotation->total_amount ?? null,
            'status' => $status,
        ];
    }
}
