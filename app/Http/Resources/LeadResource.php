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
        // $gender = [
        //     '0' => 'Male',
        //     '1' => 'Female',    
        //     '2' => 'Other',
        //     null => 'Not Specified',
        // ];

        // $source = [
        //     '0' => 'Website',
        //     '1' => 'Referral',
        //     '2' => 'Call',
        //     '3' => 'Walk-in',
        //     '4' => 'Event',
        //     null => 'Not Specified',
        // ];

        // $urgency = [
        //     '0' => 'Low',
        //     '1' => 'Medium',
        //     '2' => 'High',
        //     '3' => 'Critical',
        //     null => 'Not Specified',
        // ];

        // $status = [
        //     '0' => 'New',
        //     '1' => 'Contacted',
        //     '2' => 'Qualified',
        //     '3' => 'Proposal',
        //     '4' => 'Won',
        //     '5' => 'Lost',
        //     '6' => 'Nurture',
        //     null => 'Not Specified',
        // ];

        $customerInfo = $this->whenLoaded('customer');

        return [
            'id' => $this->id,
            'name' => $customerInfo->first_name.' '.$customerInfo->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'dob' => $this->dob,
            // 'gender' => $gender[$this->gender],
            'gender' => $this->gender,
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
