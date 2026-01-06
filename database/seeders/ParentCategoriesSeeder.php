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
        DB::table('parent_categories')->insertOrIgnore([
            [
                'name' => 'Printer',
                'slug' => 'printer',
                'image' => 'uploads/frontend/category/header-product-1.png',
                'status_ecommerce' => 1,
                'sort_order' => 1,
                'status' => 1
            ],
            [
                'name' => 'Monitor',
                'slug' => 'monitor',
                'image' => 'uploads/frontend/category/header-product-2.png',
                'status_ecommerce' => 1,
                'sort_order' => 2,
                'status' => 1
            ],
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'image' => 'uploads/frontend/category/header-product-3.png',
                'status_ecommerce' => 1,
                'sort_order' => 3,
                'status' => 1
            ],
            [
                'name' => 'CCTV',
                'slug' => 'cctv',
                'image' => 'uploads/frontend/category/header-product-4.png',
                'status_ecommerce' => 1,
                'sort_order' => 4,
                'status' => 1
            ],
            [
                'name' => 'Biometric',
                'slug' => 'biometric',
                'image' => 'uploads/frontend/category/header-product-5.png',
                'status_ecommerce' => 1,
                'sort_order' => 5,
                'status' => 1
            ],
            [
                'name' => 'Router',
                'slug' => 'router',
                'image' => 'uploads/frontend/category/header-product-6.png',
                'status_ecommerce' => 1,
                'sort_order' => 6,
                'status' => 1
            ],
            [
                'name' => 'SSD',
                'slug' => 'ssd',
                'image' => 'uploads/frontend/category/header-product-7.png',
                'status_ecommerce' => 1,
                'sort_order' => 7,
                'status' => 1
            ],
            [
                'name' => 'Scanner',
                'slug' => 'scanner',
                'image' => 'uploads/frontend/category/header-product-8.png',
                'status_ecommerce' => 1,
                'sort_order' => 8,
                'status' => 1
            ],
            [
                'name' => 'Server',
                'slug' => 'server',
                'image' => 'uploads/frontend/category/header-product-9.png',
                'status_ecommerce' => 1,
                'sort_order' => 9,
                'status' => 1
            ],
            [
                'name' => 'Keyboard',
                'slug' => 'keyboard',
                'image' => 'uploads/frontend/category/header-product-10.png',
                'status_ecommerce' => 1,
                'sort_order' => 10,
                'status' => 1
            ],
            [
                'name' => 'Mouse',
                'slug' => 'mouse',
                'image' => 'uploads/frontend/category/header-product-11.png',
                'status_ecommerce' => 1,
                'sort_order' => 11,
                'status' => 1
            ]
        ]);
    }
}
