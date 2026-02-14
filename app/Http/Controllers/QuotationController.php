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
use App\Models\QuotationInvoice;
use App\Models\QuotationInvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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

        return 'SRV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
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
            'products.*.name' => 'required|string',
            'products.*.type' => 'nullable|string',
            'products.*.brand' => 'nullable|string',
            'products.*.model_no' => 'nullable|string',
            'products.*.sku' => 'nullable|string',
            'products.*.hsn' => 'nullable|string',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.discount_per_unit' => 'nullable|numeric|min:0',
            'products.*.tax_rate' => 'nullable|numeric|min:0',
            'products.*.purchase_date' => 'nullable|date',
            'products.*.description' => 'nullable|string',
            'products.*.line_total' => 'required|numeric|min:0',
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
            $quotation->staff_id = auth()->id(); // Assuming the logged-in user is creating the quotation
            $quotation->quote_id = $request->quote_id;
            $quotation->quote_number = $request->quote_id;
            $quotation->quote_date = $request->quote_date;
            $quotation->expiry_date = $request->expiry_date;
            $quotation->total_items = count($request->products);
            $quotation->currency = 'INR'; // Assuming currency is INR, this can be made dynamic if needed
            $quotation->subtotal = 0; // Will be calculated in the loop
            $quotation->discount_amount = 0; // Will be calculated in the loop
            $quotation->tax_amount = 0; // Will be calculated in the loop
            $quotation->total_amount = 0; // This will be calculated after saving products and AMC details
            $quotation->save();

            $subtotal = 0;
            $taxAmount = 0;
            $discount = 0;
            $total = 0;

            // Save Quotation Products
            foreach ($request->products as $productData) {
                $quotationProduct = new QuotationProduct;
                $quotationProduct->quotation_id = $quotation->id;
                $quotationProduct->name = $productData['name'] ?? null;
                $quotationProduct->type = $productData['type'] ?? null;
                $quotationProduct->model_no = $productData['model_no'] ?? null;
                $quotationProduct->sku = $productData['sku'] ?? null;
                $quotationProduct->hsn = $productData['hsn'] ?? null;
                $quotationProduct->purchase_date = $productData['purchase_date'] ?? null;
                $quotationProduct->brand = $productData['brand'] ?? null;
                $quotationProduct->description = $productData['description'] ?? null;

                $quotationProduct->quantity = $productData['quantity'] ?? 1;
                $quotationProduct->unit_price = $productData['unit_price'] ?? 0;
                $quotationProduct->discount_per_unit = $productData['discount_per_unit'] ?? 0;
                $quotationProduct->tax_rate = $productData['tax_rate'] ?? 0;
                $quotationProduct->line_total = $productData['line_total'] ?? 0;
                $quotationProduct->save();

                $subtotal += $quotationProduct->unit_price * $quotationProduct->quantity;
                $taxAmount += ($quotationProduct->unit_price * $quotationProduct->quantity * $quotationProduct->tax_rate) / 100;
                $discount += $quotationProduct->discount_per_unit * $quotationProduct->quantity;
                $total += $quotationProduct->line_total;
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


            $quotation->subtotal = $subtotal;
            $quotation->tax_amount = $taxAmount;
            $quotation->discount_amount = $discount;
            $quotation->total_amount = $total;
            $quotation->save();

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

    public function view($id)
    {
        $quotation = Quotation::with([
            'leadDetails',
            'leadDetails.customerAddress',
            'products',
            'amcDetail.amcPlan',
        ])->findOrFail($id);

        $engineers = Staff::where('staff_role', 'engineer')->get();

        $invoice = QuotationInvoice::with(['quoteDetails.leadDetails', 'quoteDetails.leadDetails.customerAddress', 'items'])
            ->where('quote_id', $id)
            ->latest()
            ->first();

        return view('/crm/quotation/view', compact('quotation', 'engineers', 'invoice'));
    }

    public function edit($id)
    {
        $quotation = Quotation::with([
            'leadDetails',
            'products',
            'amcDetail.amcPlan',
        ])->findOrFail($id);

        $leads = Lead::with('customer')->get();
        $amcPlans = AmcPlan::where('status', 'Active')->get();
        // dd($quotation);
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
            'products.*.name' => 'required|string',
            'products.*.type' => 'nullable|string',
            'products.*.brand' => 'nullable|string',
            'products.*.model_no' => 'nullable|string',
            'products.*.sku' => 'nullable|string',
            'products.*.hsn' => 'nullable|string',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.discount_per_unit' => 'nullable|numeric|min:0',
            'products.*.tax_rate' => 'nullable|numeric|min:0',
            'products.*.purchase_date' => 'nullable|date',
            'products.*.description' => 'nullable|string',
            'products.*.line_total' => 'required|numeric|min:0',

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
            $quotationProduct->name = $productData['name'] ?? null;
            $quotationProduct->type = $productData['type'] ?? null;
            $quotationProduct->brand = $productData['brand'] ?? null;
            $quotationProduct->model_no = $productData['model_no'] ?? null;
            $quotationProduct->sku = $productData['sku'] ?? null;
            $quotationProduct->hsn = $productData['hsn'] ?? null;
            $quotationProduct->description = $productData['description'] ?? null;
            $quotationProduct->purchase_date = $productData['purchase_date'] ?? null;
            $quotationProduct->quantity = $productData['quantity'] ?? 1;
            $quotationProduct->unit_price = $productData['unit_price'] ?? 0;
            $quotationProduct->discount_per_unit = $productData['discount_per_unit'] ?? 0;
            $quotationProduct->tax_rate = $productData['tax_rate'] ?? 0;
            $quotationProduct->line_total = $productData['line_total'] ?? 0;
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

    public function storeOrUpdateAmcDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amc_plan_id' => 'required|string',
            'plan_duration' => 'required|integer|min:0',
            'plan_start_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'priority_level' => 'required|string',
            'additional_notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        $amcPlanDetail = QuotationAmcDetail::where('id', $request->amc_plan_id)->first();

        if (!$amcPlanDetail) {
            return redirect()->back()->with('error', 'AMC details not found.');
        }

        $amcPlanDetail->plan_duration = $request->plan_duration;
        $amcPlanDetail->plan_start_date = $request->plan_start_date;
        $amcPlanDetail->total_amount = $request->total_amount;
        $amcPlanDetail->priority_level = $request->priority_level;
        $amcPlanDetail->additional_notes = $request->additional_notes;
        $amcPlanDetail->save();

        return redirect()->back()->with('success', 'AMC details updated successfully.');
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
                $message = 'Engineer ' . $engineer->first_name . ' ' . $engineer->last_name . ' assigned successfully';
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

                $message = 'Group "' . $request->group_name . '" assigned successfully with ' . count($request->engineer_ids) . ' engineers';
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
                'message' => 'Error assigning engineer: ' . $e->getMessage(),
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
            'name' => 'required|string',
            'type' => 'nullable|string',
            'brand' => 'nullable|string',
            'model_no' => 'nullable|string',
            'sku' => 'nullable|string',
            'hsn' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'discount_per_unit' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'description' => 'nullable|string',
            'line_total' => 'required|numeric|min:0',
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
                'name' => $request->name,
                'type' => $request->type,
                'brand' => $request->brand,
                'model_no' => $request->model_no,
                'sku' => $request->sku,
                'hsn' => $request->hsn,
                'unit_price' => $request->unit_price,
                'quantity' => $request->quantity,
                'discount_per_unit' => $request->discount_per_unit,
                'tax_rate' => $request->tax_rate,
                'purchase_date' => $request->purchase_date,
                'description' => $request->description,
                'line_total' => $request->line_total,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding product: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing product
     */
    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'nullable|string',
            'brand' => 'nullable|string',
            'model_no' => 'nullable|string',
            'sku' => 'nullable|string',
            'hsn' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'discount_per_unit' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'description' => 'nullable|string',
            'line_total' => 'required|numeric|min:0',
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
                'name' => $request->name,
                'type' => $request->type,
                'brand' => $request->brand,
                'model_no' => $request->model_no,
                'sku' => $request->sku,
                'hsn' => $request->hsn,
                'unit_price' => $request->unit_price,
                'quantity' => $request->quantity,
                'discount_per_unit' => $request->discount_per_unit,
                'tax_rate' => $request->tax_rate,
                'purchase_date' => $request->purchase_date,
                'description' => $request->description,
                'line_total' => $request->line_total,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage(),
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
                'message' => 'Error deleting product: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update quotation status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:draft,sent,converted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $quotation = Quotation::findOrFail($id);
            $oldStatus = $quotation->status;
            $quotation->status = $request->status;
            $quotation->save();

            return response()->json([
                'success' => true,
                'message' => 'Quotation status updated from ' . $oldStatus . ' to ' . $request->status . ' successfully',
                'status' => $quotation->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show generate invoice form prefilled from quotation
     */
    public function generateInvoice($id)
    {
        $quotation = Quotation::with(['leadDetails', 'leadDetails.customerAddress', 'products', 'amcDetail'])->findOrFail($id);

        // if invoice exists, pass it to the view for editing
        $invoice = QuotationInvoice::where('quote_id', $id)->latest()->first();

        return view('/crm/quotation/generate_invoice', compact('quotation', 'invoice'));
    }

    /**
     * View invoice page
     */
    public function viewInvoice($id)
    {
        $invoice = QuotationInvoice::with(['quoteDetails.leadDetails', 'quoteDetails.leadDetails.customerAddress', 'items'])
            ->where('quote_id', $id)
            ->first();

        if (! $invoice) {
            return redirect()->route('quotation.view', $id)->with('error', 'Invoice not found.');
        }

        return view('/crm/quotation/view_invoice', compact('invoice'));
    }

    /**
     * Store generated invoice (draft or sent)
     */
    public function storeInvoice(Request $request, $id)
    {
        $quotation = Quotation::with(['leadDetails', 'leadDetails.customerAddress', 'products'])->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'nullable|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'billing_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|in:draft,sent',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // check if invoice already exists for this quotation
        $existing = QuotationInvoice::where('quote_id', $quotation->id)->latest()->first();

        // Generate invoice number if not provided
        $invoiceNumber = $request->input('invoice_number') ?: ($existing->invoice_number ?? 'INV-' . time());

        if ($existing) {
            $invoice = $existing;
        } else {
            $invoice = new QuotationInvoice();
        }

        $invoice->invoice_number = $invoiceNumber;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date;
        $invoice->quote_id = $quotation->id;
        $invoice->customer_id = $quotation->leadDetails->customer->id ?? null;
        $invoice->staff_id = $quotation->staff_id ?? auth()->id();
        $invoice->amc_plan_id = $quotation->amcDetail->first()->amc_plan_id ?? null;
        $invoice->total_items = $quotation->products->count();
        $invoice->subtotal = $quotation->subtotal ?? 0;
        $invoice->total_discount = $quotation->discount_amount ?? 0;
        $invoice->total_tax = $quotation->tax_amount ?? 0;
        $invoice->round_off = 0;
        $invoice->grand_total = $quotation->total_amount ?? 0;
        $invoice->currency = $quotation->currency ?? 'INR';
        $invoice->status = $request->status ?: 'draft';
        $invoice->notes = $request->notes ?? null;
        $invoice->terms_and_conditions = $request->terms_and_conditions ? true : false;
        $invoice->paid_amount = 0;
        $invoice->payment_status = 'unpaid';
        $invoice->payment_method = $request->payment_method ?? null;
        $invoice->billing_address = $request->billing_address ?? ($quotation->leadDetails->customerAddress ? json_encode($quotation->leadDetails->customerAddress) : null);
        $invoice->shipping_address = $request->shipping_address ?? ($quotation->leadDetails->customerAddress ? json_encode($quotation->leadDetails->customerAddress) : null);
        $invoice->paid_at = null;
        $invoice->save();
        // remove existing items if updating
        if ($existing) {
            QuotationInvoiceItem::where('quotation_invoice_id', $existing->id)->delete();
        }

        // Create invoice items from quotation products
        foreach ($quotation->products as $product) {
            $unitPrice = $product->unit_price ?? $product->price ?? 0;
            $discountPerUnit = $product->discount_per_unit ?? 0;
            $taxRate = $product->tax_rate ?? $product->tax ?? 0;
            $quantity = $product->quantity ?? 1;

            $lineSubtotal = ($unitPrice - $discountPerUnit) * $quantity;
            $taxAmount = ($lineSubtotal * $taxRate) / 100;
            $lineTotal = $lineSubtotal + $taxAmount;

            QuotationInvoiceItem::create([
                'quotation_invoice_id' => $invoice->id,
                'quotation_products_id' => $product->id ?? null,
                // Snapshot product fields (new schema)
                'name' => $product->name ?? $product->product_name ?? null,
                'type' => $product->type ?? null,
                'brand' => $product->brand ?? null,
                'model_no' => $product->model_no ?? null,
                'sku' => $product->sku ?? null,
                'hsn' => $product->hsn ?? $product->hsn_code ?? null,
                'purchase_date' => $product->purchase_date ?? null,
                'description' => $product->description ?? $product->product_description ?? null,

                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount_per_unit' => $discountPerUnit,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'line_subtotal' => $lineSubtotal,
                'line_total' => $lineTotal,
            ]);
        }

        // Generate PDF if status is 'sent'
        if ($invoice->status === 'sent' && !$invoice->invoice_pdf) {
            $pdfPath = $this->generateInvoicePdf($invoice);
            $invoice->invoice_pdf = $pdfPath;
            $invoice->save();
        }

        // redirect back to quotation view so buttons update
        return redirect()->route('quotation.view', $quotation->id)->with('success', 'Invoice has been ' . ($invoice->status === 'sent' ? 'sent' : 'saved as draft'));
    }

    /**
     * Generate PDF for an invoice and store it
     */
    private function generateInvoicePdf($invoice)
    {
        // Reload with relationships for PDF generation
        $invoice->load(['quoteDetails.leadDetails.customerAddress', 'items']);

        // Create PDF
        $pdf = Pdf::loadView('crm.quotation.invoice_pdf', ['invoice' => $invoice])
            ->setPaper('a4', 'portrait');

        // Define storage path
        $filename = 'invoices/' . $invoice->invoice_number . '_' . time() . '.pdf';
        $storagePath = 'public/' . $filename;

        // Store PDF file
        Storage::put($storagePath, $pdf->output());

        // Return the path to store in database
        return $filename;
    }
}
