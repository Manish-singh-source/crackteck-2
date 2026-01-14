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
            DB::table('customers')->insertOrIgnore([
                [
                    'customer_code' => 'CUS001',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '9000000001',
                    'email' => 'john.doe@example.com',
                    'dob' => '1990-01-01',
                    'gender' => 'male',
                    'customer_type' => 'ecommerce',
                    'source_type' => 'website',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'status' => "active",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'customer_code' => 'CUS002',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'phone' => '9000000002',
                    'email' => 'jane.smith@example.com',
                    'dob' => '1992-05-15',
                    'gender' => 'female',
                    'customer_type' => 'ecommerce',
                    'source_type' => 'website',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'status' => "active",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'customer_code' => 'CUS003',
                    'first_name' => 'Acme',
                    'last_name' => 'Corp',
                    'phone' => '9000000003',
                    'email' => 'acme@example.com',
                    'dob' => '1985-10-20',
                    'gender' => 'other',
                    'customer_type' => 'ecommerce',
                    'source_type' => 'website',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'status' => "active",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        $customers = Customer::inRandomOrder()->limit(3)->get();

        $orders = [];
        foreach ($customers as $cust) {
            $orders[] = [
                'customer_id' => $cust->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_items' => 0,
                'subtotal' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'shipping_charges' => 0,
                'packaging_charges' => 0,
                'total_amount' => 0,
                'billing_address_id' => null,
                'shipping_address_id' => null,
                'billing_same_as_shipping' => true,
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'delivery_status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
                'is_returnable' => true,
                'return_days' => 30,
                'return_status' => null,
                'refund_amount' => null,
                'refund_status' => null,
                'is_priority' => false,
                'requires_signature' => false,
                'is_gift' => false,
                'assigned_person_type' => null,
                'assigned_person_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'tracking_number' => null,
                'tracking_url' => null,
                'expected_delivery_date' => null,
                'confirmed_at' => null,
                'shipped_at' => null,
                'delivered_at' => null,
                'customer_notes' => null,
                'admin_notes' => null,
                'source_platform' => 'website',
                'otp_verified_at' => null,
                'otp' => null,
                'otp_expiry' => null,
            ];
        }

        if (!empty($orders)) {
            DB::table('orders')->insert($orders);
        }
    }
}
