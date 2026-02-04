<?php

namespace App\Http\Controllers;

use App\Helpers\StatusUpdateHelper;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\ServiceRequestProductPickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PickupRequestController extends Controller
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
     * Helper method to get user model by role
     */
    // protected function getUserByRole($roleName, $userId)
    // {
    //     return match ($roleName) {
    //         'engineer' => Engineer::find($userId),
    //         'delivery_man' => DeliveryMan::find($userId),
    //         'sales_person' => SalesPerson::find($userId),
    //         'customers' => Customer::find($userId),
    //         default => null,
    //     };
    // }

    /**
     * (1) Get pickup requests based on user_id and role
     * Check if user is delivery man or engineer and return their assigned pickup requests
     */
    public function getPickupRequests(Request $request)
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
        $user = Staff::where('id' , $request->user_id)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Get pickup requests assigned to this user based on role
        $pickupRequests = ServiceRequestProductPickup::with([
            'serviceRequest',
            'serviceRequestProduct',
            'serviceRequest.customer',
            'serviceRequestProduct.serviceRequest',
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
            'message' => 'Pickup requests retrieved successfully.',
            'pickup_requests' => $pickupRequests,
            'user' => [
                'id' => $user->id,
                'name' => $user->name ?? $user->first_name,
                'role' => $roleName
            ]
        ], 200);
    }

    /**
     * (2) Get particular pickup request details with product information
     */
    public function getPickupRequestDetails(Request $request, $id)
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

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::with([
            'serviceRequest',
            'serviceRequestProduct',
            'serviceRequest.customer',
            'assignedPerson',
        ])->find($id);

        if (!$pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if ($pickupRequest->assigned_person_type !== $roleName || 
            $pickupRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this pickup request.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pickup request details retrieved successfully.',
            'pickup_request' => $pickupRequest
        ], 200);
    }

    /**
     * (3) Accept pickup request - change status to 'approved' for all products in same service
     */
    public function acceptPickupRequest(Request $request, $id)
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

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::find($id);

        if (!$pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if ($pickupRequest->assigned_person_type !== $roleName || 
            $pickupRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this pickup request.'
            ], 403);
        }

        // Check if already accepted/approved
        if ($pickupRequest->status === 'approved') {
            return response()->json([
                'success' => false, 
                'message' => 'Pickup request is already approved.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Get the service_request_id from this pickup request
            $serviceRequestId = $pickupRequest->request_id;

            // Update all pickup requests with the same service_request_id to 'approved'
            $updatedCount = ServiceRequestProductPickup::where('request_id', $serviceRequestId)
                ->update([
                    'status' => 'approved',
                    'approved_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pickup request accepted successfully. All products for this service have been approved.',
                'approved_count' => $updatedCount
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error accepting pickup request: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the pickup request.'
            ], 500);
        }
    }

    /**
     * (4) Send OTP for pickup - generate OTP with 5 min expiry
     */
    public function sendPickupOtp(Request $request, $id)
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

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::with(['serviceRequest.customer'])->find($id);

        if (!$pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if ($pickupRequest->assigned_person_type !== $roleName || 
            $pickupRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this pickup request.'
            ], 403);
        }

        // Check if status is approved
        if ($pickupRequest->status !== 'approved') {
            return response()->json([
                'success' => false, 
                'message' => 'Pickup request must be approved before sending OTP.'
            ], 400);
        }

        try {
            // Generate 4-digit OTP
            $otp = rand(1000, 9999);
            
            // Update pickup request with OTP and expiry (5 minutes)
            $pickupRequest->update([
                'otp' => $otp,
                'otp_expiry' => now()->addMinutes(5)
            ]);

            // Get customer phone number for SMS
            $customer = $pickupRequest->serviceRequest->customer;
            
            if ($customer && $customer->phone) {
                // Log OTP for debugging (in production, send via SMS)
                Log::info('Pickup OTP generated', [
                    'pickup_id' => $id,
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
            Log::error('Error sending pickup OTP: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending OTP.'
            ], 500);
        }
    }

    /**
     * (5) Verify OTP and change status to 'picked'
     */
    public function verifyPickupOtp(Request $request, $id)
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

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::find($id);

        if (!$pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if ($pickupRequest->assigned_person_type !== $roleName || 
            $pickupRequest->assigned_person_id != $request->user_id) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have access to this pickup request.'
            ], 403);
        }

        // Check if OTP matches
        if ($pickupRequest->otp !== $request->otp) {
            return response()->json([
                'success' => false, 
                'message' => 'Invalid OTP.'
            ], 400);
        }

        // Check if OTP has expired
        if (now()->gt($pickupRequest->otp_expiry)) {
            return response()->json([
                'success' => false, 
                'message' => 'OTP has expired. Please request a new OTP.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Clear OTP and expiry, update status to 'picked'
            $pickupRequest->update([
                'otp' => null,
                'otp_expiry' => null,
                'status' => 'picked',
                'picked_at' => now()
            ]);

            // Check and update service request status based on return/pickup/product conditions
            StatusUpdateHelper::checkAllStatusConditions($pickupRequest->request_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. Pickup status updated to picked.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error verifying pickup OTP: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP.'
            ], 500);
        }
    }

    /**
     * Web-based index method (existing)
     */
    public function index()
    {
        $status = request()->get('status', 'all');
        
        $query = ServiceRequestProductPickup::with([
            'serviceRequestProduct',
            'serviceRequest',
            'assignedPerson',
            'assignedEngineer.engineer'
        ])->whereHas('serviceRequest');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $pickups = $query->orderBy('created_at', 'desc')->get();

        return view('/crm/pickup-requests/index', compact('pickups'));
    }

    /**
     * Web-based view method (existing)
     */
    public function view($id)
    {
        $pickup = ServiceRequestProductPickup::with([
            'serviceRequestProduct',
            'serviceRequest.customer',
            'assignedPerson',
            'assignedEngineer.engineer'
        ])->findOrFail($id);

        return view('/crm/pickup-requests/view', compact('pickup'));
    }
}
