<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CaseTransferRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        DB::table('case_transfer_requests')->insert([
            [
                'transfer_id' => 'CTR-' . $now->copy()->subDays(4)->format('Ymd') . '-001',
                'service_request_id' => 2,
                'requesting_engineer_id' => 1,
                'new_engineer_id' => 2,
                'engineer_reason' => 'Customer requested a different engineer due to timing conflicts.',
                'admin_reason' => null,
                'status' => "0",
                'approved_at' => null,
                'rejected_at' => null,
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'transfer_id' => 'CTR-' . \Carbon\Carbon::now()->subDays(2)->format('Ymd') . '-001',
                'service_request_id' => 3,
                'requesting_engineer_id' => 2,
                'new_engineer_id' => 3,
                'engineer_reason' => 'Skillset mismatch for the specific model.',
                'admin_reason' => 'Approved due to availability of the requested engineer.',
                'status' => "1",
                'approved_at' => \Carbon\Carbon::now()->subDay(),
                'rejected_at' => null,
                'created_at' => \Carbon\Carbon::now()->subDays(2),
                'updated_at' => \Carbon\Carbon::now()->subDay(),
            ],
            [
                'transfer_id' => 'CTR-' . \Carbon\Carbon::now()->format('Ymd') . '-001',
                'service_request_id' => 4,
                'requesting_engineer_id' => 3,
                'new_engineer_id' => null,
                'engineer_reason' => 'Personal emergency; request to reassign later.',
                'admin_reason' => 'Rejected due to crew shortage.',
                'status' => "2",
                'approved_at' => null,
                'rejected_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
