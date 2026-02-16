<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequestProductRequestPart;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PartRequestController extends Controller
{
    /**
     * Get role name from role_id
     * 1 => engineer, 2 => delivery_man
     */
    private function getRoleId($roleId)
    {
        $roles = [
            1 => 'engineer',
            2 => 'delivery_man',
        ];
        return $roles[$roleId] ?? null;
    }

    /**
     * (1) Get part requests - check if user is delivery man or engineer and return their assigned part requests
     */
    public function getPartRequests(Request $request)
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

        try {
            // Get part requests assigned to this user
            $partRequests = ServiceRequestProductRequestPart::with([
                'serviceRequest.customer',
                'serviceRequestProduct',
                'product',
                'engineer'
            ])
            ->where('assigned_person_type', $roleName)
            ->where('assigned_person_id', $request->user_id)
            ->whereIn('status', ['assigned', 'ap_approved', 'picked'])
            ->orderBy('created_at', 'desc')
            ->get();

            return response()->json([
                'success' => true,
                'message' => 'Part requests fetched successfully.',
                'data' => $partRequests
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching part requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching part requests.'
            ], 500);
        }
    }

    /**
     * (2) Get particular part request details with product details
     */
    public function getPartRequestDetails($id)
    {
        try {
            $partRequest = ServiceRequestProductRequestPart::with([
                'serviceRequest.customer',
                'serviceRequestProduct',
                'product',
                'engineer'
            ])->find($id);

            if (!$partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Part request details fetched successfully.',
                'data' => $partRequest
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching part request details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching part request details.'
            ], 500);
        }
    }

    /**
     * (3) Accept part request - change status to ap_approved and store acceptance time
     */
    public function acceptPartRequest(Request $request, $id)
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

        try {
            // Find the part request
            $partRequest = ServiceRequestProductRequestPart::find($id);

            if (!$partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.'
                ], 404);
            }

            // Verify the user has access to this part request
            if ($partRequest->assigned_person_type !== $roleName || 
                $partRequest->assigned_person_id != $request->user_id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You do not have access to this part request.'
                ], 403);
            }

            // Check if status is 'assigned'
            if ($partRequest->status !== 'assigned') {
                return response()->json([
                    'success' => false, 
                    'message' => 'Part request must be in assigned status to accept.'
                ], 400);
            }

            // Update part request status to ap_approved and store acceptance info
            $partRequest->update([
                'status' => 'ap_approved',
                'assigned_approved_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Part request accepted successfully.',
                'data' => $partRequest
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error accepting part request: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the part request.'
            ], 500);
        }
    }

    /**
     * (4) Send OTP for part delivery - generate OTP with 5 min expiry
     * Only if status is 'picked'
     */
    public function sendPartRequestOtp(Request $request, $id)
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

        try {
            // Find the part request with customer details
            $partRequest = ServiceRequestProductRequestPart::with(['serviceRequest.customer'])->find($id);

            if (!$partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.'
                ], 404);
            }

            // Verify the user has access to this part request
            if ($partRequest->assigned_person_type !== $roleName || 
                $partRequest->assigned_person_id != $request->user_id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You do not have access to this part request.'
                ], 403);
            }

            // Check if status is 'picked' - only then can we send OTP
            if ($partRequest->status !== 'picked') {
                return response()->json([
                    'success' => false, 
                    'message' => 'Part request must be in picked status to send OTP.'
                ], 400);
            }

            // Check if customer has phone number
            $customer = $partRequest->serviceRequest->customer;
            if (!$customer || !$customer->phone) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Customer phone number not found.'
                ], 400);
            }

            // Generate 4-digit OTP
            $otp = rand(1000, 9999);
            
            // Update part request with OTP and expiry (5 minutes)
            $partRequest->update([
                'otp' => $otp,
                'otp_expiry' => now()->addMinutes(5),
            ]);

            // TODO: Send SMS to customer with OTP
            // For now, we'll just return success - you can integrate with SMS service here
            // Example: SmsService::send($customer->phone, "Your OTP is: $otp");

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to customer.',
                'data' => [
                    'otp_sent_to' => $customer->phone,
                    'otp' => $otp,
                    'otp_expiry' => $partRequest->otp_expiry
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error sending OTP: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending OTP.'
            ], 500);
        }
    }

    /**
     * (5) Verify OTP and change status to 'delivered'
     */
    public function verifyPartRequestOtp(Request $request, $id)
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

        try {
            // Find the part request
            $partRequest = ServiceRequestProductRequestPart::find($id);

            if (!$partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.'
                ], 404);
            }

            // Verify the user has access to this part request
            if ($partRequest->assigned_person_type !== $roleName || 
                $partRequest->assigned_person_id != $request->user_id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You do not have access to this part request.'
                ], 403);
            }

            // Check if OTP matches
            if ($partRequest->otp !== $request->otp) {
                // Increment OTP attempts
                $partRequest->increment('otp_attempts');
                
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid OTP.',
                    'attempts' => $partRequest->otp_attempts
                ], 400);
            }

            // Check if OTP has expired
            if (now()->gt($partRequest->otp_expiry)) {
                return response()->json([
                    'success' => false, 
                    'message' => 'OTP has expired. Please request a new OTP.'
                ], 400);
            }

            // Update status to delivered and store delivery time
            $partRequest->update([
                'status' => 'delivered',
                'delivered_at' => now(),
                'otp' => null, // Clear OTP after successful verification
                'otp_expiry' => null
            ]);

            // Also update the service_request_products status to in_progress
            if ($partRequest->product_id) {
                ServiceRequestProduct::where('id', $partRequest->product_id)->update([
                    'status' => 'in_progress'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. Part delivered.',
                'data' => $partRequest
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error verifying OTP: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP.'
            ], 500);
        }
    }
}
