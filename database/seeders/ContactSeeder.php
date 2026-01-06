<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('contacts')->insert([
            [
                'first_name' => 'Rohit',
                'last_name' => 'Sharma',
                'email' => 'rohit.sharma@example.com',
                'phone' => '1234567890',
                'subject' => 'Website Inquiry',
                'description' => 'I want to know about your web development services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Priya',
                'last_name' => 'Patel',
                'email' => 'priya.patel@example.com',
                'phone' => '1234567890',
                'subject' => 'Product Inquiry',
                'description' => 'Can you provide more details about your product?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Amit',
                'last_name' => 'Kumar',
                'email' => 'amit.kumar@example.com',
                'phone' => '1234567890',
                'subject' => 'Support Request',
                'description' => 'I need help with my account login issue.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Neha',
                'last_name' => 'Singh',
                'email' => 'neha.singh@example.com',
                'phone' => '1234567890',
                'subject' => 'Partnership',
                'description' => 'Interested in collaborating with your company.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Vikas',
                'last_name' => 'Verma',
                'email' => 'vikas.verma@example.com',
                'phone' => '1234567890',
                'subject' => 'Feedback',
                'description' => 'Your website is very user-friendly. Great job!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
