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
        // Ensure we have leads to attach followups to
        if (Lead::count() === 0) {
            Lead::factory()->count(10)->create();
        }

        $leads = Lead::all();

        Quotation::factory()->count(20)->make()->each(function ($quotation) use ($leads) {
            $lead = $leads->random();
            $quotation->lead_id = $lead->id;

            // If lead has an assigned staff, use it for the quotation
            if (isset($lead->staff_id)) {
                $quotation->staff_id = $lead->staff_id;
            }

            $quotation->save();
        });
    }
}
