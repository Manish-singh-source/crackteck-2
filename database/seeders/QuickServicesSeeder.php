<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuickServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('quick_services')->insert([
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Quick Repair',
                'service_price' => 199,
                'service_description' => 'Fast repair service for small issues.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Full Cleaning',
                'service_price' => 299,
                'service_description' => 'Complete cleaning service.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Deep Maintenance',
                'service_price' => 399,
                'service_description' => 'Deep maintenance for devices.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Home Installation',
                'service_price' => 499,
                'service_description' => 'Installation service at home.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Accessory Replacement',
                'service_price' => 149,
                'service_description' => 'Quick accessory replacement service.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Device Checkup',
                'service_price' => 99,
                'service_description' => 'General checkup and diagnosis.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Software Update',
                'service_price' => 129,
                'service_description' => 'OS & software update service.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Water Damage Fix',
                'service_price' => 599,
                'service_description' => 'Fixing devices affected by water.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Battery Replacement',
                'service_price' => 249,
                'service_description' => 'Battery replacement service.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_image' => 'https://placehold.co/400x400',
                'name' => 'Screen Repair',
                'service_price' => 699,
                'service_description' => 'Screen repair service.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
