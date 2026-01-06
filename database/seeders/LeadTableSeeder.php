<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class LeadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //
        $staffs = Staff::where('staff_role', '3')->get();

        // Make idempotent: clear existing leads then create 20 new leads
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Lead::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 20; $i++) {
            Lead::create([
                'staff_id' => $staffs->random()->id,
                'lead_number' => 'LEAD' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'first_name' => 'First Name ' . $i,
                'last_name' => 'Last Name ' . $i,
                'phone' => '98765432' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'email' => 'lead' . $i . '@example.com',
                'dob' => null,
                'gender' => null,
                'company_name' => null,
                'designation' => null,
                'industry_type' => null,
                'source' => '0',
                'requirement_type' => null,
                'budget_range' => null,
                'urgency' => '0',
                'status' => '0',
                'estimated_value' => null,
                'notes' => null,
            ]);
        }
    }
}
