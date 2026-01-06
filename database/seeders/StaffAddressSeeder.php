<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['Mumbai', 'Maharashtra', 'India', '400001'],
            ['Delhi', 'Delhi', 'India', '110001'],
            ['Bangalore', 'Karnataka', 'India', '560001'],
            ['Pune', 'Maharashtra', 'India', '411001'],
            ['Chennai', 'Tamil Nadu', 'India', '600001'],
            ['Hyderabad', 'Telangana', 'India', '500001'],
        ];

        StaffAddress::truncate();

        Staff::chunk(50, function ($staffs) use ($locations) {
            foreach ($staffs as $staff) {
                $loc = $locations[array_rand($locations)];
                StaffAddress::create([
                    'staff_id' => $staff->id,
                    'address1' => rand(10, 250) . ' ' . ['MG Road', 'Main Street', 'Station Road', '1st Cross'][array_rand(['MG Road', 'Main Street', 'Station Road', '1st Cross'])],
                    'address2' => 'Near ' . ['Mall', 'Park', 'Temple', 'School'][array_rand(['Mall', 'Park', 'Temple', 'School'])],
                    'city' => $loc[0],
                    'state' => $loc[1],
                    'country' => $loc[2],
                    'pincode' => $loc[3],
                ]);
            }
        });
    }
}
