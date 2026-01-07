<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequestProduct;
use App\Models\AssignedEngineer;
use App\Models\Staff;
use App\Models\Product;

class ServiceRequestProductRequestPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $srProducts = ServiceRequestProduct::inRandomOrder()->limit(30)->get();
        if ($srProducts->isEmpty()) {
            return;
        }

        $staffs = Staff::inRandomOrder()->limit(10)->get();
        $parts = Product::inRandomOrder()->limit(20)->get();

        $statusMap = [
            'requested' => 0,
            'approved' => 1,
            'rejected' => 2,
            'customer_approved' => 3,
            'customer_rejected' => 4,
            'picked' => 5,
            'in_transit' => 6,
            'delivered' => 7,
            'used' => 8,
        ];

        // request_type: 0 - Stock In Hand, 1 - Part Request
        $requestTypeMap = [
            'stock' => 0,
            'part' => 1,
        ];

        $requests = [];

        // Preload assignments: map service_request_id => AssignedEngineer record
        $assignments = AssignedEngineer::whereIn('service_request_id', $srProducts->pluck('service_requests_id'))->get()->keyBy('service_request_id');

        foreach ($srProducts as $sp) {
            $statusKeys = array_keys($statusMap);
            $statusKey = $statusKeys[array_rand($statusKeys)];
            $status = $statusMap[$statusKey];

            // choose request type: most will be part requests
            $reqTypeKey = rand(0, 3) === 0 ? 'stock' : 'part';
            $requestType = $requestTypeMap[$reqTypeKey];

            $assignedPersonType = '0'; // enum expects 0 or 1
            $assignedPersonId = $staffs->isNotEmpty() ? $staffs->random()->id : null;

            $requestedPart = $parts->isNotEmpty() ? $parts->random()->id : null;

            // get assignment record; skip if missing
            $assignment = $assignments->get($sp->service_request_id ?? $sp->service_requests_id);
            if (! $assignment) {
                continue;
            }

            // Use fresh Carbon instances
            $assignedAt = Carbon::now()->subDays(rand(0, 15))->subMinutes(rand(0, 1440));
            $approvedAt = null;
            $rejectedAt = null;
            $customerApprovedAt = null;
            $customerRejectedAt = null;
            $pickedAt = null;
            $inTransitAt = null;
            $deliveredAt = null;
            $usedAt = null;

            if (in_array($statusKey, ['approved', 'customer_approved', 'customer_rejected', 'picked', 'in_transit', 'delivered', 'used'])) {
                $approvedAt = (clone $assignedAt)->addHours(rand(1, 72));
            }
            if ($statusKey === 'customer_approved') {
                $customerApprovedAt = (clone $approvedAt)->addHours(rand(1, 24));
            }
            if ($statusKey === 'customer_rejected') {
                $customerRejectedAt = (clone $approvedAt)->addHours(rand(1, 24));
            }
            if (in_array($statusKey, ['picked', 'in_transit', 'delivered', 'used'])) {
                $baseForPick = $customerApprovedAt ?: $approvedAt ?: $assignedAt;
                $pickedAt = (clone $baseForPick)->addHours(rand(1, 48));
            }
            if (in_array($statusKey, ['in_transit', 'delivered', 'used'])) {
                $inTransitAt = (clone($pickedAt ?: $assignedAt))->addHours(rand(1, 72));
            }
            if (in_array($statusKey, ['delivered', 'used'])) {
                $deliveredAt = (clone($inTransitAt ?: $pickedAt ?: $assignedAt))->addHours(rand(1, 48));
            }
            if ($statusKey === 'used' && $deliveredAt) {
                $usedAt = (clone $deliveredAt)->addDays(rand(0, 5));
            }
            if ($statusKey === 'rejected') {
                $rejectedAt = (clone $assignedAt)->addHours(rand(1, 48));
            }

            $requests[] = [
                'request_id' => $sp->service_requests_id ?? $sp->service_request_id ?? null,
                'product_id' => $sp->id,
                'engineer_id' => $assignment->id,
                'part_id' => $requestedPart,
                'request_type' => (string) $requestType,
                'assigned_person_type' => (string) $assignedPersonType,
                'assigned_person_id' => $assignedPersonId,
                'status' => (string) $status,
                'otp' => (string) rand(100000, 999999),
                'otp_expiry' => Carbon::now()->addHours(2)->toDateTimeString(),
                'assigned_at' => $assignedAt->toDateTimeString(),
                'approved_at' => $approvedAt ? $approvedAt->toDateTimeString() : null,
                'rejected_at' => $rejectedAt ? $rejectedAt->toDateTimeString() : null,
                'customer_approved_at' => $customerApprovedAt ? $customerApprovedAt->toDateTimeString() : null,
                'customer_rejected_at' => $customerRejectedAt ? $customerRejectedAt->toDateTimeString() : null,
                'picked_at' => $pickedAt ? $pickedAt->toDateTimeString() : null,
                'in_transit_at' => $inTransitAt ? $inTransitAt->toDateTimeString() : null,
                'delivered_at' => $deliveredAt ? $deliveredAt->toDateTimeString() : null,
                'used_at' => $usedAt ? $usedAt->toDateTimeString() : null,
                'cancelled_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        if (!empty($requests)) {
            DB::table('service_request_product_request_parts')->insert($requests);
        }
    }
}
