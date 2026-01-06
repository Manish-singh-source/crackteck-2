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
                'status' => 1
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'Size', 
                'status' => 1
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'Storage', 
                'status' => 1
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'RAM', 
                'status' => 1
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'Warranty', 
                'status' => 1
            ],
        ]);
    }
}
