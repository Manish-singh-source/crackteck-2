<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\SimpleExcel\SimpleExcelWriter;

class LowStockController extends Controller
{
    /**
     * Display low stock alert page for warehouse.
     */
    public function index()
    {
        $lowStockProducts = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->where('stock_quantity', '<', 40)
            ->where('status', 'active')
            ->orderBy('stock_quantity', 'asc')
            ->get();
        return view('/warehouse/low-stock-alert/index', compact('lowStockProducts'));
    }

    public function exportLowStock()
    {
        $lowStockProducts = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->where('stock_quantity', '<', 40)
            ->where('status', 'active')
            ->orderBy('stock_quantity', 'asc')
            ->get();

        // Create a new Excel instance spatie/simple-excel 
        $tempXlsxPath = storage_path('app/product_sheet_' . Str::random(8) . '.xlsx');
        $writer = SimpleExcelWriter::create($tempXlsxPath);

        // Add data rows
        foreach ($lowStockProducts as $product) {
            $writer->addRow([
                'Product Name' => $product->product_name,
                'SKU' => $product->sku,
                'Brand' => $product->brand?->name ?? 'N/A',
                'Category' => $product->parentCategorie?->name ?? 'N/A',
                'Sub Category' => $product->subCategorie?->name ?? 'N/A',
                'Warehouse' => $product->warehouse?->name ?? 'N/A',
                'Stock Quantity' => $product->stock_quantity,
            ]);
        }

        // Close the writer

        $writer->close();

        return response()->download($tempXlsxPath, 'products_sheet.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
