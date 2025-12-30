<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Support',
        //     'email' => 'support@technofra.com',
        //     'password' => '123456'
        // ]);

        Role::create(['name' => 'Engineer']);
        Role::create(['name' => 'Delivery Man']);
        Role::create(['name' => 'Sales Person']);
        Role::create(['name' => 'Customer']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Warehouse Manager']);

        $this->call([
            StaffSeeder::class,
            LeadTableSeeder::class,
            
        ]);

    }
}
