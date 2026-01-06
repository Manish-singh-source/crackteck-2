<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerAadharDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'CUS001', 'aadhar_number' => '111122223333', 'front' => 'customers/aadhar/front_1.jpg', 'back' => 'customers/aadhar/back_1.jpg'],
            ['code' => 'CUS002', 'aadhar_number' => '222233334444', 'front' => 'customers/aadhar/front_2.jpg', 'back' => 'customers/aadhar/back_2.jpg'],
            ['code' => 'CUS003', 'aadhar_number' => '333344445555', 'front' => 'customers/aadhar/front_3.jpg', 'back' => 'customers/aadhar/back_3.jpg'],
            ['code' => 'CUS004', 'aadhar_number' => '444455556666', 'front' => 'customers/aadhar/front_4.jpg', 'back' => 'customers/aadhar/back_4.jpg'],
        ];

        foreach ($data as $d) {
            $cid = DB::table('customers')->where('customer_code', $d['code'])->value('id');
            if ($cid) {
                DB::table('customer_aadhar_details')->updateOrInsert([
                    'customer_id' => $cid
                ], [
                    'aadhar_number' => $d['aadhar_number'],
                    'aadhar_front_path' => $d['front'],
                    'aadhar_back_path' => $d['back'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
