<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequest;
use App\Models\Staff;

class AssignedEngineerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Ensure there are some service requests
        if (ServiceRequest::count() < 3) {
            return; // nothing to assign to
        }

        $requests = ServiceRequest::inRandomOrder()->limit(10)->get();
        $staffs = Staff::inRandomOrder()->limit(10)->get();

        if ($staffs->isEmpty()) {
            return;
        }

        $assignments = [];

        foreach ($requests as $req) {
            $engineer = $staffs->random();
            $assignedAt = $now->subDays(rand(0, 10))->subMinutes(rand(0, 300));

            $assignments[] = [
                'service_request_id' => $req->id,
                'engineer_id' => $engineer->id,
                'assignment_type' => 'individual',
                'assigned_at' => $assignedAt->toDateTimeString(),
                'transferred_to' => null,
                'transferred_at' => null,
                'group_name' => null,
                'is_supervisor' => 0,
                'notes' => 'Auto-assigned by seeder',
                'status' => 'active',
                'is_approved_by_engineer' => rand(0, 1) === 1,
                'engineer_approved_at' => rand(0, 1) === 1 ? $assignedAt->addHours(rand(1, 48))->toDateTimeString() : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($assignments)) {
            DB::table('assigned_engineers')->insert($assignments);
        }
    }
}
