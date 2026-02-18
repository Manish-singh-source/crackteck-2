<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuotationDetailResource;
use App\Http\Resources\QuotationResource;
use App\Models\AmcPlan;
use App\Models\CoveredItem;
use App\Models\EngineerDiagnosisDetail;
use App\Models\Feedback;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\QuotationInvoice;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestProductRequestPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AllServicesController extends Controller
{
    //

    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function servicesList(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid Role Id provided.'], 400);
        }

        $services = [
            [
                'id' => '1',
                'name' => 'AMC Services',
            ],
            [
                'id' => '2',
                'name' => 'Quick Services',
            ],
            [
                'id' => '3',
                'name' => 'Installation Services',
            ],
            [
                'id' => '4',
                'name' => 'Repair Services',
            ]
        ];

        if (empty($services)) {
            return response()->json([
                'success' => false,
                'message' => 'No services found.'
            ], 404);
        }

        return response()->json(['services' => $services], 200);
    }

    public function quickServicesList(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $quickServices = CoveredItem::where('service_type', 'quick_service')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($quickServices->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No quick services found.'], 404);
        }

        return response()->json(['quick_services' => $quickServices], 200);
    }

    public function servicesListByType(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'service_type' => 'required|in:amc,quick_service,installation,repair',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $services = CoveredItem::where('service_type', $request->service_type)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($services->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No services found.'], 404);
        }

        return response()->json(['services' => $services], 200);
    }

    public function getServiceDetails(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $quickService = CoveredItem::where('status', 'active')
                ->where('id', $id)
                ->first();

            if (! $quickService) {
                return response()->json(['success' => false, 'message' => 'Quick service not found.'], 404);
            }

            return response()->json(['quick_service' => $quickService], 200);
        }
    }

    public function submitQuickServiceRequest(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'customer_address_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Please Add Address For the Service']);
        }

        if ($request->service_type == 'amc') {
            $rules = [
                'role_id' => 'required|in:4',
                'customer_id' => 'required|integer|exists:customers,id',
                'customer_address_id' => 'required|integer|exists:customer_address_details,id',
                'service_type' => 'required|in:amc',
                'products' => 'required|array|min:1',
                'products.*.name' => 'required|string',
                'products.*.type' => 'required|string',
                'products.*.model_no' => 'nullable|string',
                'products.*.sku' => 'nullable|string',
                'products.*.hsn' => 'nullable|string',
                'products.*.purchase_date' => 'nullable|date',
                'products.*.brand' => 'required|string',
                'products.*.description' => 'nullable|string',
                'products.*.images' => 'nullable|array|min:1',
                'products.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'amc_plan_id' => 'required|integer|exists:amc_plans,id',
            ];
        } else {
            $rules = [
                'role_id' => 'required|in:4',
                'customer_id' => 'required|integer|exists:customers,id',
                'customer_address_id' => 'required|integer|exists:customer_address_details,id',
                'service_type' => 'required|in:quick_service,installation,repairing',
                'products' => 'required|array|min:1',
                'products.*.service_type_id' => 'required|integer|exists:covered_items,id',
                'products.*.name' => 'required|string',
                'products.*.type' => 'required|string',
                'products.*.model_no' => 'nullable|string',
                'products.*.sku' => 'nullable|string',
                'products.*.hsn' => 'nullable|string',
                'products.*.purchase_date' => 'nullable|date',
                'products.*.brand' => 'required|string',
                'products.*.description' => 'nullable|string',
                'products.*.images' => 'nullable|array|min:1',
                'products.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        $validated = Validator::make($request->all(), $rules);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        try {
            DB::beginTransaction();
            if ($staffRole == 'customers') {
                $serviceRequest = uniqid();

                $servicesRequest = ServiceRequest::create([
                    'request_id' => $serviceRequest,
                    'service_type' => $request->service_type,
                    'customer_id' => $request->customer_id,
                    'customer_address_id' => $request->customer_address_id,
                    'created_by' => $request->customer_id,
                    'request_date' => now(),
                    'amc_plan_id' => $request->filled('amc_plan_id')
                        ? $request->amc_plan_id
                        : null,
                    // 'request_status' => 'pending',
                    'request_source' => 'customer',
                    // 'is_engineer_assigned' => '0',   
                    'status' => $request->service_type == 'amc' ? 'active' : 'pending',
                ]);

                if ($servicesRequest) {
                    if ($request->service_type == 'amc') {
                        $amcPlan = AmcPlan::where('id', $request->amc_plan_id)->first();

                        // Calculate the month gap between visits as an integer (avoid fractional months)
                        $monthGapFloat = intval($amcPlan->duration) / max(1, intval($amcPlan->total_visits));
                        $monthGap = (int) round($monthGapFloat);

                        // Ensure we have a Carbon instance for dates
                        $startVisitDate = $servicesRequest->visit_date ? \Carbon\Carbon::parse($servicesRequest->visit_date) : \Carbon\Carbon::now();

                        // Start from the next visit after the initial visit date
                        $nextVisitDate = $startVisitDate->copy()->addMonths($monthGap);

                        foreach (range(1, $amcPlan->total_visits) as $visitNumber) {
                            // Create a service request visit for each visit
                            $servicesRequest->amcScheduleMeetings()->create([
                                'service_request_id' => $servicesRequest->id,
                                'scheduled_at' => $nextVisitDate,
                                'completed_at' => null,
                                'remarks' => null,
                                'report' => null,
                                'visits_count' => $visitNumber,
                                'status' => 'scheduled',
                            ]);

                            // Update the next visit date for the next iteration
                            $nextVisitDate = $nextVisitDate->addMonths($monthGap);
                        }
                    }

                    foreach ($request->products as $product) {

                        if ($request->service_type != 'amc') {
                            $services = CoveredItem::where('status', 'active')
                                ->where('id', $product['service_type_id'] ?? null)
                                ->first();

                            if (! $services) {
                                continue;
                            }
                        }

                        $serviceProduct = $servicesRequest->products()->create([
                            'service_requests_id' => $servicesRequest->id,
                            'item_code_id' => $services->id ?? null,
                            'name' => $product['name'] ?? null,
                            'type' => $product['type'] ?? null,
                            'model_no' => $product['model_no'] ?? null,
                            'sku' => $product['sku'] ?? null,
                            'hsn' => $product['hsn'] ?? null,
                            'purchase_date' => $product['purchase_date'] ?? null,
                            'brand' => $product['brand'] ?? null,
                            'description' => $product['description'] ?? null,
                            'service_charge' => $services->service_charge ?? null,
                        ]);

                        $images = $serviceProduct->images ?? [];
                        if (!empty($product['images']) && is_array($product['images'])) {
                            foreach ($product['images'] as $file) {

                                if (!$file || !($file instanceof \Illuminate\Http\UploadedFile)) {
                                    continue;
                                }

                                $filename = time() . '_' . $serviceProduct->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                                $file->move(
                                    public_path('uploads/crm/quick-service/products'),
                                    $filename
                                );

                                $images[] = 'uploads/crm/quick-service/products/' . $filename;
                            }
                        }

                        $serviceProduct->images = $images;
                        $serviceProduct->save();
                    }
                }

                DB::commit();
                return response()->json(['quick_service_request' => $servicesRequest->load('products')], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Transaction failed.', 'errors' => $e->getMessage()], 500);
        }
    }

    public function allServiceRequests(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $serviceRequests = ServiceRequest::where('customer_id', $validated['customer_id'])->orderBy('created_at', 'desc')->get();

            return response()->json(['service_requests' => $serviceRequests], 200);
        }
    }

    public function serviceRequestDetails(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $serviceRequest = ServiceRequest::with('products', 'customer')->where('id', $id)->where('customer_id', $validated['customer_id'])->first();

            if (! $serviceRequest) {
                return response()->json(['success' => false, 'message' => 'Service request not found.'], 404);
            }

            return response()->json(['service_request' => $serviceRequest], 200);
        }
    }

    public function serviceRequestProductDiagnostics(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $serviceRequest = ServiceRequest::where('id', $id)
                ->where('customer_id', $validated['customer_id'])
                ->first();

            if (! $serviceRequest) {
                return response()->json(['success' => false, 'message' => 'Service request not found.'], 404);
            }

            $productDiagnostics = [];

            $serviceRequestProduct = ServiceRequestProduct::where('id', $product_id)
                ->where('service_requests_id', $id)
                ->first();

            if (!$serviceRequestProduct) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }

            // Get diagnosis details from engineer_diagnosis_details table
            $diagnosisDetails = EngineerDiagnosisDetail::where('service_request_id', $id)
                ->where('service_request_product_id', $product_id)
                ->get();

            $diagnoses = [];
            foreach ($diagnosisDetails as $diagnosis) {
                $diagnosisList = json_decode($diagnosis->diagnosis_list, true);
                $diagnoses[] = [
                    'diagnosis_id' => $diagnosis->id,
                    'assigned_engineer_id' => $diagnosis->assigned_engineer_id,
                    'diagnosis_list' => $diagnosisList ?? [],
                    'diagnosis_notes' => $diagnosis->diagnosis_notes,
                    'completed_at' => $diagnosis->completed_at,
                ];
            }

            // Get request parts for this product
            $requestParts = ServiceRequestProductRequestPart::where('product_id', $product_id)
                ->where('request_id', $id)
                ->get();

            $parts = [];
            foreach ($requestParts as $part) {
                $parts[] = [
                    'id' => $part->id,
                    'part_id' => $part->part_id,
                    'requested_quantity' => $part->requested_quantity,
                    'request_type' => $part->request_type,
                    'status' => $part->status,
                    'requires_customer_action' => in_array($part->status, ['admin_approved', 'warehouse_approved']),
                ];
            }

            return response()->json([
                'product' => [
                    'id' => $serviceRequestProduct->id,
                    'name' => $serviceRequestProduct->name,
                    'status' => $serviceRequestProduct->status,
                ],
                'diagnoses' => $diagnoses,
                'request_parts' => $parts,
            ], 200);
        }
    }

    /**
     * Customer approve or reject for picked, stock_in_hand, request_part status
     */
    public function customerApproveRejectPart(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
            'service_request_id' => 'required|integer|exists:service_requests,id',
            'product_id' => 'required|integer|exists:service_request_products,id',
            'part_id' => 'required|integer',
            'action' => 'required|in:customer_approved,customer_rejected',
            'request_type' => 'nullable|in:stock_in_hand,request_part',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            // Verify the service request belongs to this customer
            $serviceRequest = ServiceRequest::where('id', $validated['service_request_id'])
                ->where('customer_id', $validated['customer_id'])
                ->first();

            if (!$serviceRequest) {
                return response()->json(['success' => false, 'message' => 'Service request not found or does not belong to this customer.'], 404);
            }

            $requestPart = ServiceRequestProductRequestPart::where('id', $validated['part_id'])
                ->first();

            if (!$requestPart) {
                return response()->json(['success' => false, 'message' => 'Request part not found.'], 404);
            }

            // Check if customer action is allowed (only for admin_approved or warehouse_approved status)
            if (!in_array($requestPart->status, ['admin_approved', 'warehouse_approved'])) {
                return response()->json(['success' => false, 'message' => 'Customer approval is not required for current status. Current status: ' . $requestPart->status], 400);
            }

            // Update the status based on customer action
            if ($validated['action'] === 'customer_approved') {
                $requestPart->update([
                    'status' => 'customer_approved',
                    'customer_approved_at' => now(),
                ]);
                $message = 'Part approved successfully.';
            } else {
                $requestPart->update([
                    'status' => 'customer_rejected',
                    'customer_rejected_at' => now(),
                ]);
                $message = 'Part rejected successfully.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'part_id' => $requestPart->id,
                'status' => $requestPart->status,
            ], 200);
        }
    }

    public function serviceRequestQuotations(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Pending to implement quotation list logic
        // $serviceRequestQuotations = ServiceRequestQuotation::with('serviceRequest', 'serviceRequestPart')->orderBy('created_at', 'desc')->get();
        // $serviceRequestQuotations = ServiceRequest::with('quotations')->orderBy('created_at', 'desc')->get();
        $leadQuotations = Lead::with(['quotation' => function ($query) {
            $query->where('status', '!=', 'draft');
        }])
            ->where('customer_id', $validated['user_id'])
            ->whereHas('quotation', function ($query) {
                $query->where('status', '!=', 'draft');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $data = QuotationResource::collection($leadQuotations);

        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function serviceRequestQuotationDetails(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Pending to implement quotation details logic
        // Current (works fine)
        $quotationDetails = Quotation::with('leadDetails', 'amcDetail', 'products')->where('id', $id)->first();

        if (! $quotationDetails) {
            return response()->json(['success' => false, 'message' => 'Quotation not found.'], 404);
        }

        $data = new QuotationDetailResource($quotationDetails);

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function acceptQuotation(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);


        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the service request quotation
        $serviceRequestQuotation = Quotation::where('id', $id)->first();

        if (! $serviceRequestQuotation) {
            return response()->json(['success' => false, 'message' => 'Quotation not found.'], 404);
        }

        // Update the quotation status to accepted
        $serviceRequestQuotation->update(['status' => 'accepted']);

        return response()->json(['success' => true, 'message' => 'Quotation accepted successfully.'], 200);
    }

    public function rejectQuotation(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the service request quotation
        $serviceRequestQuotation = Quotation::where('id', $id)->first();

        if (! $serviceRequestQuotation) {
            return response()->json(['success' => false, 'message' => 'Quotation not found.'], 404);
        }

        // Update the quotation status to rejected
        $serviceRequestQuotation->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Quotation rejected successfully.'], 200);
    }

    public function payInvoice(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        try {


            // Find the quotation invoice
            $invoice = QuotationInvoice::with(['quoteDetails.products', 'quoteDetails.amcDetail'])->where('id', $id)->first();

            if (! $invoice) {
                return response()->json(['success' => false, 'message' => 'Invoice not found.'], 404);
            }

            // Update the invoice status to paid
            $invoice->update([
                'paid_amount' => $validated['amount'],
                'payment_method' => 'online', // Assuming payment method is online, you can modify as needed
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            if ($invoice->quoteDetails && $invoice->quoteDetails->leadDetails) {
                $invoice->quoteDetails->leadDetails->update(['status' => 'won']);
            }

            $serviceRequest = new ServiceRequest();
            $serviceRequest->request_id = uniqid();
            $serviceRequest->service_type = 'amc';
            $serviceRequest->customer_id = $invoice->customer_id ?? null;
            $serviceRequest->customer_address_id = $invoice->quoteDetails->leadDetails->customer_address_id ?? null;
            $serviceRequest->request_date = now();
            $serviceRequest->request_source = 'lead_won'; // lead_won
            $serviceRequest->visit_date = now()->addDays(5); // after 5 days of current date
            $serviceRequest->reschedule_date = null;
            $serviceRequest->created_by = $invoice->staff_id ?? null;
            $serviceRequest->is_engineer_assigned = 'not_assigned';
            $serviceRequest->status = 'active';
            $serviceRequest->amc_plan_id = $invoice->amc_plan_id ?? null;
            $serviceRequest->save();


            $amcPlan = AmcPlan::where('id', $invoice->amc_plan_id)->first();

            $monthGap = $amcPlan->duration / $amcPlan->total_visits; // Calculate the month gap between visits 
            $startVisitDate = $serviceRequest->visit_date; // Start visit date is the initial visit date of the service request
            $nextVisitDate = $startVisitDate->addMonths($monthGap); // Set the next visit date based on the month gap

            foreach (range(1, $amcPlan->total_visits) as $visitNumber) {
                // Create a service request visit for each visit
                // service_request_id	scheduled_at	completed_at	remarks	report	visits_count	status	created_at	updated_at
                $serviceRequest->amcScheduleMeetings()->create([
                    'service_request_id' => $serviceRequest->id,
                    'scheduled_at' => $nextVisitDate,
                    'completed_at' => null,
                    'remarks' => null,
                    'report' => null,
                    'visits_count' => $visitNumber,
                    'status' => 'scheduled',
                ]);

                // Update the next visit date for the next iteration
                $nextVisitDate = $nextVisitDate->addMonths($monthGap);
            }

            // add service request products according to quotation products
            foreach ($invoice->items as $item) {
                $serviceRequest->products()->create([
                    'service_requests_id' => $serviceRequest->id,
                    'item_code_id' => $item->item_code_id ?? null,
                    'name' => $item->name ?? 'N/A',
                    'type' => $item->type ?? 'N/A',
                    'model_no' => $item->model_no ?? 'N/A',
                    'sku' => $item->sku ?? 'N/A',
                    'hsn' => $item->hsn ?? 'N/A',
                    'purchase_date' => $item->purchase_date ?? 'N/A',
                    'brand' => $item->brand ?? 'N/A',
                    'description' => $item->description ?? 'N/A',
                    'service_charge' => $item->service_charge ?? '100',
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Invoice paid successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment processing failed.', 'errors' => $e->getMessage()], 500);
        }
    }

    // display invoice to the customer according to quotation id 
    public function serviceRequestInvoicesList(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find all quotation invoices for the customer
        $invoices = QuotationInvoice::with('quoteDetails.leadDetails', 'items')
            ->whereHas('quoteDetails.leadDetails', function ($query) use ($validated) {
                $query->where('customer_id', $validated['user_id']);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $invoices], 200);
    }

    public function serviceRequestInvoice(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the quotation invoice according to quotation id
        $invoice = QuotationInvoice::with('items')->where('quote_id', $id)->first();

        if (! $invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $invoice], 200);
    }

    public function acceptInvoice(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the quotation invoice
        $invoice = QuotationInvoice::where('id', $id)->first();

        if (! $invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found.'], 404);
        }

        // Update the invoice status to accepted
        $invoice->update(['status' => 'accepted']);

        return response()->json(['success' => true, 'message' => 'Invoice accepted successfully.'], 200);
    }

    public function rejectInvoice(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'user_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the quotation invoice
        $invoice = QuotationInvoice::where('id', $id)->first();

        if (! $invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found.'], 404);
        }

        // Update the invoice status to rejected
        $invoice->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Invoice rejected successfully.'], 200);
    }


    // Give Feedback APIs only for that services who status is completed
    public function giveFeedback(Request $request)
    {
        // Store only that feedback whose status is completed
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
            'service_type' => 'required|in:amc,repairing,installation,quick_service',
            'service_id' => 'required|integer',
            'rating' => 'required|numeric|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole || $staffRole !== 'customers') {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $serviceType = $validated['service_type'];
        $serviceId = $validated['service_id'];
        $rating = $validated['rating'];
        $comments = $validated['comments'] ?? null;

        $service = null;
        $service = ServiceRequest::where('id', $serviceId)->where('customer_id', $validated['customer_id'])->first();

        if (! $service) {
            return response()->json(['success' => false, 'message' => 'Service not found.'], 404);
        }

        // If  feedback already exists for same service
        $existingFeedback = Feedback::where('customer_id', $validated['customer_id'])
            ->where('service_type', $validated['service_type'])
            ->where('service_id', $validated['service_id'])
            ->first();

        if ($existingFeedback) {
            return response()->json(['success' => false, 'message' => 'Feedback already submitted.'], 400);
        }

        // for amc  status is active
        if ($serviceType === 'amc' && $service->status !== 'Active') {
            return response()->json(['success' => false, 'message' => 'Service is not completed.'], 400);
        }

        // for non amc and quick service status is completed
        if ($serviceType !== 'amc' && $service->status !== '10') {
            return response()->json(['success' => false, 'message' => 'Service is not completed.'], 400);
        }
        // return response()->json(['request_data' => $service->status], 200);

        $feedback = Feedback::create([
            'customer_id' => $validated['customer_id'],
            'service_type' => $validated['service_type'],
            'service_id' => $validated['service_id'],
            'rating' => $validated['rating'],
            'comments' => $validated['comments'] ?? null,
        ]);

        if (! $feedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not submitted.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Feedback submitted successfully.', 'data' => $feedback], 200);
    }

    public function getAllFeedback(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole || $staffRole !== 'customers') {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $feedbacks = Feedback::with('serviceRequest')->where('customer_id', $validated['customer_id'])->get();

        return response()->json(['success' => true, 'data' => $feedbacks], 200);
    }

    public function getFeedback(Request $request, $feedback_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole || $staffRole !== 'customers') {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $feedback = Feedback::with('serviceRequest')
            ->where('id', $feedback_id)
            ->where('customer_id', $validated['customer_id'])
            ->first();

        if (! $feedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $feedback], 200);
    }
}
