<?php

namespace App\Http\Controllers;

use App\Models\AMC;
use App\Models\AmcPlan;
use App\Models\Engineer;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\QuotationAmcDetail;
use App\Models\QuotationEngineerAssignment;
use App\Models\QuotationGroupEngineer;
use App\Models\QuotationProduct;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    //
    /**
     * Generate unique service ID
     */
    private function generateServiceId()
    {
        $year = date('Y');
        $lastService = Quotation::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->id, -4)) + 1) : 1;

        return 'SRV-'.$year.'-'.str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $quotations = Quotation::with('leadDetails')->get();

        // dd($quotations);
        // return view('/crm/meets/index', compact('meet'));
        return view('/crm/quotation/index', compact('quotations'));
    }

    public function create()
    {
        $leads = Lead::all();
        $quoteId = $this->generateServiceId();
        $amcPlans = AmcPlan::where('status', 'Active')->get();

        return view('/crm/quotation/create', compact('leads', 'quoteId', 'amcPlans'));
    }

    public function store(Request $request)
    {

        // Convert JSON string to array for products
        if ($request->has('products')) {
            $request->merge([
                'products' => json_decode($request->input('products'), true),
            ]);
        }

        // Cast plan_duration to int if present
        if ($request->has('plan_duration')) {
            $request->merge([
                'plan_duration' => (int) $request->input('plan_duration'),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'quote_id' => 'required',
            'quote_date' => 'required|date',
            'expiry_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string',
            'products.*.hsn_code' => 'required|string',
            'products.*.sku' => 'required|string',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.tax' => 'required|numeric|min:0',
            'products.*.total' => 'required|numeric|min:0',
            'amc_plan_id' => 'nullable|string',
            'plan_duration' => 'nullable|integer|min:0',
            'plan_start_date' => 'nullable|date',
            'total_amount' => 'nullable|numeric|min:0',
            'priority_level' => 'nullable|string',
            'additional_notes' => 'nullable|string',
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

            $quotation = new Quotation;
            $quotation->lead_id = $request->lead_id;
            $quotation->quote_id = $request->quote_id;
            $quotation->quote_date = $request->quote_date;
            $quotation->expiry_date = $request->expiry_date;
            $quotation->save();

            foreach ($request->products as $productData) {
                $quotationProduct = new QuotationProduct;
                $quotationProduct->quotation_id = $quotation->id;
                $quotationProduct->product_name = $productData['product_name'];
                $quotationProduct->hsn_code = $productData['hsn_code'];
                $quotationProduct->sku = $productData['sku'];
                $quotationProduct->price = $productData['price'];
                $quotationProduct->quantity = $productData['quantity'];
                $quotationProduct->tax = $productData['tax'];
                $quotationProduct->total = $productData['total'];
                $quotationProduct->save();
            }

            if ($request->filled('amc_plan_id')) {
                $amcDetail = new QuotationAmcDetail;
                $amcDetail->quotation_id = $quotation->id;
                $amcDetail->amc_plan_id = $request->amc_plan_id;
                $amcDetail->plan_duration = $request->plan_duration;
                $startDate = Carbon::parse($request->plan_start_date);
                $amcDetail->plan_start_date = $startDate;
                $amcDetail->plan_end_date = $startDate->copy()->addMonths($request->plan_duration);
                $amcDetail->total_amount = $request->total_amount;
                $amcDetail->priority_level = $request->priority_level;
                $amcDetail->additional_notes = $request->additional_notes;
                $amcDetail->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'quotation_id' => $quotation->id,
                'message' => 'Quotation added successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function store(Request $request)
    // {
    //     // return response()->json($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'lead_id' => 'required',
    //         'quote_id' => 'required',
    //         'quote_date' => 'required',
    //         'expiry_date' => 'required',

    //         'products' => 'required|array|min:1',
    //         'products.*.product_name' => 'required|string',
    //         'products.*.hsn_code' => 'required|string',
    //         'products.*.sku' => 'required|string',
    //         'products.*.price' => 'required|numeric|min:0',
    //         'products.*.quantity' => 'required|integer|min:1',
    //         'products.*.tax' => 'required|numeric|min:0',
    //         'products.*.total' => 'required|numeric|min:0',

    //         'amc_plan_id' => 'nullable|string',
    //         'plan_duration' => 'nullable|min:0',
    //         'plan_start_date' => 'nullable|date',
    //         'total_amount' => 'nullable|numeric|min:0',
    //         'priority_level' => 'nullable|string',
    //         'additional_notes' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $quotation = new Quotation();
    //     $quotation->lead_id = $request->lead_id;
    //     $quotation->quote_id = $request->quote_id;
    //     $quotation->quote_date = $request->quote_date;
    //     $quotation->expiry_date = $request->expiry_date;
    //     $quotation->save();

    //     // Save Quotation Products
    //     foreach ($request->products as $productData) {
    //         $quotationProduct = new QuotationProduct();
    //         $quotationProduct->quotation_id = $quotation->id;
    //         $quotationProduct->product_name = $productData['product_name'];
    //         $quotationProduct->hsn_code = $productData['hsn_code'];
    //         $quotationProduct->sku = $productData['sku'];
    //         $quotationProduct->price = $productData['price'];
    //         $quotationProduct->quantity = $productData['quantity'];
    //         $quotationProduct->tax = $productData['tax'];
    //         $quotationProduct->total = $productData['total'];
    //         $quotationProduct->save();
    //     }

    //     // Save AMC Details if provided
    //     if ($request->filled('amc_plan_id')) {
    //         $amcDetail = new QuotationAmcDetail();
    //         $amcDetail->quotation_id = $quotation->id;
    //         $amcDetail->amc_plan_id = $request->amc_plan_id;
    //         $amcDetail->plan_duration = $request->plan_duration;
    //         $amcDetail->plan_start_date = $request->plan_start_date;
    //         $amcDetail->plan_end_date = $request->plan_start_date->addMonths($request->plan_duration);
    //         $amcDetail->total_amount = $request->total_amount;
    //         $amcDetail->priority_level = $request->priority_level;
    //         $amcDetail->additional_notes = $request->additional_notes;
    //         $amcDetail->save();
    //     }

    //     if (!$quotation) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Something went wrong.',
    //             'error' => $validator->errors()
    //         ], 500);
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'quotation_id' => $quotation->id,
    //         'message' => 'Quotation added successfully.'
    //     ]);
    // }

    public function view($id)
    {
        $quotation = Quotation::with([
            'leadDetails',
            'products',
            'amcDetail.amcPlan',
            // 'activeAssignment.engineer',
            // 'activeAssignment.supervisor',
            // 'activeAssignment.groupEngineers',
        ])->findOrFail($id);

        $engineers = Staff::where('staff_id', 3)->all();

        return view('/crm/quotation/view', compact('quotation', 'engineers'));
    }

    public function edit($id)
    {
        $quotation = Quotation::with([
            'leadDetails',
            'products',
            'amcDetail.amcPlan',
        ])->findOrFail($id);

        $leads = Lead::all();
        $amcPlans = AmcPlan::where('status', 'Active')->get();

        return view('/crm/quotation/edit', compact('quotation', 'leads', 'amcPlans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'quote_id' => 'required',
            'quote_date' => 'required',
            'expiry_date' => 'required',

            'products' => 'required|min:1',
            'products.*.product_name' => 'required|string',
            'products.*.hsn_code' => 'required|string',
            'products.*.sku' => 'required|string',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.tax' => 'required|numeric|min:0',
            'products.*.total' => 'required|numeric|min:0',

            'amc_plan_id' => 'nullable|string',
            'plan_duration' => 'nullable|min:0',
            'plan_start_date' => 'nullable|date',
            'total_amount' => 'nullable|numeric|min:0',
            'priority_level' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $quotation = Quotation::findOrFail($id);
        $quotation->lead_id = $request->lead_id;
        $quotation->quote_id = $request->quote_id;
        $quotation->quote_date = $request->quote_date;
        $quotation->expiry_date = $request->expiry_date;
        $quotation->save();

        // Delete existing products and re-create them
        $quotation->products()->delete();

        // Save Quotation Products
        foreach ($request->products as $productData) {
            $quotationProduct = new QuotationProduct;
            $quotationProduct->quotation_id = $quotation->id;
            $quotationProduct->product_name = $productData['product_name'];
            $quotationProduct->hsn_code = $productData['hsn_code'];
            $quotationProduct->sku = $productData['sku'];
            $quotationProduct->price = $productData['price'];
            $quotationProduct->quantity = $productData['quantity'];
            $quotationProduct->tax = $productData['tax'];
            $quotationProduct->total = $productData['total'];
            $quotationProduct->save();
        }

        // Update or create AMC Details
        if ($request->filled('amc_plan_id')) {
            $quotation->amcDetail()->updateOrCreate(
                ['quotation_id' => $quotation->id],
                [
                    'amc_plan_id' => $request->amc_plan_id,
                    'plan_duration' => $request->plan_duration,
                    'plan_start_date' => $request->plan_start_date,
                    'total_amount' => $request->total_amount,
                    'priority_level' => $request->priority_level,
                    'additional_notes' => $request->additional_notes,
                ]
            );
        } else {
            // Delete AMC details if not provided
            $quotation->amcDetail()->delete();
        }

        return response()->json([
            'success' => true,
            'quotation_id' => $quotation->id,
            'message' => 'Quotation updated successfully.',
        ]);
    }

    public function delete($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Delete related products and AMC details (cascade should handle this automatically via FK constraints)
        // But we'll do it explicitly to ensure data integrity
        $quotation->products()->delete();
        $quotation->amcDetail()->delete();

        // Delete the quotation
        $quotation->delete();

        return redirect()->route('quotation.index')->with('success', 'Quotation deleted successfully.');
    }

    /**
     * Assign engineer(s) to quotation
     */
    public function assignEngineer(Request $request)
    {
        // Remove engineer_id if assignment_type is Group to avoid validation error
        if ($request->assignment_type === 'Group') {
            $request->request->remove('engineer_id');
        }

        $validator = Validator::make($request->all(), [
            'quotation_id' => 'required|exists:quotations,id',
            'assignment_type' => 'required|in:Individual,Group',
            'engineer_id' => 'required_if:assignment_type,Individual|exists:engineers,id',
            'group_name' => 'required_if:assignment_type,Group',
            'engineer_ids' => 'required_if:assignment_type,Group|array',
            'engineer_ids.*' => 'exists:engineers,id',
            'supervisor_id' => 'required_if:assignment_type,Group|exists:engineers,id',
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

            // Deactivate any existing active assignments
            QuotationEngineerAssignment::where('quotation_id', $request->quotation_id)
                ->where('status', 'Active')
                ->update(['status' => 'Inactive']);

            if ($request->assignment_type === 'Individual') {
                // Individual assignment
                $assignment = QuotationEngineerAssignment::create([
                    'quotation_id' => $request->quotation_id,
                    'assignment_type' => 'Individual',
                    'engineer_id' => $request->engineer_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                $engineer = Engineer::find($request->engineer_id);
                $message = 'Engineer '.$engineer->first_name.' '.$engineer->last_name.' assigned successfully';
            } else {
                // Group assignment
                $assignment = QuotationEngineerAssignment::create([
                    'quotation_id' => $request->quotation_id,
                    'assignment_type' => 'Group',
                    'group_name' => $request->group_name,
                    'supervisor_id' => $request->supervisor_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                // Add group members
                foreach ($request->engineer_ids as $engineerId) {
                    QuotationGroupEngineer::create([
                        'assignment_id' => $assignment->id,
                        'engineer_id' => $engineerId,
                        'is_supervisor' => ($engineerId == $request->supervisor_id),
                    ]);
                }

                $message = 'Group "'.$request->group_name.'" assigned successfully with '.count($request->engineer_ids).' engineers';
            }

            DB::commit();

            // Load relationships for response
            $assignment->load(['engineer', 'supervisor', 'groupEngineers']);

            return response()->json([
                'success' => true,
                'message' => $message,
                'assignment' => $assignment,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error assigning engineer: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new product for a quotation
     */
    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quotation_id' => 'required|exists:quotations,id',
            'product_name' => 'required|string',
            'hsn_code' => 'required|string',
            'sku' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $product = QuotationProduct::create([
                'quotation_id' => $request->quotation_id,
                'product_name' => $request->product_name,
                'hsn_code' => $request->hsn_code,
                'sku' => $request->sku,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'tax' => $request->tax,
                'total' => $request->total,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding product: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing product
     */
    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'hsn_code' => 'required|string',
            'sku' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $product = QuotationProduct::findOrFail($id);
            $product->update([
                'product_name' => $request->product_name,
                'hsn_code' => $request->hsn_code,
                'sku' => $request->sku,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'tax' => $request->tax,
                'total' => $request->total,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a product
     */
    public function deleteProduct($id)
    {
        try {
            $product = QuotationProduct::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: '.$e->getMessage(),
            ], 500);
        }
    }
}
