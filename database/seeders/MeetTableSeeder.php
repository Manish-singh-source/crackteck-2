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
        $leads = Lead::all();
        //
        Meet::factory()->count(10)->make()->each(function ($meet) use ($leads) {
            $lead = $leads->random();
            $meet->lead_id = $lead->id;
            $meet->save();
        });
    }
}
