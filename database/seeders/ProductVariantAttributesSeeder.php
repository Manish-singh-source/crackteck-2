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
                'atribute_code' => 'COLOR',
                'name' => 'Size', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'Storage', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'RAM', 
                'status' => "active",
            ],
            [
                'atribute_code' => 'COLOR',
                'name' => 'Warranty', 
                'status' => "active",
            ],
        ]);
    }
}
