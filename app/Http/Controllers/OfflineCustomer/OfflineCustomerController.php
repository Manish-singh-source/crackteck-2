<?php

namespace App\Http\Controllers\OfflineCustomer;

use App\Http\Controllers\Controller;
use App\Models\Amc;
use App\Models\CustomerAddressDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OfflineCustomerController extends Controller
{
    //
    public function index()
    {
        $customer = Auth::guard('customer_web')->user();

        return view('offline-users-dashboard.index', compact('customer'));
    }

    public function amc()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }

        // Debug: Check what Auth::id() returns
        $customerId = Auth::guard('customer_web')->id();

        // If using Customer model, get the actual customer ID
        $customer = Auth::guard('customer_web')->user();
        if ($customer instanceof \App\Models\Customer) {
            $customerId = $customer->id;
        }

        $servicesRequest = Amc::with('customer')
            ->withCount('amcProducts')
            ->where('customer_id', $customerId)
            ->whereNotNull('amc_plan_id')
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($servicesRequest);
        return view('offline-users-dashboard.amc', compact('servicesRequest'));
    }

    /**
     * Display detailed view of a specific AMC service
     */
    public function amcView($id)
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:amcs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('my-account-amc')->with('error', 'AMC service not found.');
        }

        try {

            $amcService = Amc::with([
                'amcPlan',
                'customer',
                'customer.companyDetails',
                'customer.branches',
                'amcProducts',
                'amcScheduleMeetings',
                'amcScheduleMeetings.activeAssignment.engineer',
            ])
                ->withCount('amcProducts')
                ->where('id', $id)->where('customer_id', $customerId)->firstOrFail();

            return view('offline-users-dashboard.amc-view', compact('amcService'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error viewing AMC service: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error loading AMC service details.');
        }
    }

    /**
     * Display list of tickets for the logged-in customer
     */
    public function ticket()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('offlinelogin')->with('error', 'Please login to view your tickets.');
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $amcTickets = \App\Models\AmcTicket::with(['customer', 'amc'])
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offline-users-dashboard.ticket', compact('amcTickets'));
    }

    /**
     * Display detailed view of a specific ticket
     */
    public function ticketView($id)
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('offlinelogin')->with('error', 'Please login to view ticket details.');
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $amcTicket = \App\Models\AmcTicket::with(['customer', 'amc'])
            ->where('id', $id)
            ->where('customer_id', $customerId)
            ->firstOrFail();

        return view('offline-users-dashboard.ticket-detail', compact('amcTicket'));
    }

    public function accountDetail()
    {
        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();
        $primaryAddress = CustomerAddressDetail::where('is_primary', 'yes')
            ->where('customer_id', $customerId)
            ->first();
        // dd($customer,$primaryAddress);

        return view('offline-users-dashboard.account-detail', compact('customer', 'primaryAddress'));
    }

    public function address()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('offlinelogin')->with('error', 'Please login to view your addresses.');
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $addresses = CustomerAddressDetail::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offline-users-dashboard.address', compact('addresses', 'customer'));
    }

    public function changePassword()
    {
        return view('offline-users-dashboard.password');
    }

    /**
     * Update customer password
     */
    public function updatePassword(Request $request)
    {
        // Check if customer is authenticated
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to change password.',
            ], 401);
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $customer = \App\Models\Customer::find($customerId);

            if (! $customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            // Update password
            $customer->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating password: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating password. Please try again.',
            ], 500);
        }
    }

    /**
     * Update customer profile
     */
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $customer = \App\Models\Customer::find($customerId);

            if (! $customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->phone = $request->phone;
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating customer profile: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating profile. Please try again.',
            ], 500);
        }
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        // Check if customer is authenticated
        $isAuthenticated = Auth::guard('customer_web')->check();

        if (! $isAuthenticated) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add an address. Auth: '.($isAuthenticated ? 'yes' : 'no'),
            ], 401);
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $validator = Validator::make($request->all(), [
            'branch_name' => 'nullable|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Check if setting as default (handle checkbox properly)
            $isDefault = $request->is_default === true || $request->is_default === 'true' || $request->is_default === '1' || $request->is_default === 1;

            // If setting as default, remove default from other addresses
            if ($isDefault) {
                CustomerAddressDetail::where('customer_id', $customerId)->update(['is_primary' => 'no']);
            }

            $address = new CustomerAddressDetail;
            $address->customer_id = $customerId;
            $address->branch_name = $request->branch_name ?? 'Home';
            $address->address1 = $request->address1;
            $address->address2 = $request->address2;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->country = $request->country;
            $address->pincode = $request->pincode;
            $address->is_primary = $isDefault ? 'yes' : 'no';
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Address added successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing address: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error adding address: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get address for editing
     */
    public function editAddress($id)
    {
        // Check if customer is authenticated
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to edit address.',
            ], 401);
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        try {
            $address = CustomerAddressDetail::where('id', $id)
                ->where('customer_id', $customerId)
                ->first();

            if (! $address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Address not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'address' => $address,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading address: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error loading address.',
            ], 500);
        }
    }

    /**
     * Update existing address
     */
    public function updateAddress(Request $request, $id)
    {
        // Check if customer is authenticated
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to update address.',
            ], 401);
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $validator = Validator::make($request->all(), [
            'branch_name' => 'nullable|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $address = CustomerAddressDetail::where('id', $id)
                ->where('customer_id', $customerId)
                ->first();

            if (! $address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Address not found',
                ], 404);
            }

            // If setting as default, remove default from other addresses
            if ($request->is_default) {
                CustomerAddressDetail::where('customer_id', $customerId)
                    ->where('id', '!=', $id)
                    ->update(['is_primary' => 'no']);
            }

            $address->branch_name = $request->branch_name ?? $address->branch_name ?? 'Home';
            $address->address1 = $request->address1;
            $address->address2 = $request->address2;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->country = $request->country;
            $address->pincode = $request->pincode;
            $address->is_primary = $request->is_default ? 'yes' : ($address->is_primary ?? 'no');
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating address: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating address. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete address
     */
    public function deleteAddress($id)
    {
        // Check if customer is authenticated
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to delete address.',
            ], 401);
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        try {
            $address = CustomerAddressDetail::where('id', $id)
                ->where('customer_id', $customerId)
                ->first();

            if (! $address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Address not found',
                ], 404);
            }

            $wasPrimary = $address->is_primary === 'yes';
            $address->delete();

            // If deleted address was primary, set another address as primary
            if ($wasPrimary) {
                $firstAddress = CustomerAddressDetail::where('customer_id', $customerId)
                    ->first();
                if ($firstAddress) {
                    $firstAddress->is_primary = 'yes';
                    $firstAddress->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting address: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting address. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a new AMC ticket for offline user
     */
    public function storeAmcTicket(Request $request)
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to raise a ticket.',
            ], 401);
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $validator = Validator::make($request->all(), [
            'amc_id' => 'required|exists:amcs,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $amc = Amc::where('id', $request->amc_id)->where('customer_id', $customerId)->first();

            if (! $amc) {
                return response()->json([
                    'success' => false,
                    'message' => 'AMC service not found.',
                ], 404);
            }

            $ticket = \App\Models\AmcTicket::create([
                'ticket_no' => \App\Models\AmcTicket::generateTicketNo(),
                'customer_id' => $customerId,
                'amc_id' => $request->amc_id,
                'service_id' => $amc->request_id,
                'subject' => $request->subject,
                'description' => $request->description,
                'priority' => 'low',
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket raised successfully!',
                'ticket' => $ticket,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating AMC ticket: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error creating ticket: '.$e->getMessage(),
            ], 500);
        }
    }
}
