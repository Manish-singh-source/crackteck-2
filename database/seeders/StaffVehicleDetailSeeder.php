<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffVehicleDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffVehicleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffVehicleDetail::truncate();

        $states = ['MH', 'DL', 'KA', 'TN', 'UP', 'WB'];
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        Staff::chunk(50, function ($staffs) use ($states, $letters) {
            foreach ($staffs as $staff) {
                // 70% chance staff owns a vehicle
                if (rand(1, 100) <= 70) {
                    $state = $states[array_rand($states)];
                    $num = str_pad((string)rand(1, 99), 2, '0', STR_PAD_LEFT);
                    $alpha = substr(str_shuffle($letters), 0, 2);
                    $last = str_pad((string)rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                    $vehNo = "{$state}{$num}{$alpha}{$last}";
                    StaffVehicleDetail::create([
                        'staff_id' => $staff->id,
                        // 0 - Two-wheeler, 1 - Three-wheeler, 2 - Four-wheeler, 3 - Other
                        'vehicle_type' => (string) rand(0, 3),
                        'vehicle_number' => $vehNo,
                        'driving_license_no' => 'DL' . str_pad((string)rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT),
                        'driving_license_front_path' => "uploads/license/front_{$staff->id}.jpg",
                        'driving_license_back_path' => "uploads/license/back_{$staff->id}.jpg",
                    ]);
                }
            }
        });
    }
}
