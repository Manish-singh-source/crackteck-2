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
        DB::table('sub_categories')->insert([
            // Printer
            ['id' => 1, 'parent_category_id' => 1, 'sub_categorie' => 'HP', 'feature_image' => 'uploads/crm/categorie/feature_image/hp.png', 'icon_image' => 'uploads/crm/categorie/icon_image/hp.png'],
            ['id' => 2, 'parent_category_id' => 1, 'sub_categorie' => 'Dell', 'feature_image' => 'uploads/crm/categorie/feature_image/dell.png', 'icon_image' => 'uploads/crm/categorie/icon_image/dell.png'],
            ['id' => 3, 'parent_category_id' => 1, 'sub_categorie' => 'Asus', 'feature_image' => 'uploads/crm/categorie/feature_image/asus.png', 'icon_image' => 'uploads/crm/categorie/icon_image/asus.png'],

            // Monitor
            ['id' => 4, 'parent_category_id' => 2, 'sub_categorie' => 'Samsung', 'feature_image' => 'uploads/crm/categorie/feature_image/samsung.png', 'icon_image' => 'uploads/crm/categorie/icon_image/samsung.png'],
            ['id' => 5, 'parent_category_id' => 2, 'sub_categorie' => 'LG', 'feature_image' => 'uploads/crm/categorie/feature_image/lg.png', 'icon_image' => 'uploads/crm/categorie/icon_image/lg.png'],

            // Laptop
            ['id' => 6, 'parent_category_id' => 3, 'sub_categorie' => 'HP', 'feature_image' => 'uploads/crm/categorie/feature_image/hp_laptop.png', 'icon_image' => 'uploads/crm/categorie/icon_image/hp_laptop.png'],
            ['id' => 7, 'parent_category_id' => 3, 'sub_categorie' => 'Dell', 'feature_image' => 'uploads/crm/categorie/feature_image/dell_laptop.png', 'icon_image' => 'uploads/crm/categorie/icon_image/dell_laptop.png'],

            // CCTV
            ['id' => 8, 'parent_category_id' => 4, 'sub_categorie' => 'Hikvision', 'feature_image' => 'uploads/crm/categorie/feature_image/hikvision.png', 'icon_image' => 'uploads/crm/categorie/icon_image/hikvision.png'],
            ['id' => 9, 'parent_category_id' => 4, 'sub_categorie' => 'Dahua', 'feature_image' => 'uploads/crm/categorie/feature_image/dahua.png', 'icon_image' => 'uploads/crm/categorie/icon_image/dahua.png'],

            // Biometric
            ['id' => 10, 'parent_category_id' => 5, 'sub_categorie' => 'ZKTeco', 'feature_image' => 'uploads/crm/categorie/feature_image/zkteco.png', 'icon_image' => 'uploads/crm/categorie/icon_image/zkteco.png'],

            // Router
            ['id' => 11, 'parent_category_id' => 6, 'sub_categorie' => 'TP-Link', 'feature_image' => 'uploads/crm/categorie/feature_image/tplink.png', 'icon_image' => 'uploads/crm/categorie/icon_image/tplink.png'],
            ['id' => 12, 'parent_category_id' => 6, 'sub_categorie' => 'Netgear', 'feature_image' => 'uploads/crm/categorie/feature_image/netgear.png', 'icon_image' => 'uploads/crm/categorie/icon_image/netgear.png'],

            // SSD
            ['id' => 13, 'parent_category_id' => 7, 'sub_categorie' => 'Samsung', 'feature_image' => 'uploads/crm/categorie/feature_image/ssd_samsung.png', 'icon_image' => 'uploads/crm/categorie/icon_image/ssd_samsung.png'],
            ['id' => 14, 'parent_category_id' => 7, 'sub_categorie' => 'Western Digital', 'feature_image' => 'uploads/crm/categorie/feature_image/ssd_wd.png', 'icon_image' => 'uploads/crm/categorie/icon_image/ssd_wd.png'],

            // Scanner
            ['id' => 15, 'parent_category_id' => 8, 'sub_categorie' => 'Canon', 'feature_image' => 'uploads/crm/categorie/feature_image/canon_scanner.png', 'icon_image' => 'uploads/crm/categorie/icon_image/canon_scanner.png'],

            // Server
            ['id' => 16, 'parent_category_id' => 9, 'sub_categorie' => 'Dell', 'feature_image' => 'uploads/crm/categorie/feature_image/dell_server.png', 'icon_image' => 'uploads/crm/categorie/icon_image/dell_server.png'],

            // Keyboard
            ['id' => 17, 'parent_category_id' => 10, 'sub_categorie' => 'Logitech', 'feature_image' => 'uploads/crm/categorie/feature_image/logitech_keyboard.png', 'icon_image' => 'uploads/crm/categorie/icon_image/logitech_keyboard.png'],

            // Mouse
            ['id' => 18, 'parent_category_id' => 11, 'sub_categorie' => 'Logitech', 'feature_image' => 'uploads/crm/categorie/feature_image/logitech_mouse.png', 'icon_image' => 'uploads/crm/categorie/icon_image/logitech_mouse.png'],

            // Webcam
            ['id' => 19, 'parent_category_id' => 12, 'sub_categorie' => 'Microsoft', 'feature_image' => 'uploads/crm/categorie/feature_image/microsoft_webcam.png', 'icon_image' => 'uploads/crm/categorie/icon_image/microsoft_webcam.png'],
        ]);
    }
}
