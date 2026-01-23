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
        $images = [
            'frontend-assets/images/new-products/1-1.png',
            'frontend-assets/images/new-products/1-2.png',
            'frontend-assets/images/new-products/1-3.png',
            'frontend-assets/images/new-products/1-4.png',
            'frontend-assets/images/new-products/1-5.png',
            'frontend-assets/images/new-products/2-1-1.png',
            'frontend-assets/images/new-products/2-1-2.png',
            'frontend-assets/images/new-products/2-2-1.png',
            'frontend-assets/images/new-products/2-2-2.png',
            'frontend-assets/images/new-products/2-3-1.png',
            'frontend-assets/images/new-products/2-3-2.png',
            'frontend-assets/images/new-products/2-4-1.png',
            'frontend-assets/images/new-products/2-4-2.png',
            'frontend-assets/images/new-products/2-5-1.png',
            'frontend-assets/images/new-products/2-5-2.png',
            'frontend-assets/images/new-products/header-product-1.png',
            'frontend-assets/images/new-products/header-product-2.png',
            'frontend-assets/images/new-products/header-product-3.png',
            'frontend-assets/images/new-products/header-product-4.png',
            'frontend-assets/images/new-products/header-product-5.png',
            'frontend-assets/images/new-products/header-product-6.png',
            'frontend-assets/images/new-products/header-product-7.png',
            'frontend-assets/images/new-products/header-product-8.png',
            'frontend-assets/images/new-products/header-product-9.png',
            'frontend-assets/images/new-products/header-product-10.png',
            'frontend-assets/images/new-products/header-product-11.png',
            'frontend-assets/images/new-products/header-product-12.png',
            'frontend-assets/images/new-products/product-detail-1.png',
            'frontend-assets/images/new-products/product-detail-2.webp',
            'frontend-assets/images/new-products/product-detail-3.webp',
            'frontend-assets/images/new-products/product-detail-4.webp',
            'frontend-assets/images/new-products/product-detail-5.webp',
            'frontend-assets/images/new-products/product-detail-6.webp',
            'frontend-assets/images/new-products/product-detail-7.webp'
        ];

        StaffVehicleDetail::truncate();

        $states = ['MH', 'DL', 'KA', 'TN', 'UP', 'WB'];
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $vehicleTypes = ['two_wheeler', 'three_wheeler', 'four_wheeler', 'other'];

        Staff::chunk(50, function ($staffs) use ($states, $letters, $images, $vehicleTypes) {
            foreach ($staffs as $staff) {
                // 70% chance staff owns a vehicle
                if (rand(1, 100) <= 70) {
                    $state = $states[array_rand($states)];
                    $num = str_pad((string)rand(1, 99), 2, '0', STR_PAD_LEFT);
                    $alpha = substr(str_shuffle($letters), 0, 2);
                    $last = str_pad((string)rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                    $vehNo = "{$state}{$num}{$alpha}{$last}";

                    // Ensure that both images are different
                    $frontImage = $images[array_rand($images)];
                    $backImage = $frontImage;
                    while ($backImage === $frontImage) {
                        $backImage = $images[array_rand($images)];
                    }

                    StaffVehicleDetail::create([
                        'staff_id' => $staff->id,
                        'vehicle_type' => $vehicleTypes[array_rand($vehicleTypes)],
                        'vehicle_number' => $vehNo,
                        'driving_license_no' => 'DL' . str_pad((string)rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT),
                        'driving_license_front_path' => $frontImage,
                        'driving_license_back_path' => $backImage,
                    ]);
                }
            }
        });
    }
}
