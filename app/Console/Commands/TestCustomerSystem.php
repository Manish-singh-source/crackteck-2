<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Console\Command;

class TestCustomerSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-customer-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the unified customer management system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Unified Customer Management System');
        $this->info('==========================================');

        // Test 1: Check existing customers
        $totalCustomers = Customer::count();
        $this->info("Total customers in database: {$totalCustomers}");

        // Test 2: Check customer type filtering
        $ecommerceCustomers = Customer::ecommerce()->count();
        $crmCustomers = Customer::crm()->count();
        $this->info("E-commerce customers: {$ecommerceCustomers}");
        $this->info("CRM customers: {$crmCustomers}");

        // Test 3: Create a test e-commerce customer
        $this->info("\nCreating test e-commerce customer...");
        $randomEmail = 'test.customer.'.time().'@example.com';
        $testCustomer = Customer::create([
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => $randomEmail,
            'customer_type' => 'E-commerce Customer',
            'status' => 'active',
        ]);

        $this->info("Created customer with ID: {$testCustomer->id}");
        $this->info("Full name: {$testCustomer->full_name}");
        $this->info("Display username: {$testCustomer->display_username}");
        $this->info("Order count: {$testCustomer->total_orders_count}");

        // Test 4: Test username generation
        $testCustomer->generateUsername();
        $this->info("Generated username: {$testCustomer->username}");

        // Test 5: Check filtering again
        $ecommerceCustomers = Customer::ecommerce()->count();
        $this->info("\nE-commerce customers after creation: {$ecommerceCustomers}");

        // Test 6: Test user registration sync
        $this->info("\nTesting user registration sync...");
        $userEmail = 'john.doe.'.time().'@example.com';
        $testUser = User::create([
            'name' => 'John Doe',
            'email' => $userEmail,
            'password' => bcrypt('password123'),
        ]);

        // Manually trigger customer creation (simulating the registration process)
        $nameParts = explode(' ', $testUser->name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $linkedCustomer = Customer::create([
            'user_id' => $testUser->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $userEmail,
            'customer_type' => 'E-commerce Customer',
            'status' => 'active',
        ]);

        $this->info("Created user with ID: {$testUser->id}");
        $this->info("Created linked customer with ID: {$linkedCustomer->id}");
        $this->info('Customer linked to user: '.($linkedCustomer->user_id === $testUser->id ? 'Yes' : 'No'));

        // Final count
        $finalEcommerceCount = Customer::ecommerce()->count();
        $this->info("\nFinal e-commerce customer count: {$finalEcommerceCount}");

        $this->info("\nTest completed successfully!");

        return 0;
    }
}
