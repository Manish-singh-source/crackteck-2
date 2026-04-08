<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddressDetail;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestProductRequestPart;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        try {
            // Get part requests assigned to this user
            $partRequests = ServiceRequestProductRequestPart::with([
                'serviceRequest.customer',
                'serviceRequestProduct',
                'product',
                'product.brand',
                'engineer',
            ])
                ->where('assigned_person_type', $roleName)
                ->where('assigned_person_id', $request->user_id)
                ->whereIn('status', ['assigned', 'ap_approved', 'picked'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Format the response
            $formattedPartRequests = $partRequests->map(function ($partRequest) {
                // Get customer address details
                $customerAddress = null;
                if ($partRequest->serviceRequest && $partRequest->serviceRequest->customer_address_id) {
                    $address = CustomerAddressDetail::find($partRequest->serviceRequest->customer_address_id);
                    if ($address) {
                        $customerAddress = [
                            'id' => $address->id,
                            'branch_name' => $address->branch_name,
                            'address1' => $address->address1,
                            'address2' => $address->address2,
                            'city' => $address->city,
                            'state' => $address->state,
                            'pincode' => $address->pincode,
                        ];
                    }
                }

                // Get warehouse details
                $warehouseDetails = null;
                if ($partRequest->product && $partRequest->product->warehouse_id) {
                    $warehouse = Warehouse::find($partRequest->product->warehouse_id);
                    if ($warehouse) {
                        $warehouseDetails = [
                            'id' => $warehouse->id,
                            'warehouse_code' => $warehouse->warehouse_code,
                            'name' => $warehouse->name,
                            'address' => $warehouse->address1,
                            'address' => $warehouse->address2,
                            'city' => $warehouse->city,
                            'state' => $warehouse->state,
                            'country' => $warehouse->country,
                            'pincode' => $warehouse->pincode,
                            'contact_person_name' => $warehouse->contact_person_name,
                            'phone_number' => $warehouse->phone_number,
                        ];
                    }
                }

                return [
                    'id' => $partRequest->id,
                    'request_id' => $partRequest->request_id,
                    'product_id' => $partRequest->product_id,
                    'engineer_id' => $partRequest->engineer_id,
                    'part_id' => $partRequest->part_id,
                    'requested_quantity' => $partRequest->requested_quantity,
                    'request_type' => $partRequest->request_type,
                    'assigned_person_type' => $partRequest->assigned_person_type,
                    'assigned_person_id' => $partRequest->assigned_person_id,
                    'status' => $partRequest->status,
                    'created_at' => $partRequest->created_at,
                    'updated_at' => $partRequest->updated_at,
                    'service_request' => $partRequest->serviceRequest ? [
                        'id' => $partRequest->serviceRequest->id,
                        'request_id' => $partRequest->serviceRequest->request_id,
                        'service_type' => $partRequest->serviceRequest->service_type,
                        'customer_id' => $partRequest->serviceRequest->customer_id,
                        'customer_address_id' => $partRequest->serviceRequest->customer_address_id,
                        'status' => $partRequest->serviceRequest->status,
                        'customer' => $partRequest->serviceRequest->customer ? [
                            'id' => $partRequest->serviceRequest->customer->id,
                            'first_name' => $partRequest->serviceRequest->customer->first_name,
                            'last_name' => $partRequest->serviceRequest->customer->last_name,
                            'phone' => $partRequest->serviceRequest->customer->phone,
                            'email' => $partRequest->serviceRequest->customer->email,
                        ] : null,
                    ] : null,
                    'service_request_product' => $partRequest->serviceRequestProduct ? [
                        'id' => $partRequest->serviceRequestProduct->id,
                        'name' => $partRequest->serviceRequestProduct->name,
                        'model_no' => $partRequest->serviceRequestProduct->model_no,
                    ] : null,
                    'product' => $partRequest->product ? [
                        'id' => $partRequest->product->id,
                        'product_name' => $partRequest->product->product_name,
                        'product_image' => $partRequest->product->main_product_image,
                        'sku' => $partRequest->product->sku,
                        'model_no' => $partRequest->product->model_no,
                        'brand_id' => $partRequest->product->brand_id,
                        'brand_name' => $partRequest->product->brand?->name,
                        'warehouse_id' => $partRequest->product->warehouse_id,
                    ] : null,
                    'engineer' => $partRequest->engineer ? [
                        'id' => $partRequest->engineer->id,
                        'first_name' => $partRequest->engineer->first_name,
                        'last_name' => $partRequest->engineer->last_name,
                        'phone' => $partRequest->engineer->phone,
                    ] : null,
                    'customer_address' => $customerAddress,
                    'warehouse' => $warehouseDetails,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Part requests fetched successfully.',
                'data' => $formattedPartRequests,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching part requests: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching part requests.',
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
                'product.brand',
                'engineer',
            ])->find($id);

            if (! $partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.',
                ], 404);
            }

            // Get customer address details
            $customerAddress = null;
            if ($partRequest->serviceRequest && $partRequest->serviceRequest->customer_address_id) {
                $address = CustomerAddressDetail::find($partRequest->serviceRequest->customer_address_id);
                if ($address) {
                    $customerAddress = [
                        'id' => $address->id,
                        'branch_name' => $address->branch_name,
                        'address1' => $address->address1,
                        'address2' => $address->address2,
                        'city' => $address->city,
                        'state' => $address->state,
                        'country' => $address->country,
                        'pincode' => $address->pincode,
                        'is_primary' => $address->is_primary,
                    ];
                }
            }

            // Get warehouse details
            $warehouseDetails = null;
            if ($partRequest->product && $partRequest->product->warehouse_id) {
                $warehouse = Warehouse::find($partRequest->product->warehouse_id);
                if ($warehouse) {
                    $warehouseDetails = [
                        'id' => $warehouse->id,
                        'name' => $warehouse->name,
                        'address' => $warehouse->address,
                        'city' => $warehouse->city,
                        'state' => $warehouse->state,
                        'country' => $warehouse->country,
                        'pincode' => $warehouse->pincode,
                    ];
                }
            }

            // Format the response
            $formattedData = [
                'id' => $partRequest->id,
                'request_id' => $partRequest->request_id,
                'product_id' => $partRequest->product_id,
                'engineer_id' => $partRequest->engineer_id,
                'part_id' => $partRequest->part_id,
                'requested_quantity' => $partRequest->requested_quantity,
                'reason' => $partRequest->reason,
                'request_type' => $partRequest->request_type,
                'assigned_person_type' => $partRequest->assigned_person_type,
                'assigned_person_id' => $partRequest->assigned_person_id,
                'status' => $partRequest->status,
                'otp' => $partRequest->otp,
                'otp_expiry' => $partRequest->otp_expiry,
                'created_at' => $partRequest->created_at,
                'updated_at' => $partRequest->updated_at,
                'service_request' => $partRequest->serviceRequest ? [
                    'id' => $partRequest->serviceRequest->id,
                    'request_id' => $partRequest->serviceRequest->request_id,
                    'service_type' => $partRequest->serviceRequest->service_type,
                    'customer_id' => $partRequest->serviceRequest->customer_id,
                    'customer_address_id' => $partRequest->serviceRequest->customer_address_id,
                    'request_date' => $partRequest->serviceRequest->request_date,
                    'visit_date' => $partRequest->serviceRequest->visit_date,
                    'status' => $partRequest->serviceRequest->status,
                    'customer' => $partRequest->serviceRequest->customer ? [
                        'id' => $partRequest->serviceRequest->customer->id,
                        'customer_code' => $partRequest->serviceRequest->customer->customer_code,
                        'first_name' => $partRequest->serviceRequest->customer->first_name,
                        'last_name' => $partRequest->serviceRequest->customer->last_name,
                        'phone' => $partRequest->serviceRequest->customer->phone,
                        'email' => $partRequest->serviceRequest->customer->email,
                        'customer_type' => $partRequest->serviceRequest->customer->customer_type,
                        'status' => $partRequest->serviceRequest->customer->status,
                    ] : null,
                ] : null,
                'service_request_product' => $partRequest->serviceRequestProduct ? [
                    'id' => $partRequest->serviceRequestProduct->id,
                    'name' => $partRequest->serviceRequestProduct->name,
                    'type' => $partRequest->serviceRequestProduct->type,
                    'model_no' => $partRequest->serviceRequestProduct->model_no,
                    'sku' => $partRequest->serviceRequestProduct->sku,
                    'brand' => $partRequest->serviceRequestProduct->brand,
                    'purchase_date' => $partRequest->serviceRequestProduct->purchase_date,
                ] : null,
                'product' => $partRequest->product ? [
                    'id' => $partRequest->product->id,
                    'product_name' => $partRequest->product->product_name,
                    'product_image' => $partRequest->product->main_product_image,
                    'sku' => $partRequest->product->sku,
                    'model_no' => $partRequest->product->model_no,
                    'brand_id' => $partRequest->product->brand_id,
                    'brand_name' => $partRequest->product->brand?->name,
                    'warehouse_id' => $partRequest->product->warehouse_id,
                    'stock_quantity' => $partRequest->product->stock_quantity,
                    'stock_status' => $partRequest->product->stock_status,
                ] : null,
                'engineer' => $partRequest->engineer ? [
                    'id' => $partRequest->engineer->id,
                    'staff_code' => $partRequest->engineer->staff_code,
                    'first_name' => $partRequest->engineer->first_name,
                    'last_name' => $partRequest->engineer->last_name,
                    'phone' => $partRequest->engineer->phone,
                    'email' => $partRequest->engineer->email,
                ] : null,
                'customer_address' => $customerAddress,
                'warehouse' => $warehouseDetails,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Part request details fetched successfully.',
                'data' => $formattedData,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching part request details: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching part request details.',
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        try {
            // Find the part request
            $partRequest = ServiceRequestProductRequestPart::find($id);

            if (! $partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.',
                ], 404);
            }

            // Verify the user has access to this part request
            if ($partRequest->assigned_person_type !== $roleName ||
                $partRequest->assigned_person_id != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this part request.',
                ], 403);
            }

            // Check if status is 'assigned'
            if ($partRequest->status !== 'assigned') {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request must be in assigned status to accept.',
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
                'data' => $partRequest,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error accepting part request: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the part request.',
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        try {
            // Find the part request with customer details
            $partRequest = ServiceRequestProductRequestPart::with(['serviceRequest.customer'])->find($id);

            if (! $partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.',
                ], 404);
            }

            // Verify the user has access to this part request
            if ($partRequest->assigned_person_type !== $roleName ||
                $partRequest->assigned_person_id != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this part request.',
                ], 403);
            }

            // Check if status is 'picked' - only then can we send OTP
            if ($partRequest->status !== 'picked') {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request must be in picked status to send OTP.',
                ], 400);
            }

            // Check if customer has phone number
            $customer = $partRequest->serviceRequest->customer;
            if (! $customer || ! $customer->phone) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer phone number not found.',
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
                    'otp_expiry' => $partRequest->otp_expiry,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error sending OTP: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending OTP.',
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleName = $this->getRoleId($request->role_id);

        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        try {
            // Find the part request
            $partRequest = ServiceRequestProductRequestPart::find($id);

            if (! $partRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part request not found.',
                ], 404);
            }

            // Verify the user has access to this part request
            if ($partRequest->assigned_person_type !== $roleName ||
                $partRequest->assigned_person_id != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this part request.',
                ], 403);
            }

            // Check if OTP matches
            if ($partRequest->otp !== $request->otp) {
                // Increment OTP attempts
                $partRequest->increment('otp_attempts');

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP.',
                    'attempts' => $partRequest->otp_attempts,
                ], 400);
            }

            // Check if OTP has expired
            if (now()->gt($partRequest->otp_expiry)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.',
                ], 400);
            }

            // Update status to delivered and store delivery time
            $partRequest->update([
                'status' => 'delivered',
                'delivered_at' => now(),
                'otp' => null, // Clear OTP after successful verification
                'otp_expiry' => null,
            ]);

            // Also update the service_request_products status to in_progress
            if ($partRequest->product_id) {
                ServiceRequestProduct::where('id', $partRequest->product_id)->update([
                    'status' => 'in_progress',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. Part delivered.',
                'data' => $partRequest,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error verifying OTP: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP.',
            ], 500);
        }
    }
}
