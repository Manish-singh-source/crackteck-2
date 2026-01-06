<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('service_requests')->insert([
            [
                'request_id' => 'SR-' . Carbon::now()->subDays(5)->format('Ymd') . '-001',
                'customer_id' => 1,
                'request_date' => Carbon::now()->subDays(5)->toDateString(),
                'request_status' => "0", // Pending
                'request_source' => "0", // Customer
                'created_by' => null,
                'is_engineer_assigned' => "0",
                'created_at' => $now->subDays(5),
                'updated_at' => $now->subDays(5),
            ],
            [
                'request_id' => 'SR-' . Carbon::now()->subDays(3)->format('Ymd') . '-001',
                'customer_id' => 2,
                'request_date' => Carbon::now()->subDays(3)->toDateString(),
                'request_status' => "3", // Processing
                'request_source' => "0",
                'created_by' => 1,
                'is_engineer_assigned' => "1",
                'created_at' => $now->subDays(3),
                'updated_at' => $now->subDays(3),
            ],
            [
                'request_id' => 'SR-' . Carbon::now()->subDays(2)->format('Ymd') . '-001',
                'customer_id' => 3,
                'request_date' => Carbon::now()->subDays(2)->toDateString(),
                'request_status' => "1", // Approved
                'request_source' => "1", // System
                'created_by' => 2,
                'is_engineer_assigned' => "0",
                'created_at' => $now->subDays(2),
                'updated_at' => $now->subDays(2),
            ],
            [
                'request_id' => 'SR-' . Carbon::now()->subDays(1)->format('Ymd') . '-001',
                'customer_id' => 4,
                'request_date' => Carbon::now()->subDays(1)->toDateString(),
                'request_status' => "4", // In Progress
                'request_source' => "0",
                'created_by' => null,
                'is_engineer_assigned' => "1",
                'created_at' => $now->subDays(1),
                'updated_at' => $now->subDays(1),
            ],
        ]);
    }
}
