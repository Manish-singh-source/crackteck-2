<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequest;

class ServiceRequestPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $requests = ServiceRequest::inRandomOrder()->limit(20)->get();
        if ($requests->isEmpty()) {
            return;
        }

        $payments = [];

        foreach ($requests as $req) {
            $total = $req->total_amount ?? ($req->subtotal ?? 0);
            if ($total <= 0) {
                continue;
            }

            $status = ['completed', 'pending', 'failed'][array_rand(['completed', 'pending', 'failed'])];
            $paid = $status === 'completed' ? $total : ($status === 'pending' ? round($total * (rand(10, 90) / 100), 2) : 0);

            $payments[] = [
                'service_request_id' => $req->id,
                'transaction_id' => 'SRP-' . strtoupper(uniqid()),
                'total_amount' => $total,
                'payment_gateway' => 'manual',
                'payment_method' => 'online',
                'payment_date' => $now->subDays(rand(0, 30))->toDateString(),
                'payment_status' => $status,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($payments)) {
            DB::table('service_request_payments')->insert($payments);
        }
    }
}
