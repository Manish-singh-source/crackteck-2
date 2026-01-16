<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\ProductVariantAttribute;
use App\Models\ScrapItem;
use App\Models\SubCategory;
use App\Models\Vendor;
use App\Models\VendorPurchaseOrder;
use App\Models\Warehouse;
use App\Models\WarehouseRack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        if (request()->has('status') && request('status') !== 'all') {
            $products->where('status', request('status'));
        }

        $products = $products->with(['brand', 'parentCategorie', 'subCategorie', 'warehouse', 'warehouseRack'])->get();

        return view('/warehouse/product-list/index', compact('products'));
    }

    public function create()
    {
        $vendors = Vendor::selectRaw(
            "id, CONCAT(vendor_code, ' - ', first_name, ' ', last_name) AS name"
        )->pluck('name', 'id');
        $vendorPurchaseOrders = VendorPurchaseOrder::pluck('po_number', 'id');
        $brands = Brand::pluck('name', 'id');
        $parentCategories = ParentCategory::pluck('name', 'id');
        $subCategories = SubCategory::pluck('name', 'id');
        $warehouses = Warehouse::pluck('name', 'id');
        $warehouseRacks = WarehouseRack::pluck('rack_name', 'id');
        $zoneAreas = WarehouseRack::pluck('zone_area', 'id');
        $rackNo = WarehouseRack::pluck('rack_no', 'id');
        $levelNo = WarehouseRack::pluck('level_no', 'id');
        $positionNo = WarehouseRack::pluck('position_no', 'id');
        $variationAttributes = ProductVariantAttribute::with('values')->get();

        $variationAttributeValues = [];
        foreach ($variationAttributes as $attribute) {
            $variationAttributeValues[$attribute->name] = $attribute->values->pluck('value');
        }

        // Initialize empty selectedVariations for create page
        $selectedVariations = [];

        // dd($subCategories);

        // $parentCategories = Categorie::pluck('name', 'id');
        // $subCategories = SubCategorie::pluck('name', 'id');
        return view('/warehouse/product-list/create', compact('brands', 'vendors', 'vendorPurchaseOrders', 'parentCategories', 'subCategories', 'warehouses', 'warehouseRacks', 'zoneAreas', 'rackNo', 'levelNo', 'positionNo', 'variationAttributes', 'variationAttributeValues', 'selectedVariations'));
    }

    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            // Process product variations
            // Format: ["Color" => ["Red", "Blue"], "Size" => ["Large"]]
            // Store as: {"Color": ["Red", "Blue"], "Size": ["Large"]}
            if (isset($data['variations']) && is_array($data['variations'])) {
                $data['variation_options'] = $data['variations'];
                unset($data['variations']);
            } else {
                $data['variation_options'] = null;
            }

            // Calculate final price (DO NOT trust client)
            $data['final_price'] =
                ($data['selling_price'] ?? 0)
                - ($data['discount_price'] ?? 0)
                + (($data['selling_price'] ?? 0) * ($data['tax'] ?? 0) / 100);

            // Main image
            if ($request->hasFile('main_product_image')) {
                $file = $request->file('main_product_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products/images'), $filename);
                $data['main_product_image'] = 'uploads/products/images/' . $filename;
            }

            // Additional images
            if ($request->hasFile('additional_product_images')) {
                $images = [];
                foreach ($request->file('additional_product_images') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/products/images'), $filename);
                    $images[] = 'uploads/products/images/' . $filename;
                }
                $data['additional_product_images'] = json_encode($images);
            }

            // Datasheet
            if ($request->hasFile('datasheet_manual')) {
                $file = $request->file('datasheet_manual');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products/datasheets'), $filename);
                $data['datasheet_manual'] = 'uploads/products/datasheets/' . $filename;
            }

            $product = Product::create($data);

            // Ensure serials
            $this->ensureProductSerials($product);

            DB::commit();

            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Error creating product.')
                ->withInput();
        }
    }

    public function view($id)
    {
        $product = Product::with([
            'brand',
            'parentCategorie',
            'subCategorie',
            'warehouse',
            'warehouseRack',
            'productSerials' => function ($query) {
                $query->where('status', 'active'); // Only show active serial numbers
            },
        ])->findOrFail($id);

        // Prepare variations for display
        return view('/warehouse/product-list/view', compact('product'));
    }

    /**
     * Ensure product serials exist for the product based on stock quantity
     */
    private function ensureProductSerials(Product $product)
    {
        $stockQuantity = $product->stock_quantity ?? 0;
        $existingSerials = $product->productSerials()->count();

        // If we need more serials, create them
        if ($existingSerials < $stockQuantity) {
            $serialsToCreate = $stockQuantity - $existingSerials;

            for ($i = 0; $i < $serialsToCreate; $i++) {
                $autoSerial = ProductSerial::generateAutoSerial($product->sku);

                ProductSerial::create([
                    'product_id' => $product->id,
                    'auto_generated_serial' => $autoSerial,
                    'cost_price' => $product->cost_price,
                    'selling_price' => $product->selling_price,
                    'discount_price' => $product->discount_price,
                    'tax' => $product->tax,
                    'final_price' => $product->final_price,
                    'main_product_image' => $product->main_product_image,
                    'additional_product_images' => $product->additional_product_images,
                    'variations' => $product->variation_options,
                    'status' => $product->status,
                ]);
            }
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $vendors = Vendor::selectRaw(
            "id, CONCAT(vendor_code, ' - ', first_name, ' ', last_name) AS name"
        )->pluck('name', 'id');
        $vendorPurchaseOrders = VendorPurchaseOrder::where('vendor_id', $product->vendor_id)->pluck('po_number', 'id');
        $brands = Brand::pluck('name', 'id');
        $parentCategories = ParentCategory::pluck('name', 'id');
        $subCategories = SubCategory::where('parent_category_id', $product->parent_category_id)->pluck('name', 'id');
        $warehouses = Warehouse::pluck('name', 'id');

        // Attributes + their values
        $variationAttributes = ProductVariantAttribute::with('values')->get();
        // dd($variationAttributes);
        // variation_options stored as: { "attribute_id": [value_id, value_id], ... }
        $selectedVariations = $product->variation_options;
        // dd($selectedVariations);
        // $selectedVariations = collect($selectedVariations)->map(function ($values) {
        //     return array_map('intval', (array) $values);
        // })->toArray();
        // dd($selectedVariations);

        return view('warehouse.product-list.edit', compact(
            'product',
            'vendors',
            'vendorPurchaseOrders',
            'brands',
            'parentCategories',
            'subCategories',
            'warehouses',
            'variationAttributes',
            'selectedVariations'
        ));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);
            $data = $request->validated();

            // Handle variations
            $data['variation_options'] = $data['variations'] ?? null;
            unset($data['variations']);

            // Final price calculation (optional)
            $data['final_price'] = ($data['selling_price'] ?? 0)
                - ($data['discount_price'] ?? 0)
                + (($data['selling_price'] ?? 0) * ($data['tax'] ?? 0) / 100);

            // Main image
            if ($request->hasFile('main_product_image')) {
                if ($product->main_product_image && Storage::disk('public')->exists($product->main_product_image)) {
                    Storage::disk('public')->delete($product->main_product_image);
                }
                $data['main_product_image'] = $request->file('main_product_image')
                    ->store('products/images', 'public');
            }

            // Additional images
            if ($request->hasFile('additional_product_images')) {
                $additional = [];
                foreach ($request->file('additional_product_images') as $file) {
                    $additional[] = $file->store('products/images', 'public');
                }
                $data['additional_product_images'] = $additional;
            }

            // Datasheet manual
            if ($request->hasFile('datasheet_manual')) {
                if ($product->datasheet_manual && Storage::disk('public')->exists($product->datasheet_manual)) {
                    Storage::disk('public')->delete($product->datasheet_manual);
                }
                $data['datasheet_manual'] = $request->file('datasheet_manual')
                    ->store('products/datasheets', 'public');
            }

            $product->update($data);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete associated files
            if ($product->main_product_image && file_exists(public_path($product->main_product_image))) {
                unlink(public_path($product->main_product_image));
            }

            if (is_array($product->additional_product_images)) {
                foreach ($product->additional_product_images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image));
                    }
                }
            }

            if ($product->datasheet_manual && file_exists(public_path($product->datasheet_manual))) {
                unlink(public_path($product->datasheet_manual));
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function scrapItems()
    {
        $scrapItems = ScrapItem::with(['product', 'productSerial'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('/warehouse/product-list/scrap-items', compact('scrapItems'));
    }

    public function scrapProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial_ids' => 'required|string',
            'reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $serialIds = array_map('trim', explode(',', $request->serial_ids));
            $scrappedCount = 0;
            $errors = [];

            foreach ($serialIds as $serialId) {
                if (empty($serialId)) {
                    continue;
                }

                // Find the product serial
                $productSerial = ProductSerial::where('final_serial', $serialId)
                    ->where('status', 'active')
                    ->first();

                if (! $productSerial) {
                    $errors[] = "Serial ID '{$serialId}' not found or already inactive";

                    continue;
                }

                $product = $productSerial->product;
                if (! $product) {
                    $errors[] = "Product not found for serial ID '{$serialId}'";

                    continue;
                }

                // Create scrap item record
                ScrapItem::create([
                    'product_id' => $product->id,
                    'product_serial_id' => $productSerial->id,
                    'serial_number' => $serialId,
                    'product_name' => $product->product_name,
                    'product_sku' => $product->sku,
                    'reason' => $request->reason,
                    'quantity_scrapped' => 1,
                    'scrapped_at' => now(),
                    'scrapped_by' => auth()->user()->name ?? 'System',
                ]);

                // Update product serial status
                $productSerial->update(['status' => 'damaged']);

                // Decrease product quantity
                if ($product->stock_quantity > 0) {
                    $product->decrement('stock_quantity', 1);
                }

                $scrappedCount++;
            }

            DB::commit();

            if ($scrappedCount > 0) {
                $message = $scrappedCount . ' item(s) scrapped successfully';
                if (! empty($errors)) {
                    $message .= '. Some items had errors: ' . implode(', ', $errors);
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'scrapped_count' => $scrappedCount,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No items were scrapped. Errors: ' . implode(', ', $errors),
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while scrapping items: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function restoreProduct(Request $request, $scrapItemId)
    {
        try {
            DB::beginTransaction();

            $scrapItem = ScrapItem::with(['product', 'productSerial'])->findOrFail($scrapItemId);

            // Restore the product serial status
            if ($scrapItem->productSerial) {
                $scrapItem->productSerial->update(['status' => 'active']);
            }

            // Increase product quantity
            if ($scrapItem->product) {
                $scrapItem->product->increment('stock_quantity', $scrapItem->quantity_scrapped);
            }

            // Delete the scrap item record
            $scrapItem->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product restored successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while restoring the product: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function ec_index()
    {
        return view('/e-commerce/products/index');
    }

    public function ec_create()
    {
        $brand = Brand::pluck('brand_title', 'id');
        $parentCategorie = ParentCategorie::pluck('parent_categories', 'id');
        $subcategorie = SubCategorie::pluck('sub_categorie', 'id');

        return view('/e-commerce/products/create', compact('brand', 'parentCategorie', 'subcategorie'));
    }

    public function ec_view()
    {
        return view('/e-commerce/products/view');
    }

    public function ec_edit()
    {
        return view('/e-commerce/products/edit');
    }

    public function ec_scrapItems()
    {
        return view('/e-commerce/products/scrap-items');
    }

    /**
     * Save or update a product serial number
     */
    public function saveSerial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial_id' => 'required|exists:product_serials,id',
            'manual_serial' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $productSerial = ProductSerial::findOrFail($request->serial_id);

            // Check if manual serial is provided and if it's unique
            if ($request->manual_serial) {
                $existingSerial = ProductSerial::where('final_serial', $request->manual_serial)
                    ->where('id', '!=', $productSerial->id)
                    ->first();

                if ($existingSerial) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Serial number already exists. Please use a unique serial number.',
                    ], 422);
                }

                $productSerial->manual_serial = $request->manual_serial;
                $productSerial->final_serial = $request->manual_serial;
                $productSerial->is_manual = true;
            } else {
                // If no manual serial provided, use auto-generated
                $productSerial->manual_serial = null;
                $productSerial->final_serial = $productSerial->auto_generated_serial;
                $productSerial->is_manual = false;
            }

            $productSerial->save();

            return response()->json([
                'success' => true,
                'message' => 'Serial number saved successfully',
                'data' => [
                    'final_serial' => $productSerial->final_serial,
                    'is_manual' => $productSerial->is_manual,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the serial number',
            ], 500);
        }
    }

    /**
     * Check if SKU is unique for warehouse products via AJAX
     */
    public function checkSkuUnique(Request $request): JsonResponse
    {
        $sku = $request->input('sku');
        $productId = $request->input('product_id'); // For updates, exclude current product

        if (empty($sku)) {
            return response()->json([
                'valid' => false,
                'message' => 'SKU is required',
            ]);
        }

        $query = Product::where('sku', $sku);

        // If updating, exclude current product
        if ($productId) {
            $query->where('id', '!=', $productId);
        }

        $exists = $query->exists();

        return response()->json([
            'valid' => ! $exists,
            'message' => $exists ? 'Product with this SKU already exists' : 'SKU is available',
        ]);
    }

    /**
     * Get subcategories based on parent category via AJAX
     */
    public function getSubcategoriesByParent(Request $request): JsonResponse
    {
        // From AJAX: data: { parent_id: parentId }
        $parentId = $request->input('parent_id');

        if (empty($parentId)) {
            return response()->json([]);
        }

        $subcategories = SubCategory::where('parent_category_id', $parentId)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($subcategories);
    }

    public function getVendorPurchaseOrdersByVendor(Request $request): JsonResponse
    {
        $vendorId = $request->input('vendor_id');
        if (empty($vendorId)) {
            return response()->json([]);
        }

        $vendorPurchaseOrders = VendorPurchaseOrder::where('vendor_id', $vendorId)->pluck('po_number', 'id');

        return response()->json($vendorPurchaseOrders);
    }

    public function getSubCategories(Request $request): JsonResponse
    {
        $parentId = $request->input('parent_id');
        if (empty($parentId)) {
            return response()->json([]);
        }

        $subcategories = SubCategory::where('parent_category_id', $parentId)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($subcategories);
    }
}
