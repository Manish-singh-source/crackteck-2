<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lead = $this->leadDetails;

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'lead_id' => $this->lead_id,
            'followup_date' => $this->followup_date,
            'followup_time' => $this->followup_time,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'lead' => [
                'id' => $lead->id,
                'name' => $lead->first_name.' '.$lead->last_name,
                'phone' => $lead->phone,
                'email' => $lead->email,
                'company_name' => $lead->company_name,
                'industry_type' => $lead->industry_type,
                'designation' => $lead->designation,
                'source' => $lead->source,
                'requirement_type' => $lead->requirement_type,
                'budget_range' => $lead->budget_range,
                'urgency' => $lead->urgency,
                'status' => $lead->status,
                'created_at' => $lead->created_at->toDateTimeString(),
                'updated_at' => $lead->updated_at->toDateTimeString(),
            ],
        ];
    }
}
