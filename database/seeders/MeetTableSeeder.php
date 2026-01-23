<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Meet;
use Illuminate\Database\Seeder;

class MeetTableSeeder extends Seeder
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

        // Ensure we have leads to attach followups to
        if (Lead::count() === 0) {
            Lead::factory()->count(10)->create();
        }

        $meets = [];

        $meetingTypes = ['onsite_demo', 'virtual_meeting', 'technical_visit', 'business_meeting', 'other'];
        $statuses = ['scheduled', 'confirmed', 'completed', 'cancelled'];

        foreach ($leads as $lead) {
            $meets[] = [
                'lead_id' => $lead->id,
                'staff_id' => $lead->staff_id,
                'meet_title' => fake()->sentence(),
                'meeting_type' => $meetingTypes[array_rand($meetingTypes)],
                'date' => now()->addDays(rand(1, 30))->toDateString(),
                'start_time' => now()->addHours(rand(1, 24))->toTimeString(),
                'end_time' => now()->addHours(rand(1, 24))->toTimeString(),
                'location' => fake()->address(),
                'meeting_link' => 'https://meet.google.com/abc-xyz-123',
                'attendees' => json_encode([fake()->name(), fake()->name()]),
                'attachment' => 'frontend-assets/images/new-products/1-1.png',
                'meet_agenda' => fake()->sentence(),
                'meeting_notes' => fake()->paragraph(),
                'follow_up_action' => fake()->sentence(),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        \DB::table('meets')->insert($meets);
    }
}
