<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['active', 'inactive'];
        $ecommerceStatuses = ['active', 'inactive'];

        $images = [
            'frontend-assets/images/new-products/1-1.png',
            'frontend-assets/images/new-products/1-2.png',
            'frontend-assets/images/new-products/1-3.png',
            'frontend-assets/images/new-products/1-4.png',
            'frontend-assets/images/new-products/1-5.png',
        ];

        $brands = [];

        for ($i = 0; $i < 10; $i++) {
            $brand = [
                'name' => fake()->company(),
                'slug' => strtolower(str_replace(' ', '-', fake()->company())),
                'image' => $images[rand(0, 4)],
                'status_ecommerce' => $ecommerceStatuses[rand(0, 1)],
                'status' => $statuses[rand(0, 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $brands[] = $brand;
        }

        DB::table('brands')->insertOrIgnore($brands);
    }
}
