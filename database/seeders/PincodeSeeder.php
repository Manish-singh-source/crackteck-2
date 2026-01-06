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
                'delivery' => 1,
                'installation' => "1",
                'repair' => 1,
                'quick_service' => "1",
                'amc' => "1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '411001', // Pune
                'delivery' => 1,
                'installation' => "1",
                'repair' => 1,
                'quick_service' => "1",
                'amc' => "1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '110001', // Delhi (CP)
                'delivery' => 1,
                'installation' => "0",
                'repair' => 1,
                'quick_service' => "0",
                'amc' => "1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '560001', // Bangalore
                'delivery' => 1,
                'installation' => "1",
                'repair' => 1,
                'quick_service' => "1",
                'amc' => "1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '600001', // Chennai
                'delivery' => 1,
                'installation' => "0",
                'repair' => 1,
                'quick_service' => "0",
                'amc' => "1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pincode' => '500001', // Hyderabad
                'delivery' => 1,
                'installation' => "1",
                'repair' => 1,
                'quick_service' => "1",
                'amc' => "0",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
