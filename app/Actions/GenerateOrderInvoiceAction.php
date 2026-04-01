<?php

namespace App\Actions;

use App\Helpers\FileUpload;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateOrderInvoiceAction
{
    public function execute(Order $order): Invoice
    {
        return DB::transaction(function () use ($order) {
            $order->loadMissing(['orderItems', 'customer', 'billingAddress', 'orderPayments']);

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

            $invoice->invoice_document_path = $this->storeInvoicePdf($order, $invoice);
            $invoice->save();

            return $invoice->fresh(['items', 'order']);
        });
    }

    protected function storeInvoicePdf(Order $order, Invoice $invoice): string
    {
        $pdf = Pdf::loadView('pdf.order-invoice', [
            'order' => $order,
            'invoice' => $invoice,
            'totals' => [
                'subtotal' => (float) ($invoice->subtotal ?? 0),
                'tax_amount' => (float) ($invoice->tax_amount ?? 0),
                'shipping_charges' => (float) ($order->shipping_charges ?? 0),
                'discount_amount' => (float) ($invoice->discount_amount ?? 0),
                'grand_total' => (float) ($invoice->total_amount ?? 0),
            ],
            'amount_in_words' => $this->convertNumberToWords((float) ($invoice->total_amount ?? 0)),
        ]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'defaultFont' => 'DejaVu Sans',
        ]);

        $tempDirectory = storage_path('app/tmp');
        if (! File::exists($tempDirectory)) {
            File::makeDirectory($tempDirectory, 0755, true);
        }

        $tempFilename = 'invoice-' . ($invoice->invoice_number ?? Str::random(12)) . '.pdf';
        $tempPath = $tempDirectory . DIRECTORY_SEPARATOR . $tempFilename;
        File::put($tempPath, $pdf->output());

        $uploadedFile = new UploadedFile(
            $tempPath,
            $tempFilename,
            'application/pdf',
            null,
            true
        );

        try {
            return FileUpload::updateFileUpload($uploadedFile, $invoice->invoice_document_path ?? '', 'uploads/order-invoices/');
        } finally {
            if (File::exists($tempPath)) {
                File::delete($tempPath);
            }
        }
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

    protected function convertNumberToWords(float $number): string
    {
        $number = (int) round($number);

        if ($number === 0) {
            return 'Zero Rupees Only';
        }

        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
        ];

        $result = '';

        if ($number >= 10000000) {
            $crores = intdiv($number, 10000000);
            $result .= $this->convertHundreds($crores, $words) . ' Crore ';
            $number %= 10000000;
        }

        if ($number >= 100000) {
            $lakhs = intdiv($number, 100000);
            $result .= $this->convertHundreds($lakhs, $words) . ' Lakh ';
            $number %= 100000;
        }

        if ($number >= 1000) {
            $thousands = intdiv($number, 1000);
            $result .= $this->convertHundreds($thousands, $words) . ' Thousand ';
            $number %= 1000;
        }

        if ($number >= 100) {
            $hundreds = intdiv($number, 100);
            $result .= $words[$hundreds] . ' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = intdiv($number, 10) * 10;
            $result .= $words[$tens] . ' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number] . ' ';
        }

        return trim($result) . ' Rupees Only';
    }

    protected function convertHundreds(int $number, array $words): string
    {
        $result = '';

        if ($number >= 100) {
            $hundreds = intdiv($number, 100);
            $result .= $words[$hundreds] . ' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = intdiv($number, 10) * 10;
            $result .= $words[$tens] . ' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number] . ' ';
        }

        return trim($result);
    }
}

