<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;

class StockInHandProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // find a couple of stock_in_hand records to attach products to
        $sihForService2 = DB::table('stock_in_hands')->where('service_request_id', 2)->value('id');
        $sihForService3 = DB::table('stock_in_hands')->where('service_request_id', 3)->value('id');

        // pick two products seeded earlier
        $battery = Product::where('sku', 'SKU48756')->first();
        $dell = Product::where('sku', 'SKU48751')->first();

        $inserts = [];

        if ($sihForService2 && $battery) {
            $serialId = DB::table('product_serials')->where('product_id', $battery->id)->value('id');

            $inserts[] = [
                'stock_in_hand_id' => $sihForService2,
                'product_id' => $battery->id,
                'product_serial_id' => $serialId,
                'requested_quantity' => 1,
                'delivered_quantity' => 1,
                'unit_price' => $battery->selling_price ?? 0,
                'status' => "completed",
                'notes' => 'Battery replaced during pickup cycle.',
                'picked_at' => $now->copy()->subDays(3),
                'returned_at' => null,
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(2),
            ];
        }

        if ($sihForService3 && $dell) {
            $serialId = DB::table('product_serials')->where('product_id', $dell->id)->value('id');

            $inserts[] = [
                'stock_in_hand_id' => $sihForService3,
                'product_id' => $dell->id,
                'product_serial_id' => $serialId,
                'requested_quantity' => 2,
                'delivered_quantity' => 0,
                'unit_price' => $dell->selling_price ?? 0,
                'status' => "pending",
                'notes' => 'Spare parts requested for diagnostic.',
                'picked_at' => null,
                'returned_at' => null,
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ];
        }

        if (!empty($inserts)) {
            DB::table('stock_in_hand_products')->insert($inserts);
        }
    }
}
