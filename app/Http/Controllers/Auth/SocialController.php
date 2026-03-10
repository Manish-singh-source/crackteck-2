<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the OAuth provider.
     */
    public function redirectToProvider(Request $request, string $provider)
    {
        // Get source from request (customer or admin)
        $source = $request->get('source', 'customer');
        
        // Validate source
        if (!in_array($source, ['customer', 'admin'])) {
            return redirect()->route('login')
                ->with('error', 'Invalid source parameter.');
        }

        // Validate provider
        if (!in_array($provider, ['google', 'facebook', 'github'])) {
            return redirect()->route('login')
                ->with('error', 'Invalid social login provider.');
        }

        // Store source in session for callback
        $request->session()->put('social_login_source', $source);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from provider.
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        // Get source from session
        $source = $request->session()->get('social_login_source', 'customer');

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'Unable to login using ' . $provider . '. Please try again.');
        }

        // Handle based on source
        if ($source === 'admin') {
            return $this->handleAdminLogin($socialUser, $provider);
        } else {
            return $this->handleCustomerLogin($socialUser, $provider);
        }
    }

    /**
     * Handle admin (Staff) login.
     */
    protected function handleAdminLogin($socialUser, string $provider)
    {
        // Find existing by provider + provider_id first
        $staff = Staff::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        // If not found, try by email, then create new
        if (! $staff && $socialUser->getEmail()) {
            $staff = Staff::where('email', $socialUser->getEmail())->first();
        }

        if (! $staff) {
            $staff = new Staff();
            $staff->email_verified_at = now();
            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? '';

            $parts = explode(' ', $name);
            $staff->first_name = array_shift($parts);
            $staff->last_name  = implode(' ', $parts);

            $nextNumber = (Staff::max('id') ?? 0) + 1;
            $staffCode = 'STF' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $staff->staff_code = $staffCode;
            $staff->staff_role = 'staff';

            $staff->email = $socialUser->getEmail();
            $staff->joining_date = now();
            $staff->provider = $provider;
            $staff->provider_id = $socialUser->getId();
            $staff->avatar = $socialUser->getAvatar();
            $staff->save();
        } else {
            // Update existing user with provider info
            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? '';
            $parts = explode(' ', $name);
            $staff->first_name = array_shift($parts);
            $staff->last_name  = implode(' ', $parts);
            $staff->provider = $provider;
            $staff->provider_id = $socialUser->getId();
            $staff->avatar = $socialUser->getAvatar();
            $staff->save();
        }

        // Login the staff
        Auth::guard('staff_web')->login($staff, true);

        return redirect()->intended('demo/crm/index');
    }

    /**
     * Handle customer login.
     */
    protected function handleCustomerLogin($socialUser, string $provider)
    {
        // Find existing customer by provider + provider_id first
        $customer = Customer::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        // If not found, try by email, then create new
        if (! $customer && $socialUser->getEmail()) {
            $customer = Customer::where('email', $socialUser->getEmail())->first();
        }

        if (! $customer) {
            $lastCustomer = Customer::orderBy('id', 'desc')->first();
            $lastCustomerCode = $lastCustomer?->customer_code ?? 'CUST0000';
            $customerCode = str_replace('CUST', '', $lastCustomerCode);
            $customerCode = (int) $customerCode + 1;
            $customerCode = 'CUST' . str_pad($customerCode, 4, '0', STR_PAD_LEFT);

            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? '';
            $parts = explode(' ', $name);
            $firstName = array_shift($parts);
            $lastName = implode(' ', $parts);

            $customer = Customer::create([
                'customer_code' => $customerCode,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $socialUser->getEmail(),
                'customer_type' => 'ecommerce',
                'source_type' => 'ecommerce',
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'status' => 'active',
            ]);
        } else {
            // Update existing customer with provider info
            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? '';
            $parts = explode(' ', $name);
            $customer->first_name = array_shift($parts);
            $customer->last_name = implode(' ', $parts);
            $customer->provider = $provider;
            $customer->provider_id = $socialUser->getId();
            $customer->save();
        }

        // Login the customer
        Auth::guard('customer_web')->login($customer);

        return redirect()->intended('/beta')->with('success', 'Login successful via ' . ucfirst($provider));
    }
}
