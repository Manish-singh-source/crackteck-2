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
            $products = Product::with([
                'brand',
                'parentCategorie',
                'subCategorie',
                'productSerials',
            ])
            // ->where('sku', 'LIKE', '%' . $searchTerm . '%')
            // ->orWhere('product_name', 'LIKE', '%' . $searchTerm . '%')
            ->whereHas('productSerials', function ($query) use ($searchTerm) {
                $query->where('auto_generated_serial', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('manual_serial', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();
            if ($products) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product found successfully.',
                    'data' => $products,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No product found with this SKU or Serial ID.',
                    'data' => [],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching for products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
