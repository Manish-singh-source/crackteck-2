<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $orders = Order::where('total_amount', '>', 0)->inRandomOrder()->limit(15)->get();

        if ($orders->isEmpty()) {
            return;
        }

        $invoices = [];

        foreach ($orders as $order) {
            // Skip if invoice already exists for this order
            $exists = DB::table('invoices')->where('order_id', $order->id)->exists();
            if ($exists) {
                continue;
            }

            $invoiceDate = $now->subDays(rand(0, 30));
            $dueDate = (clone $invoiceDate)->addDays(30);

            // Randomly decide if fully paid, partially paid, or unpaid
            $paidOption = rand(0, 2); // 0=unpaid,1=partial,2=paid
            $total = $order->total_amount ?: ($order->subtotal ?: 0);
            $paidAmount = 0;
            if ($paidOption === 2) {
                $paidAmount = $total;
            } elseif ($paidOption === 1) {
                $paidAmount = round($total * (rand(10, 80) / 100), 2);
            }

            $status = $paidAmount >= $total ? '4' : ($paidAmount > 0 ? '3' : '0');

            $invoices[] = [
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'invoice_id' => 'INV-' . strtoupper(uniqid()),
                'invoice_date' => $invoiceDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                'currency' => 'INR',
                'subtotal' => $order->subtotal ?? $total,
                'discount_amount' => $order->discount_amount ?? 0,
                'tax_amount' => $order->tax_amount ?? 0,
                'total_amount' => $total,
                'paid_amount' => $paidAmount,
                'status' => $status,
                'notes' => 'Seeded invoice for order #' . $order->order_number,
                'invoice_document_path' => null,
                'sent_at' => $now->toDateTimeString(),
                'viewed_at' => $paidAmount > 0 ? $now->subDays(rand(0, 10))->toDateTimeString() : null,
                'paid_at' => $paidAmount > 0 && $paidAmount >= $total ? $now->toDateTimeString() : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($invoices)) {
            DB::table('invoices')->insert($invoices);
        }
    }
}
