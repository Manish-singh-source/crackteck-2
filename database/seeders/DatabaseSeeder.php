<?php

namespace Database\Seeders;

use App\Models\Contact;
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

        User::factory()->create([
            'name' => 'Support',
            'email' => 'support@technofra.com',
            'password' => '123456'
        ]);

        // Create roles idempotently
        // Role::firstOrCreate(['name' => 'Engineer']);
        // Role::firstOrCreate(['name' => 'Delivery Man']);
        // Role::firstOrCreate(['name' => 'Sales Person']);
        // Role::firstOrCreate(['name' => 'Customer']);
        // Role::firstOrCreate(['name' => 'Admin']);
        // Role::firstOrCreate(['name' => 'Warehouse Manager']);

        $this->call([
            StaffSeeder::class,
            StaffAddressSeeder::class,
            StaffAadharDetailSeeder::class,
            StaffPanCardDetailSeeder::class,
            StaffBankDetailSeeder::class,
            StaffVehicleDetailSeeder::class,
            StaffPoliceVerificationSeeder::class,
            StaffWorkSkillSeeder::class,

            LeadTableSeeder::class,
            FollowUpTableSeeder::class,
            MeetTableSeeder::class,
            QuotationTableSeeder::class,
            QuotationProductTableSeeder::class,
            BrandsSeeder::class,
            ContactSeeder::class,
            CouponSeeder::class,
            CustomerSeeder::class,
            CustomerAddressDetailsSeeder::class,
            CustomerAadharDetailSeeder::class,
            CustomerPanCardDetailSeeder::class,
            CustomerCompanyDetailSeeder::class,
            VendorSeeder::class,
            VendorPurchaseOrderSeeder::class,
            WarehousesSeeder::class,
            ParentCategoriesSeeder::class,
            SubCategoriesSeeder::class,
            ProductsSeeder::class,
            EcommerceProductsSeeder::class,
            ProductSerialSeeder::class,
            CoveredItemSeeder::class,
            AmcPlanSeeder::class,
            ServiceRequestSeeder::class,
            ServiceRequestProductSeeder::class,
            RemoteJobSeeder::class,
            CaseTransferRequestSeeder::class,
            PickupRequestSeeder::class,
            StockInHandSeeder::class,
            StockInHandProductSeeder::class,
            FieldIssueSeeder::class,
            PincodeSeeder::class,
            
            // OrderSeeder::class,
            // OrderItemSeeder::class,
            // OrderPaymentSeeder::class,
            // SubscriberSeeder::class,
            // CouponUsageSeeder::class,
            // TestimonialSeeder::class,
            // CollectionSeeder::class,
            // TicketSeeder::class,
            // TicketCommentSeeder::class,
            // InvoiceSeeder::class,
            // InvoiceItemSeeder::class,
            // AssignedEngineerSeeder::class,
            // EngineerDiagnosisDetailSeeder::class,
            // ServiceRequestProductPickupSeeder::class,
            // ServiceRequestProductRequestPartSeeder::class,
            // ServiceRequestPaymentSeeder::class,
            ServiceRequestQuotationSeeder::class,
            // RequestedPartDeliverySeeder::class,
            // AssignedEngineerGroupSeeder::class,
            // WebsiteBannerSeeder::class,
        ]);
    }
}
