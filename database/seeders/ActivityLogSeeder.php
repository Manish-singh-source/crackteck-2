<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Models\Activity;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users
        $users = User::limit(5)->get();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please create users first.');

            return;
        }

        // Create sample activity logs
        foreach ($users as $user) {
            // Login activity
            activity('authentication')
                ->causedBy($user)
                ->withProperties([
                    'ip' => '192.168.1.'.rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'event' => 'login',
                ])
                ->log('User logged in');

            // Profile update activity
            activity('user')
                ->causedBy($user)
                ->performedOn($user)
                ->withProperties([
                    'ip' => '192.168.1.'.rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'old' => ['name' => 'Old Name'],
                    'attributes' => ['name' => $user->name],
                ])
                ->log('User updated');
        }

        // Create activities for customers if they exist
        $customers = Customer::limit(3)->get();
        foreach ($customers as $customer) {
            $user = $users->random();

            activity('customer')
                ->causedBy($user)
                ->performedOn($customer)
                ->withProperties([
                    'ip' => '192.168.1.'.rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                ])
                ->log('Customer created');
        }

        // Create activities for leads if they exist
        $leads = Lead::limit(3)->get();
        foreach ($leads as $lead) {
            $user = $users->random();

            activity('lead')
                ->causedBy($user)
                ->performedOn($lead)
                ->withProperties([
                    'ip' => '192.168.1.'.rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                ])
                ->log('Lead created');
        }

        $this->command->info('Activity logs seeded successfully!');
    }
}
