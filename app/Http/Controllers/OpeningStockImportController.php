<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\SubCategory;
use App\Models\Vendor;
use App\Models\VendorPurchaseOrder;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class OpeningStockImportController extends Controller
{
    private const TEMPLATE_HEADERS = [
        'Vendor Code', 'Invoice Number', 'Product Name', 'SKU', 'HSN Code', 'Model No',
        'Brand', 'Parent Category', 'Sub Category', 'Warehouse', 'Cost Price', 'Selling Price',
        'Tax', 'Opening Quantity', 'Stock Status', 'Status',
    ];

    public function create()
    {
        return view('warehouse.opening-stock.create');
    }

    public function downloadTemplate()
    {
        $path = storage_path('app/opening_stock_template_'.Str::random(8).'.xlsx');
        $writer = SimpleExcelWriter::create($path);
        $writer->addHeader(self::TEMPLATE_HEADERS);
        $writer->close();

        return response()->download(
            $path,
            'opening-stock-template.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        )->deleteFileAfterSend(true);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'opening_stock_file' => 'required|file|mimes:xlsx,csv|max:5120',
        ]);

        $file = $request->file('opening_stock_file');

        // PHP stores uploaded files with a temporary `.tmp` extension. Pass the
        // validated original extension so Simple Excel picks the correct reader.
        $rows = SimpleExcelReader::create($file->getRealPath(), strtolower($file->getClientOriginalExtension()))
            ->headersToSnakeCase()
            ->getRows();

        $preparedRows = [];
        $errors = [];
        $uploadedSkus = [];
        $rowNumber = 1;

        foreach ($rows as $row) {
            $rowNumber++;

            if ($this->isEmptyRow($row)) {
                continue;
            }

            $prepared = $this->prepareRow($row, $rowNumber, $errors, $uploadedSkus);
            if ($prepared) {
                $preparedRows[] = $prepared;
            }
        }

        if (empty($preparedRows) && empty($errors)) {
            $errors[] = 'The uploaded file does not contain any stock rows.';
        }

        if ($errors) {
            return back()->withInput()->with('import_errors', $errors);
        }

        try {
            DB::transaction(function () use ($preparedRows) {
                foreach ($preparedRows as $data) {
                    $product = Product::create($data);
                    $this->createSerialsAndBarcodes($product);
                }
            });
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('error', 'Opening stock could not be imported. No stock was added.');
        }

        return redirect()->route('products.index')
            ->with('success', count($preparedRows).' opening-stock product(s) imported successfully.');
    }

    private function prepareRow(array $row, int $rowNumber, array &$errors, array &$uploadedSkus): ?array
    {
        $errorCount = count($errors);
        $values = collect($row)->map(fn ($value) => is_string($value) ? trim($value) : $value);
        $required = [
            'vendor_code', 'invoice_number', 'product_name', 'sku', 'hsn_code', 'model_no',
            'brand', 'parent_category', 'warehouse', 'cost_price', 'selling_price',
            'opening_quantity',
        ];

        foreach ($required as $field) {
            if (blank($values->get($field))) {
                $errors[] = "Row {$rowNumber}: ".str($field)->replace('_', ' ')->title().' is required.';
            }
        }

        if (Product::where('sku', $values->get('sku'))->exists() || in_array($values->get('sku'), $uploadedSkus, true)) {
            $errors[] = "Row {$rowNumber}: SKU '{$values->get('sku')}' already exists.";
        }

        if (! is_numeric($values->get('cost_price')) || (float) $values->get('cost_price') < 0) {
            $errors[] = "Row {$rowNumber}: Cost Price must be a number greater than or equal to 0.";
        }

        if (! is_numeric($values->get('selling_price')) || (float) $values->get('selling_price') < 0) {
            $errors[] = "Row {$rowNumber}: Selling Price must be a number greater than or equal to 0.";
        }

        if (filled($values->get('tax')) && (! is_numeric($values->get('tax')) || (float) $values->get('tax') < 0 || (float) $values->get('tax') > 100)) {
            $errors[] = "Row {$rowNumber}: Tax must be a number between 0 and 100.";
        }

        if (filter_var($values->get('opening_quantity'), FILTER_VALIDATE_INT) === false || (int) $values->get('opening_quantity') < 1) {
            $errors[] = "Row {$rowNumber}: Opening Quantity must be a whole number of at least 1.";
        }

        $stockStatus = $values->get('stock_status') ?: 'in_stock';
        $status = $values->get('status') ?: 'active';
        if (! in_array($stockStatus, ['in_stock', 'out_of_stock', 'low_stock', 'scrap'], true)) {
            $errors[] = "Row {$rowNumber}: Stock Status is invalid.";
        }
        if (! in_array($status, ['active', 'inactive'], true)) {
            $errors[] = "Row {$rowNumber}: Status is invalid.";
        }

        $vendor = Vendor::where('vendor_code', $values->get('vendor_code'))->first();
        $brand = Brand::where('name', $values->get('brand'))->first();
        $parentCategory = ParentCategory::where('name', $values->get('parent_category'))->first();
        $subCategory = $parentCategory && filled($values->get('sub_category'))
            ? SubCategory::where('parent_category_id', $parentCategory->id)->where('name', $values->get('sub_category'))->first()
            : null;
        $warehouse = Warehouse::where('name', $values->get('warehouse'))->first();
        $invoice = $vendor
            ? VendorPurchaseOrder::where('vendor_id', $vendor->id)->where('invoice_number', $values->get('invoice_number'))->first()
            : null;

        foreach ([
            'Vendor Code' => $vendor,
            'Brand' => $brand,
            'Parent Category' => $parentCategory,
            'Warehouse' => $warehouse,
            'Invoice Number for the selected vendor' => $invoice,
        ] as $label => $model) {
            if (! $model) {
                $errors[] = "Row {$rowNumber}: {$label} was not found.";
            }
        }

        if (filled($values->get('sub_category')) && ! $subCategory) {
            $errors[] = "Row {$rowNumber}: Sub Category was not found under the selected Parent Category.";
        }

        if (count($errors) > $errorCount) {
            return null;
        }

        $uploadedSkus[] = $values->get('sku');

        return [
            'vendor_id' => $vendor->id,
            'vendor_purchase_order_id' => $invoice->id,
            'brand_id' => $brand->id,
            'parent_category_id' => $parentCategory->id,
            'sub_category_id' => $subCategory?->id,
            'warehouse_id' => $warehouse->id,
            'product_name' => $values->get('product_name'),
            'hsn_code' => $values->get('hsn_code'),
            'sku' => $values->get('sku'),
            'model_no' => $values->get('model_no'),
            'cost_price' => $values->get('cost_price'),
            'selling_price' => $values->get('selling_price'),
            'tax' => is_numeric($values->get('tax')) ? $values->get('tax') : 0,
            'final_price' => $values->get('selling_price'),
            'stock_quantity' => (int) $values->get('opening_quantity'),
            'stock_status' => $stockStatus,
            'status' => $status,
        ];
    }

    private function createSerialsAndBarcodes(Product $product): void
    {
        for ($i = 0; $i < $product->stock_quantity; $i++) {
            $serial = ProductSerial::generateAutoSerial($product->sku);

            ProductSerial::create([
                'product_id' => $product->id,
                'auto_generated_serial' => $serial,
                'cost_price' => $product->cost_price,
                'selling_price' => $product->selling_price,
                'discount_price' => $product->discount_price,
                'tax' => $product->tax,
                'final_price' => $product->final_price,
                'barcode_url' => ProductSerial::generateBarcode($serial),
                'status' => $product->status,
            ]);
        }
    }

    private function isEmptyRow(array $row): bool
    {
        return collect($row)->filter(fn ($value) => filled($value))->isEmpty();
    }
}
