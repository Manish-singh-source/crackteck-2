<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductSerial;

class ProductSerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // pick a set of SKUs from ProductsSeeder
        $skus = [
            'SKU48751',
            'SKU48752',
            'SKU48753',
            'SKU48754',
            'SKU48755',
            'SKU48756',
            'SKU48757',
            'SKU48758',
            'SKU48759',
            'SKU48760'
        ];

        $products = Product::whereIn('sku', $skus)->get()->keyBy('sku');

        $inserts = [];

        foreach ($products as $product) {
            // Auto-generated serial
            $inserts[] = [
                'product_id' => $product->id,
                'auto_generated_serial' => ProductSerial::generateAutoSerial($product->sku),
                'manual_serial' => null,
                'cost_price' => $product->cost_price ?? 0,
                'selling_price' => $product->selling_price ?? 0,
                'discount_price' => $product->discount_price ?? null,
                'tax' => $product->tax ?? null,
                'final_price' => $product->final_price ?? ($product->selling_price ?? 0),
                'main_product_image' => $product->main_product_image,
                'additional_product_images' => json_encode([$product->main_product_image]),
                'variations' => json_encode(['color' => 'Black']),
                'status' => "1",
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Manual serial (example)
            $inserts[] = [
                'product_id' => $product->id,
                'auto_generated_serial' => ProductSerial::generateAutoSerial($product->sku),
                'manual_serial' => 'MAN-' . $product->sku . '-001',
                'cost_price' => $product->cost_price ?? 0,
                'selling_price' => $product->selling_price ?? 0,
                'discount_price' => $product->discount_price ?? null,
                'tax' => $product->tax ?? null,
                'final_price' => $product->final_price ?? ($product->selling_price ?? 0),
                'main_product_image' => $product->main_product_image,
                'additional_product_images' => json_encode([$product->main_product_image]),
                'variations' => json_encode(['color' => 'White']),
                'status' => "1",
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($inserts)) {
            DB::table('product_serials')->insert($inserts);
        }
    }
}
