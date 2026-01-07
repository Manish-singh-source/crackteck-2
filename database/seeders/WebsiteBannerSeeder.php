<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WebsiteBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('website_banners')->insert([
            [
                'title' => 'Big Smartphone Sale',
                'slug' => 'big-smartphone-sale',
                'description' => 'Discover the newest smartphones from Apple, Samsung, OnePlus and more with exciting offers.',
                'image_url' => 'uploads/frontend/banner/main-banner-1.jpg',
                'type' => "0",
                'channel' => 1,
                'is_active' => 1,
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Laptop Clearance Event',
                'slug' => 'laptop-clearance-event',
                'description' => 'Upgrade your tech with our laptop clearance event. Top brands at unbeatable prices.',
                'image_url' => 'uploads/frontend/banner/main-banner-2.jpg',
                'type' => "0",
                'channel' => 1,
                'is_active' => 1,
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Home Appliance Fest',
                'slug' => 'home-appliance-fest',
                'description' => 'Revamp your home with our exclusive deals on refrigerators, washing machines, and more.',
                'image_url' => 'uploads/frontend/banner/main-banner-3.jpg',
                'type' => "0",
                'channel' => 1,
                'is_active' => 1,
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
