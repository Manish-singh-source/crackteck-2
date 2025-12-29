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
        DB::table('customers')->insert([

            [
                'user_id' => 1,
                'first_name' => 'Saurabh',
                'last_name' => 'Damale',
                'phone' => '7709131547',
                'email' => 'saurabh.damale@example.com',
                'username' => 'saurabhdamale',
                'dob' => '1990-05-12',
                'branch_name' => 'Mumbai',
                'gender' => 'Male',
                'customer_type' => 'E-commerce Customer',
                'company_name' => null,
                'company_addr' => null,
                'gst_no' => null,
                'pan_no' => 'ABCDE1234F',
                'pic' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],

            [
                'user_id' => 1,
                'first_name' => 'Roshan',
                'last_name' => 'Yadav',
                'phone' => '8928339535',
                'email' => 'support@technofra.com',
                'username' => 'roshanyadav',
                'dob' => '1988-11-20',
                'branch_name' => 'Bengaluru',
                'gender' => 'Female',
                'customer_type' => 'AMC Customer',
                'company_name' => null,
                'company_addr' => null,
                'gst_no' => null,
                'pan_no' => 'FGHIJ5678K',
                'pic' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],

            [
                'user_id' => 1,
                'first_name' => 'Mayur',
                'last_name' => 'Satam',
                'phone' => '8591483531',
                'email' => 'mayur.satam@example.com',
                'username' => 'mayursatam',
                'dob' => '1985-02-03',
                'branch_name' => 'Ahmedabad',
                'gender' => 'Male',
                'customer_type' => 'Both',
                'company_name' => 'Patel Infotech Pvt Ltd',
                'company_addr' => 'SG Highway, Ahmedabad, Gujarat',
                'gst_no' => '24ABCDE1234F1Z5',
                'pan_no' => 'ABCDE1234F',
                'pic' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],

            [
                'user_id' => 1,
                'first_name' => 'Manish',
                'last_name' => 'Singh',
                'phone' => '7039553407',
                'email' => 'manish.singh@example.com',
                'username' => 'manishsingh',
                'dob' => '1992-07-18',
                'branch_name' => 'Delhi',
                'gender' => 'Female',
                'customer_type' => 'E-commerce Customer',
                'company_name' => 'Kapoor Traders',
                'company_addr' => 'Karol Bagh, New Delhi',
                'gst_no' => '07FGHIJ5678K2Z7',
                'pan_no' => 'FGHIJ5678K',
                'pic' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],

            [
                'user_id' => 1,
                'first_name' => 'Khushi',
                'last_name' => 'Yadav',
                'phone' => '8080803375',
                'email' => 'khushi.yadav@example.com',
                'username' => 'khushi',
                'dob' => '1989-03-10',
                'branch_name' => 'Hyderabad',
                'gender' => 'Male',
                'customer_type' => 'AMC Customer',
                'company_name' => null,
                'company_addr' => null,
                'gst_no' => null,
                'pan_no' => 'LMNOP1234Q',
                'pic' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],

        ]);
    }
}
