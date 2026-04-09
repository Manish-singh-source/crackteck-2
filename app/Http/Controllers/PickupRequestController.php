<?php

namespace App\Http\Controllers;

use App\Helpers\StatusUpdateHelper;
use App\Models\Customer;
use App\Models\CustomerAddressDetail;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\ServiceRequestProductPickup;
use App\Models\ServiceRequestProductRequestPart;
use App\Models\Staff;
use App\Models\Warehouse;
use App\Services\Fast2smsService;
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Verify user exists
        $user = Staff::where('id', $request->user_id)->first();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Get pickup requests assigned to this user based on role
        $pickupRequests = ServiceRequestProductPickup::with([
            'serviceRequest',
            'serviceRequest.addressDetail',
            'serviceRequestProduct',
            'serviceRequestProduct.requestedParts.product',
            'serviceRequestProduct.requestedParts.product.brand',
            'serviceRequest.customer',
        ])
            ->where('assigned_person_type', $roleName)
            ->where('assigned_person_id', $request->user_id)
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Format the response to include product details with warehouse_id
        $formattedPickupRequests = $pickupRequests->map(function ($pickup) {
            $productDetails = null;
            $warehouseDetails = null;

            if ($pickup->serviceRequestProduct && $pickup->serviceRequestProduct->requestedParts->isNotEmpty()) {
                $requestedPart = $pickup->serviceRequestProduct->requestedParts->first();
                if ($requestedPart && $requestedPart->product) {
                    $productDetails = [
                        'part_id' => $requestedPart->part_id,
                        'product_name' => $requestedPart->product->product_name,
                        'sku' => $requestedPart->product->sku,
                        'model_no' => $requestedPart->product->model_no,
                        'brand_id' => $requestedPart->product->brand_id,
                        'brand_name' => $requestedPart->product->brand?->name,
                        'warehouse_id' => $requestedPart->product->warehouse_id,
                    ];

                    // Get warehouse details if warehouse_id exists
                    if ($requestedPart->product->warehouse_id) {
                        $warehouse = Warehouse::find($requestedPart->product->warehouse_id);
                        if ($warehouse) {
                            $warehouseDetails = [
                                'id' => $warehouse->id,
                                'name' => $warehouse->name,
                                'address' => $warehouse->address1 ?? $warehouse->address2 ?? null,
                                'city' => $warehouse->city ?? null,
                                'state' => $warehouse->state ?? null,
                            ];
                        }
                    }
                }
            }

            // If no warehouse details found, get the primary/default warehouse
            if (!$warehouseDetails) {
                $primaryWarehouse = Warehouse::where('default_warehouse', 'yes')->first();
                if ($primaryWarehouse) {
                    $warehouseDetails = [
                        'id' => $primaryWarehouse->id,
                        'name' => $primaryWarehouse->name,
                        'address' => $primaryWarehouse->address1 ?? $primaryWarehouse->address2 ?? null,
                        'city' => $primaryWarehouse->city ?? null,
                        'state' => $primaryWarehouse->state ?? null,
                        'is_primary' => true,
                    ];
                }
            }

            $customerAddress = null;
            if ($pickup->serviceRequest && $pickup->serviceRequest->customer_address_id) {
                $address = CustomerAddressDetail::find($pickup->serviceRequest->customer_address_id);
                if ($address) {
                    $customerAddress = [
                        'id' => $address->id,
                        'address1' => $address->address1,
                        'address2' => $address->address2,
                        'city' => $address->city,
                        'state' => $address->state,
                        'country' => $address->country,
                        'pincode' => $address->pincode,
                        'branch_name' => $address->branch_name,
                    ];
                }
            }

            return [
                'id' => $pickup->id,
                'request_id' => $pickup->request_id,
                'product_id' => $pickup->product_id,
                'status' => $pickup->status,
                'created_at' => $pickup->created_at,
                'updated_at' => $pickup->updated_at,
                'product_details' => $productDetails,
                'warehouse_details' => $warehouseDetails,
                'customer_address' => $customerAddress,
                'service_request' => $pickup->serviceRequest ? [
                    'id' => $pickup->serviceRequest->id,
                    'request_id' => $pickup->serviceRequest->request_id,
                    'service_type' => $pickup->serviceRequest->service_type,
                    'customer_address_id' => $pickup->serviceRequest->customer_address_id,
                    'status' => $pickup->serviceRequest->status,
                ] : null,
                'service_request_product' => $pickup->serviceRequestProduct ? [
                    'id' => $pickup->serviceRequestProduct->id,
                    'name' => $pickup->serviceRequestProduct->name,
                    'model_no' => $pickup->serviceRequestProduct->model_no,
                ] : null,
                'customer' => $pickup->serviceRequest?->customer ? [
                    'id' => $pickup->serviceRequest->customer->id,
                    'name' => $pickup->serviceRequest->customer->first_name . ' ' . $pickup->serviceRequest->customer->last_name,
                    'phone' => $pickup->serviceRequest->customer->phone,
                    'email' => $pickup->serviceRequest->customer->email,
                ] : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Pickup requests retrieved successfully.',
            'pickup_requests' => $formattedPickupRequests,
            'user' => [
                'id' => $user->id,
                'name' => $user->name ?? $user->first_name,
                'role' => $roleName,
            ],
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::with([
            'serviceRequest',
            'serviceRequest.addressDetail',
            'serviceRequestProduct',
            'serviceRequestProduct.requestedParts.product',
            'serviceRequestProduct.requestedParts.product.brand',
            'serviceRequest.customer',
            'assignedPerson',
        ])->find($id);

        if (! $pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if (
            $pickupRequest->assigned_person_type !== $roleName ||
            $pickupRequest->assigned_person_id != $request->user_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this pickup request.',
            ], 403);
        }

        // Format the response to include product details with warehouse_id
        $productDetails = null;
        $warehouseDetails = null;

        if ($pickupRequest->serviceRequestProduct && $pickupRequest->serviceRequestProduct->requestedParts->isNotEmpty()) {
            $requestedPart = $pickupRequest->serviceRequestProduct->requestedParts->first();
            if ($requestedPart && $requestedPart->product) {
                $productDetails = [
                    'part_id' => $requestedPart->part_id,
                    'product_name' => $requestedPart->product->product_name,
                    'sku' => $requestedPart->product->sku,
                    'model_no' => $requestedPart->product->model_no,
                    'brand_id' => $requestedPart->product->brand_id,
                    'brand_name' => $requestedPart->product->brand?->name,
                    'warehouse_id' => $requestedPart->product->warehouse_id,
                    'mac_address' => $requestedPart->product->mac_address,
                ];

                // Get warehouse details if warehouse_id exists
                if ($requestedPart->product->warehouse_id) {
                    $warehouse = Warehouse::find($requestedPart->product->warehouse_id);
                    if ($warehouse) {
                        $warehouseDetails = [
                            'id' => $warehouse->id,
                            'name' => $warehouse->name,
                            'address' => $warehouse->address1 ?? $warehouse->address2 ?? null,
                            'city' => $warehouse->city ?? null,
                            'state' => $warehouse->state ?? null,
                        ];
                    }
                }
            }
        }

        // If no warehouse details found, get the primary/default warehouse
        if (!$warehouseDetails) {
            $primaryWarehouse = Warehouse::where('default_warehouse', 'yes')->first();
            if ($primaryWarehouse) {
                $warehouseDetails = [
                    'id' => $primaryWarehouse->id,
                    'name' => $primaryWarehouse->name,
                    'address' => $primaryWarehouse->address1 ?? $primaryWarehouse->address2 ?? null,
                    'city' => $primaryWarehouse->city ?? null,
                    'state' => $primaryWarehouse->state ?? null,
                    'is_primary' => true,
                ];
            }
        }

        $customerAddress = null;
        if ($pickupRequest->serviceRequest && $pickupRequest->serviceRequest->customer_address_id) {
            $address = CustomerAddressDetail::find($pickupRequest->serviceRequest->customer_address_id);
            if ($address) {
                $customerAddress = [
                    'id' => $address->id,
                    'address1' => $address->address1,
                    'address2' => $address->address2,
                    'city' => $address->city,
                    'state' => $address->state,
                    'country' => $address->country,
                    'pincode' => $address->pincode,
                    'branch_name' => $address->branch_name,
                ];
            }
        }

        $formattedPickupRequest = [
            'id' => $pickupRequest->id,
            'request_id' => $pickupRequest->request_id,
            'product_id' => $pickupRequest->product_id,
            'engineer_id' => $pickupRequest->engineer_id,
            'reason' => $pickupRequest->reason,
            'assigned_person_type' => $pickupRequest->assigned_person_type,
            'assigned_person_id' => $pickupRequest->assigned_person_id,
            'status' => $pickupRequest->status,
            'otp' => $pickupRequest->otp,
            'otp_expiry' => $pickupRequest->otp_expiry,
            'created_at' => $pickupRequest->created_at,
            'updated_at' => $pickupRequest->updated_at,
            'assigned_at' => $pickupRequest->assigned_at,
            'approved_at' => $pickupRequest->approved_at,
            'picked_at' => $pickupRequest->picked_at,
            'product_details' => $productDetails,
            'warehouse_details' => $warehouseDetails,
            'customer_address' => $customerAddress,
            'service_request' => $pickupRequest->serviceRequest ? [
                'id' => $pickupRequest->serviceRequest->id,
                'request_id' => $pickupRequest->serviceRequest->request_id,
                'service_type' => $pickupRequest->serviceRequest->service_type,
                'customer_id' => $pickupRequest->serviceRequest->customer_id,
                'customer_address_id' => $pickupRequest->serviceRequest->customer_address_id,
                'request_date' => $pickupRequest->serviceRequest->request_date,
                'visit_date' => $pickupRequest->serviceRequest->visit_date,
                'status' => $pickupRequest->serviceRequest->status,
            ] : null,
            'service_request_product' => $pickupRequest->serviceRequestProduct ? [
                'id' => $pickupRequest->serviceRequestProduct->id,
                'name' => $pickupRequest->serviceRequestProduct->name,
                'type' => $pickupRequest->serviceRequestProduct->type,
                'model_no' => $pickupRequest->serviceRequestProduct->model_no,
                'sku' => $pickupRequest->serviceRequestProduct->sku,
                'brand' => $pickupRequest->serviceRequestProduct->brand,
                'mac_address' => $pickupRequest->serviceRequestProduct->mac_address,
            ] : null,
            'customer' => $pickupRequest->serviceRequest?->customer ? [
                'id' => $pickupRequest->serviceRequest->customer->id,
                'first_name' => $pickupRequest->serviceRequest->customer->first_name,
                'last_name' => $pickupRequest->serviceRequest->customer->last_name,
                'name' => $pickupRequest->serviceRequest->customer->first_name . ' ' . $pickupRequest->serviceRequest->customer->last_name,
                'phone' => $pickupRequest->serviceRequest->customer->phone,
                'email' => $pickupRequest->serviceRequest->customer->email,
            ] : null,
            'assigned_person' => $pickupRequest->assignedPerson ? [
                'id' => $pickupRequest->assignedPerson->id,
                'name' => $pickupRequest->assignedPerson->name ?? $pickupRequest->assignedPerson->first_name,
            ] : null,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Pickup request details retrieved successfully.',
            'pickup_request' => $formattedPickupRequest,
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::find($id);

        if (! $pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if (
            $pickupRequest->assigned_person_type !== $roleName ||
            $pickupRequest->assigned_person_id != $request->user_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this pickup request.',
            ], 403);
        }

        // Check if already accepted/approved
        if ($pickupRequest->status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Pickup request is already approved.',
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
                    'approved_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pickup request accepted successfully. All products for this service have been approved.',
                'approved_count' => $updatedCount,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error accepting pickup request: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the pickup request.',
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::with(['serviceRequest.customer'])->find($id);

        if (! $pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if (
            $pickupRequest->assigned_person_type !== $roleName ||
            $pickupRequest->assigned_person_id != $request->user_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this pickup request.',
            ], 403);
        }

        // Check if status is approved
        if ($pickupRequest->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Pickup request must be approved before sending OTP.',
            ], 400);
        }

        try {
            // Check if OTP already sent and still valid
            if ($pickupRequest->otp && $pickupRequest->otp_expiry && now()->lt($pickupRequest->otp_expiry)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP already sent and is still valid. Please wait before retrying.',
                ], 400);
            }

            // Generate 4-digit OTP
            $otp = rand(1000, 9999);

            // Get customer phone number for SMS
            $customer = $pickupRequest->serviceRequest->customer;
            $customerPhone = $customer->phone ?? null;
            $smsSent = false;

            if ($customerPhone) {
                try {
                    $smsService = new Fast2smsService();
                    $smsResponse = $smsService->sendOtp($customerPhone, $otp);
                    $smsSent = $smsResponse['success'] ?? false;

                    Log::info('Pickup OTP SMS sent to customer', [
                        'pickup_id' => $id,
                        'customer_phone' => $customerPhone,
                        'sms_success' => $smsSent,
                    ]);
                } catch (\Exception $smsException) {
                    Log::error('Failed to send pickup OTP SMS', [
                        'pickup_id' => $id,
                        'error' => $smsException->getMessage(),
                    ]);
                }
            }

            // Update pickup request with OTP and expiry (5 minutes)
            $pickupRequest->update([
                'otp' => $otp,
                'otp_expiry' => now()->addMinutes(5),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'otp' => $otp,
                'otp_expiry' => $pickupRequest->otp_expiry,
                'sms_sent' => $smsSent,
                'customer_phone' => $customerPhone,
                'otp_expires_in_seconds' => 300,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error sending pickup OTP: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending OTP.',
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        // Find the pickup request
        $pickupRequest = ServiceRequestProductPickup::find($id);

        if (! $pickupRequest) {
            return response()->json(['success' => false, 'message' => 'Pickup request not found.'], 404);
        }

        // Verify the user has access to this pickup request
        if (
            $pickupRequest->assigned_person_type !== $roleName ||
            $pickupRequest->assigned_person_id != $request->user_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this pickup request.',
            ], 403);
        }

        // Check if OTP matches
        if ($pickupRequest->otp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
        }

        // Check if OTP has expired
        if (now()->gt($pickupRequest->otp_expiry)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new OTP.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Clear OTP and expiry, update status to 'picked'
            $pickupRequest->update([
                'otp' => null,
                'otp_expiry' => null,
                'status' => 'picked',
                'picked_at' => now(),
            ]);

            // Check and update service request status based on return/pickup/product conditions
            StatusUpdateHelper::checkAllStatusConditions($pickupRequest->request_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. Pickup status updated to picked.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error verifying pickup OTP: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP.',
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
            'assignedEngineer.engineer',
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
            'assignedEngineer.engineer',
        ])->findOrFail($id);

        return view('/crm/pickup-requests/view', compact('pickup'));
    }
}
