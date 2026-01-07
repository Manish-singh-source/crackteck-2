<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequestProductRequestPart;
use App\Models\Product;

class ServiceRequestQuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $partsRequests = ServiceRequestProductRequestPart::whereIn('status', ['requested', 'approved'])->inRandomOrder()->limit(30)->get();
        if ($partsRequests->isEmpty()) {
            return;
        }

        $products = Product::pluck('id')->toArray();

        $quotations = [];

        foreach ($partsRequests as $pr) {
            $productPrice = rand(200, 2000);
            $serviceCharge = rand(50, 500);
            $deliveryCharge = rand(20, 150);

            $total = $productPrice + $serviceCharge + $deliveryCharge;

            $status = ['pending', 'accepted', 'rejected'][array_rand(['pending', 'accepted', 'rejected'])];

            $quotations[] = [
                'service_request_id' => $pr->service_request_id,
                'service_request_product_request_part_id' => $pr->id,
                'requested_part_id' => $pr->requested_part_id ?? ($products ? $products[array_rand($products)] : null),
                'product_price' => $productPrice,
                'service_charge' => $serviceCharge,
                'delivery_charge' => $deliveryCharge,
                'total_amount' => $total,
                'discount' => rand(0, 200),
                'quotation_file' => null,
                'quotation_status' => $status,
                'quotation_date' => $now->subDays(rand(0, 30))->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($quotations)) {
            DB::table('service_request_quotations')->insert($quotations);
        }
    }
}
