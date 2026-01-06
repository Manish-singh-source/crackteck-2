<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PickupRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        DB::table('pickup_requests')->insert([
            [
                'pickup_request_id' => 'PR-' . $now->copy()->subDays(4)->format('Ymd') . '-001',
                'service_request_id' => 2,
                'engineer_id' => 2,
                'customer_id' => 2,
                'pickup_person_id' => 5,
                'pickup_assigned_at' => $now->copy()->subDays(4)->addHour(),
                'pickup_completed_at' => $now->copy()->subDays(3)->addHour(),
                'delivery_person_id' => 6,
                'delivery_assigned_at' => $now->copy()->subDays(3)->addHours(2),
                'delivery_completed_at' => $now->copy()->subDays(2)->addHours(3),
                'status' => "3",
                'cancellation_reason' => null,
                'before_photos' => json_encode(['uploads/before/2_1.jpg']),
                'after_photos' => json_encode(['uploads/after/2_1.jpg']),
                'otp' => '123456',
                'otp_verified_at' => $now->copy()->subDays(3)->addHours(1),
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'pickup_request_id' => 'PR-' . \Carbon\Carbon::now()->subDays(3)->format('Ymd') . '-001',
                'service_request_id' => 3,
                'engineer_id' => 3,
                'customer_id' => 3,
                'pickup_person_id' => 6,
                'pickup_assigned_at' => \Carbon\Carbon::now()->subDays(3)->addHour(),
                'pickup_completed_at' => \Carbon\Carbon::now()->subDays(2)->addHour(),
                'delivery_person_id' => 7,
                'delivery_assigned_at' => \Carbon\Carbon::now()->subDays(2)->addHours(2),
                'delivery_completed_at' => \Carbon\Carbon::now()->subDay(),
                'status' => "7",
                'cancellation_reason' => null,
                'before_photos' => json_encode(['uploads/before/3_1.jpg', 'uploads/before/3_2.jpg']),
                'after_photos' => json_encode(['uploads/after/3_1.jpg']),
                'otp' => '654321',
                'otp_verified_at' => \Carbon\Carbon::now()->subDays(2)->addHours(1),
                'created_at' => \Carbon\Carbon::now()->subDays(3),
                'updated_at' => \Carbon\Carbon::now()->subDay(),
            ],
            [
                'pickup_request_id' => 'PR-' . \Carbon\Carbon::now()->subDays(2)->format('Ymd') . '-001',
                'service_request_id' => 1,
                'engineer_id' => 1,
                'customer_id' => 1,
                'pickup_person_id' => null,
                'pickup_assigned_at' => null,
                'pickup_completed_at' => null,
                'delivery_person_id' => null,
                'delivery_assigned_at' => null,
                'delivery_completed_at' => null,
                'status' => "0",
                'cancellation_reason' => null,
                'before_photos' => null,
                'after_photos' => null,
                'otp' => null,
                'otp_verified_at' => null,
                'created_at' => \Carbon\Carbon::now()->subDays(2),
                'updated_at' => \Carbon\Carbon::now()->subDays(2),
            ],
            [
                'pickup_request_id' => 'PR-' . \Carbon\Carbon::now()->format('Ymd') . '-001',
                'service_request_id' => 4,
                'engineer_id' => 4,
                'customer_id' => 4,
                'pickup_person_id' => 8,
                'pickup_assigned_at' => \Carbon\Carbon::now()->addHour(),
                'pickup_completed_at' => null,
                'delivery_person_id' => null,
                'delivery_assigned_at' => null,
                'delivery_completed_at' => null,
                'status' => "9",
                'cancellation_reason' => 'Customer cancelled pickup due to schedule change.',
                'before_photos' => json_encode(['uploads/before/4_1.jpg']),
                'after_photos' => null,
                'otp' => null,
                'otp_verified_at' => null,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
