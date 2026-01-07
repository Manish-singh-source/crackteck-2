<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Invoice;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Use DB query to avoid SoftDeletes global scope when the table lacks deleted_at
        $invoices = DB::table('invoices')->inRandomOrder()->limit(20)->get();
        if ($invoices->isEmpty()) {
            return;
        }

        $items = [];

        foreach ($invoices as $invoice) {
            // If order items exist, mirror them into invoice items
            $orderItems = DB::table('order_items')->where('order_id', $invoice->order_id)->get();

            if ($orderItems->isNotEmpty()) {
                foreach ($orderItems as $oi) {
                    $taxRate = 0;
                    if (!empty($oi->unit_price) && $oi->unit_price != 0) {
                        $taxRate = round((($oi->tax_per_unit ?? 0) / $oi->unit_price) * 100, 2);
                    }

                    $items[] = [
                        'invoice_id' => $invoice->id,
                        'item_description' => $oi->product_name ?? ($oi->product_sku ?? 'Item'),
                        'quantity' => $oi->quantity ?? 1,
                        'unit_price' => $oi->unit_price ?? 0,
                        'tax_rate' => $taxRate,
                        'line_total' => $oi->line_total ?? (($oi->unit_price ?? 0) * ($oi->quantity ?? 1)),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            } else {
                // Fallback: create a single item matching invoice total
                $taxRate = 0;
                if (!empty($invoice->subtotal) && $invoice->subtotal != 0) {
                    $taxRate = round((($invoice->tax_amount ?? 0) / $invoice->subtotal) * 100, 2);
                }

                $items[] = [
                    'invoice_id' => $invoice->id,
                    'item_description' => 'Invoice for order #' . $invoice->order_id,
                    'quantity' => 1,
                    'unit_price' => $invoice->subtotal ?? $invoice->total_amount,
                    'tax_rate' => $taxRate,
                    'line_total' => $invoice->total_amount,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($items)) {
            DB::table('invoice_items')->insert($items);
        }
    }
}
