<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddressDetail;
use App\Models\CustomerAadharDetail;
use App\Models\CustomerCompanyDetail;
use App\Models\CustomerPanCardDetail;
use App\Models\StaffAadharDetail;
use App\Models\StaffPanCardDetail;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //

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
            $user = Customer::where('id', $validated['user_id'])->first();
            unset($user->otp, $user->otp_expiry, $user->password, $user->created_by, $user->created_at);
        } else {
            $user = Staff::where('id', $validated['user_id'])->first();
            unset($user->otp, $user->otp_expiry, $user->password);
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'email' => 'nullable|email',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

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
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->save();

            if (! $user) {
                return response()->json(['success' => false, 'message' => 'User not updated.'], 404);
            }

            return response()->json(['success' => true, 'message' => 'User updated successfully.'], 200);
        }


        $user = Staff::where('id', $validated['user_id'])->first();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->employment_type = $request->employment_type;
        $user->joining_date = $request->joining_date;
        $user->marital_status = $request->marital_status;
        $user->assigned_area = $request->assigned_area;
        $user->status = $request->status;
        $user->save();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not updated.'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function getAddresses(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] != 4) {
            return response()->json(['success' => false, 'message' => 'Addresses are only available for customers.'], 400);
        }

        $addresses = CustomerAddressDetail::where('customer_id', $validated['user_id'])->get();

        if (! $addresses) {
            return response()->json(['success' => false, 'message' => 'Addresses not found.'], 404);
        }

        return response()->json(['addresses' => $addresses], 200);
    }

    public function addAddress(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required|exists:customers,id',
            'is_primary' => 'required|in:yes,no',
            'branch_name' => 'required',
            'address1' => 'required',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        if ($validated['role_id'] != 4) {
            return response()->json(['success' => false, 'message' => 'Addresses are only available for customers.'], 400);
        }

        $primaryAddress = CustomerAddressDetail::where('customer_id', $validated['user_id'])->where('is_primary', "yes")->first();

        if ($request->filled('is_primary')) {
            if ($request->is_primary && !$primaryAddress) {
                $request->is_primary = "yes";
            } else {
                $request->is_primary = "no";
            }
        } else {
            if (! $primaryAddress) {
                $request->is_primary = "yes";
            } else {
                $request->is_primary = "no";
            }
        }


        $address = CustomerAddressDetail::create([
            'customer_id' => $validated['user_id'],
            'branch_name' => $request->branch_name,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'is_primary' => $request->is_primary,
        ]);


        if (! $address) {
            return response()->json(['success' => false, 'message' => 'Address not added.'], 404);
        }

        return response()->json(['address' => $address], 200);
    }

    public function updateAddress(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required|exists:customers,id',
            'is_primary' => 'required|in:yes,no',
            'branch_name' => 'required',
            'address1' => 'required',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] == 4) {
            $address = CustomerAddressDetail::where('customer_id', $validated['user_id'])->find($id);

            if (! $address) {
                return response()->json(['success' => false, 'message' => 'Address not found.'], 404);
            }

            $address->branch_name = $request->branch_name ?? '';
            $address->address1 = $request->address1;
            $address->address2 = $request->address2;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = $request->country;
            $address->pincode = $request->pincode;

            if ($request->is_primary) {
                $primaryAddress = CustomerAddressDetail::where('customer_id', $validated['user_id'])->where('is_primary', "1")->first();
                if ($primaryAddress) {
                    return response()->json(['success' => false, 'message' => 'One address is already primary.'], 400);
                }
                $address->is_primary = "yes";
            }
            $address->save();
        } else {
            return response()->json(['success' => false, 'message' => 'Addresses are only available for customers.'], 400);
        }

        if (! $address) {
            return response()->json(['success' => false, 'message' => 'Address not updated.'], 404);
        }

        return response()->json(['address' => $address], 200);
    }

    public function getAadharCard(Request $request)
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
            // check customer exists 
            $customer = Customer::where('id', $validated['user_id'])->first();
            if (! $customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
            }
            $aadharCard = CustomerAadharDetail::where('customer_id', $validated['user_id'])->first();
        } else {
            $staff = Staff::where('id', $validated['user_id'])->first();
            if (! $staff) {
                return response()->json(['success' => false, 'message' => 'Staff not found.'], 404);
            }
            $aadharCard = StaffAadharDetail::where('staff_id', $validated['user_id'])->first();
        }

        if (! $aadharCard) {
            return response()->json(['success' => false, 'message' => 'Aadhar card not found.'], 404);
        }

        return response()->json(['aadhar_card' => $aadharCard], 200);
    }

    public function addAadharCard(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
            'aadhar_number' => 'required',
            'aadhar_front_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'aadhar_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] == 4) {
            // check customer exists 
            $customer = Customer::where('id', $validated['user_id'])->first();
            if (! $customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
            }

            // check if aadhar card already exists
            $existingAadhar = CustomerAadharDetail::where('customer_id', $validated['user_id'])->first();
            if ($existingAadhar) {
                return response()->json(['success' => false, 'message' => 'Aadhar card already exists.'], 400);
            }

            // upload aadhar card
            if ($request->hasFile('aadhar_front_path')) {
                if ($request->aadhar_front_path && File::exists(public_path($request->aadhar_front_path))) {
                    File::delete(public_path($request->aadhar_front_path));
                }

                $file = $request->file('aadhar_front_path');
                $filename = time() . '_aadhar_front.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/customer/aadhar'), $filename);
                $aadharFrontPath = 'uploads/crm/customer/aadhar/' . $filename;
            }

            if ($request->hasFile('aadhar_back_path')) {
                if ($request->aadhar_back_path && File::exists(public_path($request->aadhar_back_path))) {
                    File::delete(public_path($request->aadhar_back_path));
                }

                $file = $request->file('aadhar_back_path');
                $filename = time() . '_aadhar_back.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/customer/aadhar'), $filename);
                $aadharBackPath = 'uploads/crm/customer/aadhar/' . $filename;
            }

            // create aadhar card
            $aadharCard = CustomerAadharDetail::create([
                'customer_id' => $validated['user_id'],
                'aadhar_number' => $request->aadhar_number,
                'aadhar_front_path' => $aadharFrontPath,
                'aadhar_back_path' => $aadharBackPath,
            ]);
        } else {
            // check staff exists 
            $staff = Staff::where('id', $validated['user_id'])->first();
            if (! $staff) {
                return response()->json(['success' => false, 'message' => 'Staff not found.'], 404);
            }

            // check if aadhar card already exists
            $existingAadhar = StaffAadharDetail::where('staff_id', $validated['user_id'])->first();
            if ($existingAadhar) {
                return response()->json(['success' => false, 'message' => 'Aadhar card already exists.'], 400);
            }

            // upload aadhar card            
            $aadharCard = StaffAadharDetail::create([
                'staff_id' => $validated['user_id'],
                'aadhar_number' => $request->aadhar_number,
                'aadhar_front_path' => $request->aadhar_front_path,
                'aadhar_back_path' => $request->aadhar_back_path,
            ]);
        }

        if (! $aadharCard) {
            return response()->json(['success' => false, 'message' => 'Aadhar card not added.'], 404);
        }

        return response()->json(['aadhar_card' => $aadharCard], 200);
    }

    public function updateAadharCard(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
            'aadhar_number' => 'required',
            'aadhar_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'aadhar_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] == 4) {
            // check customer exists 
            $customer = Customer::where('id', $validated['user_id'])->first();
            if (! $customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
            }

            // check if aadhar card already exists
            $aadharCard = CustomerAadharDetail::where('customer_id', $validated['user_id'])->find($id);
        } else {
            // check staff exists 
            $staff = Staff::where('id', $validated['user_id'])->first();
            if (! $staff) {
                return response()->json(['success' => false, 'message' => 'Staff not found.'], 404);
            }

            // check if aadhar card already exists
            $aadharCard = StaffAadharDetail::where('staff_id', $validated['user_id'])->find($id);
        }

        if ($request->hasFile('aadhar_front_path')) {
            if ($request->aadhar_front_path && File::exists(public_path($request->aadhar_front_path))) {
                File::delete(public_path($request->aadhar_front_path));
            }

            $file = $request->file('aadhar_front_path');
            $filename = time() . '_aadhar_front.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/customer/aadhar'), $filename);
            $aadharFrontPath = 'uploads/crm/customer/aadhar/' . $filename;
        }

        if ($request->hasFile('aadhar_back_path')) {
            if ($request->aadhar_back_path && File::exists(public_path($request->aadhar_back_path))) {
                File::delete(public_path($request->aadhar_back_path));
            }

            $file = $request->file('aadhar_back_path');
            $filename = time() . '_aadhar_back.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/customer/aadhar'), $filename);
            $aadharBackPath = 'uploads/crm/customer/aadhar/' . $filename;
        }

        if (! $aadharCard) {
            return response()->json(['success' => false, 'message' => 'Aadhar card not found.'], 404);
        }

        // return response()->json(['message' => 'here', 'data' => $request->aadhar_number], 501);
        $aadharCard->aadhar_number = $request->aadhar_number;
        $aadharCard->aadhar_front_path = $aadharFrontPath ?? null;
        $aadharCard->aadhar_back_path = $aadharBackPath ?? null;
        $aadharCard->save();

        if (! $aadharCard) {
            return response()->json(['success' => false, 'message' => 'Aadhar card not updated.'], 404);
        }

        return response()->json(['aadhar_card' => $aadharCard], 200);
    }

    public function getPanCard(Request $request)
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
            // check customer exists 
            $customer = Customer::where('id', $validated['user_id'])->first();
            if (! $customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
            }
            $panCard = CustomerPanCardDetail::where('customer_id', $validated['user_id'])->first();
        } else {
            // check staff exists 
            $staff = Staff::where('id', $validated['user_id'])->first();
            if (! $staff) {
                return response()->json(['success' => false, 'message' => 'Staff not found.'], 404);
            }
            $panCard = StaffPanCardDetail::where('staff_id', $validated['user_id'])->first();
        }

        if (! $panCard) {
            return response()->json(['success' => false, 'message' => 'Pan card not found.'], 404);
        }

        return response()->json(['pan_card' => $panCard], 200);
    }

    // check if pan card is already avaialble then return error
    // pan card can be added only once
    // and if not available then only add
    public function addPanCard(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
            'pan_number' => 'required',
            'pan_card_front_path' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'pan_card_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] == 4) {
            // check customer exists 
            $customer = Customer::where('id', $validated['user_id'])->first();
            if (! $customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
            }

            $existingPan = CustomerPanCardDetail::where('customer_id', $validated['user_id'])->first();
            if ($existingPan) {
                return response()->json(['success' => false, 'message' => 'Pan card already exists.'], 400);
            }

            if ($request->hasFile('pan_card_front_path')) {
                if ($request->pan_card_front_path && File::exists(public_path($request->pan_card_front_path))) {
                    File::delete(public_path($request->pan_card_front_path));
                }

                $file = $request->file('pan_card_front_path');
                $filename = time() . '_pan_card_front.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/customer/pan'), $filename);
                $panCardFrontPath = 'uploads/crm/customer/pan/' . $filename;
            }

            if ($request->hasFile('pan_card_back_path')) {
                if ($request->pan_card_back_path && File::exists(public_path($request->pan_card_back_path))) {
                    File::delete(public_path($request->pan_card_back_path));
                }

                $file = $request->file('pan_card_back_path');
                $filename = time() . '_pan_card_back.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/customer/pan'), $filename);
                $panCardBackPath = 'uploads/crm/customer/pan/' . $filename;
            }

            $panCard = CustomerPanCardDetail::create([
                'customer_id' => $validated['user_id'],
                'pan_number' => $request->pan_number,
                'pan_card_front_path' => $panCardFrontPath ?? null,
                'pan_card_back_path' => $panCardBackPath ?? null,
            ]);
        } else {
            $existingPan = StaffPanCardDetail::where('staff_id', $validated['user_id'])->first();
            if ($existingPan) {
                return response()->json(['success' => false, 'message' => 'Pan card already exists.'], 400);
            }

            $panCard = StaffPanCardDetail::create([
                'staff_id' => $validated['user_id'],
                'pan_number' => $request->pan_number,
                'pan_card_front_path' => $request->pan_card_front_path,
                'pan_card_back_path' => $request->pan_card_back_path,
            ]);
        }

        if (! $panCard) {
            return response()->json(['success' => false, 'message' => 'Pan card not added.'], 404);
        }

        return response()->json(['pan_card' => $panCard], 200);
    }

    public function updatePanCard(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
            'pan_number' => 'required',
            'pan_card_front_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'pan_card_back_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] == 4) {
            $panCard = CustomerPanCardDetail::where('customer_id', $validated['user_id'])->find($id);
        } else {
            $panCard = StaffPanCardDetail::where('staff_id', $validated['user_id'])->find($id);
        }

        if ($request->hasFile('pan_card_front_path')) {
            if ($request->pan_card_front_path && File::exists(public_path($request->pan_card_front_path))) {
                File::delete(public_path($request->pan_card_front_path));
            }

            $file = $request->file('pan_card_front_path');;
            $filename = time() . '_pan_card_front.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/customer/pan'), $filename);
            $panCardFrontPath = 'uploads/crm/customer/pan/' . $filename;
        }

        if ($request->hasFile('pan_card_back_path')) {
            if ($request->pan_card_back_path && File::exists(public_path($request->pan_card_back_path))) {
                File::delete(public_path($request->pan_card_back_path));
            }

            $file = $request->file('pan_card_back_path');;
            $filename = time() . '_pan_card_back.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/crm/customer/pan'), $filename);
            $panCardBackPath = 'uploads/crm/customer/pan/' . $filename;
        }

        if (! $panCard) {
            return response()->json(['success' => false, 'message' => 'Pan card not found.'], 404);
        }

        $panCard->pan_number = $request->pan_number;
        $panCard->pan_card_front_path = $panCardFrontPath ?? null;
        $panCard->pan_card_back_path = $panCardBackPath ?? null;
        $panCard->save();

        if (! $panCard) {
            return response()->json(['success' => false, 'message' => 'Pan card not updated.'], 404);
        }
        return response()->json(['pan_card' => $panCard], 200);
    }

    public function getCompanyDetails(Request $request)
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
            $companyDetails = CustomerCompanyDetail::where('customer_id', $validated['user_id'])->first();
        } else {
            return response()->json(['success' => false, 'message' => 'Company details not found.'], 404);
        }

        if (! $companyDetails) {
            return response()->json(['success' => false, 'message' => 'Company details not found.'], 404);
        }

        return response()->json(['company_details' => $companyDetails], 200);
    }

    public function addCompanyDetails(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:1,2,3,4',
            'user_id' => 'required',
            'company_name' => 'required',
            'comp_address1' => 'nullable',
            'comp_address2' => 'nullable',
            'comp_city' => 'nullable',
            'comp_state' => 'nullable',
            'comp_country' => 'nullable',
            'comp_pincode' => 'nullable',
            'gst_no' => 'nullable',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        if ($validated['role_id'] == 4) {
            $existingCompany = CustomerCompanyDetail::where('customer_id', $validated['user_id'])->first();
            if ($existingCompany) {
                return response()->json(['success' => false, 'message' => 'Company details already exists.'], 400);
            }

            $companyDetails = CustomerCompanyDetail::create([
                'customer_id' => $validated['user_id'],
                'company_name' => $request->company_name,
                'comp_address1' => $request->comp_address1,
                'comp_address2' => $request->comp_address2,
                'comp_city' => $request->comp_city,
                'comp_state' => $request->comp_state,
                'comp_country' => $request->comp_country,
                'comp_pincode' => $request->comp_pincode,
                'gst_no' => $request->gst_no,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Company details can be added only for customers.'], 400);
        }

        if (! $companyDetails) {
            return response()->json(['success' => false, 'message' => 'Company details not added.'], 404);
        }

        return response()->json(['company_details' => $companyDetails], 200);
    }

    public function updateCompanyDetails(Request $request, $id)
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
            $companyDetails = CustomerCompanyDetail::where('customer_id', $validated['user_id'])->find($id);
        } else {
            return response()->json(['success' => false, 'message' => 'Company details can be updated only for customers.'], 400);
        }

        if (! $companyDetails) {
            return response()->json(['success' => false, 'message' => 'Company details not found.'], 404);
        }

        $companyDetails->company_name = $request->company_name;
        $companyDetails->comp_address1 = $request->comp_address1;
        $companyDetails->comp_address2 = $request->comp_address2;
        $companyDetails->comp_city = $request->comp_city;
        $companyDetails->comp_state = $request->comp_state;
        $companyDetails->comp_country = $request->comp_country;
        $companyDetails->comp_pincode = $request->comp_pincode;
        $companyDetails->gst_no = $request->gst_no;
        $companyDetails->save();

        if (! $companyDetails) {
            return response()->json(['success' => false, 'message' => 'Company details not updated.'], 404);
        }

        return response()->json(['company_details' => $companyDetails], 200);
    }
}
