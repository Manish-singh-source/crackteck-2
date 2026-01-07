<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;

class OrderPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $orders = Order::whereIn('payment_status', ['pending', null])->limit(5)->get();

        $payments = [];
        $orderUpdates = [];

        foreach ($orders as $order) {
            if (empty($order->total_amount) || $order->total_amount <= 0) {
                // skip if order has no amount
                continue;
            }

            $payments[] = [
                'order_id' => $order->id,
                'payment_id' => 'PMT-' . strtoupper(uniqid()),
                'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                'payment_method' => 'cash',
                'payment_gateway' => 'manual',
                'amount' => $order->total_amount,
                'currency' => 'INR',
                'status' => 'completed',
                'response_data' => json_encode([]),
                'processed_at' => $now,
                'failure_reason' => null,
                'notes' => 'Seeded payment',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $orderUpdates[] = [
                'id' => $order->id,
                'payment_status' => 'paid',
                'updated_at' => $now,
            ];
        }

        if (!empty($payments)) {
            DB::table('order_payments')->insert($payments);
        }

        foreach ($orderUpdates as $upd) {
            DB::table('orders')->where('id', $upd['id'])->update([
                'payment_status' => $upd['payment_status'],
                'updated_at' => $upd['updated_at'],
            ]);
        }
    }
}
