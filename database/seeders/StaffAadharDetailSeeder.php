<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffAadharDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffAadharDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffAadharDetail::truncate();

        Staff::chunk(50, function ($staffs) {
            foreach ($staffs as $staff) {
                $aadhar = str_pad((string) rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);
                StaffAadharDetail::create([
                    'staff_id' => $staff->id,
                    'aadhar_number' => $aadhar,
                    'aadhar_front_path' => "uploads/aadhar/front_{$staff->id}.jpg",
                    'aadhar_back_path' => "uploads/aadhar/back_{$staff->id}.jpg",
                ]);
            }
        });
    }
}
