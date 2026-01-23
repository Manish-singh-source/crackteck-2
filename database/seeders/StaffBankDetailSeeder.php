<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffBankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffBankDetailSeeder extends Seeder
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

        StaffBankDetail::truncate();

        $banks = ['State Bank of India', 'HDFC Bank', 'ICICI Bank', 'Axis Bank', 'Kotak Mahindra Bank', 'Punjab National Bank'];

        Staff::chunk(50, function ($staffs) use ($banks, $images) {
            foreach ($staffs as $staff) {
                $bank = $banks[array_rand($banks)];
                $ifsc = strtoupper(substr(str_replace(' ', '', $bank), 0, 4)) . '0' . str_pad((string)rand(0, 999999), 6, '0', STR_PAD_LEFT);

                // Ensure that both images are different
                $frontImage = $images[array_rand($images)];

                StaffBankDetail::create([
                    'staff_id' => $staff->id,
                    'bank_acc_holder_name' => trim($staff->first_name . ' ' . $staff->last_name),
                    'bank_acc_number' => (string) rand(100000000000, 999999999999),
                    'bank_name' => $bank,
                    'ifsc_code' => $ifsc,
                    'passbook_pic' => $frontImage,
                ]);
            }
        });
    }
}
