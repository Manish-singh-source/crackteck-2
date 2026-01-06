<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CoveredItem;

class CoveredItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            [
                'service_type' => '0',
                'service_name' => 'Comprehensive AMC',
                'service_charge' => 4999.00,
                'diagnosis_list' => ['Cleaning', 'Inspection', 'Software Check'],
            ],
            [
                'service_type' => '0',
                'service_name' => 'Premium AMC',
                'service_charge' => 7999.00,
                'diagnosis_list' => ['Cleaning', 'Parts Replacement', 'Priority Support'],
            ],
            [
                'service_type' => '1',
                'service_name' => 'Quick Service - Onsite',
                'service_charge' => 999.00,
                'diagnosis_list' => ['Fast Diagnosis', 'Onsite Fix'],
            ],
            [
                'service_type' => '1',
                'service_name' => 'Quick Service - Remote',
                'service_charge' => 499.00,
                'diagnosis_list' => ['Remote Diagnosis', 'Software Fix'],
            ],
            [
                'service_type' => '2',
                'service_name' => 'Installation - Basic',
                'service_charge' => 499.00,
                'diagnosis_list' => ['Setup', 'Configuration'],
            ],
            [
                'service_type' => '3',
                'service_name' => 'Repair - Motherboard',
                'service_charge' => 2599.00,
                'diagnosis_list' => ['Diagnostics', 'Board Repair'],
            ],
        ];

        $inserts = [];

        foreach ($items as $it) {
            $inserts[] = [
                'item_code' => CoveredItem::generateItemCode($it['service_type']),
                'service_type' => $it['service_type'],
                'service_name' => $it['service_name'],
                'service_charge' => $it['service_charge'],
                'status' => 1,
                'diagnosis_list' => json_encode($it['diagnosis_list']),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('covered_items')->insert($inserts);
    }
}
