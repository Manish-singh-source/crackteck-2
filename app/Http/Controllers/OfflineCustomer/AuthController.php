<?php

namespace App\Http\Controllers\OfflineCustomer;
use App\Http\Controllers\Controller;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Custom guard for offline customers
    protected function guard()
    {
        return Auth::guard('customer_web');
    }

    //
    public function login()
    {
        // If already logged in, redirect to index
        if (Auth::guard('customer_web')->check()) {
            return redirect()->route('index');
        }
        
        return view('offline-users-dashboard.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Find customer by email
        $customer = Customer::where('email', $email)->first();

        // dd($customer);
        // Check if customer exists and password matches
        if (!$customer) {
            return back()->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'No account found with this email address.',
                ]);
        }

        // Check if password matches (supports both hashed and plain text for migration)
        $passwordMatch = false;
        if ($customer->password && strlen($customer->password) < 60) {
            // Plain text password, check directly
            if ($customer->password === $password) {
                $passwordMatch = true;
                // Hash the password for future
                $customer->password = Hash::make($password);
                $customer->save();
            }
        } elseif (Hash::check($password, $customer->password)) {
            // Hashed password matches
            $passwordMatch = true;
        }

        if (!$passwordMatch) {
            return back()->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        // Check if customer status is active
        if (isset($customer->status) && $customer->status != 'active') {
            return back()->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Your account is not active. Please contact support.',
                ]);
        }

        // Login the customer
        Auth::guard('customer_web')->login($customer);

        $request->session()->regenerate();

        // Redirect to intended URL or index page
        $redirectUrl = session()->pull('url.intended', route('index'));
        return redirect($redirectUrl)->with('success', 'Welcome back, ' . $customer->first_name . '!');
    }

    public function recover_password()
    {
        return view('offline-users-dashboard.password');
    }

    public function offlinelogout(Request $request)
    {
        Auth::guard('customer_web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('offlinelogin');
    }
}
