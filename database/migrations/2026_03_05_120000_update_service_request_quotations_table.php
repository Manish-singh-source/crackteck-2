<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_request_quotations', function (Blueprint $table) {
            // Remove old columns that will be replaced
            $table->dropForeign(['request_part_id']);
            $table->dropForeign(['part_id']);
            $table->dropColumn(['request_part_id', 'part_id', 'product_price', 'service_charge', 'total_amount', 'discount', 'quotation_file', 'quotation_status', 'quotation_date']);
            
            // Add new calculated fields
            $table->unsignedInteger('request_part_count')->default(0)->after('request_id')->comment('Count of service_request_products for this request_id');
            $table->decimal('service_charge_total', 15, 2)->default(0)->after('request_part_count')->comment('Total service charge from service_request_products');
            $table->unsignedInteger('part_count')->default(0)->after('service_charge_total')->comment('Count of parts with status in service_request_product_request_parts');
            $table->decimal('product_price_total', 15, 2)->default(0)->after('part_count')->comment('Total product price from service_request_product_request_parts with status');
            
            // Add pricing fields
            $table->decimal('subtotal', 15, 2)->default(0)->after('product_price_total')->comment('service_charge_total + product_price_total');
            $table->decimal('total_discount', 15, 2)->default(0)->after('subtotal')->comment('Total discount amount');
            $table->decimal('total_tax', 15, 2)->default(0)->after('delivery_charge')->comment('Total tax amount');
            $table->decimal('round_off', 15, 2)->default(0)->after('total_tax')->comment('Round off amount');
            
            // Add currency
            $table->string('currency', 10)->default('INR')->after('round_off')->comment('Currency code');
            
            // Add grand total
            $table->decimal('grand_total', 15, 2)->default(0)->after('round_off')->comment('subtotal + delivery_charge - total_discount + total_tax + round_off');
            
            // Add payment related fields
            $table->decimal('paid_amount', 15, 2)->default(0)->after('grand_total')->comment('Amount paid');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid')->after('paid_amount')->comment('Payment status: unpaid, partial, paid');
            $table->string('payment_method', 50)->nullable()->after('payment_status')->comment('Payment method (e.g., phonepe)');
            $table->timestamp('paid_at')->nullable()->after('payment_method')->comment('Payment timestamp');
            
            // Add address fields
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_address_details')->nullOnDelete()->after('paid_at')->comment('Billing address from service_requests.customer_address_id');
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_address_details')->nullOnDelete()->after('billing_address_id')->comment('Shipping address from service_requests.customer_address_id');
            
            // Add invoice fields
            $table->string('invoice_number', 50)->unique()->nullable()->after('shipping_address_id')->comment('Unique invoice number');
            $table->date('invoice_date')->nullable()->after('invoice_number')->comment('Invoice date');
            $table->date('due_date')->nullable()->after('invoice_date')->comment('Due date (invoice_date + 7 days)');
            $table->string('invoice_pdf')->nullable()->after('due_date')->comment('Invoice PDF file path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_request_quotations', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'request_part_count',
                'service_charge_total',
                'part_count',
                'product_price_total',
                'subtotal',
                'total_discount',
                'total_tax',
                'round_off',
                'currency',
                'grand_total',
                'paid_amount',
                'payment_status',
                'payment_method',
                'paid_at',
                'billing_address_id',
                'shipping_address_id',
                'invoice_number',
                'invoice_date',
                'due_date',
                'invoice_pdf',
            ]);
            
            // Drop foreign keys for address
            $table->dropForeign(['billing_address_id']);
            $table->dropForeign(['shipping_address_id']);
            
            // Restore old columns
            $table->foreignId('request_part_id')->constrained('service_request_product_request_parts')->cascadeOnDelete();
            $table->foreignId('part_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('product_price', 15, 2);
            $table->decimal('service_charge', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->string('quotation_file')->nullable();
            $table->enum('quotation_status', ['pending', 'approved', 'rejected'])->default('pending')->comment('0 - Pending, 1 - Approved, 2 - Rejected');
            $table->date('quotation_date');
        });
    }
};
