<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lead = $this->leadDetails;
        $customer = $lead->customer;

        return [
            'id' => $this->id,
            'user_id' => $this->staff_id,
            'lead_id' => $this->lead_id,
            'meet_title' => $this->meet_title,
            'meeting_type' => $this->meeting_type,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'attachment' => $this->attachment,
            'meetAgenda' => $this->meetAgenda,
            'followUp' => $this->followUp,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'lead' => [
                'id' => $lead->id,
                'name' => $customer->first_name . ' ' . $customer->last_name,
                'phone' => $customer->phone,
                'email' => $customer->email,
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
