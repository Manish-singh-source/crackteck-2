<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Ensure some customers exist (create a few directly if no factories available)
        if (Customer::count() < 3) {
            $now = Carbon::now();
            DB::table('customers')->insert([
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '9000000001',
                    'email' => 'john.doe@example.com',
                    'status' => "1",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'phone' => '9000000002',
                    'email' => 'jane.smith@example.com',
                    'status' => "1",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'first_name' => 'Acme',
                    'last_name' => 'Corp',
                    'phone' => '9000000003',
                    'email' => 'acme@example.com',
                    'status' => "1",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        $customers = Customer::inRandomOrder()->limit(5)->get();

        $orders = [];
        foreach ($customers as $cust) {
            $orders[] = [
                'customer_id' => $cust->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_items' => 0,
                'subtotal' => 0,
                'discount_amount' => 0,
                'coupon_code' => null,
                'tax_amount' => 0,
                'shipping_charges' => 0,
                'packaging_charges' => 0,
                'total_amount' => 0,
                'billing_address_id' => null,
                'shipping_address_id' => null,
                'billing_same_as_shipping' => 1,
                'order_status' => '0',
                'payment_status' => '0',
                'delivery_status' => '0',
                'source_platform' => '0',
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($orders)) {
            DB::table('orders')->insert($orders);
        }
    }
}
