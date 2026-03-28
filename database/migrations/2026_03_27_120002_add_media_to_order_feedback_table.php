<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adds a media column to the order_feedback table to store customer
     * uploaded feedback images directly in the feedback record.
     * 
     * The media column will store JSON array of media objects with:
     * - file_path: Path to uploaded file
     * - file_type: Type of media (image/video)
     * - original_name: Original filename
     * - file_size: File size in bytes
     */
    public function up(): void
    {
        Schema::table('order_feedback', function (Blueprint $table) {
            $table->json('media')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_feedback', function (Blueprint $table) {
            $table->dropColumn('media');
        });
    }
};
