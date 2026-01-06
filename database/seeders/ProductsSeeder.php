<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();

        $parentIds = DB::table('parent_categories')->pluck('id')->toArray();
        $warehousesList = DB::table('warehouses')->pluck('id', 'warehouse_code')->toArray();
        $subCategories = DB::table('sub_categories')->select('id', 'parent_category_id')->get();

        $productsData = [
            [
                'vendor_id' => 1,
                'vendor_purchase_order_id' => 1,
                'warehouse_id' => 2,

                'product_name' => 'DELL 15 Intel Core i3 13th Gen 1305U',
                'hsn_code' => 'HSN789',
                'sku' => 'SKU48751',
                'brand_id' => 5,
                'model_no' => '35110',

                'short_description' => '<p>Short description of DELL 15 Laptop</p>',
                'full_description' => '<p>Full description with features and specifications.</p>',
                'technical_specification' => '<p>Technical specs: Intel i3, 8GB RAM, 512GB SSD.</p>',
                'brand_warranty' => 1,
                'cost_price' => 38000.00,
                'discount_price' => 500.00,
                'tax' => 18.00,
                'selling_price' => 42000.00,
                'final_price' => 49060.00,
                'stock_quantity' => 5,
                'stock_status' => '0',

                'main_product_image' => 'uploads/warehouse/products/2-4-1.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/2-4-2.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet1.pdf',
                'variation_options' => json_encode(['1' => ['1', '5'], '2' => ['7', '8']]),

                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 2,
                'vendor_purchase_order_id' => 2,
                'product_name' => 'HP Pavilion Gaming Laptop',
                'hsn_code' => 'HSN790',
                'sku' => 'SKU48752',
                'brand_id' => 1,
                'model_no' => 'HPG350',

                'short_description' => '<p>HP Pavilion Gaming Laptop</p>',
                'full_description' => '<p>Powerful gaming laptop with RTX graphics.</p>',
                'technical_specification' => '<p>Intel i7, 16GB RAM, 1TB SSD.</p>',
                'brand_warranty' => 1,
                'cost_price' => 62000.00,
                'discount_price' => 1000.00,
                'tax' => 18.00,
                'selling_price' => 68500.00,
                'final_price' => 79830.00,
                'stock_quantity' => 10,
                'stock_status' => '0',
                'warehouse_id' => 1,

                'main_product_image' => 'uploads/warehouse/products/2-4-1.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/2-4-2.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet2.pdf',
                'variation_options' => json_encode(['1' => ['1', '2'], '2' => ['3', '4']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Repeat similar structure for 8 more products
            [
                'vendor_id' => 3,
                'vendor_purchase_order_id' => 3,
                'product_name' => 'Asus ZenBook 14',
                'hsn_code' => 'HSN791',
                'sku' => 'SKU48753',
                'brand_id' => 3,
                'model_no' => 'AZ140',

                'short_description' => '<p>Lightweight ultrabook</p>',
                'full_description' => '<p>Asus ZenBook 14 with sleek design and powerful performance.</p>',
                'technical_specification' => '<p>Intel i5, 8GB RAM, 256GB SSD.</p>',
                'brand_warranty' => 1,
                'cost_price' => 52500.00,
                'discount_price' => 750.00,
                'tax' => 18.00,
                'selling_price' => 57000.00,
                'final_price' => 66510.00,
                'stock_quantity' => 8,
                'stock_status' => '0',
                'warehouse_id' => 3,

                'main_product_image' => 'uploads/warehouse/products/2-4-1.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/2-4-2.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet3.pdf',
                'variation_options' => json_encode(['1' => ['1', '3'], '2' => ['5', '6']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 1,
                'vendor_purchase_order_id' => 1,
                'product_name' => 'Dell Inspiron 16',
                'hsn_code' => 'HSN792',
                'sku' => 'SKU48754',
                'brand_id' => 5,
                'model_no' => 'DI160',

                'short_description' => '<p>16-inch display laptop</p>',
                'full_description' => '<p>Dell Inspiron 16 with Intel i5 processor and 512GB SSD.</p>',
                'technical_specification' => '<p>Intel i5, 8GB RAM, 512GB SSD.</p>',
                'brand_warranty' => 1,
                'cost_price' => 44000.00,
                'discount_price' => 600.00,
                'tax' => 18.00,
                'selling_price' => 48200.00,
                'final_price' => 56276.00,
                'stock_quantity' => 6,
                'stock_status' => '0',
                'warehouse_id' => 4,

                'main_product_image' => 'uploads/warehouse/products/2-4-1.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/2-4-2.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet4.pdf',
                'variation_options' => json_encode(['1' => ['2', '4'], '2' => ['6', '8']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 2,
                'vendor_purchase_order_id' => 2,
                'product_name' => 'HP EliteBook 840',
                'hsn_code' => 'HSN793',
                'sku' => 'SKU48755',
                'brand_id' => 1,
                'model_no' => 'HE840',

                'short_description' => '<p>Business ultrabook</p>',
                'full_description' => '<p>HP EliteBook 840 with security features.</p>',
                'technical_specification' => '<p>Intel i5, 8GB RAM, 256GB SSD.</p>',
                'brand_warranty' => 1,
                'cost_price' => 71000.00,
                'discount_price' => 1200.00,
                'tax' => 18.00,
                'selling_price' => 78000.00,
                'final_price' => 90840.00,
                'stock_quantity' => 4,
                'stock_status' => '0',
                'warehouse_id' => 5,

                'main_product_image' => 'uploads/warehouse/products/2-4-1.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/2-4-2.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet5.pdf',
                'variation_options' => json_encode(['1' => ['3', '5'], '2' => ['7', '9']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // You can continue adding 5 more products with similar structure

            // Spare Part
            [
                'vendor_id' => 3,
                'vendor_purchase_order_id' => 3,
                'product_name' => 'Laptop Battery for Dell Inspiron',
                'hsn_code' => 'HSN794',
                'sku' => 'SKU48756',
                'brand_id' => 5,
                'model_no' => 'LB-DI100',

                'parent_category_id' => 13,
                'sub_category_id' => 2,
                'short_description' => '<p>Replacement battery for Dell Inspiron series</p>',
                'full_description' => '<p>High-performance Lithium-ion 6-cell battery compatible with multiple Dell models.</p>',
                'technical_specification' => '<p>11.1V, 4400mAh capacity, OEM grade cells.</p>',
                'brand_warranty' => 1,
                'cost_price' => 5800.00,
                'discount_price' => 200.00,
                'tax' => 18.00,
                'selling_price' => 6400.00,
                'final_price' => 7552.00,
                'stock_quantity' => 15,
                'stock_status' => '0',
                'warehouse_id' => 2,

                'main_product_image' => 'uploads/warehouse/products/Spare Part.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/Spare Part.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet6.pdf',
                'variation_options' => json_encode(['1' => ['2', '3'], '2' => ['4', '5']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 1,
                'vendor_purchase_order_id' => 1,
                'product_name' => 'HP Adapter 65W Original',
                'hsn_code' => 'HSN795',
                'sku' => 'SKU48757',
                'brand_id' => 1,
                'model_no' => 'HPAD65',

                'parent_category_id' => 13,
                'sub_category_id' => 1,
                'short_description' => '<p>65W original HP laptop adapter</p>',
                'full_description' => '<p>Reliable power adapter compatible with HP Pavilion and EliteBook series.</p>',
                'technical_specification' => '<p>65W, 19.5V, 3.33A, 4.5mm pin.</p>',
                'brand_warranty' => 1,
                'cost_price' => 2300.00,
                'discount_price' => 100.00,
                'tax' => 18.00,
                'selling_price' => 2600.00,
                'final_price' => 3068.00,
                'stock_quantity' => 25,
                'stock_status' => '0',
                'warehouse_id' => 1,

                'main_product_image' => 'uploads/warehouse/products/Spare Part.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/Spare Part.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet7.pdf',
                'variation_options' => json_encode(['1' => ['1', '3'], '2' => ['5', '7']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 2,
                'vendor_purchase_order_id' => 2,
                'product_name' => 'Lenovo Laptop Keyboard',
                'hsn_code' => 'HSN796',
                'sku' => 'SKU48758',
                'brand_id' => 2,
                'model_no' => 'LK-LNV01',

                'parent_category_id' => 13,
                'sub_category_id' => 1,
                'short_description' => '<p>Original Lenovo replacement keyboard</p>',
                'full_description' => '<p>Backlit keyboard suitable for Lenovo ThinkBook and IdeaPad series.</p>',
                'technical_specification' => '<p>QWERTY, backlit, spill-resistant.</p>',
                'brand_warranty' => 1,
                'cost_price' => 1800.00,
                'discount_price' => 50.00,
                'tax' => 18.00,
                'selling_price' => 2100.00,
                'final_price' => 2479.00,
                'stock_quantity' => 30,
                'stock_status' => '0',
                'warehouse_id' => 3,

                'main_product_image' => 'uploads/warehouse/products/Spare Part.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/Spare Part.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet8.pdf',
                'variation_options' => json_encode(['1' => ['2', '5'], '2' => ['6', '8']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 3,
                'vendor_purchase_order_id' => 3,
                'product_name' => 'Laptop Cooling Fan for HP Pavilion',
                'hsn_code' => 'HSN797',
                'sku' => 'SKU48759',
                'brand_id' => 1,
                'model_no' => 'HPCF450',

                'parent_category_id' => 13,
                'sub_category_id' => 1,
                'short_description' => '<p>Cooling fan replacement for HP Pavilion models</p>',
                'full_description' => '<p>Durable and quiet cooling fan designed for efficient heat dissipation.</p>',
                'technical_specification' => '<p>Voltage: 5V, Speed: 5400RPM, Copper bearings.</p>',
                'brand_warranty' => 0,
                'cost_price' => 1200.00,
                'discount_price' => 30.00,
                'tax' => 18.00,
                'selling_price' => 1400.00,
                'final_price' => 1652.00,
                'stock_quantity' => 40,
                'stock_status' => '0',
                'warehouse_id' => 4,

                'main_product_image' => 'uploads/warehouse/products/Spare Part.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/Spare Part.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet9.pdf',
                'variation_options' => json_encode(['1' => ['1', '2'], '2' => ['3', '4']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'vendor_id' => 1,
                'vendor_purchase_order_id' => 1,
                'product_name' => 'Asus 512GB SSD Replacement',
                'hsn_code' => 'HSN798',
                'sku' => 'SKU48760',
                'brand_id' => 3,
                'model_no' => 'A512SSD',

                'parent_category_id' => 13,
                'sub_category_id' => 3,
                'short_description' => '<p>512GB M.2 SSD for Asus laptops</p>',
                'full_description' => '<p>High-speed NVMe SSD providing rapid read and write speeds for Asus laptops.</p>',
                'technical_specification' => '<p>PCIe Gen3, read speed 3500MB/s, write speed 3100MB/s.</p>',
                'brand_warranty' => 1,
                'cost_price' => 4500.00,
                'discount_price' => 150.00,
                'tax' => 18.00,
                'selling_price' => 4900.00,
                'final_price' => 5782.00,
                'stock_quantity' => 20,
                'stock_status' => '0',
                'warehouse_id' => 5,

                'main_product_image' => 'uploads/warehouse/products/Spare Part.png',
                'additional_product_images' => json_encode(['uploads/warehouse/products/Spare Part.png']),
                'datasheet_manual' => 'uploads/products/documents/datasheet10.pdf',
                'variation_options' => json_encode(['1' => ['4', '6'], '2' => ['7', '9']]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ];

        $toInsert = [];
        $parentCount = count($parentIds) ?: 1;

        foreach ($productsData as $index => $prod) {
            $parentId = $parentIds[$index % $parentCount];
            $subId = DB::table('sub_categories')->where('parent_category_id', $parentId)->value('id');

            $prod['parent_category_id'] = $parentId;
            $prod['sub_category_id'] = $subId;

            $toInsert[] = $prod;
        }

        if (!empty($toInsert)) {
            foreach ($toInsert as $prod) {
                try {
                    DB::table('products')->updateOrInsert(
                        ['sku' => $prod['sku']],
                        $prod
                    );
                } catch (\Exception $e) {
                    // Log the failing product name so we can debug
                    echo "Failed to insert product: " . ($prod['product_name'] ?? 'unknown') . " - " . $e->getMessage() . PHP_EOL;
                }
            }
        }
    }
}
