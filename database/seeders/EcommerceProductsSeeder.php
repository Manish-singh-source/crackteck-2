<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EcommerceProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $rows = [
            [

                'product_id' => 1,
                'sku' => 'SKU48751',
                'meta_title' => 'DELL 15 Intel Core i3 13th Gen 1305U',
                'meta_description' => '<p>Short description of DELL 15 Laptop</p>',
                'meta_keywords' => 'Dell, Laptop',
                'meta_product_url_slug' => 'dell-15-intel-core-i3-13th-gen-1305u',
                'with_installation' => null,
                'company_warranty' => null,
                'short_description' => '<p>Short description of DELL 15 Laptop</p>',
                'full_description' => '<p>Full description with features and specifications.</p>',
                'technical_specification' => '<p>Technical specs: Intel i3, 8GB RAM, 512GB SSD.</p>',
                'min_order_qty' => 1,
                'max_order_qty' => null,
                'product_weight' => null,
                'product_dimensions' => null,
                'shipping_charges' => null,
                'shipping_class' => '0', // 0 = Light
                'is_featured' => 0,
                'is_best_seller' => 0,
                'is_suggested' => 0,
                'is_todays_deal' => 0,
                'product_tags' => null,
                'status' => "1", // Active
                'created_at' => Carbon::parse('2025-10-01 10:29:49'),
                'updated_at' => Carbon::parse('2025-10-01 10:29:49'),
            ],
            [

                'product_id' => 2,
                'sku' => 'SKU48752',
                'meta_title' => 'HP Pavilion Gaming Laptop',
                'meta_description' => '<p>HP Pavilion Gaming Laptop</p>',
                'meta_keywords' => 'HP, Laptop',
                'meta_product_url_slug' => 'hp-pavilion-gaming-laptop',
                'with_installation' => null,
                'company_warranty' => null,
                'short_description' => '<p>HP Pavilion Gaming Laptop</p>',
                'full_description' => '<p>Powerful gaming laptop with RTX graphics.</p>',
                'technical_specification' => '<p>Intel i7, 16GB RAM, 1TB SSD.</p>',
                'min_order_qty' => 1,
                'max_order_qty' => null,
                'product_weight' => null,
                'product_dimensions' => null,
                'shipping_charges' => null,
                'shipping_class' => '0', // 0 = Light
                'is_featured' => 0,
                'is_best_seller' => 0,
                'is_suggested' => 0,
                'is_todays_deal' => 0,
                'product_tags' => null,
                'status' => "1", // Active
                'created_at' => Carbon::parse('2025-10-01 10:30:06'),
                'updated_at' => Carbon::parse('2025-10-01 10:30:06'),
            ],
            [

                'product_id' => 3,
                'sku' => 'SKU48753',
                'meta_title' => 'Asus ZenBook 14',
                'meta_description' => '<p>Lightweight ultrabook</p>',
                'meta_keywords' => 'Asus, Laptop',
                'meta_product_url_slug' => 'asus-zenbook-14',
                'with_installation' => null,
                'company_warranty' => null,
                'short_description' => '<p>Lightweight ultrabook</p>',
                'full_description' => '<p>Asus ZenBook 14 with sleek design and powerful performance.</p>',
                'technical_specification' => '<p>Intel i5, 8GB RAM, 256GB SSD.</p>',
                'min_order_qty' => 1,
                'max_order_qty' => null,
                'product_weight' => null,
                'product_dimensions' => null,
                'shipping_charges' => null,
                'shipping_class' => '0', // 0 = Light
                'is_featured' => 0,
                'is_best_seller' => 0,
                'is_suggested' => 0,
                'is_todays_deal' => 0,
                'product_tags' => null,
                'status' => "1", // Active
                'created_at' => Carbon::parse('2025-10-01 10:30:21'),
                'updated_at' => Carbon::parse('2025-10-01 10:30:21'),
            ],
        ];

        // Use upsert to avoid duplicate SKU errors when running seeds repeatedly
        DB::table('ecommerce_products')->upsert($rows, ['sku'], [
            'product_id',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_product_url_slug',
            'with_installation',
            'company_warranty',
            'short_description',
            'full_description',
            'technical_specification',
            'min_order_qty',
            'max_order_qty',
            'product_weight',
            'product_dimensions',
            'shipping_charges',
            'shipping_class',
            'is_featured',
            'is_best_seller',
            'is_suggested',
            'is_todays_deal',
            'product_tags',
            'status',
            'updated_at'
        ]);
    }
}
