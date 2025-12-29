<?php

namespace Database\Seeders;

use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\Product;
use App\Models\SparePartRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SparePartRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sample data
        $products = Product::limit(5)->get();
        $engineers = Engineer::limit(3)->get();
        $deliveryMen = DeliveryMan::limit(2)->get();

        if ($products->isEmpty() || $engineers->isEmpty()) {
            $this->command->info('Please ensure you have products and engineers in the database first.');

            return;
        }

        $urgencyLevels = ['Low', 'Medium', 'High', 'Critical'];
        $approvalStatuses = ['Pending', 'Approved', 'Rejected'];
        $reasons = [
            'Replacement due to damage',
            'Preventive maintenance',
            'Performance upgrade',
            'Warranty replacement',
            'Emergency repair',
        ];

        // Create 10 sample spare part requests
        for ($i = 0; $i < 10; $i++) {
            SparePartRequest::create([
                'product_id' => $products->random()->id,
                'requested_by' => $engineers->random()->id,
                'delivery_man_id' => $deliveryMen->isNotEmpty() ? $deliveryMen->random()->id : null,
                'request_date' => Carbon::now()->subDays(rand(1, 30)),
                'urgency_level' => $urgencyLevels[array_rand($urgencyLevels)],
                'quantity' => rand(1, 5),
                'reason' => $reasons[array_rand($reasons)],
                'approval_status' => $approvalStatuses[array_rand($approvalStatuses)],
                'service_request_id' => 'SR-'.str_pad($i + 1, 5, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('Spare part requests seeded successfully!');
    }
}
