<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('login');
    }

    // public function loginStore(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect()->intended('demo/crm/index');
    //     } elseif (Auth::guard('staff_web')->attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect()->intended('demo/crm/index');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match.',
    //     ]);
    // }

    public function loginStore(Request $request)
    {
        // Check if this is a phone login
        if ($request->has('login_type') && $request->login_type == 'phone') {
            $request->validate([
                'phone' => 'required|digits:10',
                'otp' => 'required|digits:4',
            ]);

            // Find staff by phone number
            $staff = Staff::where('phone', $request->phone)->first();

            if (!$staff) {
                return back()->withErrors([
                    'phone' => 'Phone number not found.',
                ])->withInput();
            }

            // Check if OTP is valid and not expired
            if ($staff->otp != $request->otp) {
                return back()->withErrors([
                    'otp' => 'Invalid OTP.',
                ])->withInput();
            }

            if (!$staff->otp_expiry || $staff->otp_expiry < now()) {
                return back()->withErrors([
                    'otp' => 'OTP has expired. Please request a new OTP.',
                ])->withInput();
            }

            // Clear OTP after successful verification
            $staff->update([
                'otp' => null,
                'otp_expiry' => null,
            ]);

            // Login the staff
            Auth::guard('staff_web')->login($staff);
            $request->session()->regenerate();

            return redirect()->intended('demo/crm/index');
        }

        // Regular email/password login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('staff_web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('demo/crm/index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match.',
        ])->onlyInput('email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        // Check if phone exists in staff table
        $staff = Staff::where('phone', $request->phone)->first();

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number not found in our records.',
            ], 422);
        }

        // Generate 4-digit OTP
        $otp = rand(1000, 9999);

        // OTP expires in 10 minutes
        $otpExpiry = now()->addMinutes(10);

        // Save OTP to staff table
        $staff->update([
            'otp' => $otp,
            'otp_expiry' => $otpExpiry,
        ]);

        // In production, you would send SMS here
        // For demo, return the OTP in response
        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully!',
            'otp' => $otp, // Remove this in production
        ]);
    }

    public function signup()
    {
        return view('signup');
    }

    public function profile()
    {
        $users = Auth::user();

        return view('/crm/profile', compact('users'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful.');
    }

    public function recover_password()
    {
        return view('recover-password');
    }

    public function logout(Request $request)
    {
        if (Auth::logout() || Auth::guard('staff_web')->logout()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }
}
