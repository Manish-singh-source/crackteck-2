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

        FollowUp::factory()->count(20)->make()->each(function ($followup) use ($leads) {
            $lead = $leads->random();
            $followup->lead_id = $lead->id;

            // If lead has an assigned staff, use it for the followup
            if (isset($lead->staff_id)) {
                $followup->staff_id = $lead->staff_id;
            }

            $followup->save();
        });
    }
}
