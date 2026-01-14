<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequestProductRequestPart;
use App\Models\ProductSerial;

class RequestedPartDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $partsRequests = ServiceRequestProductRequestPart::whereIn('status', ['approved', 'picked', 'in_transit'])->inRandomOrder()->limit(30)->get();
        if ($partsRequests->isEmpty()) {
            return;
        }

        $deliveries = [];

        foreach ($partsRequests as $pr) {
            $quantity = rand(1, 3);
            $unitPrice = rand(100, 2000);
            $totalPrice = $quantity * $unitPrice;

            $deliveredAt = null;
            if (in_array($pr->status, ['picked', 'in_transit'])) {
                $deliveredAt = $now->subDays(rand(0, 10))->toDateTimeString();
            }

            $deliveries[] = [
                'request_id' => $pr->request_id,
                'product_id' => $pr->product_id,
                'request_part_id' => $pr->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
                'notes' => 'Seeded delivery',
                'otp' => rand(100000, 999999),
                'otp_expiry' => $now->addHours(4)->toDateTimeString(),
                'delivered_at' => $deliveredAt,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($deliveries)) {
            DB::table('requested_part_deliveries')->insert($deliveries);
        }
    }
}
