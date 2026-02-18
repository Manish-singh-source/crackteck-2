<?php

namespace App\Http\Controllers;

use App\Models\StockInHand;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\AssignedEngineer;
use App\Models\StockInHandProduct;
use App\Models\CaseTransferRequest;
use App\Models\CoveredItem;
use Illuminate\Support\Facades\File;
use App\Models\ServiceRequestProduct;
use App\Models\EngineerDiagnosisDetail;
use App\Models\ServiceRequestProductPickup;
use App\Models\ServiceRequestProductRequestPart;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;
use App\Models\Staff;
use Illuminate\Support\Facades\{Auth, DB, Log, Storage, Validator};

class FieldEngineerController extends Controller
{
    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
        ]);

        $user = Staff::findOrFail($validated['user_id']);

        // Get all authentication logs for the user
        $authLogs = AuthenticationLog::forUser($user)
            ->whereNotNull('login_at')
            ->orderBy('login_at', 'desc')
            ->get();

        // Calculate total working hours from login_at and logout_at
        $totalWorkingSeconds = 0;
        $todayWorkingSeconds = 0;
        $today = date('Y-m-d');

        foreach ($authLogs as $log) {
            if ($log->login_at && $log->logout_at) {
                $loginTime = strtotime($log->login_at);
                $logoutTime = strtotime($log->logout_at);
                $sessionSeconds = ($logoutTime - $loginTime);
                $totalWorkingSeconds += $sessionSeconds;

                // Calculate today's working hours
                if (date('Y-m-d', $loginTime) == $today) {
                    $todayWorkingSeconds += $sessionSeconds;
                }
            }
        }

        $totalWorkingHours = round($totalWorkingSeconds / 3600, 2);
        $todayWorkingHours = round($todayWorkingSeconds / 3600, 2);

        return response()->json([
            'logs' => $authLogs,
            'total_working_hours' => $totalWorkingHours,
            'today_working_hours' => $todayWorkingHours,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'role_id' => 'required|in:1,2,3',
        ]);

        $user = Staff::findOrFail($validated['user_id']);

        // Create a new authentication log entry manually
        $authLog = new AuthenticationLog();
        $authLog->authenticatable()->associate($user);
        $authLog->ip_address = $request->ip();
        $authLog->user_agent = $request->userAgent();
        $authLog->login_at = now();
        $authLog->login_successful = true;
        $authLog->save();

        // // Login the user via JWT
        // $token = auth('staff')->login($user);

        return response()->json([
            'message' => 'Login successful',
            'auth_log' => $authLog,
            // 'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'role_id' => 'required|in:1,2,3,4',
        ]);

        $user = Staff::findOrFail($validated['user_id']);

        // Find the latest authentication log entry where logout_at is null
        $authLog = AuthenticationLog::forUser($user)
            ->whereNull('logout_at')
            ->orderBy('login_at', 'desc')
            ->first();

        if (! $authLog) {
            return response()->json(['message' => 'No active session found'], 404);
        }

        // Update logout_at
        $authLog->logout_at = now();
        $authLog->save();

        // Calculate working hours
        $loginTime = strtotime($authLog->login_at);
        $logoutTime = strtotime($authLog->logout_at);
        $totalHours = ($logoutTime - $loginTime) / 3600;
        $workingHours = round($totalHours, 2);

        // Logout the user via JWT
        // auth('staff')->logout();

        return response()->json([
            'message' => 'Logout successful',
            'auth_log' => $authLog,
            'working_hours' => $workingHours,
        ], 200);
    }

    public function serviceRequests(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $serviceRequests = ServiceRequest::with(['customer', 'products'])
            ->whereHas('activeAssignment', function ($query) use ($request) {
                $query->where('engineer_id', $request->user_id);
            })
            ->where('is_engineer_assigned', 'assigned')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['serviceRequests' => $serviceRequests], 200);
    }

    public function serviceRequestDetails(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $serviceRequest = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'products',
        ])->findOrFail($id);

        // Get active assignment
        // $activeAssignment = AssignedEngineer::with(['engineer', 'groupEngineers'])
        $activeAssignment = AssignedEngineer::with(['engineer'])
            ->where('service_request_id', $id)
            ->where('status', 'active')
            ->first();

        return response()->json(['serviceRequest' => $serviceRequest, 'activeAssignment' => $activeAssignment], 200);
    }

    public function serviceRequestProductDetails(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        // return response()->json(['success' => false, 'message' => 'Unauthorized.', 'id' => auth()->id()], 401);
        if ($validated['user_id'] != auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
            ->where('service_requests_id', $id)
            ->where('id', $product_id)
            ->first();

        return response()->json(['serviceRequestProduct' => $serviceRequestProduct], 200);
    }

    public function acceptServiceRequest(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $serviceRequest = ServiceRequest::findOrFail($id);

        // Update service request status to In Progress (status = 3)
        $serviceRequest->status = 'engineer_approved';
        $serviceRequest->save();

        $assignEngineer = AssignedEngineer::where('service_request_id', $id)->first();
        $assignEngineer->is_approved_by_engineer = '1';
        $assignEngineer->engineer_approved_at = now();
        $assignEngineer->save();


        return response()->json(['message' => 'Service request accepted successfully.'], 200);
    }

    public function startDiagnosis(Request $request, $id)
    {
        try {
            $serviceRequest = ServiceRequest::find($id);

            if (!$serviceRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.'
                ], 404);
            }

            if ($serviceRequest->status !== 'engineer_approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP can be sent only after Engineer Approval.'
                ], 400);
            }

            if ($serviceRequest->otp && $serviceRequest->otp_expiry && now()->lt($serviceRequest->otp_expiry)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP already sent and is still valid. Please wait before retrying.'
                ], 400);
            }

            $otp = rand(1000, 9999);

            DB::beginTransaction();
            $serviceRequest->otp = $otp;
            $serviceRequest->otp_expiry = now()->addMinutes(5);
            $serviceRequest->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'otp' => $otp,
                    'otp_expiry' => $serviceRequest->otp_expiry
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Start diagnosis OTP failed', [
                'service_request_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function verifyDiagnosis(Request $request, $id)
    {
        try {
            $request->validate([
                'otp' => 'required|digits:4'
            ]);

            $serviceRequest = ServiceRequest::find($id);

            if (!$serviceRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.'
                ], 404);
            }

            if ($serviceRequest->status !== 'engineer_approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP verification not allowed at this stage.'
                ], 400);
            }
            if (!$serviceRequest->otp || !$serviceRequest->otp_expiry) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP not generated for this service request.'
                ], 400);
            }

            if (now()->gt($serviceRequest->otp_expiry)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.'
                ], 400);
            }

            if ($serviceRequest->otp != $request->otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP.'
                ], 401);
            }

            DB::beginTransaction();

            $serviceRequest->update([
                'otp' => null,
                'otp_expiry' => null,
                'status' => 'in_progress' // optional, if you want to move workflow forward
            ]);

            // Update all service request products status from 'approved' to 'in_progress'
            ServiceRequestProduct::where('service_requests_id', $id)
                ->where('status', 'processing')
                ->update(['status' => 'in_progress']);

            DB::commit();

            // 8️⃣ Success response
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. Diagnosis can be started.',
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'verified_at' => now()
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Other unexpected errors
            DB::rollBack();

            Log::error('Verify diagnosis OTP failed', [
                'service_request_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify OTP. Please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function caseTransfer(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'engineer_reason' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        // return response()->json(['message' => 'Case transfer API is working.', 'id' => $id, 'request' => $validated], 200);

        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->is_engineer_assigned = 'not_assigned';
        $serviceRequest->status = 'in_transfer';
        $serviceRequest->save();

        // Create case transfer request
        $caseTransferRequest = CaseTransferRequest::create([
            'transfer_id' => 'CTR-' . date('Ymd') . '-' . random_int(100, 999),
            'service_request_id' => $id,
            'requesting_engineer_id' => $validated['user_id'],
            'engineer_reason' => $validated['engineer_reason'],
        ]);

        if (! $caseTransferRequest) {
            return response()->json(['success' => false, 'message' => 'Failed to create case transfer request.'], 500);
        }

        return response()->json(['message' => 'Case transfer request created successfully.'], 200);
    }

    public function rescheduleServiceRequest(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'reschedule_date' => 'required|date',
            'engineer_reason' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->reschedule_date = $validated['reschedule_date'];
        $serviceRequest->save();

        if (!$serviceRequest) {
            return response()->json(['success' => false, 'message' => 'Failed to reschedule service request.'], 500);
        }

        return response()->json(['message' => 'Service request rescheduled successfully.'], 200);
    }

    // public function diagnosisList1(Request $request, $id, $product_id)
    // {
    //     $validated = Validator::make($request->all(), [
    //         'role_id' => 'required|in:1',
    //         'user_id' => 'required|integer|exists:staff,id',
    //     ]);

    //     if ($validated->fails()) {
    //         return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
    //     }

    //     $validated = $validated->validated();

    //     $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
    //         ->where('service_requests_id', $id)
    //         ->where('id', $product_id)
    //         ->first();

    //     $diagnosisList = $serviceRequestProduct->itemCode->diagnosis_list;

    //     return response()->json(['diagnosisList' => $diagnosisList], 200);
    // }

    /**
     * Get diagnosis list with full details for a specific product
     */
    public function diagnosisList(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'engineer') {
            // Verify the service request is assigned to this engineer
            $assignedEngineer = AssignedEngineer::where('service_request_id', $id)
                ->where('engineer_id', $validated['user_id'])
                ->where('status', 'active')
                ->first();

            if (!$assignedEngineer) {
                return response()->json(['success' => false, 'message' => 'Service request not found or not assigned to this engineer.'], 404);
            }

            $serviceRequest = ServiceRequest::find($id);

            // Get the product
            $serviceRequestProduct = ServiceRequestProduct::where('id', $product_id)
                ->where('service_requests_id', $id)
                ->first();

            if (!$serviceRequestProduct) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }

            // Get diagnosis details
            $diagnosisDetails = EngineerDiagnosisDetail::where('service_request_id', $id)
                ->where('service_request_product_id', $product_id)
                ->get();

            if ($diagnosisDetails->isEmpty()) {
                if ($serviceRequest->service_type == 'amc') {
                    // For AMC, if no diagnosis details found, return the diagnosis list from AMC plan instead of item code
                    $amcPlan = $serviceRequest->amcPlan;
                    $diagnosisDetails = [];
                    foreach ($amcPlan->covered_items as $key => $coveredItem) {
                        if ($key > 1) continue;
                        $coveredItemDetails = CoveredItem::where('id', $coveredItem)->first();
                        if ($coveredItemDetails) {
                            $diagnosisDetails[] = $coveredItemDetails->diagnosis_list;
                        }
                    }
                } else {
                    $diagnosisDetails = $serviceRequestProduct->itemCode->diagnosis_list;
                }

                return response()->json([
                    'service_request' => [
                        'id' => $serviceRequest->id,
                        'request_id' => $serviceRequest->request_id,
                        'status' => $serviceRequest->status,
                    ],
                    'product' => [
                        'id' => $serviceRequestProduct->id,
                        'name' => $serviceRequestProduct->name,
                        'status' => $serviceRequestProduct->status,
                        'status_label' => $this->getStatusLabel($serviceRequestProduct->status),
                    ],
                    'diagnosis' => $diagnosisDetails,
                ], 200);
            }

            $diagnoses = [];
            foreach ($diagnosisDetails as $diagnosis) {
                $diagnosisList = json_decode($diagnosis->diagnosis_list, true);

                // Process each diagnosis item
                $processedList = [];
                if ($diagnosisList && is_array($diagnosisList)) {
                    foreach ($diagnosisList as $item) {
                        $itemStatus = $item['status'] ?? '';
                        $itemData = [
                            'name' => $item['name'] ?? 'N/A',
                            'report' => $item['report'] ?? 'N/A',
                            'status' => $itemStatus,
                            'status_label' => $this->getStatusLabel($itemStatus),
                        ];

                        // If status is stock_in_hand or request_part, add part details
                        if (in_array($itemStatus, ['stock_in_hand', 'request_part'])) {
                            $itemData['part_id'] = $item['part_id'] ?? null;
                            $itemData['quantity'] = $item['quantity'] ?? 1;

                            // Get the part request status from service_request_product_request_parts
                            if (isset($item['part_id'])) {
                                $partRequest = ServiceRequestProductRequestPart::where('request_id', $id)
                                    ->where('product_id', $product_id)
                                    ->where('part_id', $item['part_id'])
                                    ->first();
                                $itemData['part_status'] = $partRequest ? $partRequest->status : 'pending';
                            }
                        }

                        $processedList[] = $itemData;
                    }
                }

                $diagnoses[] = [
                    'diagnosis_id' => $diagnosis->id,
                    'assigned_engineer_id' => $diagnosis->assigned_engineer_id,
                    'covered_item_id' => $diagnosis->covered_item_id,
                    'diagnosis_list' => $processedList,
                    'diagnosis_notes' => $diagnosis->diagnosis_notes,
                    'before_photos' => json_decode($diagnosis->before_photos, true),
                    'after_photos' => json_decode($diagnosis->after_photos, true),
                    'completed_at' => $diagnosis->completed_at,
                ];
            }

            return response()->json([
                'service_request' => [
                    'id' => $serviceRequest->id,
                    'request_id' => $serviceRequest->request_id,
                    'status' => $serviceRequest->status,
                ],
                'product' => [
                    'id' => $serviceRequestProduct->id,
                    'name' => $serviceRequestProduct->name,
                    'status' => $serviceRequestProduct->status,
                    'status_label' => $this->getStatusLabel($serviceRequestProduct->status),
                ],
                'diagnosis' => $diagnoses,
            ], 200);
        }
    }

    /**
     * Helper function to get status label
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Pending',
            'working' => 'Working',
            'not_working' => 'Not Working',
            'picking' => 'Picking',
            'picked' => 'Picked',
            'stock_in_hand' => 'Stock In Hand',
            'request_part' => 'Request Part',
            'admin_approved' => 'Admin Approved',
            'admin_rejected' => 'Admin Rejected',
            'customer_approved' => 'Customer Approved',
            'customer_rejected' => 'Customer Rejected',
            'warehouse_approved' => 'Warehouse Approved',
            'warehouse_rejected' => 'Warehouse Rejected',
            'diagnosis_completed' => 'Diagnosis Completed',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    public function submitDiagnosis(Request $request, $service_request_id, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:staff,id',
            'role_id' => 'required|integer|exists:roles,id',
            'diagnosis_notes' => 'nullable|string|max:10000',
            'estimated_cost' => 'nullable|numeric|min:0',
            'diagnosis_status' => 'nullable|in:completed,pending_approval',
            'before_photos' => 'nullable|array',
            'before_photos.*' => 'nullable|file|mimes:jpeg,jpg,png|max:10240',
            'after_photos' => 'nullable|array',
            'after_photos.*' => 'nullable|file|mimes:jpeg,jpg,png|max:10240',
            'diagnosis_list' => 'required|array|min:1|max:10',
            'diagnosis_list.*.name' => 'required|string|max:255',
            'diagnosis_list.*.report' => 'required|string|max:5000',
            'diagnosis_list.*.status' => 'required|in:working,not_working,picking,stock_in_hand,request_part,used',
            'diagnosis_list.*.part_id' => 'required_if:diagnosis_list.*.status,stock_in_hand,request_part',
            'diagnosis_list.*.quantity' => 'required_if:diagnosis_list.*.status,stock_in_hand,request_part',
            'diagnosis_list.*.part_status' => 'nullable|in:pending,admin_approved,admin_rejected,customer_approved,customer_rejected,used,picked,delivered',
            'diagnosis_list.*.images' => 'nullable|array',
            'diagnosis_list.*.images.*' => 'nullable|file|mimes:jpeg,jpg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::find($service_request_id);
            $serviceRequestProduct = ServiceRequestProduct::where('service_requests_id', $service_request_id)
                ->find($product_id);

            if (!$serviceRequestProduct) {
                throw new \Exception('Service request product not found.');
            }

            $assignedEngineer = AssignedEngineer::where('service_request_id', $service_request_id)
                ->where('engineer_id', $request->user_id)
                ->first();

            if (!$assignedEngineer) {
                throw new \Exception('Assigned engineer not found.');
            }

            if ($serviceRequest->service_type != 'amc') {
                $coveredItemId = $serviceRequestProduct->item_code_id;
            } else {
                $coveredItemId = null;
            }

            /** ---------------- Upload Photos ---------------- */
            $beforePhotos = [];
            if ($request->hasFile('before_photos')) {
                foreach ($request->file('before_photos') as $k => $photo) {
                    $beforePhotos[$k] = $photo->storeAs(
                        'diagnosis_photos/before',
                        'before_' . time() . "_$k." . $photo->getClientOriginalExtension(),
                        'public'
                    );
                }
            }

            $afterPhotos = [];
            if ($request->hasFile('after_photos')) {
                foreach ($request->file('after_photos') as $k => $photo) {
                    $afterPhotos[$k] = $photo->storeAs(
                        'diagnosis_photos/after',
                        'after_' . time() . "_$k." . $photo->getClientOriginalExtension(),
                        'public'
                    );
                }
            }

            /** ---------------- Process Diagnosis List ---------------- */
            $diagnosisList = $request->diagnosis_list;
            $allWorking = true;
            $hasPicking = false;
            $hasNotWorking = false;
            $hasStockInHand = false;
            $hasRequestPart = false;

            foreach ($diagnosisList as $i => &$diagnosis) {
                if ($diagnosis['status'] === 'picking') {
                    $hasPicking = true;
                    $allWorking = false;
                } elseif ($diagnosis['status'] === 'not_working') {
                    $hasNotWorking = true;
                    $allWorking = false;
                } elseif ($diagnosis['status'] === 'stock_in_hand') {
                    $hasStockInHand = true;
                    $allWorking = false;
                } elseif ($diagnosis['status'] === 'request_part') {
                    $hasRequestPart = true;
                    $allWorking = false;

                    // Feature 1: Create new record in service_request_product_request_parts when status is request_part
                    if (isset($diagnosis['part_id'])) {
                        $existingRequestPart = ServiceRequestProductRequestPart::where('request_id', $service_request_id)
                            ->where('product_id', $product_id)
                            ->where('part_id', $diagnosis['part_id'])
                            ->where('request_type', 'request_part')
                            ->first();

                        if (!$existingRequestPart) {
                            ServiceRequestProductRequestPart::create([
                                'request_id' => $service_request_id,
                                'product_id' => $product_id,
                                'engineer_id' => $assignedEngineer->engineer_id, // Use assigned_engineer id
                                'part_id' => $diagnosis['part_id'],
                                'requested_quantity' => $diagnosis['quantity'] ?? 1,
                                'request_type' => 'request_part',
                                'status' => 'pending',
                            ]);
                        }
                    }
                } elseif ($diagnosis['status'] === 'used') {
                    // Part is marked as used - this is like completion
                    $allWorking = false;
                } elseif ($diagnosis['status'] !== 'working') {
                    $allWorking = false;
                }

                // Check if part_status is 'used' and update the request part status
                if (isset($diagnosis['part_id']) && isset($diagnosis['part_status']) && $diagnosis['part_status'] === 'used') {
                    $requestPart = ServiceRequestProductRequestPart::where('request_id', $service_request_id)
                        ->where('product_id', $product_id)
                        ->where('part_id', $diagnosis['part_id'])
                        ->first();

                    if ($requestPart) {
                        $requestPart->update([
                            'status' => 'used',
                            'used_at' => now()
                        ]);
                    }
                }

                if (!empty($diagnosis['images'])) {
                    $imgs = [];
                    foreach ($diagnosis['images'] as $j => $img) {
                        $imgs[] = $img->storeAs(
                            'diagnosis_photos/list',
                            'diag_' . time() . "_{$i}_{$j}." . $img->getClientOriginalExtension(),
                            'public'
                        );
                    }
                    $diagnosis['images'] = $imgs;
                }
            }

            /** ---------------- FIND EXISTING DIAGNOSIS ---------------- */
            $existingDiagnosis = EngineerDiagnosisDetail::where([
                'service_request_id' => $service_request_id,
                'service_request_product_id' => $serviceRequestProduct->id,
                'assigned_engineer_id' => $assignedEngineer->id,
                'covered_item_id' => $coveredItemId,
            ])->first();

            $payload = [
                'diagnosis_list' => json_encode($diagnosisList),
                'before_photos' => $beforePhotos ? json_encode($beforePhotos) : null,
                'after_photos' => $afterPhotos ? json_encode($afterPhotos) : null,
                'diagnosis_notes' => $request->diagnosis_notes,
                'estimated_cost' => $request->estimated_cost,
                'diagnosis_status' => $request->diagnosis_status ?? 'submitted',
                'completed_at' => now(),
            ];

            /** ---------------- CREATE OR UPDATE ---------------- */
            if ($existingDiagnosis) {
                $existingDiagnosis->update($payload);
                $diagnosis = $existingDiagnosis;
            } else {
                $diagnosis = EngineerDiagnosisDetail::create(array_merge($payload, [
                    'service_request_id' => $service_request_id,
                    'service_request_product_id' => $serviceRequestProduct->id,
                    'assigned_engineer_id' => $assignedEngineer->id,
                    'covered_item_id' => $coveredItemId ?? 1,
                ]));
            }

            /** ---------------- UPDATE PRODUCT STATUS ---------------- */
            // Determine product status based on diagnosis_list
            if ($hasPicking) {
                $productStatus = 'picking';
            } elseif ($hasNotWorking) {
                $productStatus = 'on_hold';
            } elseif ($hasStockInHand) {
                $productStatus = 'stock_in_hand';
            } elseif ($hasRequestPart) {
                $productStatus = 'request_part';
            } elseif ($allWorking) {
                $productStatus = 'diagnosis_completed';
            } else {
                $productStatus = 'diagnosis_submitted';
            }

            // Update the service request product status
            $serviceRequestProduct->update(['status' => $productStatus]);

            /** ---------------- UPDATE SERVICE REQUEST STATUS BASED ON ALL PRODUCTS ---------------- */
            // Get all products for this service request
            $allProducts = ServiceRequestProduct::where('service_requests_id', $service_request_id)->get();

            // Check if all products are diagnosis_completed
            $allCompleted = $allProducts->every(function ($product) {
                return $product->status === 'diagnosis_completed';
            });

            // Check if any product has picking status
            $anyPicking = $allProducts->contains(function ($product) {
                return $product->status === 'picking';
            });

            // Check if any product has on_hold status
            $anyOnHold = $allProducts->contains(function ($product) {
                return $product->status === 'on_hold';
            });

            // Update service request status based on product statuses
            $newServiceStatus = null;
            if ($allCompleted) {
                $newServiceStatus = 'completed';
            } elseif ($anyPicking) {
                $newServiceStatus = 'picking';
            } elseif ($anyOnHold) {
                $newServiceStatus = 'in_progress';
            }

            if ($newServiceStatus) {
                ServiceRequest::where('id', $service_request_id)
                    ->update(['status' => $newServiceStatus]);
            }

            /** ---------------- CREATE PICKUP RECORD IF STATUS IS PICKING ---------------- */
            if ($productStatus === 'picking') {
                // Get the active assignment for this service request
                $activeAssignment = AssignedEngineer::where('service_request_id', $service_request_id)
                    ->where('status', 'active')
                    ->first();

                if ($activeAssignment) {
                    // Check if pickup record already exists for this product
                    $existingPickup = ServiceRequestProductPickup::where('request_id', $service_request_id)
                        ->where('product_id', $serviceRequestProduct->id)
                        ->first();

                    if (!$existingPickup) {
                        // Extract reason from diagnosis list
                        $reason = '';
                        if (!empty($diagnosisList)) {
                            $reasonParts = [];
                            foreach ($diagnosisList as $item) {
                                if (isset($item['status']) && $item['status'] === 'picking') {
                                    $reasonParts[] = ($item['name'] ?? '') . ': ' . ($item['report'] ?? '');
                                }
                            }
                            $reason = implode('; ', $reasonParts);
                        }

                        ServiceRequestProductPickup::create([
                            'request_id' => $service_request_id,
                            'product_id' => $serviceRequestProduct->id,
                            'engineer_id' => $activeAssignment->id,
                            'reason' => $reason,
                            'assigned_person_type' => null,
                            'assigned_person_id' => null,
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Diagnosis saved successfully',
                'data' => [
                    'diagnosis_id' => $diagnosis->id,
                    'product_status' => $productStatus,
                    'service_request_status' => $newServiceStatus ?? 'unchanged'
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Diagnosis submit failed', [
                'service_request_id' => $service_request_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function stockInHand(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        // $stockInHandProducts = StockInHand::with(['products'])->where('engineer_id', $validated['user_id'])->get();
        $stockInHandProducts = StockInHandProduct::with(['product', 'stockInHand' => function ($query) use ($validated) {
            return $query->where('engineer_id', $validated['user_id']);
        }])->get();

        if (!$stockInHandProducts) {
            return response()->json(['success' => false, 'message' => 'No stock in hand products found.'], 404);
        }

        return response()->json(['stockInHandProducts' => $stockInHandProducts], 200);
    }

    public function requestPart(Request $request, $id, $product_id)
    {
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:1',
            'user_id' => 'required|integer|exists:staff,id',
            'part_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        // TODO: Request part logic 
        // 1. Check if part is in stock 
        // 2. If part is in stock then reduce quantity from stock in hand 
        // 3. If part is not in stock then request from warehouse 
        // 4. Create request part entry 

        return response()->json(['message' => 'Request part API is working.'], 200);
    }
}
