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
                'status' => "active",
            ],
            [
                'attribute_id' => 1, 
                'value' => 'White',
                'status' => "active",
            ],
            [
                'attribute_id' => 1, 
                'value' => 'Blue',
                'status' => "active",
            ],
            [
                'attribute_id' => 1, 
                'value' => 'Red',
                'status' => "active",
            ],
            [
                'attribute_id' => 1, 
                'value' => 'Silver',
                'status' => "active",
            ],

            // Size (attribute_id = 2)
            [
                'attribute_id' => 2, 
                'value' => 'Small',
                'status' => "active",
            ],
            [
                'attribute_id' => 2, 
                'value' => 'Medium',
                'status' => "active",
            ],
            [
                'attribute_id' => 2, 
                'value' => 'Large',
                'status' => "active",
            ],

            // Storage (attribute_id = 3)
            [
                'attribute_id' => 3, 
                'value' => '64GB',
                'status' => "active",
            ],
            [
                'attribute_id' => 3, 
                'value' => '128GB',
                'status' => "active",
            ],
            [
                'attribute_id' => 3, 
                'value' => '256GB',
                'status' => "active",
            ],
            [
                'attribute_id' => 3, 
                'value' => '512GB',
                'status' => "active",
            ],

            // RAM (attribute_id = 4)
            [
                'attribute_id' => 4, 
                'value' => '4GB',
                'status' => "active",
            ],
            [
                'attribute_id' => 4, 
                'value' => '6GB',
                'status' => "active",
            ],
            [
                'attribute_id' => 4, 
                'value' => '8GB',
                'status' => "active",
            ],
            [
                'attribute_id' => 4, 
                'value' => '12GB',
                'status' => "active",
            ],

            // Warranty (attribute_id = 5)
            [
                'attribute_id' => 5, 
                'value' => '1 Year',
                'status' => "active",
            ],
            [
                'attribute_id' => 5, 
                'value' => '2 Years',
                'status' => "active",
            ],
            [
                'attribute_id' => 5, 
                'value' => '3 Years',
                'status' => "active",
            ],
            [
                'attribute_id' => 5, 
                'value' => 'No Warranty',
                'status' => "active",
            ],

            // You can continue for other attributes like Battery, Processor, Brand, etc.
        ]);
    }
}
