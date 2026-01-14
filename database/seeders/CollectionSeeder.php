<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ParentCategory;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Ensure a few parent categories exist
        if (ParentCategory::count() < 3) {
            DB::table('parent_categories')->insert([
                [
                    'slug' => 'electronics', 
                    'name' => 'Electronics',
                    'sort_order' => 1,
                    'status' => "active", 
                    'created_at' => $now, 
                    'updated_at' => $now],
                [
                    'slug' => 'home-appliances', 
                    'name' => 'Home Appliances',
                    'sort_order' => 2,
                    'status' => "active", 
                    'created_at' => $now, 
                    'updated_at' => $now],
                [
                    'slug' => 'kitchen', 
                    'name' => 'Kitchen',
                    'sort_order' => 3,
                    'status' => "active", 
                    'created_at' => $now, 
                    'updated_at' => $now],
            ]);
        }

        $categories = ParentCategory::inRandomOrder()->limit(6)->get();

        $collections = [
            [
                'name' => 'summer-deals', 
                'slug' => 'summer-deals', 
                'description' => 'Best summer discounts', 
                'image_url' => null, 
                'sort_order' => 1, 
                'status' => "active", 
                'products_count' => 0, 
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'name' => 'top-rated', 
                'slug' => 'top-rated', 
                'description' => 'Top rated products', 
                'image_url' => null, 
                'sort_order' => 2, 
                'status' => "active", 
                'products_count' => 0, 
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'name' => 'new-arrivals', 
                'slug' => 'new-arrivals', 
                'description' => 'Latest products', 
                'image_url' => null, 
                'sort_order' => 3, 
                'status' => "active", 
                'products_count' => 0, 
                'created_at' => $now, 
                'updated_at' => $now
            ],
        ];

        DB::table('collections')->insert($collections);

        // Attach categories to collections
        $insertedCollections = DB::table('collections')->orderBy('id', 'desc')->limit(3)->get();

        foreach ($insertedCollections as $collection) {
            if ($categories->isEmpty()) {
                continue;
            }

            $pickCount = rand(1, min(3, $categories->count()));
            $picked = $categories->random($pickCount);
            if (! $picked instanceof \Illuminate\Support\Collection) {
                $picked = collect([$picked]);
            }

            $sort = 1;
            foreach ($picked as $cat) {
                DB::table('collection_categories')->insert([
                    'collection_id' => $collection->id,
                    'category_id' => $cat->id,
                    'sort_order' => $sort++,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
