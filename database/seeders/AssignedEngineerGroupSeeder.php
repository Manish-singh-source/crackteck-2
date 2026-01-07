<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AssignedEngineer;
use App\Models\Staff;

class AssignedEngineerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $assignments = AssignedEngineer::inRandomOrder()->limit(20)->get();
        $staff = Staff::inRandomOrder()->limit(50)->get();

        if ($assignments->isEmpty() || $staff->isEmpty()) {
            return;
        }

        $inserts = [];

        foreach ($assignments as $assignment) {
            // pick 1-3 additional engineers for the group (exclude primary engineer)
            $count = rand(1, 3);
            $candidates = $staff->where('id', '!=', $assignment->engineer_id);
            if ($candidates->isEmpty()) {
                continue;
            }

            $picked = $candidates->random(min($count, $candidates->count()));
            if (! $picked instanceof \Illuminate\Support\Collection) {
                $picked = collect([$picked]);
            }

            $supervisorAssigned = false;

            foreach ($picked as $member) {
                // Randomly pick one supervisor for this assignment
                $isSupervisor = false;
                if (! $supervisorAssigned && rand(0, 4) === 0) { // ~20% chance
                    $isSupervisor = true;
                    $supervisorAssigned = true;
                }

                $inserts[] = [
                    'assignment_id' => $assignment->id,
                    'engineer_id' => $member->id,
                    'is_supervisor' => $isSupervisor,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // ensure primary engineer is present in group as supervisor if not already
            $primaryIncluded = collect($inserts)->firstWhere('assignment_id', $assignment->id)['engineer_id'] ?? null;
            if ($assignment->engineer_id && $primaryIncluded != $assignment->engineer_id) {
                $inserts[] = [
                    'assignment_id' => $assignment->id,
                    'engineer_id' => $assignment->engineer_id,
                    'is_supervisor' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($inserts)) {
            DB::table('assigned_engineer_group')->insert($inserts);
        }
    }
}
