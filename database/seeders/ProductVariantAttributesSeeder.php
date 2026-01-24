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
                'attribute_code' => 'COLOR',
                'name' => 'Color', 
                'status' => "active",
            ],
            [
                'attribute_code' => 'SIZE',
                'name' => 'Size', 
                'status' => "active",
            ],
            [
                'attribute_code' => 'STORAGE',
                'name' => 'Storage', 
                'status' => "active",
            ],
            [
                'attribute_code' => 'RAM',
                'name' => 'RAM', 
                'status' => "active",
            ],
            [
                'attribute_code' => 'WARRANTY',
                'name' => 'Warranty', 
                'status' => "inactive",
            ],
        ]);
    }
}
