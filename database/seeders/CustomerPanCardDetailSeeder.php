<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerPanCardDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'CUS001', 'pan' => 'ABCDE1111F', 'front' => 'customers/pan/front_1.jpg', 'back' => 'customers/pan/back_1.jpg'],
            ['code' => 'CUS002', 'pan' => 'FGHIJ2222K', 'front' => 'customers/pan/front_2.jpg', 'back' => 'customers/pan/back_2.jpg'],
            ['code' => 'CUS003', 'pan' => 'KLMNO3333P', 'front' => 'customers/pan/front_3.jpg', 'back' => 'customers/pan/back_3.jpg'],
            ['code' => 'CUS004', 'pan' => 'QRSTU4444V', 'front' => 'customers/pan/front_4.jpg', 'back' => 'customers/pan/back_4.jpg'],
        ];

        foreach ($data as $d) {
            $cid = DB::table('customers')->where('customer_code', $d['code'])->value('id');
            if ($cid) {
                DB::table('customer_pan_card_details')->updateOrInsert([
                    'customer_id' => $cid
                ], [
                    'pan_number' => $d['pan'],
                    'pan_card_front_path' => $d['front'],
                    'pan_card_back_path' => $d['back'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
