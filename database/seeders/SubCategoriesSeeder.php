<?php

namespace Database\Seeders;

use App\Models\ParentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $parentCategoriesCount = ParentCategory::count();
        $images = [
            'frontend-assets/images/new-products/1-1.png',
            'frontend-assets/images/new-products/1-2.png',
            'frontend-assets/images/new-products/1-3.png',
            'frontend-assets/images/new-products/1-4.png',
            'frontend-assets/images/new-products/1-5.png',
        ];
        $statuses = ['active', 'inactive'];
        $ecommerceStatuses = ['yes', 'no'];

        $subCategories = [];

        for ($i = 0; $i <= 10; $i++) {
            $subCategories[] = [
                'parent_category_id' => rand(1, $parentCategoriesCount),
                'name' => fake()->company(),
                'slug' => strtolower(str_replace(' ', '-', fake()->company())),
                'image' => $images[rand(0, 4)],
                'icon_image' => $images[rand(0, 4)],
                'status_ecommerce' => $ecommerceStatuses[rand(0, 1)],
                'status' => $statuses[rand(0, 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('sub_categories')->insertOrIgnore($subCategories);
    }
}
