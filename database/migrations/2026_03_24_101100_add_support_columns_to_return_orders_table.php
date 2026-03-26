<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_orders', function (Blueprint $table) {
            $table->foreignId('order_item_id')->nullable()->after('order_number')->constrained('order_items')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->after('order_item_id')->constrained('products')->nullOnDelete();
            $table->text('return_description')->nullable()->after('return_reason');
            $table->json('return_images')->nullable()->after('return_description');
            $table->string('payment_method_snapshot')->nullable()->after('return_images');
            $table->string('refund_reference')->nullable()->after('refund_status');
            $table->text('refund_notes')->nullable()->after('refund_reference');
            $table->text('admin_notes')->nullable()->after('refund_notes');
        });
    }

    public function down(): void
    {
        Schema::table('return_orders', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn([
                'order_item_id',
                'product_id',
                'return_description',
                'return_images',
                'payment_method_snapshot',
                'refund_reference',
                'refund_notes',
                'admin_notes',
            ]);
        });
    }
};
