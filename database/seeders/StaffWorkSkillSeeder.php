<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffWorkSkill;
use Illuminate\Database\Seeder;

class StaffWorkSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffWorkSkill::truncate();

        Staff::chunk(50, function ($staffs) {
            foreach ($staffs as $staff) {
                $primary = ['AC Repair', 'Washing Machine Repair', 'Refrigerator Repair', 'Micro Oven Repair', 'TV Repair'];
                $certs = ['AC Repair', 'Washing Machine Repair', 'Refrigerator Repair', 'Micro Oven Repair', 'TV Repair'];
                $langs = ['Hindi', 'English', 'Marathi', 'Tamil', 'Telugu', 'Kannada'];

                StaffWorkSkill::create([
                    'staff_id' => $staff->id,
                    'primary_skills' => json_encode($primary),
                    'certifications' => json_encode($certs),
                    'experience' => rand(1, 12),
                    'languages_known' => json_encode($langs),
                ]);
            }
        });
    }
}
