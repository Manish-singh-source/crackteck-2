<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Models\Engineer;
use App\Models\Feedback;
use App\Models\AmcService;
use App\Models\CoveredItem;
use App\Models\DeliveryMan;
use App\Models\SalesPerson;
use App\Models\GiveFeedback;
use Illuminate\Http\Request;
use App\Models\NonAmcService;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\QuickServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestQuotation;
use Illuminate\Support\Facades\Validator;

class AllServicesController extends Controller
{
    //
    protected function getModelByRoleId($roleId)
    {
        return [
            1 => Engineer::class,
            2 => DeliveryMan::class,
            3 => SalesPerson::class,
            4 => Customer::class,
        ][$roleId] ?? null;
    }

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
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
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

        if ($staffRole == 'customers') {
            $quickServices = CoveredItem::where('service_type', 'quick_service')
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['quick_services' => $quickServices], 200);
        }
    }

    public function servicesListByType(Request $request)
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

        $service_type = $request->service_type;

        if ($staffRole == 'customers') {

            $services = CoveredItem::where('service_type', $service_type)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['services' => $services], 200);
        }
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
        // return response()->json(['request_data' => $request->all()], 200);
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'service_type' => 'required|in:quick_service,installation,repairing,amc',
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
            $serviceRequest = uniqid();

            $servicesRequest = ServiceRequest::create([
                'request_id' => $serviceRequest,
                'service_type' => $request->service_type,
                'customer_id' => $request->customer_id,
                'created_by' => $request->customer_id,
                'request_date' => now(),
                'amc_plan_id' => $request->filled('amc_plan_id')
                    ? $request->amc_plan_id
                    : null,
                // 'request_status' => 'pending',
                // 'request_source' => 'mobile_app',
                // 'is_engineer_assigned' => '0',
                // 'status' => '1',
            ]);

            if ($servicesRequest) {
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
            return response()->json(['quick_service_request' => $servicesRequest], 200);
        }
    }

    public function serviceRequestQuotations(Request $request)
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

        // Pending to implement quotation list logic
        $serviceRequestQuotations = ServiceRequestQuotation::with('serviceRequest', 'serviceRequestPart')->orderBy('created_at', 'desc')->get();
        // $serviceRequestQuotations = ServiceRequest::with('quotations')->orderBy('created_at', 'desc')->get();

        return response()->json(['quotations' => $serviceRequestQuotations], 200);
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
        $serviceRequestQuotation = ServiceRequestQuotation::with('serviceRequest', 'serviceRequestPart')
            ->whereHas('serviceRequest', function ($query) use ($validated) {
                $query->where('customer_id', $validated['user_id']);
            })
            ->where('id', $id)
            ->first();

        if (! $serviceRequestQuotation) {
            return response()->json(['success' => false, 'message' => 'Quotation not found.'], 404);
        }

        return response()->json(['quotation_details' => $serviceRequestQuotation], 200);
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
