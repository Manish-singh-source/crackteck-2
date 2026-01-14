<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEcommerceProductRequest;
use App\Http\Requests\UpdateEcommerceProductRequest;
use App\Models\Brand;
use App\Models\EcommerceProduct;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EcommerceProductController extends Controller
{
    /**
     * Display a listing of e-commerce products.
     */
    public function index()
    {
        $products = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])->paginate(15);

        return view('e-commerce.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new e-commerce product.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $parentCategories = ParentCategory::pluck('name', 'id');
        $subCategories = SubCategory::pluck('name', 'id');

        return view('e-commerce.products.create', compact('brands', 'parentCategories', 'subCategories'));
    }

    public function store(StoreEcommerceProductRequest $request)
    {
        $data = $request->all();
        // dd($data);
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Map warehouse_product_id -> product_id
            $data['product_id'] = $request->input('warehouse_product_id');

            // Map e-commerce description fields to DB columns
            $data['short_description'] = $request->input('ecommerce_short_description');
            $data['full_description'] = $request->input('ecommerce_full_description');
            $data['technical_specification'] = $request->input('ecommerce_technical_specification');

            // 1) with_installation (JSON array)
            // Frontend se: installation_options[] (text list) + hidden field nahi
            if ($request->has('installation_options')) {
                // remove empty values
                $data['with_installation'] = array_values(array_filter(
                    (array) $request->input('installation_options', [])
                ));
            }

            // 2) product_tags (JSON array)
            // Frontend se: hidden input name="product_tags" me JSON aa raha hai
            if ($request->filled('product_tags')) {
                $rawTags = $request->input('product_tags');

                // Agar JS se JSON string aata hai
                if (is_string($rawTags)) {
                    $decoded = json_decode($rawTags, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $tags = $decoded;
                    } else {
                        // fallback: comma separated string
                        $tags = array_map('trim', explode(',', $rawTags));
                    }
                } elseif (is_array($rawTags)) {
                    $tags = $rawTags;
                } else {
                    $tags = [];
                }

                $data['product_tags'] = array_values(array_filter($tags));
            }

            // 3) Image uploads (agar e-commerce table me images column nahi, to skip)
            if ($request->hasFile('product_images')) {
                $imagePaths = [];
                foreach ($request->file('product_images') as $image) {
                    $path = $image->store('ecommerce/products', 'public');
                    $imagePaths[] = $path;
                }
                // agar ecommerce_products me product_images column add kiya hai:
                $data['product_images'] = $imagePaths;
            }

            // 4) SEO slug
            if (empty($data['meta_product_url_slug']) && ! empty($data['meta_title'])) {
                $data['meta_product_url_slug'] = Str::slug($data['meta_title']);

                // unique rakho
                $original = $data['meta_product_url_slug'];
                $counter = 1;
                while (
                    EcommerceProduct::where('meta_product_url_slug', $data['meta_product_url_slug'])->exists()
                ) {
                    $data['meta_product_url_slug'] = $original.'-'.$counter++;
                }
            }

            // 5) Status mapping (agar form se '1' ya 'Active' aata ho)
            // migration: enum('0','1','2') -> ensure request se 0/1/2 hi aata hai
            // yaha koi mapping zarurat ho to karo, e.g. 'Active' => 1
            if (isset($data['status']) && ! in_array($data['status'], [0, 1, 2, '0', '1', '2'], true)) {
                $data['status'] = 1; // default Active
            }

            // 6) Boolean flags: checkbox se 'on' / null aata hai
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_best_seller'] = $request->boolean('is_best_seller');
            $data['is_suggested'] = $request->boolean('is_suggested');
            $data['is_todays_deal'] = $request->boolean('is_todays_deal');

            // 7) Create record
            $ecommerceProduct = EcommerceProduct::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'E-commerce product created successfully!',
                'redirect' => route('ec.product.index'),
            ]);

            return redirect()
                ->route('ec.product.index')
                ->with('success', 'E-commerce product created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating e-commerce product', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            // Return JSON for AJAX requests so frontend can display details
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the product: '.$e->getMessage(),
                    'errors' => method_exists($e, 'errors') ? $e->errors() : null,
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'An error occurred while creating the product: '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Display the specified e-commerce product.
     */
    public function show($id)
    {
        $product = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
            'warehouseProduct.warehouse',
            'warehouseProduct.warehouseRack',
            'warehouseProduct.productSerials' => function ($query) {
                $query->where('status', 'active');
            },
        ])->findOrFail($id);

        // dd($product);

        return view('e-commerce.products.view', compact('product'));
    }

    /**
     * Show the form for editing the specified e-commerce product.
     */
    public function edit($id)
    {
        $product = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
            'warehouseProduct.warehouse',
            'warehouseProduct.warehouseRack',
            'warehouseProduct.productSerials' => function ($query) {
                $query->where('status', 'active');
            },
        ])->findOrFail($id);
        // dd($product->is_featured);

        $brands = Brand::pluck('name', 'id');
        $parentCategories = ParentCategory::pluck('name', 'id');
        $subCategories = SubCategory::pluck('name', 'id');

        return view('e-commerce.products.edit', compact('product', 'brands', 'parentCategories', 'subCategories'));
    }

    /**
     * Update the specified e-commerce product.
     */
    public function update(UpdateEcommerceProductRequest $request, $id)
    {
        // Use FormRequest to validate and normalize data
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $product = EcommerceProduct::findOrFail($id);

            // Base data from validation
            $data = $validated;

            // 1) Status field (form may send status OR ecommerce_status text)
            if ($request->has('status')) {
                $data['status'] = $request->input('status'); // 0/1/2
            } elseif ($request->has('ecommerce_status')) {
                $statusMap = [
                    'inactive' => 0,
                    'active' => 1,
                    'draft' => 2,
                ];
                $val = strtolower($request->input('ecommerce_status'));
                $data['status'] = $statusMap[$val] ?? $product->status;
            }

            // 2) Bool flags (checkbox) normalize
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_best_seller'] = $request->boolean('is_best_seller');
            $data['is_suggested'] = $request->boolean('is_suggested');
            $data['is_todays_deal'] = $request->boolean('is_todays_deal');

            // 3) Normalize shipping_class to 0..3
            if ($request->filled('shipping_class')) {
                $val = $request->input('shipping_class');
                $map = [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    0 => '0',
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    'light' => '0',
                    'Light' => '0',
                    'medium' => '1',
                    'Medium' => '1',
                    'heavy' => '2',
                    'Heavy' => '2',
                    'fragile' => '3',
                    'Fragile' => '3',
                ];
                $key = is_string($val) ? $val : $val;
                $data['shipping_class'] = $map[$key] ?? '0';
            } else {
                $data['shipping_class'] = $product->shipping_class ?? '0';
            }

            // 4) With installation
            if ($request->has('installation_options')) {
                $data['with_installation'] = array_values(
                    array_filter((array) $request->input('installation_options', []))
                );
            } else {
                $data['with_installation'] = [];
            }

            // 5) Product tags
            if ($request->filled('product_tags')) {
                $raw = $request->input('product_tags');

                if (is_string($raw)) {
                    $decoded = json_decode($raw, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $tags = $decoded;
                    } else {
                        $tags = array_map('trim', explode(',', $raw));
                    }
                } elseif (is_array($raw)) {
                    $tags = $raw;
                } else {
                    $tags = [];
                }

                $data['product_tags'] = array_values(array_filter($tags));
            } else {
                $data['product_tags'] = [];
            }

            // 6) New images upload
            if ($request->hasFile('product_images')) {
                $imagePaths = [];
                foreach ($request->file('product_images') as $image) {
                    $path = $image->store('ecommerce/products', 'public');
                    $imagePaths[] = $path;
                }

                $existingImages = $product->product_images ?? [];
                $data['product_images'] = array_merge($existingImages, $imagePaths);
            }

            // 7) Remove selected images by index
            if ($request->has('remove_images')) {
                $existingImages = $product->product_images ?? [];
                $removeIndices = (array) $request->input('remove_images', []);

                foreach ($removeIndices as $index) {
                    if (isset($existingImages[$index])) {
                        Storage::disk('public')->delete($existingImages[$index]);
                        unset($existingImages[$index]);
                    }
                }

                $data['product_images'] = array_values($existingImages);
            }

            // 8) Auto-generate URL slug if empty
            if (empty($data['meta_product_url_slug']) && ! empty($data['meta_title'])) {
                $slug = Str::slug($data['meta_title']);

                // Ensure unique slug on update
                $original = $slug;
                $counter = 1;
                while (
                    EcommerceProduct::where('meta_product_url_slug', $slug)
                        ->where('id', '!=', $product->id)
                        ->exists()
                ) {
                    $slug = $original.'-'.$counter++;
                }

                $data['meta_product_url_slug'] = $slug;
            }

            // 9) Update record
            $product->update($data);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'E-commerce product updated successfully!',
                    'redirect' => route('ec.product.view', $product->id),
                ]);
            }

            return redirect()
                ->route('ec.product.index', $product->id)
                ->with('success', 'E-commerce product updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating e-commerce product: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the product: '.$e->getMessage(),
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'An error occurred while updating the product: '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Remove the specified e-commerce product.
     */
    public function destroy($id)
    {
        try {
            $product = EcommerceProduct::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'E-commerce product deleted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting e-commerce product: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the product: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search warehouse products for auto-fill functionality.
     */
    public function searchWarehouseProducts(Request $request)
    {
        $query = $request->get('query');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::with(['brand', 'parentCategorie', 'subCategorie'])
            ->where(function ($q) use ($query) {
                $q->where('product_name', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->where('status', '1')
            ->limit(10)
            ->get();

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'sku' => $product->sku,
                'model_no' => $product->model_no,
                'brand_name' => $product ?? '',
                'category_name' => $product->parentCategorie->name ?? '',
                'subcategory_name' => $product->subCategorie->name ?? '',
                'short_description' => $product->short_description,
                'full_description' => $product->full_description,
                'technical_specification' => $product->technical_specification,
                'brand_warranty' => $product->brand_warranty,
                'cost_price' => $product->cost_price,
                'selling_price' => $product->selling_price,
                'discount_price' => $product->discount_price,
                'tax' => $product->tax,
                'final_price' => $product->final_price,
                'stock_quantity' => $product->stock_quantity,
                'stock_status' => $product->stock_status,
                'main_product_image' => $product->main_product_image,
                'additional_product_images' => $product->additional_product_images,
                // 'brand_id' => $product->brand_id,
                // 'model_no' => $product->model_no,
                'hsn_code' => $product->hsn_code,
                'status' => $product->status,
                'display_text' => $product->product_name.' - '.$product->sku.($product->brand ? ' ('.$product->brand->brand_title.')' : ''),
            ];
        });

        return response()->json($results);
    }

    /**
     * Get warehouse product details by ID for auto-fill.
     */
    public function getWarehouseProduct($id)
    {
        try {
            $product = Product::with(['brand', 'parentCategorie', 'subCategorie'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'sku' => $product->sku,
                    // 'serial_no' => $product->serial_no,
                    'hsn_code' => $product->hsn_code,
                    'brand_name' => $product->brand->name ?? '',
                    'category_name' => $product->parentCategorie->name ?? '',
                    'subcategory_name' => $product->subCategorie->name ?? '',
                    'short_description' => $product->short_description,
                    'full_description' => $product->full_description,
                    'technical_specification' => $product->technical_specification,
                    'brand_warranty' => $product->brand_warranty,
                    'company_warranty' => $product->company_warranty,
                    'cost_price' => $product->cost_price,
                    'selling_price' => $product->selling_price,
                    'discount_price' => $product->discount_price,
                    'tax' => $product->tax,
                    'final_price' => $product->final_price,
                    'stock_quantity' => $product->stock_quantity,
                    'stock_status' => $product->stock_status,
                    'main_product_image' => $product->main_product_image,
                    'additional_product_images' => $product->additional_product_images,
                    'datasheet_manual' => $product->datasheet_manual,
                    'brand_id' => $product->brand_id,
                    'parent_category_id' => $product->parent_category_id,
                    'sub_category_id' => $product->sub_category_id,
                    'model_no' => $product->model_no,
                    'hsn_code' => $product->hsn_code,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
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
                $autoSerial = ProductSerial::generateAutoSerial($product->id);

                ProductSerial::create([
                    'product_id' => $product->id,
                    'auto_generated_serial' => $autoSerial,
                    'final_serial' => $autoSerial,
                    'is_manual' => false,
                    'status' => 'active',
                ]);
            }
        }
    }

    /**
     * Check if SKU is unique for e-commerce products via AJAX
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

        $query = EcommerceProduct::where('sku', $sku);

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
}
