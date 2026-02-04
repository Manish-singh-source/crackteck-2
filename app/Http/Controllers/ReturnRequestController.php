<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\ServiceRequestProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReturnRequestController extends Controller
{
    /**
     * Helper method to get role name from role_id
     */
    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    /**
     * (1) Get return requests based on user_id and role
     * Check if user is delivery man or engineer and return their assigned return requests
     */
    public function getReturnRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (!$roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Verify user exists
        $user = Staff::where('id', $request->user_id)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Get return requests assigned to this user based on role
        $returnRequests = ServiceRequestProductReturn::with([
            'serviceRequest',
            'serviceRequestProduct',
            'serviceRequest.customer',
            'serviceRequestProduct.serviceRequest',
            'assignedPerson',
        ])
            ->where('assigned_person_type', $roleName)
            ->where('assigned_person_id', $request->user_id)
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Return requests retrieved successfully.',
            'return_requests' => $returnRequests,
            'user' => [
                'id' => $user->id,
                'name' => $user->name ?? $user->first_name,
                'role' => $roleName
            ]
        ], 200);
    }

    /**
     * (2) Get particular return request details with product information
     */
    public function getReturnRequestDetails(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (!$roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the return request
        $returnRequest = ServiceRequestProductReturn::with([
            'serviceRequest',
            'serviceRequestProduct',
            'serviceRequest.customer',
            // 'serviceRequestProduct.product',
            'assignedPerson',
            'pickup',
        ])->find($id);

        if (!$returnRequest) {
            return response()->json(['success' => false, 'message' => 'Return request not found.'], 404);
        }

        // Verify the user has access to this return request
        if ($returnRequest->assigned_person_type !== $roleName || 
            $returnRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this return request.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Return request details retrieved successfully.',
            'return_request' => $returnRequest
        ], 200);
    }

    /**
     * (3) Accept return request - change status to 'accepted'
     */
    public function acceptReturnRequest(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (!$roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the return request
        $returnRequest = ServiceRequestProductReturn::find($id);

        if (!$returnRequest) {
            return response()->json(['success' => false, 'message' => 'Return request not found.'], 404);
        }

        // Verify the user has access to this return request
        if ($returnRequest->assigned_person_type !== $roleName || 
            $returnRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this return request.'
            ], 403);
        }

        // Check if already accepted
        if ($returnRequest->status === 'accepted') {
            return response()->json([
                'success' => false, 
                'message' => 'Return request is already accepted.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Update the return request status to 'accepted'
            $returnRequest->status = 'accepted';
            $returnRequest->accepted_at = now();
            $returnRequest->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Return request accepted successfully.',
                'return_request' => $returnRequest
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error accepting return request: ' . $e->getMessage(), [
                'return_request_id' => $id,
                'user_id' => $request->user_id,
                'role_id' => $request->role_id,
                'exception' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the return request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * (4) Send OTP for return - generate OTP with 5 min expiry
     * Only send OTP if status is 'picked'
     */
    public function sendReturnOtp(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (!$roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the return request
        $returnRequest = ServiceRequestProductReturn::with(['serviceRequest.customer'])->find($id);

        if (!$returnRequest) {
            return response()->json(['success' => false, 'message' => 'Return request not found.'], 404);
        }

        // Verify the user has access to this return request
        if ($returnRequest->assigned_person_type !== $roleName || 
            $returnRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this return request.'
            ], 403);
        }

        // Check if status is 'picked' - only then can OTP be sent
        if ($returnRequest->status !== 'picked') {
            return response()->json([
                'success' => false, 
                'message' => 'Return request must be in "picked" status before sending OTP.'
            ], 400);
        }

        try {
            // Generate 4-digit OTP
            $otp = rand(1000, 9999);
            
            // Update return request with OTP and expiry (5 minutes)
            $returnRequest->otp = $otp;
            $returnRequest->otp_expiry = now()->addMinutes(5);
            $returnRequest->save();

            // Get customer phone number for SMS
            $customer = $returnRequest->serviceRequest->customer;
            
            if ($customer && $customer->phone) {
                // Log OTP for debugging (in production, send via SMS)
                Log::info('Return OTP generated', [
                    'return_id' => $id,
                    'otp' => $otp,
                    'customer_phone' => $customer->phone
                ]);

                // TODO: Send OTP via SMS service (Fast2SMS, etc.)
                // $this->sendSms($customer->phone, $otp);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'otp' => $otp,
                'otp_expires_in_seconds' => 300 // 5 minutes
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error sending return OTP: ' . $e->getMessage(), [
                'return_request_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending OTP: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * (5) Verify OTP and change status to 'delivered'
     */
    public function verifyReturnOtp(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (!$roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the return request
        $returnRequest = ServiceRequestProductReturn::find($id);

        if (!$returnRequest) {
            return response()->json(['success' => false, 'message' => 'Return request not found.'], 404);
        }

        // Verify the user has access to this return request
        if ($returnRequest->assigned_person_type !== $roleName || 
            $returnRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this return request.'
            ], 403);
        }

        // Check if OTP matches
        if ($returnRequest->otp !== $request->otp) {
            return response()->json([
                'success' => false, 
                'message' => 'Invalid OTP.'
            ], 400);
        }

        // Check if OTP has expired
        if (now()->gt($returnRequest->otp_expiry)) {
            return response()->json([
                'success' => false, 
                'message' => 'OTP has expired. Please request a new OTP.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Clear OTP and expiry, update status to 'delivered'
            $returnRequest->otp = null;
            $returnRequest->otp_expiry = null;
            $returnRequest->status = 'delivered';
            $returnRequest->delivered_at = now();
            $returnRequest->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. Return status updated to delivered.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error verifying return OTP: ' . $e->getMessage(), [
                'return_request_id' => $id,
                'user_id' => $request->user_id,
                'role_id' => $request->role_id,
                'exception' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP: ' . $e->getMessage()
            ], 500);
        }
    }
}
