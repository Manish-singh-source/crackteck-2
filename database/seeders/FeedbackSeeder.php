<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('feedback')->insert([
            [
                'customer_id' => 1,
                'service_id' => 1,
                'service_type' => 'installation',
                'rating' => 5,
                'comments' => 'Excellent service and prompt response!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'service_id' => 3,
                'service_type' => 'quick_service',
                'rating' => 4,
                'comments' => 'Good service, but could be improved in some areas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'service_id' => 4,
                'service_type' => 'repairing',
                'rating' => 3,
                'comments' => 'Average experience, nothing special.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 4,
                'service_id' => 3,
                'service_type' => 'amc',
                'rating' => 5,
                'comments' => 'Excellent service and prompt response!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
