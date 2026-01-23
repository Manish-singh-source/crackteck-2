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
        $images = [
            'frontend-assets/images/new-products/1-1.png',
            'frontend-assets/images/new-products/1-2.png',
            'frontend-assets/images/new-products/1-3.png',
            'frontend-assets/images/new-products/1-4.png',
            'frontend-assets/images/new-products/1-5.png',
        ];
        $names = ['Printer', 'Monitor', 'Laptop', 'CCTV', 'Biometric', 'Router', 'SSD', 'Scanner', 'Server', 'Keyboard', 'Mouse'];
        $slugs = ['printer', 'monitor', 'laptop', 'cctv', 'biometric', 'router', 'ssd', 'scanner', 'server', 'keyboard', 'mouse'];
        
        $statuses = ['active', 'inactive'];

        $parentCategories = []; 

        for ($i = 0; $i < count($names); $i++) {
            $parentCategories[] = [
                'name' => $names[$i],
                'slug' => $slugs[$i],
                'image' => $images[rand(0, 4)],
                'status_ecommerce' => $statuses[rand(0, 1)],
                'sort_order' => rand(1, 10),
                'status' => $statuses[rand(0, 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('parent_categories')->insertOrIgnore($parentCategories);
    }
}
