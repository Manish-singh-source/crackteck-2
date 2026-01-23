<?php

namespace Database\Seeders;

use App\Models\FollowUp;
use App\Models\Lead;
use Illuminate\Database\Seeder;

class FollowUpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have leads to attach followups to
        if (Lead::count() === 0) {
            Lead::factory()->count(10)->create();
        }

        $leads = Lead::all();

        $followUps = [];

        $followUpTypes = ['call', 'email', 'meeting', 'sms'];
        $statuses = ['pending', 'completed', 'rescheduled', 'cancelled'];

        foreach ($leads as $lead) {
            $followUps[] = [
                'lead_id' => $lead->id,
                'staff_id' => $lead->staff_id,
                'followup_date' => now()->addDays(rand(1, 30))->toDateString(),
                'followup_time' => now()->addHours(rand(1, 24))->toTimeString(),
                'followup_type' => $followUpTypes[array_rand($followUpTypes)],
                'status' => $statuses[array_rand($statuses)],
                'remarks' => 'Follow up remark',
                'next_action' => 'Follow up next action',
                'next_followup_date' => now()->addDays(rand(1, 30))->toDateTimeString(),
            ];
        }

        \DB::table('follow_ups')->insert($followUps);
    }
}
