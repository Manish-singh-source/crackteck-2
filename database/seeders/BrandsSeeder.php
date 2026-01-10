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
        DB::table('brands')->insertOrIgnore([
            [
                'name' => 'Apple', 
                'slug' => 'apple', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Samsung', 
                'slug' => 'samsung', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'OnePlus', 
                'slug' => 'oneplus', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Sony', 
                'slug' => 'sony', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Sony_logo.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Dell', 
                'slug' => 'dell', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/48/Dell_Logo.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'HP', 
                'slug' => 'hp', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/48/Dell_Logo.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Lenovo', 
                'slug' => 'lenovo', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/HP_logo_2012.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Bose', 
                'slug' => 'bose', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/HP_logo_2012.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Xiaomi', 
                'slug' => 'xiaomi', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/HP_logo_2012.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Asus', 
                'slug' => 'asus', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/HP_logo_2012.svg', 
                'status_ecommerce' => "active", 
                'status' => "active", 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}
