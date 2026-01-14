<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $warehouses = [
            [
                'warehouse_code' => 'WH001',
                'name' => 'Malad Warehouse',
                'type' => 'Storage Hub',
                'address1' => 'Office No. 501, 5th Floor, Ghanshyam Enclave',
                'address2' => '501A',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'pincode' => '400067',
                'contact_person_name' => 'Technofra',
                'phone_number' => '8080803374',
                'alternate_phone_number' => '8080721003',
                'email' => 'customer1@gmail.com',
                'working_hours' => '9 AM - 5 PM',
                'working_days' => 'Mon-Sat',
                'max_store_capacity' => 5000,
                'supported_operations' => 'Inbound',
                'zone_conf' => 'Receiving Zone',
                'gst_no' => '24AAQFT9187K1Z8',
                'licence_no' => '5656556',
                'licence_doc' => 'uploads/warehouse/licence_docs/1759145446.pdf',
                'verification_status' => 'verified',
                'default_warehouse' => 'yes',
                'status' => 'active',
            ],
            [
                'warehouse_code' => 'WH002',
                'name' => 'Andheri Warehouse',
                'type' => 'Distribution Center',
                'address1' => 'Shop No. 12, Orion Building',
                'address2' => '12B',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'pincode' => '400058',
                'contact_person_name' => 'Rahul Sharma',
                'phone_number' => '9876543210',
                'alternate_phone_number' => '9876501234',
                'email' => 'andheri.warehouse@gmail.com',
                'working_hours' => '10 AM - 6 PM',
                'working_days' => 'Mon-Sat',
                'max_store_capacity' => 4000,
                'supported_operations' => 'Inbound, Outbound',
                'zone_conf' => 'Dispatch Zone',
                'gst_no' => '27AAQFT9187K1Z7',
                'licence_no' => '9876543',
                'licence_doc' => 'uploads/warehouse/licence_docs/1759145447.pdf',
                'verification_status' => 'verified',
                'default_warehouse' => 'no',
                'status' => 'active',
            ],
            [
                'warehouse_code' => 'WH003',
                'name' => 'Bangalore Warehouse',
                'type' => 'Storage Hub',
                'address1' => 'Plot No. 34, 3rd Cross, Whitefield',
                'address2' => '34C',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'pincode' => '560066',
                'contact_person_name' => 'Anil Kumar',
                'phone_number' => '9123456780',
                'alternate_phone_number' => '9123405678',
                'email' => 'bangalore.warehouse@gmail.com',
                'working_hours' => '9 AM - 6 PM',
                'working_days' => 'Mon-Sat',
                'max_store_capacity' => 6000,
                'supported_operations' => 'Inbound, Outbound',
                'zone_conf' => 'Receiving Zone',
                'gst_no' => '29AAQFT9187K1Z9',
                'licence_no' => '1122334',
                'licence_doc' => 'uploads/warehouse/licence_docs/1759145448.pdf',
                'verification_status' => 'verified',
                'default_warehouse' => 'no',
                'status' => 'active',
            ],
            [
                'warehouse_code' => 'WH004',
                'name' => 'Delhi Warehouse',
                'type' => 'Distribution Center',
                'address1' => 'Unit No. 21, DLF Industrial Area',
                'address2' => '21A',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'pincode' => '110045',
                'contact_person_name' => 'Priya Verma',
                'phone_number' => '9012345678',
                'alternate_phone_number' => '9012309876',
                'email' => 'delhi.warehouse@gmail.com',
                'working_hours' => '10 AM - 7 PM',
                'working_days' => 'Mon-Sat',
                'max_store_capacity' => 4500,
                'supported_operations' => 'Inbound',
                'zone_conf' => 'Dispatch Zone',
                'gst_no' => '07AAQFT9187K1D1',
                'licence_no' => '3344556',
                'licence_doc' => 'uploads/warehouse/licence_docs/1759145449.pdf',
                'verification_status' => 'verified',
                'default_warehouse' => 'no',
                'status' => 'active',
            ],
            [
                'warehouse_code' => 'WH005',
                'name' => 'Chennai Warehouse',
                'type' => 'Storage Hub',
                'address1' => 'No. 10, GST Road, Guindy',
                'address2' => '10B',
                'city' => 'Chennai',
                'state' => 'Tamil Nadu',
                'country' => 'India',
                'pincode' => '600032',
                'contact_person_name' => 'Ramesh Iyer',
                'phone_number' => '9445566778',
                'alternate_phone_number' => '9445566000',
                'email' => 'chennai.warehouse@gmail.com',
                'working_hours' => '9 AM - 5 PM',
                'working_days' => 'Mon-Sat',
                'max_store_capacity' => 5000,
                'supported_operations' => 'Inbound, Outbound',
                'zone_conf' => 'Receiving Zone',
                'gst_no' => '33AAQFT9187K1C2',
                'licence_no' => '7788990',
                'licence_doc' => 'uploads/warehouse/licence_docs/1759145450.pdf',
                'verification_status' => 'pending',
                'default_warehouse' => 'no',
                'status' => 'inactive',
            ],
        ];

        foreach ($warehouses as $w) {
            DB::table('warehouses')->updateOrInsert([
                'warehouse_code' => $w['warehouse_code']
            ], $w);
        }
    }
}
