<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuotationResource;
use App\Models\AmcPlan;
use App\Models\Quotation;
use App\Models\QuotationAmcDetail;
use App\Models\QuotationProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $quotations = Quotation::with('leadDetails', 'products', 'amcDetail')->where('staff_id', $validated['user_id'])->get();

        if ($quotations->isEmpty()) {
            return response()->json(['message' => 'No quotations found'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Quotations found successfully.', 'data' => $quotations]);
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
            'products.*.name' => 'required|string',
            'products.*.type' => 'nullable|string',
            'products.*.model_no' => 'nullable|string',
            'products.*.hsn' => 'nullable|string',
            'products.*.sku' => 'nullable|string',
            'products.*.purchase_date' => 'nullable|string',
            'products.*.brand' => 'nullable|string',
            'products.*.description' => 'nullable|string',
            'products.*.images' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'products.*.quantity' => 'nullable|integer',
            'amc_plan_id' => 'nullable|string',
            'plan_start_date' => 'nullable|date',
            'priority_level' => 'nullable|string',
            'additional_notes' => 'nullable|string',
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
        $validated['total_amount'] = $amcPlan->total_cost ?? 0;

        $Quotation = Quotation::create($validated);

        if ($request->has('products')) {
            $subtotal = 0;

            foreach ($request->products as $productData) {
                // image store 
                if ($productData['images']) {
                    $file = $productData['images'];
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(
                        public_path('uploads/crm/quick-service/products'),
                        $filename
                    );
                    $path = 'uploads/crm/quick-service/products/' . $filename;
                }

                $quotationProduct = new QuotationProduct;
                $quotationProduct->quotation_id = $Quotation->id;
                $quotationProduct->name = $productData['name'];
                $quotationProduct->type = $productData['type'];
                $quotationProduct->model_no = $productData['model_no'];
                $quotationProduct->hsn = $productData['hsn'];
                $quotationProduct->sku = $productData['sku'];
                $quotationProduct->purchase_date = $productData['purchase_date'];
                $quotationProduct->brand = $productData['brand'];
                $quotationProduct->description = $productData['description'];
                $quotationProduct->images = $path;
                $quotationProduct->quantity = $productData['quantity'];
                $quotationProduct->save();

                $subtotal += 0;
            }
        }
        $Quotation->subtotal = $subtotal;

        if (! $Quotation) {
            return response()->json(['message' => 'Quotation not created'], 500);
        }


        if ($request->has('amc_plan_id')) {
            $amcPlan = AmcPlan::find($request->amc_plan_id);

            $quotationAmcDetail = new QuotationAmcDetail;
            $quotationAmcDetail->quotation_id = $Quotation->id;
            $quotationAmcDetail->amc_plan_id = $request->amc_plan_id;
            $quotationAmcDetail->plan_duration = intval($amcPlan->duration);
            $quotationAmcDetail->total_amount = $amcPlan->total_cost;

            $startDate = Carbon::parse($request->plan_start_date);
            $quotationAmcDetail->plan_start_date = $startDate;
            // plan end date = plan start date + duration (in months)
            $planEndDate = $startDate->copy()->addMonths($amcPlan->duration);
            $quotationAmcDetail->plan_end_date = $planEndDate;
            $quotationAmcDetail->priority_level = $request->priority_level;
            $quotationAmcDetail->additional_notes = $request->additional_notes;
            $quotationAmcDetail->save();
        }


        $Quotation->load('products');

        return response()->json(['success' => true, 'message' => 'Quotations found successfully.', 'data' => $Quotation]);

        return new QuotationResource($Quotation);
    }

    // I want quotation details with there products details
    public function show(Request $request, $quote_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $Quotation = Quotation::with('leadDetails', 'products', 'amcDetail')->where('staff_id', $validated['user_id'])->find($quote_id);

        if (! $Quotation) {
            return response()->json(['message' => 'Quotation not found'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Quotations found successfully.', 'data' => $Quotation]);

        // return new QuotationResource($Quotation);
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
