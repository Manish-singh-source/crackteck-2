<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;

class CouponUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $coupons = Coupon::active()->limit(5)->get();
        if ($coupons->isEmpty()) {
            return; // no coupons to seed usage for
        }

        $customers = Customer::inRandomOrder()->limit(10)->get();
        if ($customers->isEmpty()) {
            return; // no customers
        }

        $orders = Order::where('total_amount', '>', 0)->inRandomOrder()->limit(20)->get();
        if ($orders->isEmpty()) {
            // no eligible orders; nothing to link
            return;
        }

        $inserts = [];

        // Create some coupon usages
        foreach ($coupons as $coupon) {
            // make 1-3 usages per coupon
            $uses = rand(1, 3);
            for ($i = 0; $i < $uses; $i++) {
                $cust = $customers->random();
                // try to find an order for this customer, otherwise pick any
                $order = $orders->firstWhere('customer_id', $cust->id) ?? $orders->random();

                $discount = min($coupon->discount_value ?? 50, $order->total_amount * 0.5);

                $inserts[] = [
                    'coupon_id' => $coupon->id,
                    'customer_id' => $cust->id,
                    'order_id' => $order->id,
                    'discount_amount' => $discount,
                    'used_at' => $now->subDays(rand(1, 30))->toDateTimeString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // increment used count for coupon
                DB::table('coupons')->where('id', $coupon->id)->increment('used_count');
            }
        }

        if (!empty($inserts)) {
            DB::table('coupon_usages')->insert($inserts);
        }
    }
}
