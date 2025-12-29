<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseRacksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('warehouse_racks')->insert([
            // Warehouse 1
            ['warehouse_id' => 1, 'rack_name' => 'Rack A', 'zone_area' => 'A', 'rack_no' => 101, 'level_no' => 1, 'position_no' => 1, 'floor' => 1, 'quantity' => 10],
            ['warehouse_id' => 1, 'rack_name' => 'Rack B', 'zone_area' => 'B', 'rack_no' => 102, 'level_no' => 1, 'position_no' => 2, 'floor' => 1, 'quantity' => 15],

            // Warehouse 2
            ['warehouse_id' => 2, 'rack_name' => 'Rack C', 'zone_area' => 'A', 'rack_no' => 201, 'level_no' => 1, 'position_no' => 1, 'floor' => 1, 'quantity' => 12],
            ['warehouse_id' => 2, 'rack_name' => 'Rack D', 'zone_area' => 'B', 'rack_no' => 202, 'level_no' => 1, 'position_no' => 2, 'floor' => 1, 'quantity' => 18],

            // Warehouse 3
            ['warehouse_id' => 3, 'rack_name' => 'Rack E', 'zone_area' => 'A', 'rack_no' => 301, 'level_no' => 1, 'position_no' => 1, 'floor' => 1, 'quantity' => 20],

            // Warehouse 4
            ['warehouse_id' => 4, 'rack_name' => 'Rack F', 'zone_area' => 'B', 'rack_no' => 401, 'level_no' => 1, 'position_no' => 1, 'floor' => 1, 'quantity' => 25],

            // Warehouse 5
            ['warehouse_id' => 5, 'rack_name' => 'Rack G', 'zone_area' => 'A', 'rack_no' => 501, 'level_no' => 1, 'position_no' => 1, 'floor' => 1, 'quantity' => 30],
        ]);
    }
}
