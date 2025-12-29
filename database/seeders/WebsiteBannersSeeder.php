<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteBannersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('website_banners')->insert([
            [
                'banner_title' => 'Big Smartphone Sale',
                'banner_heading' => 'Latest Smartphones',
                'banner_sub_heading' => 'Up to 30% Off',
                'banner_url' => '/smartphones',
                'banner_description' => 'Discover the newest smartphones from Apple, Samsung, OnePlus and more with exciting offers.',
                'button_text' => 'Shop Now',
                'website_banner' => 'uploads/frontend/banner/main-banner-1.jpg',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'banner_title' => 'Laptop Deals',
                'banner_heading' => 'Powerful Laptops',
                'banner_sub_heading' => 'Save Big Today',
                'banner_url' => '/laptops',
                'banner_description' => 'Upgrade your work and gaming setup with premium laptops at unbeatable prices.',
                'button_text' => 'Explore Laptops',
                'website_banner' => 'uploads/frontend/banner/main-banner-2.jpg',
                'status' => 1,
                'sort_order' => 2,
            ],
            [
                'banner_title' => 'Smart Gadgets',
                'banner_heading' => 'Smartwatches & Accessories',
                'banner_sub_heading' => 'Trendy Tech Picks',
                'banner_url' => '/smartwatches',
                'banner_description' => 'Stay connected and stylish with our collection of smartwatches and tech accessories.',
                'button_text' => 'Discover Now',
                'website_banner' => 'uploads/frontend/banner/main-banner-3.jpg',
                'status' => 1,
                'sort_order' => 3,
            ],
        ]);
    }
}
