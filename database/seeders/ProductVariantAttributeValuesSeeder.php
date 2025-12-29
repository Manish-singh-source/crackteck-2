<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantAttributeValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('product_variant_attribute_values')->insert([
            // Color (attribute_id = 1)
            ['attribute_id' => 1, 'attribute_value' => 'Black'],
            ['attribute_id' => 1, 'attribute_value' => 'White'],
            ['attribute_id' => 1, 'attribute_value' => 'Blue'],
            ['attribute_id' => 1, 'attribute_value' => 'Red'],
            ['attribute_id' => 1, 'attribute_value' => 'Silver'],

            // Size (attribute_id = 2)
            ['attribute_id' => 2, 'attribute_value' => 'Small'],
            ['attribute_id' => 2, 'attribute_value' => 'Medium'],
            ['attribute_id' => 2, 'attribute_value' => 'Large'],

            // Storage (attribute_id = 3)
            ['attribute_id' => 3, 'attribute_value' => '64GB'],
            ['attribute_id' => 3, 'attribute_value' => '128GB'],
            ['attribute_id' => 3, 'attribute_value' => '256GB'],
            ['attribute_id' => 3, 'attribute_value' => '512GB'],

            // RAM (attribute_id = 4)
            ['attribute_id' => 4, 'attribute_value' => '4GB'],
            ['attribute_id' => 4, 'attribute_value' => '6GB'],
            ['attribute_id' => 4, 'attribute_value' => '8GB'],
            ['attribute_id' => 4, 'attribute_value' => '12GB'],

            // Warranty (attribute_id = 5)
            ['attribute_id' => 5, 'attribute_value' => '1 Year'],
            ['attribute_id' => 5, 'attribute_value' => '2 Years'],
            ['attribute_id' => 5, 'attribute_value' => '3 Years'],
            ['attribute_id' => 5, 'attribute_value' => 'No Warranty'],

            // You can continue for other attributes like Battery, Processor, Brand, etc.
        ]);
    }
}
