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


        // $leadGender = [
        //     '0' => 'Male',
        //     '1' => 'Female',
        //     '2' => 'Other',
        //     null => 'Not Specified',
        // ];

        // $leadSource = [
        //     '0' => 'Website',
        //     '1' => 'Referral',
        //     '2' => 'Call',
        //     '3' => 'Walk-in',
        //     '4' => 'Event',
        //     null => 'Not Specified',
        // ];

        // $leadUrgency = [
        //     '0' => 'Low',
        //     '1' => 'Medium',
        //     '2' => 'High',
        //     '3' => 'Critical',
        //     null => 'Not Specified',
        // ];

        // $leadStatus = [
        //     '0' => 'New',
        //     '1' => 'Contacted',
        //     '2' => 'Qualified',
        //     '3' => 'Proposal',
        //     '4' => 'Won',
        //     '5' => 'Lost',
        //     '6' => 'Nurture',
        //     null => 'Not Specified',
        // ];

        // $meetingType = [
        //     '0' => 'In Person',
        //     '1' => 'Virtual',
        //     '2' => 'Phone',
        //     null => 'Not Specified',
        // ];

        // $meetingStatus = [
        //     '0' => 'Scheduled',
        //     '1' => 'Confirmed',
        //     '2' => 'Completed',
        //     '3' => 'Cancelled',
        //     '4' => 'Rescheduled',
        //     null => 'Not Specified',
        // ];

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
                'name' => $lead->first_name . ' ' . $lead->last_name,
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
