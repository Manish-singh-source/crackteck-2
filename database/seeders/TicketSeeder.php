<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\User;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Ensure there are some customers
        if (Customer::count() < 3) {
            DB::table('customers')->insert([
                ['first_name' => 'Ticket', 'last_name' => 'User1', 'phone' => '9000000010', 'email' => 'ticket.user1@example.com', 'status' => "1", 'created_at' => $now, 'updated_at' => $now],
                ['first_name' => 'Ticket', 'last_name' => 'User2', 'phone' => '9000000011', 'email' => 'ticket.user2@example.com', 'status' => "1", 'created_at' => $now, 'updated_at' => $now],
                ['first_name' => 'Ticket', 'last_name' => 'User3', 'phone' => '9000000012', 'email' => 'ticket.user3@example.com', 'status' => "1", 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        $customers = Customer::inRandomOrder()->limit(10)->get();
        $users = User::inRandomOrder()->limit(5)->get();

        if ($customers->isEmpty()) {
            return;
        }

        $statuses = ['0', '1', '2', '3', '4', '5'];
        $priorities = ['0', '1', '2', '3'];
        $categories = ['0', '1', '2', '3', '4'];

        $tickets = [];
        for ($i = 0; $i < 12; $i++) {
            $cust = $customers->random();
            $status = $statuses[array_rand($statuses)];
            $priority = $priorities[array_rand($priorities)];
            $category = $categories[array_rand($categories)];
            $assigned = $users->isNotEmpty() ? $users->random()->id : null;

            $firstResponseAt = null;
            $resolvedAt = null;
            if ($status !== 'open') {
                $firstResponseAt = $now->subDays(rand(0, 5))->subMinutes(rand(10, 300))->toDateTimeString();
            }
            if (in_array($status, ['resolved', 'closed'])) {
                $resolvedAt = $now->subDays(rand(0, 3))->subMinutes(rand(5, 300))->toDateTimeString();
            }

            $tickets[] = [
                'customer_id' => $cust->id,
                'ticket_number' => 'TCK-' . strtoupper(uniqid()),
                'ticket_id' => 'TCK-' . strtoupper(uniqid()),
                'title' => ucfirst($category) . ' issue for ' . ($cust->first_name ?? 'Customer'),
                'description' => 'This is a seeded ticket to simulate typical support requests.',
                'category' => $category,
                'subcategory' => null,
                'priority' => $priority,
                'status' => $status,
                'assigned_to' => $assigned,
                'response_time_minutes' => $firstResponseAt ? rand(10, 1440) : null,
                'resolution_time_minutes' => $resolvedAt ? rand(60, 4320) : null,
                'first_response_at' => $firstResponseAt,
                'resolved_at' => $resolvedAt,
                'created_at' => $now->subDays(rand(1, 30))->toDateTimeString(),
                'updated_at' => $now,
            ];
        }

        if (!empty($tickets)) {
            DB::table('tickets')->insert($tickets);
        }
    }
}
