<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test coupons
        $coupons = [
            [
                'coupon_code' => 'WELCOME10',
                'coupon_title' => 'Welcome Discount',
                'coupon_description' => 'Get 10% off on your first order',
                'discount_type' => 'percentage',
                'discount_value' => 10.00,
                'min_purchase_amount' => 500.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
                'total_usage_limit' => 100,
                'usage_limit_per_customer' => 1,
                'status' => 'active',
            ],
            [
                'coupon_code' => 'SAVE100',
                'coupon_title' => 'Save ₹100',
                'coupon_description' => 'Get ₹100 off on orders above ₹1000',
                'discount_type' => 'fixed_amount',
                'discount_value' => 100.00,
                'min_purchase_amount' => 1000.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(6),
                'total_usage_limit' => 50,
                'usage_limit_per_customer' => 2,
                'status' => 'active',
            ],
            [
                'coupon_code' => 'BIGDEAL20',
                'coupon_title' => 'Big Deal 20% Off',
                'coupon_description' => 'Massive 20% discount on all electronics',
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'min_purchase_amount' => 2000.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'total_usage_limit' => null, // Unlimited
                'usage_limit_per_customer' => 1,
                'status' => 'active',
            ],
            [
                'coupon_code' => 'EXPIRED50',
                'coupon_title' => 'Expired Coupon',
                'coupon_description' => 'This coupon has expired (for testing)',
                'discount_type' => 'fixed_amount',
                'discount_value' => 50.00,
                'min_purchase_amount' => null,
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->subMonth(),
                'total_usage_limit' => 10,
                'usage_limit_per_customer' => 1,
                'status' => 'active',
            ],
            [
                'coupon_code' => 'INACTIVE25',
                'coupon_title' => 'Inactive Coupon',
                'coupon_description' => 'This coupon is inactive (for testing)',
                'discount_type' => 'percentage',
                'discount_value' => 25.00,
                'min_purchase_amount' => null,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
                'total_usage_limit' => null,
                'usage_limit_per_customer' => null,
                'status' => 'inactive',
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::create($couponData);
        }

        $this->command->info('Test coupons created successfully!');
    }
}
