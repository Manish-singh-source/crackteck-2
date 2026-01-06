<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VendorPurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pos = [
            [
                'vendor_id' => 1,
                'po_number' => 'PO-2026-001',
                'invoice_number' => 'INV-2026-001',
                'invoice_pdf' => 'vendors/invoices/inv_1.pdf',
                'purchase_date' => Carbon::now()->subDays(10),
                'po_amount_due_date' => Carbon::now()->addDays(20),
                'po_amount' => 15000.00,
                'po_amount_paid' => 5000.00,
                'po_amount_pending' => 10000.00,
                'po_status' => '0', // pending
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vendor_id' => 2,
                'po_number' => 'PO-2026-002',
                'invoice_number' => 'INV-2026-002',
                'invoice_pdf' => 'vendors/invoices/inv_2.pdf',
                'purchase_date' => Carbon::now()->subDays(30),
                'po_amount_due_date' => Carbon::now()->addDays(10),
                'po_amount' => 25000.00,
                'po_amount_paid' => 25000.00,
                'po_amount_pending' => 0.00,
                'po_status' => '1', // approved
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vendor_id' => 3,
                'po_number' => 'PO-2026-003',
                'invoice_number' => 'INV-2026-003',
                'invoice_pdf' => 'vendors/invoices/inv_3.pdf',
                'purchase_date' => Carbon::now()->subDays(5),
                'po_amount_due_date' => Carbon::now()->addDays(25),
                'po_amount' => 5000.00,
                'po_amount_paid' => 0.00,
                'po_amount_pending' => 5000.00,
                'po_status' => '0', // pending
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($pos as $po) {
            DB::table('vendor_purchase_orders')->updateOrInsert(
                ['po_number' => $po['po_number']],
                $po
            );
        }
    }
}
