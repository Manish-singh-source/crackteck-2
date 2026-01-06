<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            ['vendor_code' => 'VEND001', 'first_name' => 'Akash', 'last_name' => 'Kumar', 'phone' => '9876543210', 'email' => 'akash@example.com', 'address1' => '12 Marine Drive', 'address2' => 'Suite 101', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India', 'pincode' => '400001', 'pan_no' => 'AKSDK1234L', 'gst_no' => '27AKSDF1234G1Z2', 'status' => 1, 'created_by' => null],
            ['vendor_code' => 'VEND002', 'first_name' => 'Ramesh', 'last_name' => 'Sharma', 'phone' => '9123456780', 'email' => 'ramesh@vendor.com', 'address1' => '45 Connaught Place', 'address2' => null, 'city' => 'Delhi', 'state' => 'Delhi', 'country' => 'India', 'pincode' => '110001', 'pan_no' => 'RMSHA1234P', 'gst_no' => '07RMSHA1234P1Z3', 'status' => 1, 'created_by' => null],
            ['vendor_code' => 'VEND003', 'first_name' => 'Sunita', 'last_name' => 'Mehra', 'phone' => '9988776655', 'email' => 'sunita@vendor.com', 'address1' => '101 MG Road', 'address2' => 'Unit 5', 'city' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India', 'pincode' => '560001', 'pan_no' => 'SNIME1234Q', 'gst_no' => '29SNIME1234Q1Z6', 'status' => 1, 'created_by' => null],
        ];

        foreach ($vendors as $v) {
            \Illuminate\Support\Facades\DB::table('vendors')->updateOrInsert(['vendor_code' => $v['vendor_code']], array_merge($v, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]));
        }
    }
}
