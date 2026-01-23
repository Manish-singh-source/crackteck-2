<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\CustomerAadharDetail;
use App\Models\CustomerAddressDetail;
use App\Models\CustomerCompanyDetail;
use App\Models\CustomerPanCardDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function index(Request $request)
    {
        // Filter to show only CRM customers (Retail, Wholesale, Corporate, AMC Customer)
        $customer = Customer::query();

        if ($status = request()->get('status')) {
            $customer->where('status', $status);
        }

        $customers = $customer->where('customer_type', '!=', 'ecommerce')->with('branches')->get();
        // dd($customers);

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

    public function store(StoreCustomerRequest $request)
    {

        $validated = $request->validated();

        \DB::transaction(function () use ($request, $validated) {

            // customer_code
            $lastCustomer = Customer::orderBy('id', 'desc')->first();
            $lastCustomerCode = $lastCustomer?->customer_code ?? 'CUST0000';
            $customerCode = str_replace('CUST', '', $lastCustomerCode);
            $customerCode = (int) $customerCode + 1;

            $customerCode = 'CUST' . str_pad($customerCode, 4, '0', STR_PAD_LEFT);

            // 1. Create Customer
            $customer = Customer::create([
                'customer_code' => $customerCode,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'dob' => $validated['dob'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'customer_type' => $validated['customer_type'] ?? 'ecommerce',
                'source_type' => $validated['source_type'] ?? 'admin_panel',
                'profile' => $profile ?? null,
                'status' => $validated['status'] ?? 'active',
                'is_lead' => $validated['is_lead'] ?? 0,
            ]);

            // Handle files
            $profile = $request->file('profile')?->store('customers/profile', 'public');
            $aadharFront = $request->file('aadhar_front_path')?->store('customers/aadhar', 'public');
            $aadharBack = $request->file('aadhar_back_path')?->store('customers/aadhar', 'public');
            $panFront = $request->file('pan_card_front_path')?->store('customers/pan', 'public');
            $panBack = $request->file('pan_card_back_path')?->store('customers/pan', 'public');

            if ($request->file('profile')) {
                $customer->profile = $profile;
                $customer->save();
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

            // 4. Branches
            $primaryBranch = $validated['is_primary'] ?? 'no';
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
                    'is_primary' => ($index == $primaryBranch) ? 'yes' : 'no',
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

        if ($request->getRequestUri() == '/demo/crm/store-customer') {
            return redirect()->route('customer.index')
                ->with('success', 'Customer created successfully.');
        } else {
            return redirect()->route('ec.customer.index')
                ->with('success', 'Customer created successfully.');
        }
    }

    public function view($id)
    {
        $customer = Customer::with(['branches'])->find($id);

        return view('/crm/customer/view', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::with(['branches', 'aadharDetails', 'panCardDetails', 'companyDetails'])->find($id);

        // dd($customer);
        return view('/crm/customer/edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        // dd($request->all());
        $customer = Customer::with([
            'aadharDetails',
            'panCardDetails',
            'addressDetails',
            'companyDetails',
        ])->findOrFail($id);

        $validated = $request->validated();

        \DB::transaction(function () use ($request, $validated, $customer) {

            /* ================= FILES ================= */
            // Profile
            $profile = $customer->profile;
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile')
                    ->store('customers/profile', 'public');
            }

            /* ================= CUSTOMER ================= */
            $customer->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'dob' => $validated['dob'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'customer_type' => $validated['customer_type'] ?? null,
                'source_type' => $validated['source_type'] ?? null,
                'profile' => $profile,
                'status' => $validated['status'] ?? $customer->status,
                'is_lead' => $validated['is_lead'] ?? $customer->is_lead,
            ]);

            /* ================= AADHAR ================= */
            $customerAadhar = CustomerAadharDetail::where('customer_id', $customer->id)->first();

            if ($validated['aadhar_number']) {
                $customerAadhar->aadhar_number = $validated['aadhar_number'];
            }

            if ($request->hasFile('aadhar_front_path')) {
                $aadharFront = $request->file('aadhar_front_path')
                    ->store('customers/aadhar', 'public');
                $customerAadhar->aadhar_front_path = $aadharFront;
            }

            if ($request->hasFile('aadhar_back_path')) {
                $aadharBack = $request->file('aadhar_back_path')
                    ->store('customers/aadhar', 'public');
                $customerAadhar->aadhar_back_path = $aadharBack;
            }
            $customerAadhar->save();

            /* ================= PAN ================= */
            $customerPan = CustomerPanCardDetail::where('customer_id', $customer->id)->first();

            if ($validated['pan_number']) {
                $customerPan->pan_number = $validated['pan_number'];
            }

            if ($request->hasFile('pan_card_front_path')) {
                $panFront = $request->file('pan_card_front_path')
                    ->store('customers/pan', 'public');
                $customerPan->pan_card_front_path = $panFront;
            }

            if ($request->hasFile('pan_card_back_path')) {
                $panBack = $request->file('pan_card_back_path')
                    ->store('customers/pan', 'public');
                $customerPan->pan_card_back_path = $panBack;
            }
            $customerPan->save();

            /* ================= BRANCHES ================= */
            $existingIds = $customer->addressDetails->pluck('id')->toArray();
            $sentIds = [];
            $primaryIndex = (int) ($validated['is_primary'] ?? 'no');

            foreach ($validated['branches'] as $index => $branch) {
                $isPrimary = ($index === $primaryIndex) ? 'yes' : 'no';

                if (!empty($branch['id'])) {
                    $address = $customer->addressDetails()->find($branch['id']);
                    $address?->update([
                        'branch_name' => $branch['branch_name'],
                        'address1' => $branch['address1'],
                        'address2' => $branch['address2'] ?? null,
                        'city' => $branch['city'],
                        'state' => $branch['state'],
                        'country' => $branch['country'],
                        'pincode' => $branch['pincode'],
                        'is_primary' => $isPrimary,
                    ]);
                    $sentIds[] = $branch['id'];
                } else {
                    $new = $customer->addressDetails()->create([
                        'branch_name' => $branch['branch_name'],
                        'address1' => $branch['address1'],
                        'address2' => $branch['address2'] ?? null,
                        'city' => $branch['city'],
                        'state' => $branch['state'],
                        'country' => $branch['country'],
                        'pincode' => $branch['pincode'],
                        'is_primary' => $isPrimary,
                    ]);
                    $sentIds[] = $new->id;
                }
            }

            $deleteIds = array_diff($existingIds, $sentIds);
            if ($deleteIds) {
                $customer->addressDetails()->whereIn('id', $deleteIds)->delete();
            }

            /* ================= COMPANY ================= */
            if (
                $validated['company_name'] ||
                $validated['gst_no'] ||
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
            }
        });

        // return redirect()->route('customer.index')
        //     ->with('success', 'Customer updated successfully.');
        // remove id from url 
        $url = str_replace('/' . $id, '', $request->getRequestUri());

        if ($url == '/demo/crm/update-customer') {
            return redirect()->route('customer.index')
                ->with('success', 'Customer updated successfully.');
        } else {
            return redirect()->route('ec.customer.index')
                ->with('success', 'Customer updated successfully.');
        }
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete(); // this now sets deleted_at instead of hard-deleting

        return redirect()->route('customer.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function ec_index(Request $request)
    {
        // Filter to show only E-commerce customers (status)
        $customer = Customer::query();

        if ($status = request()->get('status')) {
            $customer->where('status', $status);
        }

        $customers = $customer->where('customer_type', 'ecommerce')->get();

        return view('/e-commerce/customer/index', compact('customers'));

        // $customers = Customer::with('branches', 'orders')
        //     ->where('customer_type', 'ecommerce')
        //     ->get();
    }

    public function ec_create()
    {
        return view('/e-commerce/customer/create');
    }

    public function ec_view($id)
    {
        $customer = Customer::find($id);
        $customer_address = CustomerAddressDetail::where('customer_id', $id)->get();

        return view('/e-commerce/customer/view', compact('customer', 'customer_address'));
    }

    public function ec_edit($id)
    {
        $customer = Customer::find($id);
        $customer_address = CustomerAddressDetail::where('customer_id', $id)->get();

        return view('/e-commerce/customer/edit', compact('customer', 'customer_address'));
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
