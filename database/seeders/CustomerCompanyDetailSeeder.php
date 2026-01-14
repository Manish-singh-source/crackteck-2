<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerCompanyDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['code' => 'CUS002', 'company_name' => 'Mayur Enterprises', 'comp_address1' => '456 MG Road', 'comp_address2' => 'Apt 45C', 'comp_city' => 'Pune', 'comp_state' => 'Maharashtra', 'comp_country' => 'India', 'comp_pincode' => '411001', 'gst_no' => '27ABCDE1234F1Z5'],
            ['code' => 'CUS004', 'company_name' => 'Manish Solutions', 'comp_address1' => '101 MG Road', 'comp_address2' => 'Apt 101E', 'comp_city' => 'Bangalore', 'comp_state' => 'Karnataka', 'comp_country' => 'India', 'comp_pincode' => '560001', 'gst_no' => '29FGHIJ5678K2Z7'],
        ];

        foreach ($companies as $c) {
            $cid = DB::table('customers')->where('customer_code', $c['code'])->value('id');
            if ($cid) {
                DB::table('customer_company_details')->updateOrInsert([
                    'customer_id' => $cid
                ], [
                    'company_name' => $c['company_name'],
                    'comp_address1' => $c['comp_address1'],
                    'comp_address2' => $c['comp_address2'],
                    'comp_city' => $c['comp_city'],
                    'comp_state' => $c['comp_state'],
                    'comp_country' => $c['comp_country'],
                    'comp_pincode' => $c['comp_pincode'],
                    'gst_no' => $c['gst_no'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
