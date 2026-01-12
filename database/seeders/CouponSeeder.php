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
                'code' => 'WELCOME10',
                'title' => 'Welcome Discount',
                'description' => 'Get 10% off on your first order',
                'type' => 'percentage',
                'discount_value' => 10.00,
                'max_discount' => null,
                'min_purchase_amount' => 500.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
                'usage_limit' => 100,
                'used_count' => 0,
                'usage_per_customer' => 1,
                'is_active' => true,
                'applicable_categories' => 'all',
                'applicable_brands' => 'all',
                'excluded_products' => null,
                'stackable' => false,
            ],
            [
                'code' => 'SAVE100',
                'title' => 'Save ₹100',
                'description' => 'Get ₹100 off on orders above ₹1000',
                'type' => 'fixed',
                'discount_value' => 100.00,
                'min_purchase_amount' => 1000.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(6),
                'usage_limit' => 50,
                'usage_per_customer' => 2,
                "is_active" => true,
                'applicable_categories' => 'all',
                'applicable_brands' => 'all',
                'excluded_products' => null,
                'stackable' => false,
            ],
            [
                'code' => 'BIGDEAL20',
                'title' => 'Big Deal 20% Off',
                'description' => 'Massive 20% discount on all electronics',
                'type' => 'percentage',
                'discount_value' => 20.00,
                'min_purchase_amount' => 2000.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'usage_limit' => null, // Unlimited
                'usage_per_customer' => 1,
                "is_active" => true,
                'applicable_categories' => 'all',
                'applicable_brands' => 'all',
                'excluded_products' => null,
                'stackable' => false,
            ],
            [
                'code' => 'EXPIRED50',
                'title' => 'Expired Coupon',
                'description' => 'This coupon has expired (for testing)',
                'type' => 'fixed',
                'discount_value' => 50.00,
                'min_purchase_amount' => null,
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->subMonth(),
                'usage_limit' => 10,
                'usage_per_customer' => 1,
                "is_active" => true,
                'applicable_categories' => 'all',
                'applicable_brands' => 'all',
                'excluded_products' => null,
                'stackable' => false,
            ],
            [
                'code' => 'INACTIVE25',
                'title' => 'Inactive Coupon',
                'description' => 'This coupon is inactive (for testing)',
                'type' => 'percentage',
                'discount_value' => 25.00,
                'min_purchase_amount' => null,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
                'usage_limit' => null,
                'usage_per_customer' => 1,
                "is_active" => false,
                'applicable_categories' => 'all',
                'applicable_brands' => 'all',
                'excluded_products' => null,
                'stackable' => false,
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::updateOrCreate(['code' => $couponData['code']], $couponData);
        }

        $this->command->info('Test coupons created successfully!');
    }
}
