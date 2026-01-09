<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('sub_categories')->insertOrIgnore([
            // Printer
            [
                'id' => 1,
                'parent_category_id' => 1,
                'slug' => 'hp',
                'name' => 'HP',
                'image' => 'uploads/crm/categorie/feature_image/hp.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/hp.png',
                'status_ecommerce' => 1,
                'status' => "1",
            ],
            [
                'id' => 2,
                'parent_category_id' => 1,
                'slug' => 'dell',
                'name' => 'Dell',
                'image' => 'uploads/crm/categorie/feature_image/dell.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/dell.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            [
                'id' => 3,
                'parent_category_id' => 1,
                'slug' => 'asus',
                'name' => 'Asus',
                'image' => 'uploads/crm/categorie/feature_image/asus.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/asus.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            // Monitor
            [
                'id' => 4,
                'parent_category_id' => 2,
                'slug' => 'samsung',
                'name' => 'Samsung',
                'image' => 'uploads/crm/categorie/feature_image/samsung.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/samsung.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            [
                'id' => 5,
                'parent_category_id' => 2,
                'slug' => 'lg',
                'name' => 'LG',
                'image' => 'uploads/crm/categorie/feature_image/lg.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/lg.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            // Laptop
            [
                'id' => 6,
                'parent_category_id' => 3,
                'slug' => 'hp',
                'name' => 'HP',
                'image' => 'uploads/crm/categorie/feature_image/hp_laptop.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/hp_laptop.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            [
                'id' => 7,
                'parent_category_id' => 3,
                'slug' => 'dell',
                'name' => 'Dell',
                'image' => 'uploads/crm/categorie/feature_image/dell_laptop.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/dell_laptop.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // CCTV
            [
                'id' => 8,
                'parent_category_id' => 4,
                'slug' => 'hikvision',
                'name' => 'Hikvision',
                'image' => 'uploads/crm/categorie/feature_image/hikvision.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/hikvision.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            [
                'id' => 9,
                'parent_category_id' => 4,
                'slug' => 'dahua',
                'name' => 'Dahua',
                'image' => 'uploads/crm/categorie/feature_image/dahua.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/dahua.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // Biometric
            [
                'id' => 10,
                'parent_category_id' => 5,
                'slug' => 'zkteco',
                'name' => 'ZKTeco',
                'image' => 'uploads/crm/categorie/feature_image/zkteco.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/zkteco.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // Router
            [
                'id' => 11,
                'parent_category_id' => 6,
                'slug' => 'tp-link',
                'name' => 'TP-Link',
                'image' => 'uploads/crm/categorie/feature_image/tplink.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/tplink.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            [
                'id' => 12,
                'parent_category_id' => 6,
                'slug' => 'netgear',
                'name' => 'Netgear',
                'image' => 'uploads/crm/categorie/feature_image/netgear.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/netgear.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // SSD
            [
                'id' => 13,
                'parent_category_id' => 7,
                'slug' => 'samsung',
                'name' => 'Samsung',
                'image' => 'uploads/crm/categorie/feature_image/ssd_samsung.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/ssd_samsung.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            [
                'id' => 14,
                'parent_category_id' => 7,
                'slug' => 'western-digital',
                'name' => 'Western Digital',
                'image' => 'uploads/crm/categorie/feature_image/ssd_wd.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/ssd_wd.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // Scanner
            [
                'id' => 15,
                'parent_category_id' => 8,
                'slug' => 'canon',
                'name' => 'Canon',
                'image' => 'uploads/crm/categorie/feature_image/canon_scanner.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/canon_scanner.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // Server
            [
                'id' => 16,
                'parent_category_id' => 9,
                'slug' => 'dell',
                'name' => 'Dell',
                'image' => 'uploads/crm/categorie/feature_image/dell_server.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/dell_server.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // Keyboard
            [
                'id' => 17,
                'parent_category_id' => 10,
                'slug' => 'logitech',
                'name' => 'Logitech',
                'image' => 'uploads/crm/categorie/feature_image/logitech_keyboard.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/logitech_keyboard.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],

            // Mouse
            [
                'id' => 18,
                'parent_category_id' => 11,
                'slug' => 'logitech',
                'name' => 'Logitech',
                'image' => 'uploads/crm/categorie/feature_image/logitech_mouse.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/logitech_mouse.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
            // Webcam
            [
                'id' => 19,
                'parent_category_id' => 12,
                'slug' => 'microsoft',
                'name' => 'Microsoft',
                'image' => 'uploads/crm/categorie/feature_image/microsoft_webcam.png',
                'icon_image' => 'uploads/crm/categorie/icon_image/microsoft_webcam.png',
                'status_ecommerce' => 1,
                'status' => "1"
            ],
        ]);
    }
}
