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
        return [
            'id' => $this->id,
            'name' => $this->first_name.' '.$this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'company_name' => $this->company_name,
            'designation' => $this->designation,
            'industry_type' => $this->industry_type,
            'source' => $this->source,
            'requirement_type' => $this->requirement_type,
            'budget_range' => $this->budget_range,
            'urgency' => $this->urgency,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
