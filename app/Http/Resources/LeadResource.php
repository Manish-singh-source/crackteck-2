<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $customerInfo = $this->whenLoaded('customer');

        return [
            'id' => $this->id,
            'name' => $customerInfo
                ? trim($customerInfo->first_name . ' ' . $customerInfo->last_name)
                : null,
            'phone' => $customerInfo
                ? trim($customerInfo->phone)
                : null,
            'email' => $customerInfo
                ? trim($customerInfo->email)
                : null,
            'dob' => $customerInfo
                ? trim($customerInfo->dob)
                : null,
            // 'gender' => $gender[$this->gender],
            'gender' => $customerInfo
                ? trim($customerInfo->gender)
                : null,
            'company_name' => $this->company_name,
            'designation' => $this->designation,
            'industry_type' => $this->industry_type,
            // 'source' => $source[$this->source],
            'source' => $this->source,
            'requirement_type' => $this->requirement_type,
            'budget_range' => $this->budget_range,
            // 'urgency' => $urgency[$this->urgency],
            'urgency' => $this->urgency,
            // 'status' => $status[$this->status],
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
