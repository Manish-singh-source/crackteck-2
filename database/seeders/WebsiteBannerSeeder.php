<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('website_banners')->insert([
            [
                'title' => 'Big Smartphone Sale',
                'slug' => 'big-smartphone-sale',
                'description' => 'Discover the newest smartphones from Apple, Samsung, OnePlus and more with exciting offers.',
                'image_url' => 'uploads/frontend/banner/main-banner-1.jpg',
                'type' => "website",
                'channel' => "website",
                'promotion_type' => "discount",
                'discount_value' => 10,
                'discount_type' => "percentage",
                'promo_code' => "SAVE10",
                'link_url' => "https://www.technofra.com",
                'link_target' => "self",
                'position' => "homepage",
                'display_order' => 1,
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'click_count' => 0,
                'view_count' => 0,
                'metadata' => json_encode([]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Laptop Clearance Event',
                'slug' => 'laptop-clearance-event',
                'description' => 'Upgrade your tech with our laptop clearance event. Top brands at unbeatable prices.',
                'image_url' => 'uploads/frontend/banner/main-banner-2.jpg',
                'type' => "website",
                'channel' => "website",
                'promotion_type' => "discount",
                'discount_value' => 10,
                'discount_type' => "percentage",
                'promo_code' => "SAVE10",
                'link_url' => "https://www.technofra.com",
                'link_target' => "self",
                'position' => "homepage",
                'display_order' => 2,
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'click_count' => 0,
                'view_count' => 0,
                'metadata' => json_encode([]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Home Appliance Fest',
                'slug' => 'home-appliance-fest',
                'description' => 'Revamp your home with our exclusive deals on refrigerators, washing machines, and more.',
                'image_url' => 'uploads/frontend/banner/main-banner-3.jpg',
                'type' => "website",
                'channel' => "website",
                'promotion_type' => "discount",
                'discount_value' => 10,
                'discount_type' => "percentage",
                'promo_code' => "SAVE10",
                'link_url' => "https://www.technofra.com",
                'link_target' => "self",
                'position' => "homepage",
                'display_order' => 3,
                'is_active' => 1,
                'click_count' => 0,
                'view_count' => 0,
                'metadata' => json_encode([]),
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
