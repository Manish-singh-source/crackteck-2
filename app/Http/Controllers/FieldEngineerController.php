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

        return response()->json(['message' => 'Service request accepted successfully.'], 200);
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

    public function submitDiagnosis(Request $request, $service_request_id, $user_id)
    {
        // Validation aligned with docs + your diagnosis_list
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:staff,id', // Or users,id per docs
            'role_id' => 'required|integer|exists:roles,id', // Generic per docs
            'diagnosis_notes' => 'nullable|string|max:10000',
            'estimated_cost' => 'nullable|numeric|min:0',
            'diagnosis_status' => 'nullable|in:completed,pending_approval',
            'before_photos' => 'nullable|array',
            'before_photos.*' => 'nullable|file|mimes:jpeg,jpg,png|max:10240',
            'after_photos' => 'nullable|array',
            'after_photos.*' => 'nullable|file|mimes:jpeg,jpg,png|max:10240',
            'diagnosis_list' => 'nullable|array|max:10',
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

        // Verify user matches path param and auth
        if (Auth::id() != $user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized user ID'], 403);
        }

        DB::beginTransaction();
        try {
            // Fetch service request product (adjust relation/query as needed; docs lack product_id)
            $serviceRequestProduct = ServiceRequestProduct::with(['itemCode'])
                ->where('service_requests_id', $service_request_id)
                ->first(); // Or add product filter if multi-products

            if (!$serviceRequestProduct) {
                throw new \Exception('Service request product not found.');
            }

            $coveredItemId = $serviceRequestProduct->item_code_id;
            if (!$coveredItemId) {
                throw new \Exception('Covered item not found.');
            }

            // Upload before photos (keys: top, bottom, etc.)
            $beforePhotos = [];
            if ($request->hasFile('before_photos')) {
                foreach ($request->file('before_photos') as $angle => $photo) {
                    if ($photo) {
                        $fileName = 'before_' . $service_request_id . '_' . $user_id . '_' . $angle . '_' . time() . '.' . $photo->getClientOriginalExtension();
                        $path = $photo->storeAs('diagnosis_photos/before', $fileName, 'public');
                        $beforePhotos[$angle] = $path;
                    }
                }
            }

            // Upload after photos
            $afterPhotos = [];
            if ($request->hasFile('after_photos')) {
                foreach ($request->file('after_photos') as $angle => $photo) {
                    if ($photo) {
                        $fileName = 'after_' . $service_request_id . '_' . $user_id . '_' . $angle . '_' . time() . '.' . $photo->getClientOriginalExtension();
                        $path = $photo->storeAs('diagnosis_photos/after', $fileName, 'public');
                        $afterPhotos[$angle] = $path;
                    }
                }
            }

            // Process diagnosis_list images (fix: use storeAs, ensure array)
            $diagnosisList = $request->diagnosis_list ?? [];
            foreach ($diagnosisList as $key => &$diagnosis) {
                if (!empty($diagnosis['images'])) {
                    $images = is_array($diagnosis['images']) ? $diagnosis['images'] : [$diagnosis['images']];
                    $diagnosisImages = [];
                    foreach ($images as $imgIndex => $photo) {
                        if ($photo instanceof \Illuminate\Http\UploadedFile) {
                            $fileName = 'diag_' . $service_request_id . '_' . $key . '_' . $imgIndex . '_' . time() . '.' . $photo->getClientOriginalExtension();
                            $path = $photo->storeAs('diagnosis_photos/list', $fileName, 'public');
                            $diagnosisImages[$imgIndex] = $path;
                        }
                    }
                    $diagnosis['images'] = $diagnosisImages;
                }
            }

            // Create diagnosis
            $diagnosis = EngineerDiagnosisDetail::create([
                'service_request_id' => $service_request_id,
                'service_request_product_id' => $serviceRequestProduct->id,
                'assigned_engineer_id' => $user_id,
                'covered_item_id' => $coveredItemId,
                'diagnosis_list' => json_encode($diagnosisList),
                'before_photos' => !empty($beforePhotos) ? json_encode($beforePhotos) : null,
                'after_photos' => !empty($afterPhotos) ? json_encode($afterPhotos) : null,
                'diagnosis_notes' => $request->diagnosis_notes,
                'estimated_cost' => $request->estimated_cost,
                'diagnosis_status' => $request->diagnosis_status ?? 'submitted',
                'completed_at' => now(),
            ]);

            DB::commit();

            // Activity log
            activity()
                ->performedOn($diagnosis)
                ->causedBy(Auth::user())
                ->log('Diagnosis submitted for service request #' . $service_request_id);

            return response()->json([
                'success' => true,
                'message' => 'Diagnosis submitted successfully',
                'data' => [
                    'diagnosis_id' => $diagnosis->id,
                    'service_request_id' => $service_request_id,
                    'submitted_by' => $user_id,
                    'submitted_at' => $diagnosis->completed_at,
                    'status' => $diagnosis->diagnosis_status ?? 'submitted'
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Diagnosis submission failed: ' . $e->getMessage(), [
                'service_request_id' => $service_request_id,
                'user_id' => $user_id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit diagnosis: ' . $e->getMessage()
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
