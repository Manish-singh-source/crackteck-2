<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PincodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pincodes')->insert([
            [
                'pincode' => '400001', // Mumbai
                'delivery' => "active",
                'installation' => "active",
                'repair' => "active",
                'quick_service' => "active",
                'amc' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '411001', // Pune
                'delivery' => "active",
                'installation' => "active",
                'repair' => "active",
                'quick_service' => "active",
                'amc' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '110001', // Delhi (CP)
                'delivery' => "active",
                'installation' => "inactive",
                'repair' => "active",
                'quick_service' => "inactive",
                'amc' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '560001', // Bangalore
                'delivery' => "active",
                'installation' => "active",
                'repair' => "active",
                'quick_service' => "active",
                'amc' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '600001', // Chennai
                'delivery' => "active",
                'installation' => "inactive",
                'repair' => "active",
                'quick_service' => "inactive",
                'amc' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '500001', // Hyderabad
                'delivery' => "active",
                'installation' => "active",
                'repair' => "active",
                'quick_service' => "active",
                'amc' => "inactive",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
