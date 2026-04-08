<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\Fast2smsService;

class FrontendAuthController extends Controller
{
    /**
     * Login with phone number.
     */
    public function loginWithPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
        ]);
        
        $customer = Customer::where('phone', $request->phone)->first();
        
        if (!$customer) {
            return back()->with('error', 'No account found with this phone number');
        }
        
        // Generate and send OTP
        return $this->sendLoginOtp($request);
    }

    /**
     * Send OTP for phone login.
     */
    public function sendLoginOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
        ]);
        
        $otp = rand(1000, 9999);
        $phone = $request->phone;
        
        // Find customer and update OTP in database
        $customer = Customer::where('phone', $phone)->first();
        
        if (!$customer) {
            return back()->with('error', 'No account found with this phone number');
        }
        
        // Save OTP and expiry in customer record
        $customer->otp = $otp;
        $customer->otp_expiry = now()->addMinutes(5);
        $customer->save();
        
        // Also store in session for convenience
        $request->session()->put('login_otp', $otp);
        $request->session()->put('login_phone', $phone);
        
        // Send OTP via SMS
        $smsService = new Fast2smsService();
        $smsResponse = $smsService->sendOtp($phone, $otp);
        
        if (!$smsResponse['success']) {
            Log::warning("SMS sending failed for {$phone}: " . $smsResponse['message']);
        }
        
        Log::info("Login OTP for {$phone}: {$otp}");
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
            ]);
        }
        
        return back()->with('success', 'OTP sent to your phone number');
    }

    /**
     * Verify OTP for phone login.
     */
    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
            'otp' => 'required|string|size:4',
        ]);
        
        // Find customer by phone
        $customer = Customer::where('phone', $request->phone)->first();
        
        if (!$customer) {
            return back()->with('error', 'No account found');
        }
        
        // Check if OTP is valid and not expired
        if ($customer->otp != $request->otp) {
            return back()->with('error', 'Invalid OTP');
        }
        
        if ($customer->otp_expiry && now()->gt($customer->otp_expiry)) {
            // Clear OTP after expiry
            $customer->otp = null;
            $customer->otp_expiry = null;
            $customer->save();
            return back()->with('error', 'OTP has expired. Please request a new one.');
        }
        
        // Clear OTP after successful login
        $customer->otp = null;
        $customer->otp_expiry = null;
        $customer->save();
        
        // Login the customer
        Auth::guard('customer_web')->login($customer);
        $request->session()->forget(['login_otp', 'login_phone']);
        
        return redirect()->intended('/')->with('success', 'Login successful');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:customers',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $lastCustomer = Customer::orderBy('id', 'desc')->first();
        $lastCustomerCode = $lastCustomer?->customer_code ?? 'CUST0000';
        $customerCode = str_replace('CUST', '', $lastCustomerCode);
        $customerCode = (int) $customerCode + 1;

        $customerCode = 'CUST'.str_pad($customerCode, 4, '0', STR_PAD_LEFT);

        // Create customer directly in customers table
        $customer = Customer::create([
            'customer_code' => $customerCode,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'customer_type' => 'ecommerce',
            'source_type' => 'ecommerce',
            'status' => 'active',
        ]);

        return redirect()->route('website')->with('success', 'Registration successful. Please login.');
    }

    public function login(Request $request)
    {
        if (! Auth::guard('customer_web')->check()) {
            // return redirect()->route('login')->with('error', 'Please login to access your account.');
            return redirect()->back()->with('open_login_modal', true)->with('error', 'Please login to access your account.');
        } 

        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use the 'customer_web' guard
        if (Auth::guard('customer_web')->attempt($credentials)) {
            $request->session()->regenerate();

            // return redirect()->intended('beta/'); // customer dashboard
            return redirect()->intended('/'); // Beta Removed
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // return redirect()->intended('beta/'); // Beta Removed
        // return redirect()->intended('/beta');
        return redirect()->intended('/');
    }

    /**
     * Show e-commerce login form.
     */
    public function showEcommerceLogin()
    {
        return view('frontend.auth.login');
    }

    /**
     * Show e-commerce signup form.
     */
    public function showEcommerceSignup()
    {
        return view('frontend.auth.signup');
    }

    /**
     * Handle e-commerce login.
     */
    public function ecommerceLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if this is an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful.',
                    'redirect' => $request->input('redirect_url', route('shop')),
                ]);
            }

            return redirect()->intended(route('demo/shop'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
                'errors' => ['email' => ['The provided credentials do not match our records.']],
            ], 422);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Handle e-commerce signup.
     */
    public function ecommerceSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create corresponding customer record for e-commerce customer
        $this->createEcommerceCustomer($user, $request);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Check if this is an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful.',
                    'redirect' => $request->input('redirect_url', route('shop')),
                ]);
            }

            return redirect()->intended(route('demo/shop'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }

        return redirect()->back()->with('success', 'Registration successful.');
    }

    /**
     * Create a customer record for e-commerce user registration.
     */
    private function createEcommerceCustomer(User $user, Request $request)
    {
        Customer::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $user->email,
            'phone' => $request->phone,
            'customer_type' => 'E-commerce Customer',
            'status' => 'active',
        ]);
    }
}
