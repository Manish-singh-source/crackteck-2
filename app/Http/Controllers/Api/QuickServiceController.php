<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\QuickService;
use App\Models\QuickServiceRequest;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class QuickServiceController extends Controller
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

    public function index(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
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
            $quickServices = QuickService::active()->get();

            return response()->json(['quick_services' => $quickServices], 200);
        }
    }

    public function store(Request $request, $id)
    {
        // Validate role_id
        $validated = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validated->errors(),
            ], 422);
        }

        $staffRole = $this->getRoleId($validated->validated()['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {

            // Validate customer fields
            $validated = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'product_name' => 'required|string|max:255',
                'model_no' => 'nullable|string|max:255',
                'sku' => 'nullable|string|max:255',
                'hsn' => 'nullable|string|max:255',
                'brand' => 'nullable|string|max:255',
                'issue' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validated->errors(),
                ], 422);
            }

            $validated = $validated->validated();

            // Handle image upload if exists
            $filename = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time().'_'.$file->getClientOriginalName();

                $uploadPath = public_path('uploads/crm/quick-services');
                if (! File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
            }

            // Prepare data
            $data = [
                'quick_service_id' => $id, // URL parameter
                'customer_id' => $validated['customer_id'], // correct customer id
                'product_name' => $validated['product_name'],
                'model_no' => $validated['model_no'],
                'sku' => $validated['sku'],
                'hsn' => $validated['hsn'],
                'brand' => $validated['brand'],
                'issue' => $validated['issue'],
                'image' => $filename,
            ];

            $quickService = QuickServiceRequest::create($data);

            if (! $quickService) {
                return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
            }

            return response()->json(['quick_service' => $quickService], 200);
        }
    }
}
