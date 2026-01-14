<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FieldIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('field_issues')->insert([
            [
                'issue_id' => 'FI-' . $now->copy()->subDays(5)->format('Ymd') . '-001',
                'field_executive_id' => 5,
                'issue_type' => 'Pickup Delay',
                'issue_description' => 'Pickup delayed due to traffic and customer reschedule.',
                'priority' => "medium",
                'status' => "pending",
                'assigned_remote_engineer_id' => null,
                'resolved_at' => null,
                'resolution_notes' => null,
                'attachments' => json_encode(['uploads/issues/fi1_1.jpg']),
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'issue_id' => 'FI-' . \Carbon\Carbon::now()->subDays(3)->format('Ymd') . '-001',
                'field_executive_id' => 6,
                'issue_type' => 'Safety Concern',
                'issue_description' => 'Field executive reported an unsafe installation environment.',
                'priority' => "critical",
                'status' => "in_progress",
                'assigned_remote_engineer_id' => 2,
                'resolved_at' => null,
                'resolution_notes' => null,
                'attachments' => json_encode(['uploads/issues/fi2_1.jpg', 'uploads/issues/fi2_2.jpg']),
                'created_at' => \Carbon\Carbon::now()->subDays(3),
                'updated_at' => \Carbon\Carbon::now()->subDays(1),
            ],
            [
                'issue_id' => 'FI-' . \Carbon\Carbon::now()->subDay()->format('Ymd') . '-001',
                'field_executive_id' => 7,
                'issue_type' => 'Tool Damage',
                'issue_description' => 'Reported damage to handheld diagnostic tool; replaced from stock.',
                'priority' => "high",
                'status' => "resolved",
                'assigned_remote_engineer_id' => 3,
                'resolved_at' => \Carbon\Carbon::now()->subDay(),
                'resolution_notes' => 'Issued replacement tool and logged inventory change.',
                'attachments' => json_encode(['uploads/issues/fi3_1.jpg']),
                'created_at' => \Carbon\Carbon::now()->subDays(2),
                'updated_at' => \Carbon\Carbon::now()->subDay(),
            ],
        ]);
    }
}
