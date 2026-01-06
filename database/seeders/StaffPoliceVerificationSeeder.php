<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffPoliceVerification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffPoliceVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffPoliceVerification::truncate();

        // 0 - No / Pending, 1 - Yes / Completed
        $statuses = ['0', '1'];

        Staff::chunk(50, function ($staffs) use ($statuses) {
            foreach ($staffs as $staff) {
                $status = $statuses[array_rand($statuses)];
                // if status === '1' then verification completed
                StaffPoliceVerification::create([
                    'staff_id' => $staff->id,
                    'police_verification' => $status === '1' ? '1' : '0',
                    'police_verification_status' => $status === '1' ? '1' : '0',
                    'police_certificate' => $status === '1' ? "uploads/police/cert_{$staff->id}.pdf" : null,
                ]);
            }
        });
    }
}
