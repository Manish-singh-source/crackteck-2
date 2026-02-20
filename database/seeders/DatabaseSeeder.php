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

        User::factory()->create([
            'name' => 'Support',
            'email' => 'support@technofra.com',
            'password' => '123456'
        ]);

        // Create roles idempotently
        Role::firstOrCreate(['name' => 'Engineer']);
        Role::firstOrCreate(['name' => 'Delivery Man']);
        Role::firstOrCreate(['name' => 'Sales Person']);
        Role::firstOrCreate(['name' => 'Customer']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Warehouse Manager']);

        $this->call([
            StaffSeeder::class,
            StaffAddressSeeder::class,
            StaffAadharDetailSeeder::class,
            StaffPanCardDetailSeeder::class,
            StaffBankDetailSeeder::class,
            StaffVehicleDetailSeeder::class,
            StaffPoliceVerificationSeeder::class,
            StaffWorkSkillSeeder::class,

            CustomerSeeder::class,
            CustomerAddressDetailsSeeder::class,
            CustomerAadharDetailSeeder::class,
            CustomerPanCardDetailSeeder::class,
            CustomerCompanyDetailSeeder::class,


            // warehouse ================
            VendorSeeder::class,
            VendorPurchaseOrderSeeder::class,
            WarehousesSeeder::class,

            
            ParentCategoriesSeeder::class,
            SubCategoriesSeeder::class,
            
            BrandsSeeder::class,
            // ProductVariantAttributesSeeder::class,
            // ProductVariantAttributeValuesSeeder::class,
            
            
            ProductsSeeder::class,
            // EcommerceProductsSeeder::class,
            // ProductSerialSeeder::class,

            CouponSeeder::class,
            CouponUsageSeeder::class,
            CollectionSeeder::class,

            SubscriberSeeder::class,
            ContactSeeder::class,
            
            WebsiteBannerSeeder::class,

            // OrderSeeder::class,
            // OrderItemSeeder::class,
            // OrderPaymentSeeder::class,


            // e-commerce data ====================
            TestimonialSeeder::class,
            FeedbackSeeder::class,
            
            
            
            
            // crm ====================
            // LeadTableSeeder::class,
            // FollowUpTableSeeder::class,
            // MeetTableSeeder::class,

            // QuotationTableSeeder::class,
            // QuotationProductTableSeeder::class,
            
            CoveredItemSeeder::class,
            AmcPlanSeeder::class,
            PincodeSeeder::class,


            // ServiceRequestSeeder::class,
            // ServiceRequestProductSeeder::class,
            // ServiceRequestQuotationSeeder::class,

            
            // AssignedEngineerSeeder::class,
            // EngineerDiagnosisDetailSeeder::class,
            // ServiceRequestProductPickupSeeder::class,
            // ServiceRequestProductRequestPartSeeder::class,
            // RequestedPartDeliverySeeder::class,
            // AssignedEngineerGroupSeeder::class,
            // ServiceRequestPaymentSeeder::class,
           
            // RemoteJobSeeder::class,
            // CaseTransferRequestSeeder::class,
            // PickupRequestSeeder::class,
            // StockInHandSeeder::class,
            // StockInHandProductSeeder::class,
            // FieldIssueSeeder::class,
            
            
            
            // InvoiceSeeder::class,
            // InvoiceItemSeeder::class,
            
            
            // CustomerFeedbackSeeder::class,
            // TicketSeeder::class,
            // TicketCommentSeeder::class,

        ]);
    }
}
    