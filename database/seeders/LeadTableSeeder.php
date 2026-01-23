<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\CustomerAddressDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have at least one staff member
        if (Staff::count() === 0) {
            // StaffSeeder should have run before this, but we handle the empty case
            return;
        }

        // Ensure we have at least one customer
        if (Customer::count() === 0) {
            echo "Creating dummy customer for leads...";
            // Create a dummy customer if none exist
            $customerId = DB::table('customers')->insertGetId([
                'customer_code' => 'CUS-SEED-LEAD',
                'first_name' => 'Seeded',
                'last_name' => 'Customer',
                'phone' => '9999999999',
                'email' => 'seeded.lead.customer@example.com',
                'dob' => '1990-01-01',
                'gender' => 'male',
                'customer_type' => 'ecommerce',
                'source_type' => 'lead',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // dummy password
                'status' => "active",  // Ensure status is set
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Ensure all customers have at least one address to avoid factory failures
        $customers = Customer::all();
        foreach ($customers as $customer) {
            if (CustomerAddressDetail::where('customer_id', $customer->id)->doesntExist()) {
                DB::table('customer_address_details')->insert([
                    'customer_id' => $customer->id,
                    'branch_name' => 'Main',
                    'address1' => '123 Seed Street',
                    'city' => 'Seed City',
                    'state' => 'Seed State',
                    'country' => 'India',
                    'pincode' => '123456',
                    'is_primary' => 'yes',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Create leads for multiple customers
        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost', 'nurture'];

        // Get the list of staff and customers
        $staffs = Staff::all();
        $customers = Customer::all();

        // Loop through each customer and create multiple leads
        foreach ($customers as $customer) {
            // Select a random staff member for each lead
            $staffId = $staffs->random()->id;
            
            // Select a random address for the customer
            $customerAddressId = CustomerAddressDetail::where('customer_id', $customer->id)
                ->inRandomOrder()
                ->value('id');
            
            // Define the number of leads to create per customer (you can make this dynamic)
            $leadCount = rand(1, 5); // For example, create between 1 and 5 leads per customer

            for ($i = 0; $i < $leadCount; $i++) {
                Lead::create([
                    'staff_id' => $staffId,  // Random staff ID
                    'customer_id' => $customer->id,  // Customer ID
                    'customer_address_id' => $customerAddressId,  // Random address for the same customer
                    'lead_number' => 'LEAD' . strtoupper(uniqid()),  // Unique lead number
                    'requirement_type' => fake()->randomElement(['servers', 'cctv', 'biometric', 'networking']),
                    'budget_range' => fake()->randomElement(['10K-50K', '50K-100K', '100K-500K', '500K-1000K']),
                    'urgency' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
                    'status' => fake()->randomElement($statuses),  // Ensures a valid status
                    'estimated_value' => fake()->randomFloat(2, 100, 1000),  // Random estimated value between 100 and 1000
                    'notes' => fake()->paragraph(),  // Random notes
                ]);
            }
        }
    }
}
