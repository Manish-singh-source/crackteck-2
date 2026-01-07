<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSerial;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $orders = Order::inRandomOrder()->limit(5)->get();
        $products = Product::inRandomOrder()->limit(10)->get();
        $serials = ProductSerial::whereIn('product_id', $products->pluck('id'))->get()->keyBy('product_id');

        $orderUpdates = [];
        $items = [];

        foreach ($orders as $order) {
            $numItems = rand(1, 3);
            $totalItems = 0;
            $subtotal = 0;
            $taxAmount = 0;

            for ($i = 0; $i < $numItems; $i++) {
                $product = $products->random();
                $qty = rand(1, 2);
                $unitPrice = $product->selling_price ?? 1000;
                $discount = rand(0, 50);
                $taxPerUnit = round($unitPrice * 0.18, 2);
                $lineTotal = ($unitPrice - $discount) * $qty + ($taxPerUnit * $qty);

                $ps = $serials->has($product->id) ? $serials[$product->id] : null;

                $items[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_serial_id' => $ps ? $ps->id : null,
                    'product_name' => $product->name ?? $product->sku,
                    'product_sku' => $product->sku ?? null,
                    'hsn_code' => null,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'discount_per_unit' => $discount,
                    'tax_per_unit' => $taxPerUnit,
                    'line_total' => $lineTotal,
                    'variant_details' => json_encode([]),
                    'custom_options' => json_encode([]),
                    'item_status' => '0',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $totalItems += $qty;
                $subtotal += ($unitPrice - $discount) * $qty;
                $taxAmount += $taxPerUnit * $qty;
            }

            $orderUpdates[] = [
                'id' => $order->id,
                'total_items' => $totalItems,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $subtotal + $taxAmount + ($order->shipping_charges ?? 0) + ($order->packaging_charges ?? 0),
                'updated_at' => $now,
            ];
        }

        if (!empty($items)) {
            DB::table('order_items')->insert($items);
        }

        foreach ($orderUpdates as $upd) {
            DB::table('orders')->where('id', $upd['id'])->update([
                'total_items' => $upd['total_items'],
                'subtotal' => $upd['subtotal'],
                'tax_amount' => $upd['tax_amount'],
                'total_amount' => $upd['total_amount'],
                'updated_at' => $upd['updated_at'],
            ]);
        }
    }
}
