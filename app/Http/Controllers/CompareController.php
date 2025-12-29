<?php

namespace App\Http\Controllers;

use App\Models\EcommerceProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    /**
     * Display the compare page
     */
    public function index()
    {
        $compareProductIds = array_keys(session('compare_products', []));

        // Check minimum products requirement
        if (count($compareProductIds) < 2) {
            return redirect()->route('website')->with('error', 'Please add at least 2 products to compare.');
        }

        // Get products with relationships
        $products = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])
            ->whereIn('id', $compareProductIds)
            ->get();

        return view('frontend.compare', compact('products'));
    }

    /**
     * Toggle product in compare list (add if not exists, remove if exists)
     */
    public function addToCompare(Request $request): JsonResponse
    {
        $request->validate([
            'ecommerce_product_id' => 'required|integer|exists:ecommerce_products,id',
        ]);

        $productId = $request->ecommerce_product_id;
        $compareProducts = session('compare_products', []);

        // Check if product already exists - if yes, remove it (toggle behavior)
        if (array_key_exists($productId, $compareProducts)) {
            unset($compareProducts[$productId]);
            session(['compare_products' => $compareProducts]);

            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Product removed from compare list.',
                'compare_count' => count($compareProducts),
            ]);
        }

        // Check maximum limit (3 products)
        if (count($compareProducts) >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'You can compare only up to 3 products. Please remove one first.',
            ], 400);
        }

        // Add product to compare list
        $compareProducts[$productId] = now()->timestamp;
        session(['compare_products' => $compareProducts]);

        return response()->json([
            'success' => true,
            'action' => 'added',
            'message' => 'Product added to Compare Section',
            'compare_count' => count($compareProducts),
        ]);
    }

    /**
     * Remove product from compare list
     */
    public function removeFromCompare($productId): JsonResponse
    {
        $compareProducts = session('compare_products', []);

        if (array_key_exists($productId, $compareProducts)) {
            unset($compareProducts[$productId]);
            session(['compare_products' => $compareProducts]);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from compare list.',
                'compare_count' => count($compareProducts),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in compare list.',
        ], 404);
    }

    /**
     * Clear all products from compare list
     */
    public function clearCompare(): JsonResponse
    {
        session()->forget('compare_products');

        return response()->json([
            'success' => true,
            'message' => 'Compare list cleared.',
            'compare_count' => 0,
        ]);
    }

    /**
     * Get compare data for sidebar
     */
    public function getCompareData(): JsonResponse
    {
        $compareProductIds = array_keys(session('compare_products', []));

        if (empty($compareProductIds)) {
            return response()->json([
                'success' => true,
                'products' => [],
                'compare_count' => 0,
            ]);
        }

        $products = EcommerceProduct::with('warehouseProduct')
            ->whereIn('id', $compareProductIds)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->warehouseProduct->product_name ?? 'Product Name',
                    'image' => $product->warehouseProduct->product_image ?? null,
                    'price' => $product->warehouseProduct->selling_price ?? 0,
                ];
            });

        return response()->json([
            'success' => true,
            'products' => $products,
            'compare_count' => count($products),
        ]);
    }

    /**
     * Get compare count
     */
    public function getCompareCount(): JsonResponse
    {
        $compareCount = count(session('compare_products', []));

        return response()->json([
            'compare_count' => $compareCount,
        ]);
    }

    /**
     * Check if product is in compare list
     */
    public function checkCompareStatus(Request $request): JsonResponse
    {
        $request->validate([
            'ecommerce_product_id' => 'required|integer',
        ]);

        $productId = $request->ecommerce_product_id;
        $compareProducts = session('compare_products', []);

        return response()->json([
            'in_compare' => array_key_exists($productId, $compareProducts),
        ]);
    }
}
