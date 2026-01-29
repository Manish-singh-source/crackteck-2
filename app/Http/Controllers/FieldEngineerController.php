<?php

namespace App\Http\Controllers;

use App\Models\StockInHand;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\AssignedEngineer;
use App\Models\StockInHandProduct;
use App\Models\CaseTransferRequest;
use Illuminate\Support\Facades\File;
use App\Models\ServiceRequestProduct;
use App\Models\EngineerDiagnosisDetail;
use Illuminate\Support\Facades\{Auth, DB, Log, Storage, Validator};

class FieldEngineerController extends Controller
{
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
        $activeAssignment = AssignedEngineer::with(['engineer', 'groupEngineers'])
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
        $serviceRequest->request_date = $validated['reschedule_date'];
        $serviceRequest->save();

        if (!$serviceRequest) {
            return response()->json(['success' => false, 'message' => 'Failed to reschedule service request.'], 500);
        }

        return response()->json(['message' => 'Service request rescheduled successfully.'], 200);
    }

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

        $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
            ->where('service_requests_id', $id)
            ->where('id', $product_id)
            ->first();

        $diagnosisList = $serviceRequestProduct->itemCode->diagnosis_list;

        return response()->json(['diagnosisList' => $diagnosisList], 200);
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
            'diagnosis_list.*.status' => 'required|in:working,not_working',
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

            $coveredItemId = $serviceRequestProduct->item_code_id;

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

            foreach ($diagnosisList as $i => &$diagnosis) {
                if ($diagnosis['status'] !== 'working') {
                    $allWorking = false;
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
                    'covered_item_id' => $coveredItemId,
                ]));
            }

            /** ---------------- UPDATE SERVICE REQUEST STATUS ---------------- */
            if ($allWorking) {
                ServiceRequest::where('id', $service_request_id)
                    ->update(['status' => 'completed']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Diagnosis saved successfully',
                'data' => [
                    'diagnosis_id' => $diagnosis->id,
                    'service_request_status' => $allWorking ? 'completed' : 'pending'
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
