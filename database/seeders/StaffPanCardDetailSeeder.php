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

        StaffPanCardDetail::truncate();

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        Staff::chunk(50, function ($staffs) use ($letters, $images) {
            foreach ($staffs as $staff) {
                // Ensure that both images are different
                $frontImage = $images[array_rand($images)];
                $backImage = $frontImage;
                while ($backImage === $frontImage) {
                    $backImage = $images[array_rand($images)];
                }

                $pan = substr(str_shuffle($letters), 0, 5) . rand(1000, 9999) . substr(str_shuffle($letters), 0, 1);
                StaffPanCardDetail::create([
                    'staff_id' => $staff->id,
                    'pan_number' => $pan,
                    'pan_card_front_path' => $frontImage,
                    'pan_card_back_path' => $backImage,
                ]);
            }
        });
    }
}
