<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\StockInHand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequestProductRequestPart;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * 1. Products List of all the product available in warehouse with status active (Basic Details)
     */
    public function listProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $products = Product::where('status', 'active')
            ->with('brand')
            ->with('parentCategorie')
            ->select([
                'id',
                'brand_id',
                'parent_category_id',
                'sub_category_id',
                'product_name',
                'model_no',
                'sku',
                'short_description',
                'main_product_image',
                'cost_price',
                'selling_price',
                'discount_price',
                'stock_quantity',
                'stock_status',
            ])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully.',
            'products' => $products
        ], 200);
    }

    /**
     * 2. Products Detail Page (In Details)
     */
    public function productDetail(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::where('id', $product_id)
            ->where('status', 'active')
            ->with('brand')
            ->with('parentCategorie')
            ->with('subCategorie')
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product details retrieved successfully.',
            'product' => $product
        ], 200);
    }

    /**
     * 3. Request New Product For Stock In Hand (Product Id, quantity, user_id, role_id)
     */
    public function requestStockInHand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:staff,id',
            'part_id' => 'required|exists:products,id',
            'requested_quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create stock in hand request in service_request_product_request_parts table
        $stockInHandRequest = ServiceRequestProductRequestPart::create([
            'engineer_id' => $request->user_id,
            'part_id' => $request->part_id,
            'requested_quantity' => $request->requested_quantity,
            'request_type' => 'stock_in_hand',
            'assigned_person_type' => 'engineer',
            'assigned_person_id' => $request->user_id,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stock in hand request created successfully.',
            'data' => [
                'id' => $stockInHandRequest->id,
                'engineer_id' => $stockInHandRequest->engineer_id,
                'part_id' => $stockInHandRequest->part_id,
                'requested_quantity' => $stockInHandRequest->requested_quantity,
                'request_type' => $stockInHandRequest->request_type,
                'assigned_person_type' => $stockInHandRequest->assigned_person_type,
                'assigned_person_id' => $stockInHandRequest->assigned_person_id,
                'status' => $stockInHandRequest->status,
                'created_at' => $stockInHandRequest->created_at,
            ]
        ], 201);
    }

    /**
     * 4. List Of stock in hand product (Product Id, quantity, status)
     */
    public function listStockInHand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required|in:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Build query based on role
        $query = ServiceRequestProductRequestPart::query();

        if ($request->role_id == 1) {
            $query->where('engineer_id', $request->user_id);
        } elseif ($request->role_id == 4) {
            $query->where('customer_id', $request->user_id);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This API is only available for engineer and customer roles.'
            ], 400);
        }

        $stockInHandItems = $query->with(['serviceRequest', 'serviceRequestProduct', 'product'])
            ->where('request_type', 'stock_in_hand')
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedItems = $stockInHandItems->map(function ($item) {
            return [
                'stock_in_hand_id' => $item->id,
                'status' => $item->status,
                'products' => $item->product,
                // ->map(function ($product) {
                //     return [
                //         'product_id' => $product->product_id,
                //         'product_name' => $product->product->product_name ?? null,
                //         'quantity' => $product->requested_quantity,
                //         'delivered_quantity' => $product->delivered_quantity,
                //         'unit_price' => $product->unit_price,
                //         'status' => $product->status,
                //     ];
                // }),
                'total_requested_quantity' => $item->requested_quantity,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock in hand list retrieved successfully.',
            'stock_in_hand_items' => $formattedItems
        ], 200);
    }
}
