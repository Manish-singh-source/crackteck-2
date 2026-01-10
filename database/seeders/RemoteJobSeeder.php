<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RemoteJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        DB::table('remote_jobs')->insert([
            [
                'job_id' => 'RJ-' . $now->copy()->subDays(5)->format('Ymd') . '-001',
                'service_request_id' => 1,
                'field_executive_id' => null,
                'assigned_engineer_id' => 1,
                'job_type' => "remote_diagnosis",
                'job_description' => 'Initial remote diagnosis via screen-share and logs.',
                'remote_access_details' => json_encode(['method' => 'ssh', 'ip' => '192.168.10.10', 'username' => 'tech1', 'port' => 22]),
                'status' => "pending",
                'started_at' => null,
                'completed_at' => null,
                'resolution_notes' => null,
                'escalation_reason' => null,
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'job_id' => 'RJ-' . \Carbon\Carbon::now()->subDays(3)->format('Ymd') . '-001',
                'service_request_id' => 2,
                'field_executive_id' => 6,
                'assigned_engineer_id' => 2,
                'job_type' => "troubleshooting",
                'job_description' => 'Remote troubleshooting session — applied firmware patch.',
                'remote_access_details' => json_encode(['method' => 'rdp', 'ip' => '10.0.0.5', 'username' => 'admin', 'port' => 3389]),
                'status' => "completed",
                'started_at' => \Carbon\Carbon::now()->subDays(3)->addHour(),
                'completed_at' => \Carbon\Carbon::now()->subDays(3)->addHours(2),
                'resolution_notes' => 'Applied firmware patch and validated functionality.',
                'escalation_reason' => null,
                'created_at' => \Carbon\Carbon::now()->subDays(3),
                'updated_at' => \Carbon\Carbon::now()->subDays(3),
            ],
            [
                'job_id' => 'RJ-' . \Carbon\Carbon::now()->subDays(2)->format('Ymd') . '-001',
                'service_request_id' => 3,
                'field_executive_id' => null,
                'assigned_engineer_id' => 3,
                'job_type' => "guidance",
                'job_description' => 'Guided user through configuration steps on call.',
                'remote_access_details' => json_encode(['method' => 'phone', 'number' => '+919812345678']),
                'status' => "assigned",
                'started_at' => \Carbon\Carbon::now()->subDays(2)->addHour(),
                'completed_at' => null,
                'resolution_notes' => null,
                'escalation_reason' => null,
                'created_at' => \Carbon\Carbon::now()->subDays(2),
                'updated_at' => \Carbon\Carbon::now()->subDays(2),
            ],
            [
                'job_id' => 'RJ-' . \Carbon\Carbon::now()->subDays(1)->format('Ymd') . '-001',
                'service_request_id' => 4,
                'field_executive_id' => 7,
                'assigned_engineer_id' => 4,
                'job_type' => "remote_diagnosis",
                'job_description' => 'Attempted diagnosis; escalated to on-site due to hardware fault.',
                'remote_access_details' => json_encode(['method' => 'ssh', 'ip' => '172.16.0.20', 'username' => 'tech2', 'port' => 22]),
                'status' => "escalated",
                'started_at' => \Carbon\Carbon::now()->subDay(),
                'completed_at' => null,
                'resolution_notes' => null,
                'escalation_reason' => 'Hardware fault detected — requires part replacement.',
                'created_at' => \Carbon\Carbon::now()->subDay(),
                'updated_at' => \Carbon\Carbon::now()->subDay(),
            ],
        ]);
    }
}
