<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockInHandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('stock_in_hands')->insert([
            [
                'stock_in_hand_id' => 'SIH-' . $now->copy()->subDays(4)->format('Ymd') . '-001',
                'service_request_id' => 2,
                'engineer_id' => 2,
                'customer_id' => 2,
                'requested_at' => $now->copy()->subDays(4),
                'assigned_delivery_man_id' => 6,
                'assigned_at' => $now->copy()->subDays(3),
                'delivered_at' => $now->copy()->subDays(2),
                'status' => "4",
                'request_notes' => 'Replace battery for Dell Inspiron (customer agreed to replacement).',
                'delivery_photos' => json_encode(['uploads/delivery/si1_photo1.jpg']),
                'cancellation_reason' => null,
                'requested_quantity' => 1,
                'delivered_quantity' => 1,
                'requested_date' => $now->copy()->subDays(4)->toDateString(),
                'approved_at' => $now->copy()->subDays(4)->addHours(2),
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'stock_in_hand_id' => 'SIH-' . \Carbon\Carbon::now()->subDays(2)->format('Ymd') . '-001',
                'service_request_id' => 3,
                'engineer_id' => 3,
                'customer_id' => 3,
                'requested_at' => \Carbon\Carbon::now()->subDays(2),
                'assigned_delivery_man_id' => null,
                'assigned_at' => null,
                'delivered_at' => null,
                'status' => "0",
                'request_notes' => 'Spare part required for diagnostic follow-up.',
                'delivery_photos' => null,
                'cancellation_reason' => null,
                'requested_quantity' => 2,
                'delivered_quantity' => 0,
                'requested_date' => \Carbon\Carbon::now()->subDays(2)->toDateString(),
                'approved_at' => null,
                'created_at' => \Carbon\Carbon::now()->subDays(2),
                'updated_at' => \Carbon\Carbon::now()->subDays(2),
            ],
            [
                'stock_in_hand_id' => 'SIH-' . \Carbon\Carbon::now()->format('Ymd') . '-001',
                'service_request_id' => 1,
                'engineer_id' => 1,
                'customer_id' => 1,
                'requested_at' => \Carbon\Carbon::now(),
                'assigned_delivery_man_id' => null,
                'assigned_at' => null,
                'delivered_at' => null,
                'status' => "6",
                'request_notes' => 'Customer cancelled after request placed.',
                'delivery_photos' => null,
                'cancellation_reason' => 'Customer no longer available',
                'requested_quantity' => 1,
                'delivered_quantity' => 0,
                'requested_date' => \Carbon\Carbon::now()->toDateString(),
                'approved_at' => null,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
