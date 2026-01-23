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
            ['code' => 'CUS001', 'pan' => 'ABCDE1111F', 'front' => 'frontend-assets/images/new-products/1-1.png', 'back' => 'frontend-assets/images/new-products/1-1.png'],
            ['code' => 'CUS002', 'pan' => 'FGHIJ2222K', 'front' => 'frontend-assets/images/new-products/1-1.png', 'back' => 'frontend-assets/images/new-products/1-1.png'],
            ['code' => 'CUS003', 'pan' => 'KLMNO3333P', 'front' => 'frontend-assets/images/new-products/1-1.png', 'back' => 'frontend-assets/images/new-products/1-1.png'],
            ['code' => 'CUS004', 'pan' => 'QRSTU4444V', 'front' => 'frontend-assets/images/new-products/1-1.png', 'back' => 'frontend-assets/images/new-products/1-1.png'],
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
