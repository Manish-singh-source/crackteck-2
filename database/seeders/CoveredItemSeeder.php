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
                'service_type' => 'amc',
                'service_name' => 'Comprehensive AMC',
                'service_charge' => 4999.00,
                'diagnosis_list' => ['Cleaning', 'Inspection', 'Software Check'],
            ],
            [
                'service_type' => 'amc',
                'service_name' => 'Premium AMC',
                'service_charge' => 7999.00,
                'diagnosis_list' => ['Cleaning', 'Parts Replacement', 'Priority Support'],
            ],
            [
                'service_type' => 'quick_service',
                'service_name' => 'Quick Service - Onsite',
                'service_charge' => 999.00,
                'diagnosis_list' => ['Fast Diagnosis', 'Onsite Fix'],
            ],
            [
                'service_type' => 'quick_service',
                'service_name' => 'Quick Service - Remote',
                'service_charge' => 499.00,
                'diagnosis_list' => ['Remote Diagnosis', 'Software Fix'],
            ],
            [
                'service_type' => 'installation',
                'service_name' => 'Installation - Basic',
                'service_charge' => 499.00,
                'diagnosis_list' => ['Setup', 'Configuration'],
            ],
            [
                'service_type' => 'repair',
                'service_name' => 'Repair - Motherboard',
                'service_charge' => 2599.00,
                'diagnosis_list' => ['Diagnostics', 'Board Repair'],
            ],
        ];

        $inserts = [];

        foreach ($items as $index => $it) {
            $prefix = match ($it['service_type']) {
                'amc' => 'AMC',
                'quick_service' => 'QS',
                'installation' => 'INS',
                'repair' => 'REP',
                default => 'ITM',
            };

            $inserts[] = [
                'item_code' => $prefix . '-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'service_type' => $it['service_type'],
                'service_name' => $it['service_name'],
                'image' => null,
                'service_charge' => $it['service_charge'],
                'status' => "active",
                'diagnosis_list' => json_encode($it['diagnosis_list']),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('covered_items')->insert($inserts);
    }
}
