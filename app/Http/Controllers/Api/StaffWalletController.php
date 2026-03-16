<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffWalletController extends Controller
{
    /**
     * Get reimbursements details for engineer or delivery man.
     *
     * GET /api/v1/staff-reimbursements
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staffId = $request->user_id;

        // Get staff details
        $staff = Staff::find($staffId);

        if (! $staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found',
            ], 404);
        }

        // Get staff_type from staff_role in staff table
        $staffType = $staff->staff_role;

        // Get all reimbursements submissions for this staff
        $reimbursements = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($reimbursements) {
                if ($reimbursements->receipt) {
                    $reimbursements->receipt_url = url('api/v1/receipts/' . basename($reimbursements->receipt));
                }

                return $reimbursements;
            });

        // Calculate totals
        $totalPending = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType)
            ->where('status', 'pending')
            ->sum('amount');

        $totalApproved = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType)
            ->where('status', 'admin_approved')
            ->sum('amount');

        $totalRejected = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType)
            ->where('status', 'admin_rejected')
            ->sum('amount');

        $totalPayed = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType)
            ->where('status', 'paid')
            ->sum('amount');

        return response()->json([
            'success' => true,
            'message' => 'Reimbursements details retrieved successfully',
            'data' => [
                'staff' => [
                    'id' => $staff->id,
                    'name' => $staff->first_name . ' ' . $staff->last_name,
                    'staff_code' => $staff->staff_code,
                    'staff_role' => $staff->staff_role,
                    'phone' => $staff->phone,
                    'email' => $staff->email,
                ],
                'reimbursements' => $reimbursements,
                'summary' => [
                    'total_pending' => $totalPending,
                    'total_approved' => $totalApproved,
                    'total_rejected' => $totalRejected,
                    'total_payed' => $totalPayed,
                ],
            ],
        ], 200);
    }

    /**
     * Submit reimbursements form for engineer or delivery man.
     *
     * POST /api/v1/staff-reimbursements
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staffId = $request->user_id;

        // Verify staff exists and get staff details
        $staff = Staff::find($staffId);

        if (! $staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found',
            ], 404);
        }

        // Get staff_type from staff_role in staff table automatically
        $staffType = $staff->staff_role;

        // Validate that staff_type is valid (engineer or delivery_man)
        $validStaffTypes = ['engineer', 'delivery_man'];
        if (! in_array($staffType, $validStaffTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid staff role. Only engineer or delivery_man can submit reimbursements.',
            ], 422);
        }

        // Handle receipt file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = FileUpload::fileUpload($request->file('receipt'), 'receipts/');
        }

        // Create new reimbursements entry with auto-determined staff_type
        $reimbursements = StaffWallet::create([
            'staff_type' => $staffType,
            'staff_id' => $staffId,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'receipt' => $receiptPath,
            'status' => 'pending', // Default status
        ]);

        // Build receipt URL if exists
        $receiptUrl = null;
        if ($receiptPath) {
            $receiptUrl = url('api/v1/receipts/' . basename($receiptPath));
        }

        return response()->json([
            'success' => true,
            'message' => 'Reimbursements submitted successfully',
            'data' => [
                'id' => $reimbursements->id,
                'staff_type' => $reimbursements->staff_type,
                'staff_id' => $reimbursements->staff_id,
                'amount' => $reimbursements->amount,
                'reason' => $reimbursements->reason,
                'receipt' => $reimbursements->receipt,
                'receipt_url' => $receiptUrl,
                'status' => $reimbursements->status,
                'created_at' => $reimbursements->created_at,
            ],
        ], 201);
    }

    /**
     * Get single reimbursements details.
     *
     * GET /api/v1/staff-reimbursements/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $reimbursements = StaffWallet::with('staff')->find($id);

        if (! $reimbursements) {
            return response()->json([
                'success' => false,
                'message' => 'reimbursements not found',
            ], 404);
        }

        // Build receipt URL if exists
        $receiptUrl = null;
        if ($reimbursements->receipt) {
            $receiptUrl = url('api/v1/receipts/' . basename($reimbursements->receipt));
        }

        $reimbursementsData = $reimbursements->toArray();
        $reimbursementsData['receipt_url'] = $receiptUrl;

        return response()->json([
            'success' => true,
            'message' => 'reimbursements details retrieved successfully',
            'data' => $reimbursementsData,
        ], 200);
    }

    /**
     * Get reimbursements history for a specific staff.
     *
     * GET /api/v1/staff-reimbursements/history
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'status' => 'nullable|string|in:admin_rejected,paid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staffId = $request->user_id;

        // Get staff details
        $staff = Staff::find($staffId);

        if (! $staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found',
            ], 404);
        }

        // Get staff_type from staff_role in staff table automatically
        $staffType = $staff->staff_role;

        $query = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }else {
            $query->whereIn('status', ['admin_rejected', 'paid']);
        }

        $reimbursements = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Reimbursements history retrieved successfully',
            'data' => $reimbursements,
        ], 200);
    }

    /**
     * Update reimbursements status.
     *
     * PUT /api/v1/staff-reimbursements/{id}/status
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,admin_approved,admin_rejected,paid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $reimbursements = StaffWallet::find($id);

        if (! $reimbursements) {
            return response()->json([
                'success' => false,
                'message' => 'Reimbursements not found',
            ], 404);
        }

        $reimbursements->status = $request->status;
        $reimbursements->save();

        return response()->json([
            'success' => true,
            'message' => 'Reimbursements status updated successfully',
            'data' => [
                'id' => $reimbursements->id,
                'status' => $reimbursements->status,
            ],
        ], 200);
    }
}
