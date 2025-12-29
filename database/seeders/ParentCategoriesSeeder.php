<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('parent_categories')->insert([
            ['parent_categories' => 'Printer', 'category_image' => 'uploads/frontend/category/header-product-1.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 1, 'status' => 1],
            ['parent_categories' => 'Monitor', 'category_image' => 'uploads/frontend/category/header-product-2.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 2, 'status' => 1],
            ['parent_categories' => 'Laptop', 'category_image' => 'uploads/frontend/category/header-product-3.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 3, 'status' => 1],
            ['parent_categories' => 'CCTV', 'category_image' => 'uploads/frontend/category/header-product-4.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 4, 'status' => 1],
            ['parent_categories' => 'Biometric', 'category_image' => 'uploads/frontend/category/header-product-5.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 5, 'status' => 1],
            ['parent_categories' => 'Router', 'category_image' => 'uploads/frontend/category/header-product-6.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 6, 'status' => 1],
            ['parent_categories' => 'SSD', 'category_image' => 'uploads/frontend/category/header-product-7.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 7, 'status' => 1],
            ['parent_categories' => 'Scanner', 'category_image' => 'uploads/frontend/category/header-product-8.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 8, 'status' => 1],
            ['parent_categories' => 'Server', 'category_image' => 'uploads/frontend/category/header-product-9.png', 'category_status_ecommerce' => 1, 'url' => 'gaming-https://technofra.com/', 'sort_order' => 9, 'status' => 1],
            ['parent_categories' => 'Keyboard', 'category_image' => 'uploads/frontend/category/header-product-10.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 10, 'status' => 1],
            ['parent_categories' => 'Mouse', 'category_image' => 'uploads/frontend/category/header-product-11.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 11, 'status' => 1],
            ['parent_categories' => 'Webcam', 'category_image' => 'uploads/frontend/category/header-product-12.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 12, 'status' => 1],
            ['parent_categories' => 'Spare Parts', 'category_image' => 'uploads/frontend/category/Spare Part.png', 'category_status_ecommerce' => 1, 'url' => 'https://technofra.com/', 'sort_order' => 13, 'status' => 0],
        ]);
    }
}
