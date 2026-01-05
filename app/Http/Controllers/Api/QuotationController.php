<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuotationResource;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    //
    //   I want quotation list with there products details
    public function index(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $quotations = Quotation::with('leadDetails','products')->where('staff_id', $validated['user_id'])->get();

        if ($quotations->isEmpty()) {
            return response()->json(['message' => 'No quotations found'], 404);
        }

        return QuotationResource::collection($quotations);
    }

    // I want to create quotation with there products details
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
            'lead_id' => 'required',
            'quote_date' => 'required',
            'expiry_date' => 'required',
            'products' => 'array',
            'products.*.product_name' => 'required|string',
            'products.*.hsn_code' => 'nullable|string',
            'products.*.sku' => 'nullable|string',
            'products.*.price' => 'required',
            'products.*.quantity' => 'required|integer',
            'products.*.tax' => 'required',
            'products.*.total' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $validated['staff_id'] = $validated['user_id'];
        unset($validated['user_id']);

        $validated['quote_id'] = 'Q-' . strtoupper(uniqid());
        $validated['quote_number'] = 'Q-' . strtoupper(uniqid());
        $validated['subtotal'] = 0;
        $validated['tax_amount'] = 0;
        $validated['discount_amount'] = 0;
        $validated['total_amount'] = 0;
        
        $Quotation = Quotation::create($validated);

        if ($request->has('products')) {
            $subtotal = 0;
            
            foreach ($request->products as $productData) {
                $quotationProduct = new QuotationProduct;
                $quotationProduct->quotation_id = $Quotation->id;
                $quotationProduct->product_name = $productData['product_name'];
                $quotationProduct->hsn_code = $productData['hsn_code'];
                $quotationProduct->sku = $productData['sku'];
                $quotationProduct->unit_price = $productData['price'];
                $quotationProduct->quantity = $productData['quantity'];
                $quotationProduct->tax_rate = $productData['tax'];
                $quotationProduct->line_total = $productData['total'];
                $quotationProduct->save();
                $subtotal += $productData['total'];
            }
        }
        $Quotation->subtotal = $subtotal;

        if (! $Quotation) {
            return response()->json(['message' => 'Quotation not created'], 500);
        }

        $Quotation->load('products');

        return new QuotationResource($Quotation);
    }

    // I want quotation details with there products details
    public function show(Request $request, $lead_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $Quotation = Quotation::with('leadDetails', 'products')->where('staff_id', $validated['user_id'])->first();

        if (! $Quotation) {
            return response()->json(['message' => 'Quotation not found'], 404);
        }

        return new QuotationResource($Quotation);
    }

    // I want to update quotation with there products details
    public function update(Request $request, $Quotation_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $Quotation = Quotation::where('staff_id', $validated['user_id'])->where('id', $Quotation_id)->first();

        if (! $Quotation) {
            return response()->json(['message' => 'Quotation not found'], 404);
        }

        $Quotation->update($request->all());

        if ($request->has('products')) {
            foreach ($request->products as $productData) {
                if (isset($productData['id'])) {
                    $quotationProduct = QuotationProduct::find($productData['id']);
                    if ($quotationProduct) {
                        $quotationProduct->update($productData);
                    }
                } else {
                    $quotationProduct = new QuotationProduct;
                    $quotationProduct->quotation_id = $Quotation->id;
                    $quotationProduct->product_name = $productData['product_name'];
                    $quotationProduct->hsn_code = $productData['hsn_code'];
                    $quotationProduct->sku = $productData['sku'];
                    $quotationProduct->price = $productData['price'];
                    $quotationProduct->quantity = $productData['quantity'];
                    $quotationProduct->tax = $productData['tax'];
                    $quotationProduct->total = $productData['total'];
                    $quotationProduct->save();
                }
            }
        }

        $Quotation->load('products');

        return new QuotationResource($Quotation);
    }

    public function destroy(Request $request, $lead_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $Quotation = Quotation::where('staff_id', $validated['user_id'])->where('id', $lead_id)->delete();

        if (! $Quotation) {
            return response()->json(['message' => 'Quotation not found'], 404);
        }

        return response()->json(['message' => 'Quotation deleted successfully'], 200);
    }
}
