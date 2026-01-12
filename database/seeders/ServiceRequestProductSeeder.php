<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequest;
use App\Models\CoveredItem;
use App\Models\Product;

class ServiceRequestProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $requests = ServiceRequest::latest()->take(4)->get();
        $covered = CoveredItem::pluck('id')->toArray();

        foreach ($requests as $index => $req) {
            // First product: usually the device reported
            DB::table('service_request_products')->insert([
                [
                    'service_requests_id' => $req->id,
                    'name' => 'DELL 15 Notebook',
                    'type' => 'Laptop',
                    'model_no' => '35110',
                    'sku' => 'SKU48751',
                    'hsn' => 'HSN789',
                    'brand' => 'Dell',
                    'images' => json_encode(['uploads/warehouse/products/2-4-1.png']),
                    'description' => 'Customer reported display flicker and battery drain.',
                    'item_code_id' => $covered[$index % max(1, count($covered))] ?? null,
                    'service_charge' => 999.00,
                    'purchase_date' => '2024-10-15',
                    'status' => "pending",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'service_requests_id' => $req->id,
                    'name' => 'Battery Replacement',
                    'type' => 'Spare Part',
                    'model_no' => 'LB-DI100',
                    'sku' => 'SKU48756',
                    'hsn' => 'HSN794',
                    'brand' => 'Dell',
                    'images' => json_encode(['uploads/warehouse/products/Spare Part.png']),
                    'description' => 'Replace battery as per customer request.',
                    'item_code_id' => $covered[$index % max(1, count($covered))] ?? null,
                    'service_charge' => 2500.00,
                    'purchase_date' => '2024-08-01',
                    'status' => "pending",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }
}
