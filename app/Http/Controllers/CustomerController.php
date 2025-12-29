<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAadharDetail;
use App\Models\CustomerAddressDetail;
use App\Models\CustomerCompanyDetail;
use App\Models\CustomerPanCardDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function index()
    {
        // Filter to show only CRM customers (Retail, Wholesale, Corporate, AMC Customer)
        $customers = Customer::withCount('branches')
            ->get();

        return view('/crm/customer/index', compact('customers'));
    }

    public function create()
    {
        return view('/crm/customer/create');
    }

    // customers
    // customer_company_details
    // customer_address_details
    // customer_aadhar_details
    // customer_pan_card_details

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Personal
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:0,1,2',
            'customer_type' => 'nullable|in:0,1,2,3',
            'source_type' => 'nullable|in:0,1,2,3,4',
            'status' => 'nullable|in:1,2,3,4',

            // Aadhar
            'aadhar_number' => 'nullable|string|max:20',
            'aadhar_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'aadhar_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // PAN
            'pan_number' => 'nullable|string|max:20',
            'pan_card_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Branches
            'branches' => 'required|array|min:1',
            'branches.*.branch_name' => 'required|string|max:255',
            'branches.*.address1' => 'required|string|max:255',
            'branches.*.address2' => 'nullable|string|max:255',
            'branches.*.city' => 'required|string|max:255',
            'branches.*.state' => 'required|string|max:255',
            'branches.*.country' => 'required|string|max:255',
            'branches.*.pincode' => 'required|string|max:20',
            'is_primary' => 'nullable|integer',

            // Company
            'company_name' => 'nullable|string|max:255',
            'comp_address1' => 'nullable|string|max:255',
            'comp_address2' => 'nullable|string|max:255',
            'comp_city' => 'nullable|string|max:255',
            'comp_state' => 'nullable|string|max:255',
            'comp_country' => 'nullable|string|max:255',
            'comp_pincode' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:50',
        ]);

        \DB::transaction(function () use ($request, $validated) {

            $customerCode = 'CUST'.str_pad((Customer::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);

            // 1. Customer (main)
            $customer = Customer::create([
                // customer_code
                'customer_code' => $customerCode,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'dob' => $validated['dob'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'customer_type' => $validated['customer_type'] ?? null,
                'source_type' => $validated['source_type'] ?? null,
                'status' => $validated['status'] ?? 1, // Active
            ]);

            // Handle uploads
            $aadharFront = null;
            if ($request->hasFile('aadhar_front_path')) {
                $file = $request->file('aadhar_front_path');
                $filename = time().'_'.$file->getClientOriginalName();
                $aadharFront = $file->storeAs('customers/aadhar', $filename, 'public');
            }

            $aadharBack = null;
            if ($request->hasFile('aadhar_back_path')) {
                $file = $request->file('aadhar_back_path');
                $filename = time().'_'.$file->getClientOriginalName();
                $aadharBack = $file->storeAs('customers/aadhar', $filename, 'public');
            }

            $panFront = null;
            if ($request->hasFile('pan_card_front_path')) {
                $file = $request->file('pan_card_front_path');
                $filename = time().'_'.$file->getClientOriginalName();
                $panFront = $file->storeAs('customers/pan', $filename, 'public');
            }

            $panBack = null;
            if ($request->hasFile('pan_card_back_path')) {
                $file = $request->file('pan_card_back_path');
                $filename = time().'_'.$file->getClientOriginalName();
                $panBack = $file->storeAs('customers/pan', $filename, 'public');
            }

            // 2. Aadhar
            if ($validated['aadhar_number'] || $aadharFront || $aadharBack) {
                CustomerAadharDetail::create([
                    'customer_id' => $customer->id,
                    'aadhar_number' => $validated['aadhar_number'] ?? null,
                    'aadhar_front_path' => $aadharFront,
                    'aadhar_back_path' => $aadharBack,
                ]);
            }

            // 3. PAN
            if ($validated['pan_number'] || $panFront || $panBack) {
                CustomerPanCardDetail::create([
                    'customer_id' => $customer->id,
                    'pan_number' => $validated['pan_number'] ?? null,
                    'pan_card_front_path' => $panFront,
                    'pan_card_back_path' => $panBack,
                ]);
            }

            // 4. Branches (addresses)
            $primaryBranch = $validated['is_primary'] ?? 0;

            foreach ($validated['branches'] as $index => $branch) {
                CustomerAddressDetail::create([
                    'customer_id' => $customer->id,
                    'branch_name' => $branch['branch_name'],
                    'address1' => $branch['address1'],
                    'address2' => $branch['address2'] ?? null,
                    'city' => $branch['city'],
                    'state' => $branch['state'],
                    'country' => $branch['country'],
                    'pincode' => $branch['pincode'],
                    'is_primary' => ($index == $primaryBranch) ? 1 : 0,
                ]);
            }

            // 5. Company
            if ($validated['company_name'] || $validated['gst_no']) {
                CustomerCompanyDetail::create([
                    'customer_id' => $customer->id,
                    'company_name' => $validated['company_name'] ?? null,
                    'comp_address1' => $validated['comp_address1'] ?? null,
                    'comp_address2' => $validated['comp_address2'] ?? null,
                    'comp_city' => $validated['comp_city'] ?? null,
                    'comp_state' => $validated['comp_state'] ?? null,
                    'comp_country' => $validated['comp_country'] ?? null,
                    'comp_pincode' => $validated['comp_pincode'] ?? null,
                    'gst_no' => $validated['gst_no'] ?? null,
                ]);
            }
        });

        return redirect()->route('customer.index')
            ->with('success', 'Customer created successfully.');
    }

    public function view($id)
    {
        $customer = Customer::with(['branches'])->find($id);

        return view('/crm/customer/view', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::with(['branches'])->find($id);

        return view('/crm/customer/edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::with([
            'aadharDetail',      // hasOne CustomerAadharDetail
            'panCardDetail',     // hasOne CustomerPanCardDetail
            'addressDetails',    // hasMany CustomerAddressDetail
            'companyDetail',     // hasOne CustomerCompanyDetail
        ])->findOrFail($id);

        $validated = $request->validate([
            // Personal (customers)
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email,'.$id,
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:0,1,2',
            'customer_type' => 'nullable|in:0,1,2,3',
            'source_type' => 'nullable|in:0,1,2,3,4',
            'status' => 'nullable|in:1,2,3,4',

            // Aadhar (customer_aadhar_details)
            'aadhar_number' => 'nullable|string|max:20',
            'aadhar_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'aadhar_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // PAN (customer_pan_card_details)
            'pan_number' => 'nullable|string|max:20',
            'pan_card_front_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card_back_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Branches (customer_address_details)
            'branches' => 'required|array|min:1',
            'branches.*.id' => 'nullable|integer|exists:customer_address_details,id',
            'branches.*.branch_name' => 'required|string|max:255',
            'branches.*.address1' => 'required|string|max:255',
            'branches.*.address2' => 'nullable|string|max:255',
            'branches.*.city' => 'required|string|max:255',
            'branches.*.state' => 'required|string|max:255',
            'branches.*.country' => 'required|string|max:255',
            'branches.*.pincode' => 'required|string|max:20',
            'is_primary' => 'nullable|integer',

            // Company (customer_company_details)
            'company_name' => 'nullable|string|max:255',
            'comp_address1' => 'nullable|string|max:255',
            'comp_address2' => 'nullable|string|max:255',
            'comp_city' => 'nullable|string|max:255',
            'comp_state' => 'nullable|string|max:255',
            'comp_country' => 'nullable|string|max:255',
            'comp_pincode' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:50',
        ]);

        \DB::transaction(function () use ($request, $validated, $customer) {

            // ---- FILE UPLOADS (Aadhar / PAN) ----
            $aadharFront = optional($customer->aadharDetail)->aadhar_front_path;
            if ($request->hasFile('aadhar_front_path')) {
                $file = $request->file('aadhar_front_path');
                $aadharFront = $file->storeAs(
                    'customers/aadhar',
                    time().'_front_'.$file->getClientOriginalName(),
                    'public'
                );
            }

            $aadharBack = optional($customer->aadharDetail)->aadhar_back_path;
            if ($request->hasFile('aadhar_back_path')) {
                $file = $request->file('aadhar_back_path');
                $aadharBack = $file->storeAs(
                    'customers/aadhar',
                    time().'_back_'.$file->getClientOriginalName(),
                    'public'
                );
            }

            $panFront = optional($customer->panCardDetail)->pan_card_front_path;
            if ($request->hasFile('pan_card_front_path')) {
                $file = $request->file('pan_card_front_path');
                $panFront = $file->storeAs(
                    'customers/pan',
                    time().'_front_'.$file->getClientOriginalName(),
                    'public'
                );
            }

            $panBack = optional($customer->panCardDetail)->pan_card_back_path;
            if ($request->hasFile('pan_card_back_path')) {
                $file = $request->file('pan_card_back_path');
                $panBack = $file->storeAs(
                    'customers/pan',
                    time().'_back_'.$file->getClientOriginalName(),
                    'public'
                );
            }

            // ---- 1) UPDATE MAIN CUSTOMER ----
            $customer->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'dob' => $validated['dob'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'customer_type' => $validated['customer_type'] ?? null,
                'source_type' => $validated['source_type'] ?? null,
                'status' => $validated['status'] ?? $customer->status,
            ]);

            // ---- 2) UPDATE / CREATE AADHAR DETAIL ----
            if ($validated['aadhar_number'] || $aadharFront || $aadharBack) {
                CustomerAadharDetail::updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        'aadhar_number' => $validated['aadhar_number'] ?? null,
                        'aadhar_front_path' => $aadharFront,
                        'aadhar_back_path' => $aadharBack,
                    ]
                );
            } else {
                // optional: delete if all cleared
                // $customer->aadharDetail()->delete();
            }

            // ---- 3) UPDATE / CREATE PAN DETAIL ----
            if ($validated['pan_number'] || $panFront || $panBack) {
                CustomerPanCardDetail::updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        'pan_number' => $validated['pan_number'] ?? null,
                        'pan_card_front_path' => $panFront,
                        'pan_card_back_path' => $panBack,
                    ]
                );
            } else {
                // optional: delete if all cleared
                // $customer->panCardDetail()->delete();
            }

            // ---- 4) SYNC BRANCHES (customer_address_details) ----
            $existingBranchIds = $customer->addressDetails->pluck('id')->toArray();
            $sentBranchIds = [];
            $primaryBranchIndex = (int) ($validated['is_primary'] ?? 0);

            foreach ($validated['branches'] as $index => $branchData) {
                $isPrimary = ($primaryBranchIndex === (int) $index) ? 1 : 0;

                if (! empty($branchData['id'])) {
                    $branch = $customer->addressDetails()->where('id', $branchData['id'])->first();
                    if ($branch) {
                        $branch->update([
                            'branch_name' => $branchData['branch_name'],
                            'address1' => $branchData['address1'],
                            'address2' => $branchData['address2'] ?? null,
                            'city' => $branchData['city'],
                            'state' => $branchData['state'],
                            'country' => $branchData['country'],
                            'pincode' => $branchData['pincode'],
                            'is_primary' => $isPrimary,
                        ]);
                        $sentBranchIds[] = $branch->id;
                    }
                } else {
                    $branch = $customer->addressDetails()->create([
                        'branch_name' => $branchData['branch_name'],
                        'address1' => $branchData['address1'],
                        'address2' => $branchData['address2'] ?? null,
                        'city' => $branchData['city'],
                        'state' => $branchData['state'],
                        'country' => $branchData['country'],
                        'pincode' => $branchData['pincode'],
                        'is_primary' => $isPrimary,
                    ]);
                    $sentBranchIds[] = $branch->id;
                }
            }

            // delete removed branches (unchanged)
            $toDelete = array_diff($existingBranchIds, $sentBranchIds);
            if (! empty($toDelete)) {
                $customer->addressDetails()->whereIn('id', $toDelete)->delete();
            }

            // ---- 5) UPDATE / CREATE COMPANY DETAIL ----
            if (
                $validated['company_name'] ||
                $validated['gst_no'] ||
                $validated['comp_address1'] ||
                $validated['comp_city']
            ) {
                CustomerCompanyDetail::updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        'company_name' => $validated['company_name'] ?? null,
                        'comp_address1' => $validated['comp_address1'] ?? null,
                        'comp_address2' => $validated['comp_address2'] ?? null,
                        'comp_city' => $validated['comp_city'] ?? null,
                        'comp_state' => $validated['comp_state'] ?? null,
                        'comp_country' => $validated['comp_country'] ?? null,
                        'comp_pincode' => $validated['comp_pincode'] ?? null,
                        'gst_no' => $validated['gst_no'] ?? null,
                    ]
                );
            } else {
                // optional: delete if all cleared
                // $customer->companyDetail()->delete();
            }
        });

        return redirect()->route('customer.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete(); // this now sets deleted_at instead of hard-deleting

        return redirect()->route('customer.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function ec_index()
    {
        // Filter to show only E-commerce customers
        $customers = Customer::with('branches')
            ->ecommerce()
            ->get();

        return view('/e-commerce/customer/index', compact('customers'));
    }

    public function ec_create()
    {
        return view('/e-commerce/customer/create');
    }

    public function ec_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // Personal details
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'nullable|min:10',
            'email' => 'required|email|unique:customers,email',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:0,1',

            // Address details (optional for e-commerce customers)
            'address' => 'nullable',
            'address2' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'pincode' => 'nullable|min:6',

            // Business details (optional for e-commerce customers)
            'company_name' => 'nullable',
            'company_addr' => 'nullable',
            'gst_no' => 'nullable',
            'pan_no' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer = new Customer;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->dob = $request->dob;
        $customer->gender = $request->gender == '1' ? 'male' : 'female';
        $customer->customer_type = 'E-commerce Customer'; // Fixed customer type for e-commerce
        $customer->company_name = $request->company_name;
        $customer->company_addr = $request->company_addr;
        $customer->gst_no = $request->gst_no;
        $customer->pan_no = $request->pan_no;
        $customer->status = 'active';
        if ($request->hasFile('pic')) {
            $file = $request->file('pic');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/customer/pic'), $filename);
            $customer->pic = 'uploads/crm/customer/pic/'.$filename;
        }
        $customer->save();

        // dd($customer);
        $customer_address = CustomerAddressDetails::where('customer_id', $customer->id)->first();
        if (! $customer_address) {
            $customer_address = new CustomerAddressDetails;
            $customer_address->customer_id = $customer->id;
        }
        $customer_address->branch_name = $request->branch_name;
        $customer_address->address = $request->address;
        $customer_address->address2 = $request->address2;
        $customer_address->city = $request->city;
        $customer_address->state = $request->state;
        $customer_address->country = $request->country;
        $customer_address->pincode = $request->pincode;
        $customer_address->save();

        if (! $customer) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('ec.customer.index')->with('success', 'Customer added successfully.');
    }

    public function ec_view($id)
    {
        $customer = Customer::find($id);
        $customer_address = CustomerAddressDetails::where('customer_id', $id)->get();

        return view('/e-commerce/customer/view', compact('customer', 'customer_address'));
    }

    public function ec_edit($id)
    {
        $customer = Customer::find($id);
        $customer_address = CustomerAddressDetails::where('customer_id', $id)->get();

        return view('/e-commerce/customer/edit', compact('customer', 'customer_address'));
    }

    public function ec_update(Request $request, $id)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer = Customer::findOrFail($id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->dob = $request->dob;
        $customer->gender = $request->gender;
        $customer->customer_type = $request->customer_type;
        $customer->company_name = $request->company_name;
        $customer->company_addr = $request->company_addr;
        $customer->gst_no = $request->gst_no;
        $customer->pan_no = $request->pan_no;
        if ($request->hasFile('pic')) {

            // Only if updating profile
            if ($customer->pic != '') {
                if (File::exists(public_path($customer->pic))) {
                    File::delete(public_path($customer->pic));
                }
            }
            // updating profile end

            $file = $request->file('pic');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/customer/pic'), $filename);
            $customer->pic = 'uploads/crm/customer/pic/'.$filename;
        }
        $customer->save();

        $customer_address = new CustomerAddressDetails;
        $customer_address->customer_id = $customer->id;
        $customer_address->branch_name = $request->branch_name;
        $customer_address->address = $request->address;
        $customer_address->address2 = $request->address2;
        $customer_address->city = $request->city;
        $customer_address->state = $request->state;
        $customer_address->country = $request->country;
        $customer_address->pincode = $request->pincode;
        $customer_address->save();

        return redirect()->route('ec.customer.index')->with('success', 'Customer updated successfully.');
    }

    public function ec_delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('ec.customer.index')->with('success', 'Customer deleted successfully.');
    }

    // app/Http/Controllers/CustomerController.php

    public function searchByFirstName(Request $request)
    {
        $email = $request->get('email');

        if (! $email) {
            return response()->json(['found' => false]);
        }

        $customer = \App\Models\Customer::with('addressDetails', 'companyDetails', 'panCardDetails')
            ->where('email', $email)
            ->first();

        if (! $customer) {
            return response()->json(['found' => false]);
        }

        $customer_address = $customer->addressDetails->first();
        $customer_company = $customer->companyDetails->first();
        $customer_pan = $customer->panCardDetails->first();

        return response()->json([
            'found' => true,
            'customer' => [
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'dob' => $customer->dob,
                'gender' => $customer->gender,

                // CUSTOMER ADDRESS (form ke Customer Details section ke liye)
                'cust_branch_name' => $customer_address->branch_name ?? null,
                'cust_address1' => $customer_address->address1 ?? null,
                'cust_address2' => $customer_address->address2 ?? null,
                'cust_country' => $customer_address->country ?? null,
                'cust_state' => $customer_address->state ?? null,
                'cust_city' => $customer_address->city ?? null,
                'cust_pincode' => $customer_address->pincode ?? null,

                // COMPANY DETAILS
                'company_name' => $customer_company->company_name ?? null,
                'gst_no' => $customer_company->gst_no ?? null,

                // COMPANY ADDRESS (form ke Company section ke liye)
                'comp_address1' => $customer_company->comp_address1 ?? null,
                'comp_address2' => $customer_company->comp_address2 ?? null,
                'comp_country' => $customer_company->comp_country ?? null,
                'comp_state' => $customer_company->comp_state ?? null,
                'comp_city' => $customer_company->comp_city ?? null,
                'comp_pincode' => $customer_company->comp_pincode ?? null,

                // PAN
                'pan_no' => $customer_pan->pan_number ?? null,
            ],
        ]);
    }
}
