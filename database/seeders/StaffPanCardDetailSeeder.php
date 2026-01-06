<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffPanCardDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffPanCardDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffPanCardDetail::truncate();

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        Staff::chunk(50, function ($staffs) use ($letters) {
            foreach ($staffs as $staff) {
                $pan = substr(str_shuffle($letters), 0, 5) . rand(1000, 9999) . substr(str_shuffle($letters), 0, 1);
                StaffPanCardDetail::create([
                    'staff_id' => $staff->id,
                    'pan_number' => $pan,
                    'pan_card_front_path' => "uploads/pan/front_{$staff->id}.jpg",
                    'pan_card_back_path' => "uploads/pan/back_{$staff->id}.jpg",
                ]);
            }
        });
    }
}
