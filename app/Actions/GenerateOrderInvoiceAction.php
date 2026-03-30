<?php

namespace App\Actions;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateOrderInvoiceAction
{
    public function execute(Order $order): Invoice
    {
        return DB::transaction(function () use ($order) {
            $order->loadMissing(['orderItems', 'customer']);

            $invoice = Invoice::firstOrNew([
                'order_id' => $order->getKey(),
            ]);

            if (! $invoice->exists) {
                $invoice->invoice_number = $this->generateUniqueValue('invoice_number', 'INV-' . ($order->order_number ?: strtoupper(Str::random(10))));
                $invoice->invoice_id = $this->generateUniqueValue('invoice_id', 'OID-' . ($order->order_number ?: strtoupper(Str::random(10))));
            }

            $invoice->fill([
                'customer_id' => $order->customer_id,
                'invoice_date' => now()->toDateString(),
                'due_date' => now()->toDateString(),
                'currency' => 'INR',
                'subtotal' => (float) ($order->subtotal ?? 0),
                'discount_amount' => (float) ($order->discount_amount ?? 0),
                'tax_amount' => (float) ($order->tax_amount ?? 0),
                'total_amount' => (float) ($order->total_amount ?? 0),
                'paid_amount' => (float) ($order->total_amount ?? 0),
                'status' => 'paid',
                'notes' => 'Auto-generated after successful payment for order #' . ($order->order_number ?? $order->getKey()),
                'paid_at' => now(),
            ]);
            $invoice->save();

            InvoiceItem::where('invoice_id', $invoice->getKey())->delete();

            foreach ($order->orderItems as $item) {
                $unitPrice = (float) ($item->unit_price ?? 0);
                $taxPerUnit = (float) ($item->tax_per_unit ?? 0);

                InvoiceItem::create([
                    'invoice_id' => $invoice->getKey(),
                    'item_description' => $item->product_name ?: ('Order item #' . $item->getKey()),
                    'quantity' => (int) ($item->quantity ?? 1),
                    'unit_price' => $unitPrice,
                    'tax_rate' => $unitPrice > 0 ? round(($taxPerUnit / $unitPrice) * 100, 2) : 0,
                    'line_total' => (float) ($item->line_total ?? ($unitPrice * (int) ($item->quantity ?? 1))),
                ]);
            }

            return $invoice->fresh();
        });
    }

    protected function generateUniqueValue(string $column, string $base): string
    {
        $value = $base;
        $suffix = 1;

        while (Invoice::where($column, $value)->exists()) {
            $value = $base . '-' . $suffix;
            $suffix++;
        }

        return $value;
    }
}
