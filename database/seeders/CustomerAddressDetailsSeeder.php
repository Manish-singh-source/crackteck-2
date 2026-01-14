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
        $addresses = [
            ['code' => 'CUS001', 'branch_name' => 'Mumbai', 'address1' => '123 MG Road', 'address2' => 'Apt 12B', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India', 'pincode' => '400001'],
            ['code' => 'CUS002', 'branch_name' => 'Pune', 'address1' => '456 MG Road', 'address2' => 'Apt 45C', 'city' => 'Pune', 'state' => 'Maharashtra', 'country' => 'India', 'pincode' => '411001'],
            ['code' => 'CUS003', 'branch_name' => 'Delhi', 'address1' => '789 MG Road', 'address2' => 'Apt 78D', 'city' => 'Delhi', 'state' => 'Delhi', 'country' => 'India', 'pincode' => '110001'],
            ['code' => 'CUS004', 'branch_name' => 'Bangalore', 'address1' => '101 MG Road', 'address2' => 'Apt 101E', 'city' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India', 'pincode' => '560001'],
        ];

        foreach ($addresses as $addr) {
            $cid = DB::table('customers')->where('customer_code', $addr['code'])->value('id');
            if ($cid) {
                DB::table('customer_address_details')->updateOrInsert([
                    'customer_id' => $cid,
                    'branch_name' => $addr['branch_name']
                ], [
                    'address1' => $addr['address1'],
                    'address2' => $addr['address2'],
                    'city' => $addr['city'],
                    'state' => $addr['state'],
                    'country' => $addr['country'],
                    'pincode' => $addr['pincode'],
                    'is_primary' => "yes",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
