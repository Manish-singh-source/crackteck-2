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
        //
        $leads = Lead::all();

        // foreach ($leads as $lead) {
        //     FollowUp::factory()->count(1)->for($lead)->create();
        // }
        FollowUp::factory()->count(20)->make()->each(function ($followup) use ($leads) {
            $lead = $leads->random();
            $followup->lead_id = $lead->id;
            $followup->save();
        });
    }
}
