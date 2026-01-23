<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $staff = [];

        $roles = [
            1 => 'Engineer',
            2 => 'Delivery Man',
            3 => 'Sales Person',
            4 => 'Customer',
            5 => 'Admin',
            6 => 'Warehouse Manager',
        ];

        $staffRoles = [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customer',
            5 => 'admin',
            6 => 'warehouse_manager',
        ];

        $areas = ['Mumbai', 'Delhi', 'Bangalore', 'Pune', 'Chennai', 'Hyderabad'];
        $genders = ['male', 'female', 'other'];
        $marital = ['unmarried', 'married', 'divorced'];
        $employment = ['full_time', 'part_time', 'contractual'];
        $statuses = ['active', 'inactive', 'resigned', 'terminated', 'blocked', 'suspended', 'pending'];

        $i = 1;

        foreach ($roles as $roleId => $roleName) {
            for ($j = 1; $j <= 5; $j++) { 
                $staff[] = [
                    'staff_code' => 'STF' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'staff_role' => $staffRoles[$roleId],
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'phone' => '98' . rand(10000000, 99999999),
                    'email' => fake()->unique()->safeEmail(),
                    'dob' => fake()->date(),
                    'gender' => $genders[array_rand($genders)],
                    'marital_status' => $marital[array_rand($marital)],
                    'employment_type' => $employment[array_rand($employment)],
                    'joining_date' => fake()->date(),
                    'assigned_area' => $areas[array_rand($areas)],
                    'status' => $statuses[array_rand($statuses)],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $i++;
            }
        }

        // Use upsert to make seeding idempotent and avoid duplicate key errors
        Staff::upsert($staff, ['staff_code']);
    }
}
