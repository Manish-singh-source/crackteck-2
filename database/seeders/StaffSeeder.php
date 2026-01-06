<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        $areas = ['Mumbai', 'Delhi', 'Bangalore', 'Pune', 'Chennai', 'Hyderabad'];
        $genders = ['0', '1', '2'];
        $marital = ['0', '1', '2'];
        $employment = ['0', '1'];

        $i = 1;

        foreach ($roles as $roleId => $roleName) {
            for ($j = 1; $j <= 4; $j++) { // 4 records per role → 24 total
                $staff[] = [
                    'staff_code' => 'STF' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'staff_role' => $roleId,
                    'first_name' => $roleName . $j,
                    'last_name' => 'User',
                    'phone' => '98' . rand(10000000, 99999999),
                    'email' => strtolower(str_replace(' ', '', $roleName)) . $j . '@example.com',
                    'dob' => Carbon::now()->subYears(rand(22, 40))->format('Y-m-d'),
                    'gender' => $genders[array_rand($genders)],
                    'marital_status' => $marital[array_rand($marital)],
                    'employment_type' => $employment[array_rand($employment)],
                    'joining_date' => Carbon::now()->subMonths(rand(1, 48))->format('Y-m-d'),
                    'assigned_area' => $areas[array_rand($areas)],
                ];
                $i++;
            }
        }

        // Use upsert to make seeding idempotent and avoid duplicate key errors
        Staff::upsert($staff, ['staff_code']);
    }
}
