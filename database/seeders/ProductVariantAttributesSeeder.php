<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('product_variant_attributes')->insert([
            [
                'atribute_code' => 'COLOR',
                'name' => 'Color', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'SIZE',
                'name' => 'Size', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'STORAGE',
                'name' => 'Storage', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'RAM',
                'name' => 'RAM', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'WARRANTY',
                'name' => 'Warranty', 
                'status' => "inactive",
            ],
        ]);
    }
}
