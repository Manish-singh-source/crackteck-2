<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddressDetails;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
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
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();
        if ($validated['role_id'] == 4) {
            $user = Customer::with('branches')->where('id', $validated['user_id'])->first();
        } else {
            $model = $this->getModelByRoleId($validated['role_id']);
            $user = $model::where('id', $validated['user_id'])->first();
        }
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
        ]);

        $validated = $validated->validated();
        // return response()->json(['message' => $request->all()], 501);

        if (! $validated['user_id']) {
            return response()->json(['message' => 'User ID is required'], 400);
        }
        if (! $validated['role_id']) {
            return response()->json(['message' => 'Role ID is required'], 400);
        }

        if ($request->role_id == 4) {
            // return  response()->json(['message' => $request->address], 501);
            $user = Customer::findOrFail($validated['user_id']);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->branch_name = $request->branch_name;
            $user->pan_no = $request->pan_no;

            $user->company_name = $request->company_name;
            $user->company_addr = $request->company_addr;
            $user->gst_no = $request->gst_no;
            $user->customer_type = $request->customer_type;
            $user->save();

            foreach ($request->branches as $index => $branchData) {
                $userAddress = CustomerAddressDetails::where('customer_id', $branchData['customer_id'])->find($branchData['id']);
                if (! $userAddress) {
                    $userAddress = new CustomerAddressDetails;
                    $userAddress->customer_id = $validated['user_id'];
                }
                $userAddress->branch_name = $branchData['branch_name'];
                $userAddress->address = $branchData['address'];
                $userAddress->address2 = $branchData['address2'] ?? null;
                $userAddress->city = $branchData['city'];
                $userAddress->state = $branchData['state'];
                $userAddress->country = $branchData['country'];
                $userAddress->pincode = $branchData['pincode'];
                $userAddress->save();
            }

            if (! $user) {
                return response()->json(['success' => false, 'message' => 'User not updated.'], 404);
            }

            return response()->json(['success' => true, 'message' => 'User updated successfully.'], 200);
        }

        $model = $this->getModelByRoleId($request->role_id);
        if (! $model) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $user = $model::where('id', $validated['user_id'])->first();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->current_address = $request->current_address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->pincode = $request->pincode;
        $user->employment_type = $request->employment_type;
        $user->joining_date = $request->joining_date;
        $user->police_verification = $request->police_verification;
        $user->police_verification_status = $request->police_verification_status;
        $user->police_certificate = $request->police_certificate;
        $user->save();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not updated.'], 404);
        }

        return response()->json(['user' => $user], 200);

    }
}
