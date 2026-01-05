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

        Meet::factory()->count(20)->make()->each(function ($meet) use ($leads) {
            $lead = $leads->random();
            $meet->lead_id = $lead->id;

            // If lead has an assigned staff, use it for the meet
            if (isset($lead->staff_id)) {
                $meet->staff_id = $lead->staff_id;
            }

            $meet->save();
        });
    }
}
