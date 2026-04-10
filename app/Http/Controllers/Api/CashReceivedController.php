<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashReceivedRequest;
use App\Models\CashReceived;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ServiceRequest;
use App\Models\Staff;
use App\Models\AssignedEngineer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * API Controller for Cash Received from Customer
 * 
 * This controller handles the API endpoint where staff members
 * (Delivery Man / Engineer) submit cash collection entries.
 */
class CashReceivedController extends Controller
{
    /**
     * Store a newly created cash received entry.
     *
     * Staff can submit cash collection with either:
     * - order_id (for Order cash collection)
     * - service_request_id (for Service Request cash collection)
     *
     * customer_id, staff_id, and amount will be derived from the 
     * order/service request if not provided directly.
     *
     * @param StoreCashReceivedRequest $request
     * @return JsonResponse
     */
    public function store(StoreCashReceivedRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $orderId = $request->input('order_id');
            $serviceRequestId = $request->input('service_request_id');
            $customerId = $request->input('customer_id');
            $staffId = $request->input('staff_id');
            $amount = $request->input('amount');

            // If order_id is provided, derive customer, staff, amount from order table
            if ($orderId) {
                $order = Order::find($orderId);
                
                if (!$order) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Order not found.',
                    ], 404);
                }

                // Derive customer_id from orders table
                $customerId = $customerId ?? $order->customer_id;
                
                // Derive staff_id from orders.assigned_person_id (any assigned person)
                if (!$staffId && $order->assigned_person_id) {
                    $staffId = $order->assigned_person_id;
                }
                
                // Derive amount from order_payments table (pending payment)
                if (!$amount) {
                    $orderPayment = \App\Models\OrderPayment::where('order_id', $orderId)
                        ->where('status', '!=', 'completed')
                        ->first();
                    $amount = $orderPayment ? $orderPayment->amount : $order->total_amount;
                }
            }

            // If service_request_id is provided, derive customer, staff, amount from service_requests and assigned_engineers tables
            if ($serviceRequestId) {
                $serviceRequest = ServiceRequest::find($serviceRequestId);
                
                if (!$serviceRequest) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Service request not found.',
                    ], 404);
                }

                // Derive customer_id from service_requests table
                $customerId = $customerId ?? $serviceRequest->customer_id;
                
                // Derive staff_id from assigned_engineers table
                if (!$staffId) {
                    $assignedEngineer = AssignedEngineer::where('service_request_id', $serviceRequestId)
                        ->first();
                    $staffId = $assignedEngineer ? $assignedEngineer->engineer_id : null;
                }
                
                // Derive amount from service_request_payments table (pending payment)
                if (!$amount) {
                    $servicePayment = \App\Models\ServiceRequestPayment::where('service_request_id', $serviceRequestId)
                        ->where('payment_status', '!=', 'completed')
                        ->first();
                    $amount = $servicePayment ? $servicePayment->total_amount : 0;
                }
            }

            // Validate that we have all required data
            if (!$customerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer ID is required. Could not derive from order/service request.',
                ], 422);
            }

            if (!$staffId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff ID is required. Could not derive from order/service request.',
                ], 422);
            }

            if (!$amount || $amount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amount is required and must be greater than 0. Could not derive from order/service request.',
                ], 422);
            }

            // Create the cash received entry
            $cashReceived = CashReceived::create([
                'customer_id' => $customerId,
                'staff_id' => $staffId,
                'order_id' => $orderId,
                'service_request_id' => $serviceRequestId,
                'amount' => $amount,
                'status' => $request->input('status', CashReceived::STATUS_CUSTOMER_PAID),
            ]);

            // Update payment status when staff receives cash
            if ($orderId) {
                // For Order: Update order payment_status to completed
                $order = Order::find($orderId);
                if ($order) {
                    $order->payment_status = 'completed';
                    $order->save();
                }
            }

            if ($serviceRequestId) {
                // For Service Request: Update service_request_payments
                $servicePayment = \App\Models\ServiceRequestPayment::where('service_request_id', $serviceRequestId)
                    ->where('payment_status', '!=', 'completed')
                    ->first();
                if ($servicePayment) {
                    $servicePayment->payment_method = 'COD';
                    $servicePayment->payment_status = 'completed';
                    $servicePayment->save();
                }
            }

            // Reload relationships for response
            $cashReceived->load([
                'customer',
                'staff',
                'order.customer',
                'order.billingAddress',
                'order.shippingAddress',
                'order.orderItems.product',
                'serviceRequest'
            ]);

            DB::commit();

            $orderData = null;
            if ($cashReceived->order) {
                $orderData = [
                    'id' => $cashReceived->order->id,
                    'order_number' => $cashReceived->order->order_number,
                    'total_amount' => (float) $cashReceived->order->total_amount,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Cash received entry created successfully',
                'data' => [
                    'id' => $cashReceived->id,
                    'customer_id' => $cashReceived->customer_id,
                    'customer_name' => $cashReceived->customer ? ($cashReceived->customer->first_name . ' ' . $cashReceived->customer->last_name) : null,
                    'staff_id' => $cashReceived->staff_id,
                    'staff_name' => $cashReceived->staff ? ($cashReceived->staff->first_name . ' ' . $cashReceived->staff->last_name) : null,
                    'order_id' => $cashReceived->order_id,
                    'order' => $orderData,
                    'service_request_id' => $cashReceived->service_request_id,
                    'amount' => (float) $cashReceived->amount,
                    'status' => $cashReceived->status,
                    'created_at' => $cashReceived->created_at->toISOString(),
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CashReceived store error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * Display a listing of all cash received entries.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = CashReceived::with([
                'customer',
                'staff',
                'order.customer',
                'order.billingAddress',
                'order.shippingAddress',
                'order.orderItems.product',
                'serviceRequest'
            ]);

            // Apply filters
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->has('staff_id') && $request->staff_id) {
                $query->where('staff_id', $request->staff_id);
            }

            if ($request->has('customer_id') && $request->customer_id) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->has('start_date') && $request->start_date) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }

            if ($request->has('end_date') && $request->end_date) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }

            $perPage = $request->input('per_page', 15);
            $cashReceivedList = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $cashReceivedList->map(function ($cash) {
                    $orderData = null;
                    if ($cash->order) {
                        $orderData = [
                            'id' => $cash->order->id,
                            'order_number' => $cash->order->order_number,
                            'customer_id' => $cash->order->customer_id,
                            'customer_name' => $cash->order->customer ? ($cash->order->customer->first_name . ' ' . $cash->order->customer->last_name) : null,
                            'total_items' => $cash->order->total_items,
                            'subtotal' => (float) $cash->order->subtotal,
                            'discount_amount' => (float) $cash->order->discount_amount,
                            'tax_amount' => (float) $cash->order->tax_amount,
                            'shipping_charges' => (float) $cash->order->shipping_charges,
                            'packaging_charges' => (float) $cash->order->packaging_charges,
                            'total_amount' => (float) $cash->order->total_amount,
                            'order_status' => $cash->order->order_status,
                            'payment_status' => $cash->order->payment_status,
                            // 'billing_address' => $cash->order->billingAddress ? [
                            //     'id' => $cash->order->billingAddress->id,
                            //     'address' => $cash->order->billingAddress->address,
                            //     'city' => $cash->order->billingAddress->city,
                            //     'state' => $cash->order->billingAddress->state,
                            //     'pincode' => $cash->order->billingAddress->pincode,
                            // ] : null,
                            // 'shipping_address' => $cash->order->shippingAddress ? [
                            //     'id' => $cash->order->shippingAddress->id,
                            //     'address' => $cash->order->shippingAddress->address,
                            //     'city' => $cash->order->shippingAddress->city,
                            //     'state' => $cash->order->shippingAddress->state,
                            //     'pincode' => $cash->order->shippingAddress->pincode,
                            // ] : null,
                            // 'order_items' => $cash->order->orderItems->map(function ($item) {
                            //     return [
                            //         'id' => $item->id,
                            //         'product_id' => $item->product_id,
                            //         'product_name' => $item->product?->name,
                            //         'variant_details' => $item->variant_details,
                            //         'quantity' => $item->quantity,
                            //         'unit_price' => (float) $item->unit_price,
                            //         'line_total' => (float) $item->line_total,
                            //     ];
                            // }),
                            'created_at' => $cash->order->created_at->toISOString(),
                        ];
                    }

                    return [
                        'id' => $cash->id,
                        'customer_id' => $cash->customer_id,
                        'customer_name' => $cash->customer ? ($cash->customer->first_name . ' ' . $cash->customer->last_name) : null,
                        'staff_id' => $cash->staff_id,
                        'staff_name' => $cash->staff ? ($cash->staff->first_name . ' ' . $cash->staff->last_name) : null,
                        'staff_role' => $cash->staff?->staff_role,
                        'order_id' => $cash->order_id,
                        'order' => $orderData,
                        'service_request_id' => $cash->service_request_id,
                        'type' => $cash->order_id ? 'Order' : 'Service Request',
                        'amount' => (float) $cash->amount,
                        'status' => $cash->status,
                        'created_at' => $cash->created_at->toISOString(),
                    ];
                }),
                'pagination' => [
                    'current_page' => $cashReceivedList->currentPage(),
                    'last_page' => $cashReceivedList->lastPage(),
                    'per_page' => $cashReceivedList->perPage(),
                    'total' => $cashReceivedList->total(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('CashReceived index error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching data.',
            ], 500);
        }
    }

    /**
     * Display the specified cash received entry.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $cashReceived = CashReceived::with([
                'customer',
                'staff',
                'order.customer',
                'order.billingAddress',
                'order.shippingAddress',
                'order.orderItems.product',
                'serviceRequest'
            ])->find($id);

            if (!$cashReceived) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cash received entry not found.',
                ], 404);
            }

            $orderData = null;
            if ($cashReceived->order) {
                $orderData = [
                    'id' => $cashReceived->order->id,
                    'order_number' => $cashReceived->order->order_number,
                    'customer_id' => $cashReceived->order->customer_id,
                    'customer_name' => $cashReceived->order->customer ? ($cashReceived->order->customer->first_name . ' ' . $cashReceived->order->customer->last_name) : null,
                    'total_items' => $cashReceived->order->total_items,
                    'subtotal' => (float) $cashReceived->order->subtotal,
                    'discount_amount' => (float) $cashReceived->order->discount_amount,
                    'coupon_code' => $cashReceived->order->coupon_code,
                    'tax_amount' => (float) $cashReceived->order->tax_amount,
                    'shipping_charges' => (float) $cashReceived->order->shipping_charges,
                    'packaging_charges' => (float) $cashReceived->order->packaging_charges,
                    'total_amount' => (float) $cashReceived->order->total_amount,
                    'order_status' => $cashReceived->order->order_status,
                    'payment_status' => $cashReceived->order->payment_status,
                    'delivery_status' => $cashReceived->order->delivery_status,
                    // 'billing_address' => $cashReceived->order->billingAddress ? [
                    //     'id' => $cashReceived->order->billingAddress->id,
                    //     'address' => $cashReceived->order->billingAddress->address,
                    //     'city' => $cashReceived->order->billingAddress->city,
                    //     'state' => $cashReceived->order->billingAddress->state,
                    //     'pincode' => $cashReceived->order->billingAddress->pincode,
                    // ] : null,
                    // 'shipping_address' => $cashReceived->order->shippingAddress ? [
                    //     'id' => $cashReceived->order->shippingAddress->id,
                    //     'address' => $cashReceived->order->shippingAddress->address,
                    //     'city' => $cashReceived->order->shippingAddress->city,
                    //     'state' => $cashReceived->order->shippingAddress->state,
                    //     'pincode' => $cashReceived->order->shippingAddress->pincode,
                    // ] : null,
                    // 'order_items' => $cashReceived->order->orderItems->map(function ($item) {
                    //     return [
                    //         'id' => $item->id,
                    //         'product_id' => $item->product_id,
                    //         'product_name' => $item->product?->name,
                    //         'variant_details' => $item->variant_details,
                    //         'quantity' => $item->quantity,
                    //         'unit_price' => (float) $item->unit_price,
                    //         'line_total' => (float) $item->line_total,
                    //     ];
                    // }),
                    'expected_delivery_date' => $cashReceived->order->expected_delivery_date?->toISOString(),
                    'created_at' => $cashReceived->order->created_at->toISOString(),
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $cashReceived->id,
                    'customer' => [
                        'id' => $cashReceived->customer?->id,
                        'name' => $cashReceived->customer ? ($cashReceived->customer->first_name . ' ' . $cashReceived->customer->last_name) : null,
                        'email' => $cashReceived->customer?->email,
                        'phone' => $cashReceived->customer?->phone,
                    ],
                    'staff' => [
                        'id' => $cashReceived->staff?->id,
                        'name' => $cashReceived->staff ? ($cashReceived->staff->first_name . ' ' . $cashReceived->staff->last_name) : null,
                        'role' => $cashReceived->staff?->staff_role,
                    ],
                    'order_id' => $cashReceived->order_id,
                    'order' => $orderData,
                    'service_request_id' => $cashReceived->service_request_id,
                    'type' => $cashReceived->order_id ? 'Order' : 'Service Request',
                    'amount' => (float) $cashReceived->amount,
                    'status' => $cashReceived->status,
                    'created_at' => $cashReceived->created_at->toISOString(),
                    'updated_at' => $cashReceived->updated_at->toISOString(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('CashReceived show error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching data.',
            ], 500);
        }
    }
}