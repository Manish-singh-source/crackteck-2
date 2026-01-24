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
        $now = Carbon::now();

        $brands = DB::table('brands')->pluck('id')->toArray();
        $parentCategories = DB::table('parent_categories')->pluck('id')->toArray();
        $subCategories = DB::table('sub_categories')->pluck('id')->toArray();
        $vendors = DB::table('vendors')->pluck('id')->toArray();
        $warehouses = DB::table('warehouses')->pluck('id')->toArray();

        $products = [];

        for ($i = 0; $i < 16; $i++) {
            $sku = 'SKU' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            $modelNo = 'MODEL' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            $vendor_id = $vendors[array_rand($vendors)];
            $vendor_purchase_order_id = DB::table('vendor_purchase_orders')->where('vendor_id', $vendor_id)->pluck('id')->toArray();

            // cost price 
            $cost_price = rand(1000, 10000);
            $selling_price = $cost_price + rand(1000, 10000);
            $discount_price = rand(0, $selling_price);
            $tax = rand(0, 100);
            $final_price = $selling_price + $tax;

            // stock quantity
            $stock_quantity = rand(0, 100);
            if ($stock_quantity == 0) {
                $stock_status = 'out_of_stock';
            } elseif($stock_quantity < 10) {
                $stock_status = 'low_stock';
            } else {
                $stock_status = 'in_stock';
            }

            // images
            $main_product_image = 'frontend-assets/images/new-products/1-1.png';
            $additional_product_images = json_encode(['frontend-assets/images/new-products/1-2.png', 'frontend-assets/images/new-products/1-3.png']);
            $datasheet_manual = 'frontend-assets/images/new-products/1-4.png';

            // variation options
            $variation_options = json_encode(['color' => 'Black']);

            // status
            $statuses = ['active', 'inactive'];
            $status = $statuses[array_rand($statuses)];


            $products[] = [
                'vendor_id' => $vendor_id,
                'vendor_purchase_order_id' => $vendor_purchase_order_id[array_rand($vendor_purchase_order_id)],
                'brand_id' => $brands[array_rand($brands)],
                'parent_category_id' => $parentCategories[array_rand($parentCategories)],
                'sub_category_id' => $subCategories[array_rand($subCategories)],
                'warehouse_id' => $warehouses[array_rand($warehouses)],

                'product_name' => fake()->company(),
                'hsn_code' => fake()->randomNumber(6),
                'sku' => $sku,
                'model_no' => $modelNo,
                'short_description' => fake()->paragraph(),
                'full_description' => fake()->paragraph(),
                'technical_specification' => fake()->paragraph(),
                'brand_warranty' => fake()->sentence(),
                'company_warranty' => fake()->sentence(),

                'cost_price' => $cost_price,
                'selling_price' => $selling_price,
                'discount_price' => $discount_price,
                'tax' => $tax,
                'final_price' => $final_price,
                'stock_quantity' => $stock_quantity,

                'stock_status' => $stock_status,
                'main_product_image' => $main_product_image,
                'additional_product_images' => $additional_product_images,
                'datasheet_manual' => $datasheet_manual,
                'variation_options' => $variation_options,
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('products')->insert($products);
    }
}
