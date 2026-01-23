<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductDealRequest;
use App\Http\Requests\UpdateProductDealRequest;
use App\Models\EcommerceProduct;
use App\Models\ProductDeal;
use App\Models\ProductDealItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDealController extends Controller
{
    public function index()
    {
        $status = request()->get('status') ?? 'all';
        $query = ProductDeal::query();
        if ($status != 'all') {
            $query->where('status', $status);
        }
        $deals = $query->with(['dealItems.ecommerceProduct.warehouseProduct'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('e-commerce.product-deals.index', compact('deals'));
    }

    public function create()
    {
        return view('e-commerce.product-deals.create');
    }

    public function store(StoreProductDealRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Create the main deal
            $deal = ProductDeal::create([
                'deal_title' => $validated['deal_title'],
                'offer_start_date' => $validated['offer_start_date'],
                'offer_end_date' => $validated['offer_end_date'],
                'status' => $validated['status'],
            ]);

            // Create deal items for each product
            foreach ($validated['products'] as $productData) {
                $ecommerceProduct = EcommerceProduct::with('warehouseProduct')
                    ->findOrFail($productData['ecommerce_product_id']);

                $originalPrice = $ecommerceProduct->warehouseProduct->final_price;

                // Calculate offer price
                if ($productData['discount_type'] === 'percentage') {
                    $offerPrice = $originalPrice - ($originalPrice * $productData['discount_value'] / 100);
                } else {
                    $offerPrice = $originalPrice - $productData['discount_value'];
                }

                ProductDealItem::create([
                    'product_deal_id' => $deal->id,
                    'ecommerce_product_id' => $productData['ecommerce_product_id'],
                    'original_price' => $originalPrice,
                    'discount_type' => $productData['discount_type'],
                    'discount_value' => $productData['discount_value'],
                    'offer_price' => $offerPrice,
                ]);
            }

            DB::commit();

            return redirect()->route('product-deals.index')->with('success', 'Product deal created successfully!');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Error creating product deal: ' . $e->getMessage())->withInput();
        }
    }

    public function show(ProductDeal $productDeal)
    {
        $productDeal->load(['dealItems.ecommerceProduct.warehouseProduct']);

        return view('e-commerce.product-deals.view', compact('productDeal'));
    }

    public function edit(ProductDeal $productDeal)
    {
        return view('e-commerce.product-deals.edit', compact('productDeal'));
    }

    public function update(UpdateProductDealRequest $request, ProductDeal $productDeal)
    {
        // Validate the incoming request data
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Update the main deal
            $productDeal->update([
                'deal_title' => $validated['deal_title'],
                'offer_start_date' => $validated['offer_start_date'],
                'offer_end_date' => $validated['offer_end_date'],
                'status' => $validated['status'],
            ]);

            // Update or create deal items for each product
            foreach ($validated['products'] as $productData) {
                // Find existing deal item or create a new one if not found
                $dealItem = ProductDealItem::where('product_deal_id', $productDeal->id)
                    ->where('ecommerce_product_id', $productData['ecommerce_product_id'])
                    ->first();

                // If the deal item exists, update it
                if ($dealItem) {
                    $ecommerceProduct = EcommerceProduct::with('warehouseProduct')
                        ->findOrFail($productData['ecommerce_product_id']);

                    $originalPrice = $ecommerceProduct->warehouseProduct->final_price;

                    // Calculate offer price based on discount type
                    if ($productData['discount_type'] === 'percentage') {
                        $offerPrice = $originalPrice - ($originalPrice * $productData['discount_value'] / 100);
                    } else {
                        $offerPrice = $originalPrice - $productData['discount_value'];
                    }

                    // Update existing deal item
                    $dealItem->update([
                        'original_price' => $originalPrice,
                        'discount_type' => $productData['discount_type'],
                        'discount_value' => $productData['discount_value'],
                        'offer_price' => $offerPrice,
                    ]);
                } else {
                    // If the deal item doesn't exist, create a new one
                    $ecommerceProduct = EcommerceProduct::with('warehouseProduct')
                        ->findOrFail($productData['ecommerce_product_id']);

                    $originalPrice = $ecommerceProduct->warehouseProduct->final_price;

                    // Calculate offer price
                    if ($productData['discount_type'] === 'percentage') {
                        $offerPrice = $originalPrice - ($originalPrice * $productData['discount_value'] / 100);
                    } else {
                        $offerPrice = $originalPrice - $productData['discount_value'];
                    }

                    // Create new product deal item
                    ProductDealItem::create([
                        'product_deal_id' => $productDeal->id,
                        'ecommerce_product_id' => $productData['ecommerce_product_id'],
                        'original_price' => $originalPrice,
                        'discount_type' => $productData['discount_type'],
                        'discount_value' => $productData['discount_value'],
                        'offer_price' => $offerPrice,
                    ]);
                }
            }

            // Commit the transaction if everything is fine
            DB::commit();

            return redirect()->route('product-deals.index')->with('success', 'Product deal updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of any error
            DB::rollback();

            return back()->with('error', 'Error updating product deal: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(ProductDeal $productDeal)
    {
        try {
            // Deal items will be automatically deleted due to cascade delete in foreign key
            $productDeal->delete();

            return redirect()->route('product-deals.index')->with('success', 'Product deal deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting product deal: ' . $e->getMessage());
        }
    }

    public function searchEcommerceProducts(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $products = EcommerceProduct::with(['warehouseProduct.brand'])
            ->where(function ($query) use ($search) {
                // Search in e-commerce product SKU
                $query->where('sku', 'LIKE', "%{$search}%")
                    // Or search in warehouse product name and SKU
                    ->orWhereHas('warehouseProduct', function ($subQuery) use ($search) {
                        $subQuery->where('product_name', 'LIKE', "%{$search}%")
                            ->orWhere('sku', 'LIKE', "%{$search}%");
                    });
            })
            ->whereHas('warehouseProduct', function ($query) {
                $query->where('status', 'active');
            })
            ->where('status', 'active')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->warehouseProduct->product_name,
                    'sku' => $product->sku, // E-commerce SKU
                    'warehouse_sku' => $product->warehouseProduct->sku, // Warehouse SKU
                    'brand' => $product->warehouseProduct->brand->brand_title ?? 'N/A',
                    'final_price' => $product->warehouseProduct->final_price,
                    'image' => $product->warehouseProduct->main_product_image,
                    'display_text' => $product->warehouseProduct->product_name . ' (SKU: ' . $product->sku . ')',
                ];
            });

        return response()->json($products);
    }

    public function getEcommerceProduct($id): JsonResponse
    {
        $product = EcommerceProduct::with(['warehouseProduct.brand'])
            ->where('id', $id)
            ->where('status', 'active')
            ->whereHas('warehouseProduct', function ($query) {
                $query->where('status', 'active');
            })
            ->first();

        if (! $product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->warehouseProduct->product_name,
            'brand' => $product->warehouseProduct->brand->brand_title ?? 'N/A',
            'final_price' => $product->warehouseProduct->final_price,
            'image' => $product->warehouseProduct->main_product_image,
        ]);
    }

    public function removeProductFromDeal(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:product_deal_items,ecommerce_product_id',
        ]);

        $productId = $request->input('product_id');

        ProductDealItem::where('ecommerce_product_id', $productId)->delete();

        return response()->json(['message' => 'Product removed from deal successfully']);
    }
}
