<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AmcService;
use App\Models\CoveredItem;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\GiveFeedback;
use App\Models\NonAmcService;
use App\Models\QuickServiceRequest;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
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
            $quickServices = CoveredItem::where('service_type', '2')
                ->where('status', '1')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['quick_services' => $quickServices], 200);
        }
    }

    public function allRequests(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validated->errors(),
            ], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid role_id provided.',
            ], 400);
        }

        if ($staffRole !== 'customers') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized role.',
            ], 403);
        }

        // AMC summary
        $amcServices = AmcService::where('customer_id', $validated['customer_id'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $row->id,
                    'type' => 'amc',
                    'title' => $row->amc_number ?? ('AMC #' . $row->id),
                    'status' => $row->status,
                    'created_at' => $row->created_at,
                    'detail_url' => url('/api/v1/amc-request-details/' . $row->id),
                ];
            });

        // Non-AMC summary (Non-AMC + Installation + Repairing agar same table + subtype hai)
        $nonAmcServices = NonAmcService::where('customer_id', $validated['customer_id'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $row->id,
                    'type' => $row->service_sub_type ?? 'non_amc', // non_amc / installation / repairing
                    'title' => $row->service_number ?? ('NON-AMC #' . $row->id),
                    'status' => $row->status,
                    'created_at' => $row->created_at,
                    'detail_url' => url('/api/v1/non-amc-request-details/' . $row->id),
                ];
            });

        // Quick Service summary
        $quickServiceRequests = QuickServiceRequest::where('customer_id', $validated['customer_id'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $row->id,
                    'type' => 'quick_service',
                    'title' => $row->ticket_number ?? ('Quick Service #' . $row->id),
                    'status' => $row->status,
                    'created_at' => $row->created_at,
                    'detail_url' => url('/api/v1/quick-service-request-details/' . $row->id),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'amc_services' => $amcServices,
                'non_amc_services' => $nonAmcServices,
                'quick_service_requests' => $quickServiceRequests,
            ],
        ], 200);
    }

    public function amcRequestDetails(Request $request, $id)
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

        $amcService = AmcService::with(['amcPlan', 'branches', 'products', 'creator'])
            ->where('id', $id)
            ->where('customer_id', $validated['customer_id']) // security
            ->first();

        if (! $amcService) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'request' => $amcService,
        ], 200);
    }

    public function nonAmcRequestDetails(Request $request, $id)
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

        $nonAmcService = NonAmcService::with(['serviceType', 'branches', 'products', 'creator'])
            ->where('id', $id)
            ->where('customer_id', $validated['customer_id']) // security
            ->first();

        if (! $nonAmcService) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'request' => $nonAmcService,
        ], 200);
    }

    public function quickServiceRequestDetails(Request $request, $id)
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

        $quickServiceRequest = QuickServiceRequest::with(['quickService', 'branches', 'products', 'creator'])
            ->where('id', $id)
            ->where('customer_id', $validated['customer_id']) // security
            ->first();

        if (! $quickServiceRequest) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'request' => $quickServiceRequest,
        ], 200);
    }

    // Give Feedback APIs only for that services who status is completed
    public function giveFeedback(Request $request)
    {
        // Store only that feedback whose status is completed
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
            'service_type' => 'required|in:amc,non_amc,quick_service',
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
        switch ($serviceType) {
            case 'amc':
                $service = AmcService::where('id', $serviceId)->where('customer_id', $validated['customer_id'])->first();
                break;
            case 'non_amc':
                $service = NonAmcService::where('id', $serviceId)->where('customer_id', $validated['customer_id'])->first();
                break;
            case 'quick_service':
                $service = QuickServiceRequest::where('id', $serviceId)->where('customer_id', $validated['customer_id'])->first();
                break;
        }

        if (! $service) {
            return response()->json(['success' => false, 'message' => 'Service not found.'], 404);
        }

        // If  feedback already exists for same service
        $existingFeedback = GiveFeedback::where('customer_id', $validated['customer_id'])
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
        if ($serviceType !== 'amc' && $service->status !== 'Completed') {
            return response()->json(['success' => false, 'message' => 'Service is not completed.'], 400);
        }

        $feedback = GiveFeedback::create([
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

        $feedbacks = GiveFeedback::where('customer_id', $validated['customer_id'])->get();

        return response()->json(['success' => true, 'data' => $feedbacks], 200);
    }

    public function getFeedback(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
            'customer_id' => 'required|integer|exists:customers,id',
            'service_type' => 'required|in:amc,non_amc,quick_service',
            'service_id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole || $staffRole !== 'customers') {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $feedback = GiveFeedback::where('customer_id', $validated['customer_id'])
            ->where('service_type', $validated['service_type'])
            ->where('service_id', $validated['service_id'])
            ->first();

        if (! $feedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $feedback], 200);
    }
}
