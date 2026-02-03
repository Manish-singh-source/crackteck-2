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
        $customer = $this->whenLoaded('customer');
        $company  = $customer?->companyDetails;

        return [
            'id' => $this->id,

            'name' => $customer
                ? trim($customer->first_name . ' ' . $customer->last_name)
                : null,

            'phone' => $customer?->phone,
            'email' => $customer?->email,
            'dob' => $customer?->dob,
            'gender' => $customer?->gender,

            'company_name' => $company?->company_name,
            'industry_type' => $company?->industry_type,

            'designation' => $this->designation,
            'source' => $this->source,
            'requirement_type' => $this->requirement_type,
            'budget_range' => $this->budget_range,
            'urgency' => $this->urgency,
            'status' => $this->status,

            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
