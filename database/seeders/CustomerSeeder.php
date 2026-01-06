<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customers = [
            [
                'customer_code' => 'CUS001',
                'first_name' => 'Saurabh',
                'last_name' => 'Damale',
                'phone' => '7709131547',
                'email' => 'saurabh.damale@gmail.com',
                'dob' => '1990-05-12',
                'gender' => '0',
                'customer_type' => '0',
                'source_type' => '1',
                'password' => bcrypt('password123'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'customer_code' => 'CUS002',
                'first_name' => 'Mayur',
                'last_name' => 'Satam',
                'phone' => '9892320172',
                'email' => 'mayursatam@gmail.com',
                'dob' => '1985-08-25',
                'gender' => '1',
                'customer_type' => '1',
                'source_type' => '2',
                'password' => bcrypt('password123'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'customer_code' => 'CUS003',
                'first_name' => 'Roshan',
                'last_name' => 'Yadav',
                'phone' => '8928339535',
                'email' => 'roshanyadav@gmail.com',
                'dob' => '1995-11-10',
                'gender' => '0',
                'customer_type' => '0',
                'source_type' => '3',
                'password' => bcrypt('password123'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_code' => 'CUS004',
                'first_name' => 'Manish',
                'last_name' => 'Singh',
                'phone' => '9988776655',
                'email' => 'manishsingh@gmail.com',
                'dob' => '1992-03-18',
                'gender' => '1',
                'customer_type' => '1',
                'source_type' => '1',
                'password' => bcrypt('password123'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($customers as $c) {
            \Illuminate\Support\Facades\DB::table('customers')->updateOrInsert(['customer_code' => $c['customer_code']], $c);
        }
    }
}
