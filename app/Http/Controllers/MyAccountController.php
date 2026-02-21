<?php

namespace App\Http\Controllers;

use App\Models\Amc;
use App\Models\CustomerAddressDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MyAccountController extends Controller
{
    /**
     * Display the user's addresses page.
     */
    public function addresses()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Debug: Check what Auth::id() returns
        $customerId = Auth::id();

        // If using Customer model, get the actual customer ID
        $customer = Auth::user();
        if ($customer instanceof \App\Models\Customer) {
            $customerId = $customer->id;
        }

        $addresses = CustomerAddressDetail::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.my-account-address', compact('addresses'));
    }

    /**
     * Store a new address.
     */
    public function storeAddress(Request $request): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add addresses.',
            ], 401);
        }

        // Get customer ID from authenticated user
        $customer = Auth::user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $request->validate([
            'address1' => 'required|string|max:500',
            'address2' => 'nullable|string|max:500',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();

            // Check if this address should be set as default (is_primary = 'yes')
            $isPrimary = $request->has('is_default') ? 'yes' : 'no';

            // If this address is being set as default, remove default from others
            if ($isPrimary === 'yes') {
                CustomerAddressDetail::where('customer_id', $customerId)
                    ->update(['is_primary' => 'no']);
            }

            $address = CustomerAddressDetail::create([
                'customer_id' => $customerId,
                'branch_name' => $request->input('branch_name', 'Primary'),
                'address1' => $request->address1,
                'address2' => $request->address2,
                'state' => $request->state,
                'city' => $request->city,
                'country' => $request->country,
                'pincode' => $request->pincode,
                'is_primary' => $isPrimary,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Address added successfully!',
                'address' => $address,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the address.',
            ], 500);
        }
    }

    /**
     * Get address data for editing.
     */
    public function getAddress($id): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to access addresses.',
            ], 401);
        }

        $customer = Auth::user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $address = CustomerAddressDetail::where('id', $id)
            ->where('customer_id', $customerId)
            ->first();

        if (! $address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'address' => $address,
        ]);
    }

    /**
     * Update an existing address.
     */
    public function updateAddress(Request $request, $id): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to update addresses.',
            ], 401);
        }

        $customer = Auth::user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $address = CustomerAddressDetail::where('id', $id)
            ->where('customer_id', $customerId)
            ->first();

        if (! $address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ], 404);
        }

        $request->validate([
            'address1' => 'required|string|max:500',
            'address2' => 'nullable|string|max:500',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();

            // Check if this address should be set as default (is_primary = 'yes')
            $isPrimary = $request->has('is_default') ? 'yes' : 'no';

            // If this address is being set as default, remove default from others
            if ($isPrimary === 'yes' && $address->is_primary !== 'yes') {
                CustomerAddressDetail::where('customer_id', $customerId)
                    ->where('id', '!=', $id)
                    ->update(['is_primary' => 'no']);
            }

            $address->update([
                'branch_name' => $request->input('branch_name', $address->branch_name),
                'address1' => $request->address1,
                'address2' => $request->address2,
                'state' => $request->state,
                'city' => $request->city,
                'country' => $request->country,
                'pincode' => $request->pincode,
                'is_primary' => $isPrimary,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!',
                'address' => $address->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the address.',
            ], 500);
        }
    }

    /**
     * Delete an address.
     */
    public function deleteAddress($id): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to delete addresses.',
            ], 401);
        }

        $customer = Auth::user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $address = CustomerAddressDetail::where('id', $id)
            ->where('customer_id', $customerId)
            ->first();

        if (! $address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ], 404);
        }

        try {
            $address->delete();

            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the address.',
            ], 500);
        }
    }

    /**
     * Show account details page
     */
    public function accountDetails()
    {
        $customer = Auth::user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();
        $primaryAddress = CustomerAddressDetail::where('is_primary', 'yes')
            ->where('customer_id', $customerId)
            ->first();
        // dd($customer,$primaryAddress);

        return view('frontend.my-account-edit', compact('customer', 'primaryAddress'));
    }

    /**
     * Display the user's AMC service requests
     */
    public function amcServices()
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

        // Get AMC services for the logged-in user (by email)
        // $servicesRequest = \App\Models\ServiceRequest::where('customer_id', $customer->id)
        //     ->whereNotNull('amc_plan_id') // Only AMC services
        //     ->with('customer') // Load relationship (if defined in model)
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $servicesRequest = Amc::with('customer')
            ->withCount('amcProducts')
            ->where('customer_id', $customerId)
            ->whereNotNull('amc_plan_id')
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($servicesRequest);
        return view('frontend.my-account-amc', compact('servicesRequest'));
    }

    /**
     * Display detailed view of a specific AMC service
     */
    public function viewAmcService($id)
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

            return view('frontend.my-account-amc-view', compact('amcService'));
        } catch (\Exception $e) {
            Log::error('Error viewing AMC service: ' . $e->getMessage());

            return redirect()->route('my-account-amc')->with('error', 'Error loading AMC service details.');
        }
    }

    /**
     * Display the user's Non-AMC service requests
     */
    public function nonAmcServices()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }

        $user = Auth::user();

        // Get Non-AMC services for the logged-in user (by email)
        $nonAmcServices = \App\Models\NonAmcService::where('email', $user->email)
            ->with(['products'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.my-account-non-amc', compact('nonAmcServices'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $user = Auth::user();

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name, // Update full name
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show change password page
     */
    public function changePassword()
    {
        return view('frontend.my-account-password');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'new_password.min' => 'New password must be at least 8 characters long.',
            'new_password.confirmed' => 'New password and confirm password do not match.',
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password_confirmation.required' => 'Confirm password is required.',
        ]);

        try {
            $user = Auth::user();

            // Verify current password
            if (! Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.',
                ], 422);
            }

            // Check if new password is different from current password
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'New password must be different from current password.',
                ], 422);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully. Please login again with your new password.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating your password.',
            ], 500);
        }
    }
}
