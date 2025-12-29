<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('brands')->insert([
            ['brand_title' => 'Apple', 'logo' => 'apple.png', 'status' => 1],
            ['brand_title' => 'Samsung', 'logo' => 'samsung.png', 'status' => 1],
            ['brand_title' => 'OnePlus', 'logo' => 'oneplus.png', 'status' => 1],
            ['brand_title' => 'Sony', 'logo' => 'sony.png', 'status' => 1],
            ['brand_title' => 'Dell', 'logo' => 'dell.png', 'status' => 1],
            ['brand_title' => 'HP', 'logo' => 'hp.png', 'status' => 1],
            ['brand_title' => 'Lenovo', 'logo' => 'lenovo.png', 'status' => 1],
            ['brand_title' => 'Bose', 'logo' => 'bose.png', 'status' => 1],
            ['brand_title' => 'Xiaomi', 'logo' => 'xiaomi.png', 'status' => 1],
            ['brand_title' => 'Asus', 'logo' => 'asus.png', 'status' => 1],
        ]);
    }
}
