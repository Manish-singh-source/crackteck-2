<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffWorkSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffWorkSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffWorkSkill::truncate();

        $engineerSkills = ['AC Repair', 'Washing Machine Repair', 'Refrigerator Repair', 'Micro Oven Repair', 'TV Repair'];
        $deliverySkills = ['Two Wheeler Delivery', 'Four Wheeler Delivery', 'Heavy Load Handling'];
        $salesSkills = ['B2B Sales', 'Retail Sales', 'Customer Acquisition'];

        Staff::chunk(50, function ($staffs) use ($engineerSkills, $deliverySkills, $salesSkills) {
            foreach ($staffs as $staff) {
                $primary = [];
                $certs = [];
                $langs = ['Hindi', 'English', 'Marathi', 'Tamil', 'Telugu', 'Kannada'];

                switch ($staff->staff_role) {
                    case 1: // Engineer
                        $primary = (array) array_rand(array_flip($engineerSkills), rand(1, 3));
                        $certs = ['Basic Repair Certification', 'Safety Training'];
                        break;
                    case 2: // Delivery
                        $primary = (array) array_rand(array_flip($deliverySkills), 1);
                        $certs = ['Driving License'];
                        break;
                    case 3: // Sales
                        $primary = (array) array_rand(array_flip($salesSkills), rand(1, 2));
                        $certs = ['Sales Training'];
                        break;
                    default:
                        $primary = ['General'];
                        $certs = [];
                }

                StaffWorkSkill::create([
                    'staff_id' => $staff->id,
                    'primary_skills' => array_values((array)$primary),
                    'certifications' => $certs,
                    'experience' => rand(1, 12),
                    'languages_known' => array_values(array_slice($langs, 0, rand(1, 3))),
                ]);
            }
        });
    }
}
