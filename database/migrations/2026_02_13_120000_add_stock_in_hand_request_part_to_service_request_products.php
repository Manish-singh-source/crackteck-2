<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update status enum to add stock_in_hand and request_part options
        DB::statement("ALTER TABLE service_request_products MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'processing', 'in_progress', 'on_hold', 'diagnosis_completed', 'processed', 'picking', 'picked', 'completed', 'stock_in_hand', 'request_part') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status enum to original values
        DB::statement("ALTER TABLE service_request_products MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'processing', 'in_progress', 'on_hold', 'diagnosis_completed', 'processed', 'picking', 'picked', 'completed') DEFAULT 'pending'");
    }
};
