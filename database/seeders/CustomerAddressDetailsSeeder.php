<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerAddressDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('customer_address_details')->insert([
            [
                'customer_id' => 1,
                'branch_name' => 'Mumbai',
                'address' => '123 MG Road',
                'address2' => 'Apt 12B',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'pincode' => '400001',
                'is_primary' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_id' => 2,
                'branch_name' => 'Pune',
                'address' => '456 MG Road',
                'address2' => 'Apt 45C',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'country' => 'India',
                'pincode' => '411001',
                'is_primary' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_id' => 3,
                'branch_name' => 'Delhi',
                'address' => '789 MG Road',
                'address2' => 'Apt 78D',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'pincode' => '110001',
                'is_primary' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_id' => 4,
                'branch_name' => 'Bangalore',
                'address' => '101 MG Road',
                'address2' => 'Apt 101E',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'pincode' => '560001',
                'is_primary' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_id' => 5,
                'branch_name' => 'Chennai',
                'address' => '121 MG Road',
                'address2' => 'Apt 121F',
                'city' => 'Chennai',
                'state' => 'Tamil Nadu',
                'country' => 'India',
                'pincode' => '600001',
                'is_primary' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
