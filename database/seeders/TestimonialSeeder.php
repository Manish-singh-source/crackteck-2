<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $testimonials = [
            [
                'customer_name' => 'Ravi Kumar',
                'customer_image' => null,
                'customer_designation' => 'Engineer',
                'testimonial_text' => 'Great service and quick resolution.',
                'rating' => 5,
                'source' => 'web',
                'is_verified' => 1,
                'is_featured' => 1,
                'is_active' => "1",
                'display_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'customer_name' => 'Priya Sharma',
                'customer_image' => null,
                'customer_designation' => 'Manager',
                'testimonial_text' => 'Professional team and timely updates.',
                'rating' => 4,
                'source' => 'email',
                'is_verified' => 1,
                'is_featured' => 0,
                'is_active' => "1",
                'display_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'customer_name' => 'Amit Singh',
                'customer_image' => null,
                'customer_designation' => 'Owner',
                'testimonial_text' => 'Satisfied with the product quality.',
                'rating' => 5,
                'source' => 'mobile',
                'is_verified' => 1,
                'is_featured' => 1,
                'is_active' => "1",
                'display_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('testimonials')->insertOrIgnore($testimonials);
    }
}
