<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequestProduct;
use App\Models\AssignedEngineer;
use App\Models\Staff;

class ServiceRequestProductPickupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $srProducts = ServiceRequestProduct::inRandomOrder()->limit(20)->get();
        if ($srProducts->isEmpty()) {
            return;
        }

        $staffs = Staff::inRandomOrder()->limit(10)->get();

        $assignments = AssignedEngineer::whereIn('service_request_id', $srProducts->pluck('service_requests_id'))->get()->keyBy('service_request_id');

        $statuses = ['assigned', 'approved', 'picked', 'received', 'cancelled', 'returned'];

        $pickups = [];

        foreach ($srProducts as $sp) {
            // Assignment (required) and request foreign key in service_request_products is `service_requests_id`
            $assignment = $assignments->get($sp->service_request_id ?? $sp->service_requests_id);
            if (! $assignment) {
                continue; // cannot create pickup without an assignment (engineer id requires assigned_engineers id)
            }

            $statusName = $statuses[array_rand($statuses)];

            $assignedPersonType = 0; // 0 - Delivery Man, 1 - Engineer
            $assignedPersonId = $staffs->isNotEmpty() ? $staffs->random()->id : null;

            // Use a fresh Carbon for each record to avoid mutating shared $now
            $assignedAt = Carbon::now()->subDays(rand(0, 10))->subMinutes(rand(0, 600));
            $approvedAt = null;
            $pickedAt = null;
            $receivedAt = null;
            $cancelledAt = null;
            $returnedAt = null;

            if (in_array($statusName, ['approved', 'picked', 'received', 'returned'])) {
                $approvedAt = (clone $assignedAt)->addHours(rand(1, 48));
            }
            if (in_array($statusName, ['picked', 'received', 'returned'])) {
                $baseForPick = $approvedAt ?: $assignedAt;
                $pickedAt = (clone $baseForPick)->addHours(rand(1, 48));
            }
            if ($statusName === 'received' && $pickedAt) {
                $receivedAt = (clone $pickedAt)->addHours(rand(1, 48));
            }
            if ($statusName === 'cancelled') {
                $cancelledAt = (clone $assignedAt)->addHours(rand(1, 48));
            }
            if ($statusName === 'returned') {
                $baseForReturn = $receivedAt ?: $pickedAt ?: $assignedAt;
                $returnedAt = (clone $baseForReturn)->addDays(rand(1, 10));
            }

            $pickups[] = [
                'request_id' => $sp->service_requests_id ?? $sp->service_request_id ?? null,
                'product_id' => $sp->id,
                'engineer_id' => $assignment ? $assignment->id : null,
                'reason' => 'Pickup created by seeder',
                'assigned_person_type' => (string) $assignedPersonType,
                'assigned_person_id' => $assignedPersonId,
                'status' => $statusName,
                'otp' => (string) rand(100000, 999999),
                'otp_expiry' => Carbon::now()->addHours(2)->toDateTimeString(),
                'assigned_at' => $assignedAt->toDateTimeString(),
                'approved_at' => $approvedAt ? $approvedAt->toDateTimeString() : null,
                'picked_at' => $pickedAt ? $pickedAt->toDateTimeString() : null,
                'received_at' => $receivedAt ? $receivedAt->toDateTimeString() : null,
                'cancelled_at' => $cancelledAt ? $cancelledAt->toDateTimeString() : null,
                'returned_at' => $returnedAt ? $returnedAt->toDateTimeString() : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        if (!empty($pickups)) {
            DB::table('service_request_product_pickups')->insert($pickups);
        }
    }
}
