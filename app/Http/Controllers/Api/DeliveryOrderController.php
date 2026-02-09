<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\DmAadharDetails;
use App\Models\DmDrivingLicenseDetails;
use App\Models\DmPanCardDetails;
use App\Models\Order;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\VehicalRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeliveryOrderController extends Controller
{
    //

    // protected function getModelByRoleId($roleId)
    // {
    //     return [
    //         1 => Engineer::class,
    //         2 => DeliveryMan::class,
    //         3 => SalesPerson::class,
    //         4 => Customer::class,
    //     ][$roleId] ?? null;
    // }

    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function sendDltSms($phoneNumbers, $templateId, $variablesValues)
    {
        $apiKey = env('FAST2SMS_API_KEY');
        $senderId = env('FAST2SMS_SENDER_ID');

        $payload = [
            'route' => 'dlt',
            'sender_id' => $senderId,
            'message' => $templateId, // Template ID (numeric)
            'variables_values' => $variablesValues, // OTP value
            'flash' => 0,
            'numbers' => is_array($phoneNumbers) ? implode(',', $phoneNumbers) : $phoneNumbers,
        ];

        try {
            $response = Http::withHeaders([
                'authorization' => $apiKey,
            ])->asForm()->post('https://www.fast2sms.com/dev/bulkV2', $payload);

            // Log the response for debugging
            Log::info('Fast2SMS Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                return $responseData['return'] ?? false;
            }

            Log::error('Fast2SMS Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Fast2SMS Exception: '.$e->getMessage());

            return false;
        }
    }

    public function acceptOrder(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $order = Order::where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($order->assigned_person_id != $request->user_id) {
                return response()->json(['message' => 'Order already accepted by another delivery man'], 400);
            }

            $order->update(['status' => 'order_accepted', 'accepted_at' => now()]);
            $order->save();

            return response()->json(['message' => 'Order accepted successfully'], 200);
        }
    }

    public function allOrders(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }
        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $orders = Order::with(['orderItems'])->where('assigned_person_id', $request->user_id);
            if ($request->filled('status')) {
                $orders->where('status', $request->status);
            }
            $orders = $orders->get();

            return response()->json(['orders' => $orders], 200);
        }
    }

    public function orderDetails(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $order = Order::with(['orderItems'])->where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            return response()->json(['order' => $order], 200);
        }
    }

    public function updateOrderProfile(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/orders/profile'), $filename);
                $request->merge(['profile' => 'uploads/e-commerce/orders/profile/'.$filename]);
            }

            $order = Order::where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
            $order->profile = $filename;
            $order->save();

            return response()->json(['message' => 'Order updated successfully'], 200);
        }
    }

    public function updateOrderOtp(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $order = Order::where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $otp = rand(1000, 9999);
            $order->otp = $otp;
            $order->otp_expiry = now()->addMinutes(5);
            $order->save();

            if (! $order) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user = Customer::where('id', $order->customer_id)->first();

            if (! $user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Send OTP via Fast2SMS DLT
            // $templateId = env('FAST2SMS_TEMPLATE_ID'); 

            // $success = $this->sendDltSms(
            //     $user->phone,           // Phone number
            //     $templateId,            // Template ID (191040)
            //     $otp                    // OTP value to replace {#var#}
            // );

            // if (! $success) {
            //     return response()->json(['message' => 'Failed to send OTP'], 500);
            // }

            return response()->json(['message' => 'OTP sent successfully', 'Otp' => $otp], 200);
        }
    }

    public function verifyOrderOtp(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'otp' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $order = Order::where('id', $order_id)->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($order->otp != $request->otp) {
                return response()->json(['message' => 'Invalid OTP'], 400);
            }

            if (now()->gt($order->otp_expiry)) {
                return response()->json(['message' => 'OTP expired'], 400);
            }

            $order->otp = null;
            $order->otp_expiry = null;
            $order->status = 'delivered';
            $order->delivered_at = now();
            $order->save();

            return response()->json(['message' => 'OTP verified successfully'], 200);
        }
    }

    public function deliveredOrderDetails(Request $request, $order_id)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $order = Order::where('id', $order_id)->where('status', 'delivered')->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            return response()->json(['order' => $order], 200);
        }
    }

    public function getVehicleDetails(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $vehicleDetails = VehicalRegistration::where('delivery_man_id', $request->user_id)->first();

            if (! $vehicleDetails) {
                return response()->json(['message' => 'Vehicle details not found'], 404);
            }

            return response()->json(['vehicle_details' => $vehicleDetails], 200);
        }
    }

    public function vehicleRegistration(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'brand' => 'required|string',
            'model' => 'required|string',
            'vehicle_number' => 'required|string',
            'fuel_type' => 'required|string',
            'license_document_back_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'license_document_front_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            if ($request->hasFile('license_document_front_path')) {
                $file = $request->file('license_document_front_path');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/vehicles'), $filename);
                $request->merge(['license_document_front_path' => 'uploads/e-commerce/delivery/vehicles/'.$filename]);
            }

            if ($request->hasFile('license_document_back_path')) {
                $file = $request->file('license_document_back_path');
                $filename = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/vehicles'), $filename);
                $request->merge(['license_document_back_path' => 'uploads/e-commerce/delivery/vehicles/'.$filename]);
            }

            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();
            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }

            $vehicalRegistration = new VehicalRegistration;
            $vehicalRegistration->delivery_man_id = $request->user_id;
            $vehicalRegistration->brand = $request->brand;
            $vehicalRegistration->model = $request->model;
            $vehicalRegistration->vehical_no = $request->vehicle_number;
            $vehicalRegistration->fuel_type = $request->fuel_type;
            if ($request->hasFile('license_document_front_path')) {
                $vehicalRegistration->license_document_front_path = $request->license_document_front_path;
            }
            if ($request->hasFile('license_document_back_path')) {
                $vehicalRegistration->license_document_back_path = $request->license_document_back_path;
            }
            $vehicalRegistration->created_by = $request->user_id;
            $vehicalRegistration->save();

            return response()->json(['message' => 'Vehicle registered successfully'], 200);
        }
    }

    public function updateVehicleRegistration(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'brand' => 'required|string',
            'model' => 'required|string',
            'vehicle_number' => 'required|string',
            'fuel_type' => 'required|string',
            'license_document_back_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'license_document_front_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $vehicalRegistration = VehicalRegistration::where('delivery_man_id', $request->user_id)->first();
            if (! $vehicalRegistration) {
                return response()->json(['message' => 'Vehicle registration not found'], 404);
            }

            $vehicalRegistration->brand = $request->brand;
            $vehicalRegistration->model = $request->model;
            $vehicalRegistration->vehical_no = $request->vehicle_number;
            $vehicalRegistration->fuel_type = $request->fuel_type;

            if ($request->hasFile('license_document_front_path')) {
                $file = $request->file('license_document_front_path');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/vehicles'), $filename);
                $vehicalRegistration->license_document_front_path = 'uploads/e-commerce/delivery/vehicles/'.$filename;
            }

            if ($request->hasFile('license_document_back_path')) {
                $file = $request->file('license_document_back_path');
                $filename = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/vehicles'), $filename);
                $vehicalRegistration->license_document_back_path = 'uploads/e-commerce/delivery/vehicles/'.$filename;
            }

            $vehicalRegistration->save();

            return response()->json(['message' => 'Vehicle registration updated successfully'], 200);
        }
    }

    public function getAadharDetails(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();

            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }

            $aadharDetails = DmAadharDetails::where('delivery_man_id', $request->user_id)->first();

            if (! $aadharDetails) {
                return response()->json(['message' => 'Aadhar details not found'], 404);
            }

            return response()->json(['aadhar_details' => $aadharDetails], 200);
        }
    }

    public function storeAadhar(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'aadhar_number' => 'required|string',
            'aadhar_front_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'aadhar_back_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            if ($request->hasFile('aadhar_front_path')) {
                $file = $request->file('aadhar_front_path');
                $frontFile = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/aadhar'), $frontFile);
                $request->merge(['aadhar_front_path' => 'uploads/e-commerce/delivery/aadhar/'.$frontFile]);
            }

            if ($request->hasFile('aadhar_back_path')) {
                $file = $request->file('aadhar_back_path');
                $backFile = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/aadhar'), $backFile);
                $request->merge(['aadhar_back_path' => 'uploads/e-commerce/delivery/aadhar/'.$backFile]);
            }

            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();
            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }

            $aadharDetails = new DmAadharDetails;
            $aadharDetails->delivery_man_id = $request->user_id;
            $aadharDetails->aadhar_number = $request->aadhar_number;
            $aadharDetails->aadhar_front_path = 'uploads/e-commerce/delivery/aadhar/'.$frontFile;
            $aadharDetails->aadhar_back_path = 'uploads/e-commerce/delivery/aadhar/'.$backFile;
            $aadharDetails->created_by = $request->user_id;
            $aadharDetails->save();

            return response()->json(['message' => 'Aadhar details added successfully'], 200);
        }
    }

    public function updateAadhar(Request $request)
    {
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'aadhar_number' => 'required|string',
            'aadhar_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $aadharDetails = DmAadharDetails::where('delivery_man_id', $request->user_id)->first();
            if (! $aadharDetails) {
                return response()->json(['message' => 'Aadhar details not found'], 404);
            }

            $aadharDetails->aadhar_number = $request->aadhar_number;

            if ($request->hasFile('aadhar_front_path')) {
                $file = $request->file('aadhar_front_path');
                $frontFile = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/aadhar'), $frontFile);
                $aadharDetails->aadhar_front_path = 'uploads/e-commerce/delivery/aadhar/'.$frontFile;
            }

            if ($request->hasFile('aadhar_back_path')) {
                $file = $request->file('aadhar_back_path');
                $backFile = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/aadhar'), $backFile);
                $aadharDetails->aadhar_back_path = 'uploads/e-commerce/delivery/aadhar/'.$backFile;
            }

            $aadharDetails->save();

            return response()->json(['message' => 'Aadhar details updated successfully'], 200);
        }
    }

    public function getPanCardDetails(Request $request)
    {

        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();

            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }

            $panCardDetails = DmPanCardDetails::where('delivery_man_id', $request->user_id)->first();

            if (! $panCardDetails) {
                return response()->json(['message' => 'PAN card details not found'], 404);
            }

            return response()->json(['pan_card_details' => $panCardDetails], 200);
        }
    }

    public function storePanCard(Request $request)
    {

        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'pan_number' => 'required|string',
            'pan_card_front_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'pan_card_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'delivery_man') {
            if ($request->hasFile('pan_card_front_path')) {
                $file = $request->file('pan_card_front_path');
                $panFrontFile = time().'_front.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/pan'), $panFrontFile);
                $request->merge(['pan_card_front_path' => 'uploads/e-commerce/delivery/pan/'.$panFrontFile]);
            }

            if ($request->hasFile('pan_card_back_path')) {
                $file = $request->file('pan_card_back_path');
                $panBackFile = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/pan'), $panBackFile);
                $request->merge(['pan_card_back_path' => 'uploads/e-commerce/delivery/pan/'.$panBackFile]);
            }

            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();
            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }

            $panCardDetails = new DmPanCardDetails;
            $panCardDetails->delivery_man_id = $request->user_id;
            $panCardDetails->pan_number = $request->pan_number;
            $panCardDetails->pan_card_front_path = 'uploads/e-commerce/delivery/pan/'.$panFrontFile;
            $panCardDetails->pan_card_back_path = 'uploads/e-commerce/delivery/pan/'.$panBackFile;
            $panCardDetails->created_by = $request->user_id;
            $panCardDetails->updated_by = $request->user_id;
            $panCardDetails->save();

            return response()->json(['message' => 'PAN card details added successfully'], 200);
        }
    }

    public function updatePanCard(Request $request)
    {

        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'pan_number' => 'required|string',
            'pan_card_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'pan_card_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }
        if ($staffRole == 'delivery_man') {
            $panCardDetails = DmPanCardDetails::where('delivery_man_id', $request->user_id)->first();
            if (! $panCardDetails) {
                return response()->json(['message' => 'PAN card details not found'], 404);
            }

            $panCardDetails->pan_number = $request->pan_number;
            $panCardDetails->updated_by = $request->user_id;
            if ($request->hasFile('pan_card_front_path')) {
                $file = $request->file('pan_card_front_path');
                $panFrontFile = time().'_front.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/pan'), $panFrontFile);
                $panCardDetails->pan_card_front_path = 'uploads/e-commerce/delivery/pan/'.$panFrontFile;
            }

            if ($request->hasFile('pan_card_back_path')) {
                $file = $request->file('pan_card_back_path');
                $panBackFile = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/pan'), $panBackFile);
                $panCardDetails->pan_card_back_path = 'uploads/e-commerce/delivery/pan/'.$panBackFile;
            }

            $panCardDetails->save();

            return response()->json(['message' => 'PAN card details updated successfully'], 200);
        }
    }

    public function getDrivingLicenseDetails(Request $request)
    {
        //
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]));
        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }
        $staffRole = $this->getRoleId($request->role_id);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }
        if ($staffRole == 'delivery_man') {
            // Implementation for fetching driving license details goes here
            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();
            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }
            $drivingLicenseDetails = DmDrivingLicenseDetails::where('delivery_man_id', $request->user_id)->first();
            if (! $drivingLicenseDetails) {
                return response()->json(['message' => 'Driving license details not found'], 404);
            }

            return response()->json(['driving_license_details' => $drivingLicenseDetails], 200);
        }

        return response()->json(['message' => 'Method not implemented'], 501);
    }

    public function storeDrivingLicense(Request $request)
    {
        //
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'license_number' => 'required|string',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date',
            'license_front_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'license_back_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }
        if ($staffRole == 'delivery_man') {
            if ($request->hasFile('license_front_path')) {
                $file = $request->file('license_front_path');
                $licenseFrontFile = time().'_front.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/driving_license'), $licenseFrontFile);
                $request->merge(['license_front_path' => 'uploads/e-commerce/delivery/driving_license/'.$licenseFrontFile]);
            }

            if ($request->hasFile('license_back_path')) {
                $file = $request->file('license_back_path');
                $licenseBackFile = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/driving_license'), $licenseBackFile);
                $request->merge(['license_back_path' => 'uploads/e-commerce/delivery/driving_license/'.$licenseBackFile]);
            }

            $deliveryMan = DeliveryMan::where('id', $request->user_id)->first();
            if (! $deliveryMan) {
                return response()->json(['message' => 'Delivery man not found'], 404);
            }

            $drivingLicenseDetails = new DmDrivingLicenseDetails;
            $drivingLicenseDetails->delivery_man_id = $request->user_id;
            $drivingLicenseDetails->license_number = $request->license_number;
            $drivingLicenseDetails->issue_date = $request->issue_date;
            $drivingLicenseDetails->expiry_date = $request->expiry_date;
            $drivingLicenseDetails->license_front_path = 'uploads/e-commerce/delivery/driving_license/'.$licenseFrontFile;
            $drivingLicenseDetails->license_back_path = 'uploads/e-commerce/delivery/driving_license/'.$licenseBackFile;
            $drivingLicenseDetails->created_by = $request->user_id;
            $drivingLicenseDetails->updated_by = $request->user_id;
            $drivingLicenseDetails->save();

            return response()->json(['message' => 'Driving license details added successfully'], 200);
        }
    }

    public function updateDrivingLicense(Request $request)
    {
        //
        $roleValidated = Validator::make($request->all(), ([
            'role_id' => 'required|in:2',
            'user_id' => 'required',
            'license_number' => 'required|string',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date',
            'license_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'license_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]));

        if ($roleValidated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $roleValidated->errors()], 422);
        }

        $staffRole = $this->getRoleId($request->role_id);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }
        if ($staffRole == 'delivery_man') {
            $drivingLicenseDetails = DmDrivingLicenseDetails::where('delivery_man_id', $request->user_id)->first();
            if (! $drivingLicenseDetails) {
                return response()->json(['message' => 'Driving license details not found'], 404);
            }
            $drivingLicenseDetails->license_number = $request->license_number;
            $drivingLicenseDetails->issue_date = $request->issue_date;
            $drivingLicenseDetails->expiry_date = $request->expiry_date;
            $drivingLicenseDetails->updated_by = $request->user_id;
            if ($request->hasFile('license_front_path')) {
                $file = $request->file('license_front_path');
                $licenseFrontFile = time().'_front.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/driving_license'), $licenseFrontFile);
                $drivingLicenseDetails->license_front_path = 'uploads/e-commerce/delivery/driving_license/'.$licenseFrontFile;
            }
            if ($request->hasFile('license_back_path')) {
                $file = $request->file('license_back_path');
                $licenseBackFile = time().'_back.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/e-commerce/delivery/driving_license'), $licenseBackFile);
                $drivingLicenseDetails->license_back_path = 'uploads/e-commerce/delivery/driving_license/'.$licenseBackFile;
            }
            $drivingLicenseDetails->save();

            return response()->json(['message' => 'Driving license details updated successfully'], 200);
        }
    }
}
