<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TrackProductController extends Controller
{
    public function index()
    {
        return view('/warehouse/track-product/index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search_term' => 'required|string|min:1|max:255',
        ]);

        $searchTerm = trim($request->search_term);

        try {
            // Search by SKU or Serial Number (case-insensitive, partial matches)
            $products = Product::with([
                'brand',
                'parentCategorie',
                'subCategorie',
                'warehouse',
                'warehouseRack',
                'productSerials' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
                ->where(function ($query) use ($searchTerm) {
                    // Search by SKU
                    $query->where('sku', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('product_name', 'LIKE', '%'.$searchTerm.'%');
                })
                ->orWhereHas('productSerials', function ($query) use ($searchTerm) {
                    // Search by Serial Numbers
                    $query->where('final_serial', 'LIKE', '%'.$searchTerm.'%')
                        ->where('status', 'active');
                })
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No product found with this SKU or Serial ID.',
                    'data' => [],
                ]);
            }

            // Format the response data
            $formattedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'sku' => $product->sku,
                    'serial_numbers' => $product->productSerials->pluck('final_serial')->toArray(),
                    'warehouse_name' => $product->warehouse->warehouse_name ?? 'N/A',
                    'rack_info' => [
                        'rack_no' => $product->rack_no ?? 'N/A',
                        'zone_area' => $product->rack_zone_area ?? 'N/A',
                        'level_no' => $product->level_no ?? 'N/A',
                        'position_no' => $product->position_no ?? 'N/A',
                    ],
                    'availability_status' => $product->stock_status ?? 'N/A',
                    'quantity' => $product->stock_quantity ?? 0,
                    'brand' => $product->brand->brand_title ?? 'N/A',
                    'category' => $product->parentCategorie->parent_categories ?? 'N/A',
                    'sub_category' => $product->subCategorie->sub_categorie ?? 'N/A',
                    'main_image' => $product->main_product_image ? asset($product->main_product_image) : null,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Products found successfully.',
                'data' => $formattedProducts,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching for products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
