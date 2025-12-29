<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\NonAmcService;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NonAmcServicesController extends Controller
{
    //
    protected function getModelByRoleId($roleId)
    {
        return [
            1 => Engineer::class,
            2 => DeliveryMan::class,
            3 => SalesPerson::class,
            4 => Customer::class,
        ][$roleId] ?? null;
    }

    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function generateServiceId()
    {
        $year = date('Y');
        $lastService = NonAmcService::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->service_id, -4)) + 1) : 1;

        return 'SRV-'.$year.'-'.str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function calculateEndDate($startDate, $duration)
    {
        $duration = strtolower($duration);
        $startDate = \Carbon\Carbon::parse($startDate);

        if (strpos($duration, 'months') !== false) {
            $months = intval($duration);

            return $startDate->addMonths($months);
        } elseif (strpos($duration, 'years') !== false) {
            $years = intval($duration);

            return $startDate->addYears($years);
        }

        // Default to 1 year if duration format is unclear
        return $startDate->addYear();
    }

    public function installationStore(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|in:4',
                'customer_id' => 'nullable|integer',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'pan_no' => 'required|string|max:20',
                'customer_type' => 'required|in:Individual,Business,Corporate,SME',
                'source_type_label' => 'required|string',

                'company_name' => 'nullable|string|max:255',
                'branch_name' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'pincode' => 'required|string|max:20',
                'gst_no' => 'nullable|string|max:20',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',

                'products' => 'nullable|array|min:1',
                'products.*.product_name' => 'nullable|string',
                'products.*.product_type' => 'nullable|string',
                'products.*.brand_name' => 'nullable|string',
                'products.*.model_number' => 'nullable|string',
                'products.*.serial_number' => 'nullable|string',
                'products.*.purchase_date' => 'nullable|date',

                'additional_notes' => 'nullable|string',
                'terms_agreed' => 'required|accepted',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            $nonAmcService = new NonAmcService;
            $nonAmcService->customer_id = $validated['customer_id'] ?? null;
            $nonAmcService->first_name = $validated['first_name'];
            $nonAmcService->last_name = $validated['last_name'];
            $nonAmcService->phone = $validated['phone'];
            $nonAmcService->email = $validated['email'];
            $nonAmcService->pan_no = $validated['pan_no'];
            $nonAmcService->customer_type = $validated['customer_type'];
            $nonAmcService->source_type = $validated['source_type_label'];
            $nonAmcService->company_name = $validated['company_name'] ?? null;
            $nonAmcService->branch_name = $validated['branch_name'] ?? null;
            $nonAmcService->city = $validated['city'];
            $nonAmcService->state = $validated['state'];
            $nonAmcService->country = $validated['country'];
            $nonAmcService->pincode = $validated['pincode'];
            $nonAmcService->gst_no = $validated['gst_no'] ?? null;
            $nonAmcService->service_type = $validated['service_type'] ?? 'Online';
            $nonAmcService->address_line1 = $validated['address_line1'];
            $nonAmcService->address_line2 = $validated['address_line2'] ?? null;
            $nonAmcService->additional_notes = $validated['additional_notes'] ?? null;
            $nonAmcService->terms_agreed = $validated['terms_agreed'] ?? false;
            $nonAmcService->status = 'Pending';
            // $nonAmcService->created_by = Auth::id() ?? $validated['created_by'] ?? null;
            $nonAmcService->save();

            foreach ($validated['products'] as $product) {
                $nonAmcProducts = new \App\Models\NonAmcProduct;
                $nonAmcProducts->non_amc_service_id = $nonAmcService->id;
                $nonAmcProducts->product_name = $product['product_name'] ?? null;
                $nonAmcProducts->product_type = $product['product_type'] ?? null;
                $nonAmcProducts->product_brand = $product['brand_name'] ?? null;
                $nonAmcProducts->model_no = $product['model_number'] ?? null;
                $nonAmcProducts->serial_no = $product['serial_number'] ?? null;
                $nonAmcProducts->purchase_date = $product['purchase_date'] ?? null;
                $nonAmcProducts->save();
            }

            return response()->json(['success' => true, 'message' => 'Non-AMC service request submitted successfully!', 'data' => $nonAmcService]);
        }
    }

    public function repairStore(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|in:4',
                'customer_id' => 'nullable|integer',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'pan_no' => 'required|string|max:20',
                'customer_type' => 'required|in:Individual,Business,Corporate,SME',
                'source_type_label' => 'required|string',

                'company_name' => 'nullable|string|max:255',
                'branch_name' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'pincode' => 'required|string|max:20',
                'gst_no' => 'nullable|string|max:20',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',

                'products' => 'nullable|array|min:1',
                'products.*.product_name' => 'nullable|string',
                'products.*.product_type' => 'nullable|string',
                'products.*.brand_name' => 'nullable|string',
                'products.*.model_number' => 'nullable|string',
                'products.*.serial_number' => 'nullable|string',
                'products.*.purchase_date' => 'nullable|date',

                'additional_notes' => 'nullable|string',
                'terms_agreed' => 'required|accepted',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            $nonAmcService = new NonAmcService;
            $nonAmcService->customer_id = $validated['customer_id'] ?? null;
            $nonAmcService->first_name = $validated['first_name'];
            $nonAmcService->last_name = $validated['last_name'];
            $nonAmcService->phone = $validated['phone'];
            $nonAmcService->email = $validated['email'];
            $nonAmcService->pan_no = $validated['pan_no'];
            $nonAmcService->customer_type = $validated['customer_type'];
            $nonAmcService->source_type = $validated['source_type_label'];
            $nonAmcService->company_name = $validated['company_name'] ?? null;
            $nonAmcService->branch_name = $validated['branch_name'] ?? null;
            $nonAmcService->city = $validated['city'];
            $nonAmcService->state = $validated['state'];
            $nonAmcService->country = $validated['country'];
            $nonAmcService->pincode = $validated['pincode'];
            $nonAmcService->gst_no = $validated['gst_no'] ?? null;
            $nonAmcService->service_type = $validated['service_type'] ?? 'Online';
            $nonAmcService->address_line1 = $validated['address_line1'];
            $nonAmcService->address_line2 = $validated['address_line2'] ?? null;
            $nonAmcService->additional_notes = $validated['additional_notes'] ?? null;
            $nonAmcService->terms_agreed = $validated['terms_agreed'] ?? false;
            $nonAmcService->status = 'Pending';
            // $nonAmcService->created_by = Auth::id() ?? $validated['created_by'] ?? null;
            $nonAmcService->save();

            foreach ($validated['products'] as $product) {
                $nonAmcProducts = new \App\Models\NonAmcProduct;
                $nonAmcProducts->non_amc_service_id = $nonAmcService->id;
                $nonAmcProducts->product_name = $product['product_name'] ?? null;
                $nonAmcProducts->product_type = $product['product_type'] ?? null;
                $nonAmcProducts->product_brand = $product['brand_name'] ?? null;
                $nonAmcProducts->model_no = $product['model_number'] ?? null;
                $nonAmcProducts->serial_no = $product['serial_number'] ?? null;
                $nonAmcProducts->purchase_date = $product['purchase_date'] ?? null;
                $nonAmcProducts->save();
            }

            return response()->json(['success' => true, 'message' => 'Non-AMC service request submitted successfully!', 'data' => $nonAmcService]);
        }
    }
}
