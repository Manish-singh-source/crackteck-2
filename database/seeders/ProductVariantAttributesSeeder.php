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
            ['attribute_name' => 'Color', 'status' => 1],
            ['attribute_name' => 'Size', 'status' => 1],
            ['attribute_name' => 'Storage', 'status' => 1],
            ['attribute_name' => 'RAM', 'status' => 1],
            ['attribute_name' => 'Warranty', 'status' => 1],
        ]);
    }
}
