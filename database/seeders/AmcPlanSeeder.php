<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CoveredItem;

class AmcPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Grab some covered item ids to include
        $covered = CoveredItem::pluck('id')->toArray();

        // fallback if no covered items exist yet
        $coveredA = array_slice($covered, 0, 2) ?: [];
        $coveredB = array_slice($covered, 0, 3) ?: $coveredA;
        $coveredC = array_slice($covered, 2, 3) ?: $coveredA;

        DB::table('amc_plans')->insert([
            [
                'plan_name' => 'Basic AMC Plan',
                'plan_code' => 'AMCP-BASIC',
                'description' => 'Basic annual AMC covering essential services.',
                'duration' => 12,
                'total_visits' => 2,
                'plan_cost' => 4999.00,
                'tax' => 899.82,
                'total_cost' => 5898.82,
                'pay_terms' => "0",
                'support_type' => 2,
                'covered_items' => json_encode($coveredA),
                'brochure' => null,
                'tandc' => null,
                'replacement_policy' => null,
                'status' => "1",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'plan_name' => 'Standard AMC Plan',
                'plan_code' => 'AMCP-STD',
                'description' => 'Standard plan with additional visits and parts coverage.',
                'duration' => 12,
                'total_visits' => 4,
                'plan_cost' => 7999.00,
                'tax' => 1439.82,
                'total_cost' => 9438.82,
                'pay_terms' => "1",
                'support_type' => 2,
                'covered_items' => json_encode($coveredB),
                'brochure' => null,
                'tandc' => null,
                'replacement_policy' => null,
                'status' => "1",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'plan_name' => 'Premium AMC Plan',
                'plan_code' => 'AMCP-PREMIUM',
                'description' => 'Premium plan with priority support and maximum coverage.',
                'duration' => 24,
                'total_visits' => 8,
                'plan_cost' => 14999.00,
                'tax' => 2699.82,
                'total_cost' => 17698.82,
                'pay_terms' => "1",
                'support_type' => 2,
                'covered_items' => json_encode($coveredC),
                'brochure' => null,
                'tandc' => null,
                'replacement_policy' => null,
                'status' => "1",
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
