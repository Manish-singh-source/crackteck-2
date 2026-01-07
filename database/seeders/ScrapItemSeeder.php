<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductSerial;

class ScrapItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Pick up to 5 products to attach scrap items to
        $products = Product::limit(5)->get();

        if ($products->isEmpty()) {
            // No products available to attach scrap records to
            return;
        }

        $serials = ProductSerial::whereIn('product_id', $products->pluck('id'))->get();

        $inserts = [];

        foreach ($products as $product) {
            // Product-level scrap (no specific serial)
            $inserts[] = [
                'product_id' => $product->id,
                'product_serial_id' => null,
                'quantity_scrapped' => rand(1, 3),
                'reason_for_scrap' => 'Damaged in transit',
                'scrap_notes' => 'Packaging torn and unit not powering on.',
                'photos' => json_encode(['damaged_' . strtolower($product->sku ?? 'prod') . '.jpg']),
                'scrapped_by' => 1,
                'scrapped_at' => $now->subDays(rand(1, 30))->toDateTimeString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // If a product serial exists, create a serial-specific scrap
            $ps = $serials->where('product_id', $product->id)->first();
            if ($ps) {
                $inserts[] = [
                    'product_id' => $product->id,
                    'product_serial_id' => $ps->id,
                    'quantity_scrapped' => 1,
                    'reason_for_scrap' => 'Defective unit',
                    'scrap_notes' => 'Unit failed QA during inspection.',
                    'photos' => json_encode([$ps->auto_generated_serial . '.jpg']),
                    'scrapped_by' => 2,
                    'scrapped_at' => $now->subDays(rand(1, 30))->toDateTimeString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($inserts)) {
            DB::table('scrap_items')->insert($inserts);
        }
    }
}
