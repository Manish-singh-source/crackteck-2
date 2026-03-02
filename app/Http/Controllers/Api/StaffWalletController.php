<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffWalletController extends Controller
{
    /**
     * Get expense details for engineer or delivery man.
     * 
     * GET /api/v1/staff-expenses
     * 
     * @param Request $request
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
                'errors' => $validator->errors()
            ], 422);
        }

        $staffId = $request->user_id;

        // Get staff details
        $staff = Staff::find($staffId);

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found'
            ], 404);
        }

        // Get staff_type from staff_role in staff table
        $staffType = $staff->staff_role;

        // Get all expense submissions for this staff
        $expenses = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($expense) {
                if ($expense->receipt) {
                    $expense->receipt_url = url('api/v1/receipts/' . basename($expense->receipt));
                }
                return $expense;
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
            'message' => 'Expense details retrieved successfully',
            'data' => [
                'staff' => [
                    'id' => $staff->id,
                    'name' => $staff->first_name . ' ' . $staff->last_name,
                    'staff_code' => $staff->staff_code,
                    'staff_role' => $staff->staff_role,
                    'phone' => $staff->phone,
                    'email' => $staff->email,
                ],
                'expenses' => $expenses,
                'summary' => [
                    'total_pending' => $totalPending,
                    'total_approved' => $totalApproved,
                    'total_rejected' => $totalRejected,
                    'total_payed' => $totalPayed,
                ]
            ]
        ], 200);
    }

    /**
     * Submit expense form for engineer or delivery man.
     * 
     * POST /api/v1/staff-expenses
     * 
     * @param Request $request
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
                'errors' => $validator->errors()
            ], 422);
        }

        $staffId = $request->user_id;

        // Verify staff exists and get staff details
        $staff = Staff::find($staffId);

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found'
            ], 404);
        }

        // Get staff_type from staff_role in staff table automatically
        $staffType = $staff->staff_role;

        // Validate that staff_type is valid (engineer or delivery_man)
        $validStaffTypes = ['engineer', 'delivery_man'];
        if (!in_array($staffType, $validStaffTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid staff role. Only engineer or delivery_man can submit expenses.'
            ], 422);
        }

        // Handle receipt file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receipt = $request->file('receipt');
            $receiptName = time() . '_' . $receipt->getClientOriginalName();
            $receipt->move(public_path('public/receipts'), $receiptName);
            $receiptPath = 'receipts/' . $receiptName;
        }

        // Create new expense entry with auto-determined staff_type
        $expense = StaffWallet::create([
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
            'message' => 'Expense submitted successfully',
            'data' => [
                'id' => $expense->id,
                'staff_type' => $expense->staff_type,
                'staff_id' => $expense->staff_id,
                'amount' => $expense->amount,
                'reason' => $expense->reason,
                'receipt' => $expense->receipt,
                'receipt_url' => $receiptUrl,
                'status' => $expense->status,
                'created_at' => $expense->created_at,
            ]
        ], 201);
    }

    /**
     * Get single expense details.
     * 
     * GET /api/v1/staff-expenses/{id}
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $expense = StaffWallet::with('staff')->find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found'
            ], 404);
        }

        // Build receipt URL if exists
        $receiptUrl = null;
        if ($expense->receipt) {
            $receiptUrl = url('api/v1/receipts/' . basename($expense->receipt));
        }

        $expenseData = $expense->toArray();
        $expenseData['receipt_url'] = $receiptUrl;

        return response()->json([
            'success' => true,
            'message' => 'Expense details retrieved successfully',
            'data' => $expenseData
        ], 200);
    }

    /**
     * Get expense history for a specific staff.
     * 
     * GET /api/v1/staff-expenses/history
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'status' => 'nullable|string|in:pending,admin_approved,admin_rejected,paid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $staffId = $request->user_id;

        // Get staff details
        $staff = Staff::find($staffId);

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found'
            ], 404);
        }

        // Get staff_type from staff_role in staff table automatically
        $staffType = $staff->staff_role;

        $query = StaffWallet::where('staff_id', $staffId)
            ->where('staff_type', $staffType);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $expenses = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Expense history retrieved successfully',
            'data' => $expenses
        ], 200);
    }

    /**
     * Update expense status.
     * 
     * PUT /api/v1/staff-expenses/{id}/status
     * 
     * @param Request $request
     * @param int $id
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
                'errors' => $validator->errors()
            ], 422);
        }

        $expense = StaffWallet::find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found'
            ], 404);
        }

        $expense->status = $request->status;
        $expense->save();

        return response()->json([
            'success' => true,
            'message' => 'Expense status updated successfully',
            'data' => [
                'id' => $expense->id,
                'status' => $expense->status,
            ]
        ], 200);
    }
}
