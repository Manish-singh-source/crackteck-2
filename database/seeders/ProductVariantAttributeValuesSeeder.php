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
            [
                'attribute_id' => 1, 
                'value' => 'Black',
                'status' => 1,
            ],
            [
                'attribute_id' => 1, 
                'value' => 'White',
                'status' => 1,
            ],
            [
                'attribute_id' => 1, 
                'value' => 'Blue',
                'status' => 1,
            ],
            [
                'attribute_id' => 1, 
                'value' => 'Red',
                'status' => 1,
            ],
            [
                'attribute_id' => 1, 
                'value' => 'Silver',
                'status' => 1,
            ],

            // Size (attribute_id = 2)
            [
                'attribute_id' => 2, 
                'value' => 'Small',
                'status' => 1,
            ],
            [
                'attribute_id' => 2, 
                'value' => 'Medium',
                'status' => 1,
            ],
            [
                'attribute_id' => 2, 
                'value' => 'Large',
                'status' => 1,
            ],

            // Storage (attribute_id = 3)
            [
                'attribute_id' => 3, 
                'value' => '64GB',
                'status' => 1,
            ],
            [
                'attribute_id' => 3, 
                'value' => '128GB',
                'status' => 1,
            ],
            [
                'attribute_id' => 3, 
                'value' => '256GB',
                'status' => 1,
            ],
            [
                'attribute_id' => 3, 
                'value' => '512GB',
                'status' => 1,
            ],

            // RAM (attribute_id = 4)
            [
                'attribute_id' => 4, 
                'value' => '4GB',
                'status' => 1,
            ],
            [
                'attribute_id' => 4, 
                'value' => '6GB',
                'status' => 1,
            ],
            [
                'attribute_id' => 4, 
                'value' => '8GB',
                'status' => 1,
            ],
            [
                'attribute_id' => 4, 
                'value' => '12GB',
                'status' => 1,
            ],

            // Warranty (attribute_id = 5)
            [
                'attribute_id' => 5, 
                'value' => '1 Year',
                'status' => 1,
            ],
            [
                'attribute_id' => 5, 
                'value' => '2 Years',
                'status' => 1,
            ],
            [
                'attribute_id' => 5, 
                'value' => '3 Years',
                'status' => 1,
            ],
            [
                'attribute_id' => 5, 
                'value' => 'No Warranty',
                'status' => 1,
            ],

            // You can continue for other attributes like Battery, Processor, Brand, etc.
        ]);
    }
}
