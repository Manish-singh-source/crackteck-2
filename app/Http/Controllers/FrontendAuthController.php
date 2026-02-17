<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendAuthController extends Controller
{
    //

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

        $customerCode = 'CUST' . str_pad($customerCode, 4, '0', STR_PAD_LEFT);

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
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('demo/');
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

        return redirect()->intended('demo/');
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
