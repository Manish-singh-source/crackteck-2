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
        Schema::create('vendor_purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('po_number')->unique();
            $table->string('invoice_number')->unique();
            $table->string('invoice_pdf')->nullable();
            $table->date('purchase_date');
            $table->date('po_amount_due_date');
            $table->decimal('po_amount', 10, 2);
            $table->decimal('po_amount_paid', 10, 2)->nullable();
            $table->decimal('po_amount_pending', 10, 2)->nullable();
            $table->enum('po_status', ['pending', 'approved', 'rejected', 'cancelled'])->default('approved');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_purchase_orders');
    }
};
