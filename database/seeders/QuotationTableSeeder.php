<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Quotation;
use Illuminate\Database\Seeder;

class QuotationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leads = Lead::all();
        //

        Quotation::factory()->count(10)->make()->each(function ($quotation) use ($leads) {
            $lead = $leads->random();
            $quotation->user_id = $lead->user_id;
            $quotation->lead_id = $lead->id;
            $quotation->save();
        });
    }
}
