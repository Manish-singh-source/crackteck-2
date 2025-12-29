<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $brands = [
            [
                'brand_title' => 'Apple',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
            ],
            [
                'brand_title' => 'Samsung',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg',
            ],
            [
                'brand_title' => 'Sony',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Sony_logo.svg',
            ],
            [
                'brand_title' => 'LG',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/09/LG_logo_%282015%29.svg',
            ],
            [
                'brand_title' => 'Panasonic',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/53/Panasonic_logo.svg',
            ],
            [
                'brand_title' => 'Intel',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/c9/Intel-logo.svg',
            ],
            [
                'brand_title' => 'Dell',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/48/Dell_Logo.svg',
            ],
            [
                'brand_title' => 'HP',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/HP_logo_2012.svg',
            ],
            [
                'brand_title' => 'Asus',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/51/ASUS_Logo.svg',
            ],
            [
                'brand_title' => 'Microsoft',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg',
            ],
        ];

        DB::table('brands')->insert($brands);
    }
}
