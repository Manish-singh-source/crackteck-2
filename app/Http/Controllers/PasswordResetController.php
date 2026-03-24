<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Staff;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Display the forgot password form based on source.
     */
    public function showForgotPasswordForm(Request $request)
    {
        $source = $request->query('source', 'frontend');

        return view('auth.forgot-password', compact('source'));
    }

    /**
     * Handle sending password reset link.
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'user_type' => 'required|in:customer,staff',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $userType = $request->user_type;

        // Find user based on user_type
        $user = null;
        if ($userType === 'customer') {
            $user = Customer::where('email', $email)->first();
        } elseif ($userType === 'staff') {
            $user = Staff::where('email', $email)->first();
        }

        if (!$user) {
            // For security reasons, don't reveal if email exists or not
            // But for better UX, we can show a message
            return back()->with('error', 'We couldn\'t find an account with this email address.')
                ->withInput();
        }

        // Generate unique token
        $token = Str::random(64);

        // Delete any existing tokens for this email and user type
        DB::table('password_resets')
            ->where('email', $email)
            ->where('user_type', $userType)
            ->delete();

        // Insert new token
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'user_type' => $userType,
            'created_at' => now(),
        ]);

        // Send password reset email
        try {
            $resetUrl = route('password.reset', [
                'token' => $token,
                'email' => $email,
                'user_type' => $userType,
            ]);

            $mail = Mail::to($email)->send(new PasswordResetMail($user, $resetUrl, $userType));
            if ($mail) {
                return back()->with('success', 'We have emailed your password reset link!');
            }
            return back()->with('error', 'Failed to send password reset email. Please try again later.')
                ->withInput();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Password reset email failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to send password reset email. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Display the password reset form.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        $userType = $request->query('user_type', 'customer');

        return view('auth.reset-password', compact('token', 'email', 'userType'));
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required|in:customer,staff',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('user_type', $request->user_type)
            ->first();

        if (!$tokenData) {
            return back()->with('error', 'Invalid or expired password reset token.')
                ->withInput();
        }

        // Check if token is expired (1 hour)
        if ($tokenData->created_at && now()->diffInMinutes($tokenData->created_at) > 60) {
            DB::table('password_resets')
                ->where('email', $request->email)
                ->where('user_type', $request->user_type)
                ->delete();

            return back()->with('error', 'Password reset token has expired. Please request a new one.')
                ->withInput();
        }

        // Find and update user password
        $user = null;
        if ($request->user_type === 'customer') {
            $user = Customer::where('email', $request->email)->first();
        } elseif ($request->user_type === 'staff') {
            $user = Staff::where('email', $request->email)->first();
        }

        if (!$user) {
            return back()->with('error', 'User not found.')
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the used token
        DB::table('password_resets')
            ->where('email', $request->email)
            ->where('user_type', $request->user_type)
            ->delete();

        if ($request->user_type === 'customer') {
            return redirect()->route('frontend.login')->with('success', 'Your password has been reset successfully. Please login with your new password.');
        } elseif ($request->user_type === 'staff') {
            return redirect()->route('login')->with('success', 'Your password has been reset successfully. Please login with your new password.');
        }
    }

    /**
     * API: Send password reset link (for AJAX requests from frontend modal)
     */
    public function apiSendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'user_type' => 'required|in:customer,staff',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $email = $request->email;
        $userType = $request->user_type;

        // Find user based on user_type
        $user = null;
        if ($userType === 'customer') {
            $user = Customer::where('email', $email)->first();
        } elseif ($userType === 'staff') {
            $user = Staff::where('email', $email)->first();
        }

        if (!$user) {
            // Don't reveal if email exists
            return response()->json([
                'success' => true,
                'message' => 'If an account exists with this email, you will receive a password reset link.'
            ]);
        }

        // Generate unique token
        $token = Str::random(64);

        // Delete any existing tokens
        DB::table('password_resets')
            ->where('email', $email)
            ->where('user_type', $userType)
            ->delete();

        // Insert new token
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'user_type' => $userType,
            'created_at' => now(),
        ]);

        // Send password reset email
        try {
            $resetUrl = route('password.reset', [
                'token' => $token,
                'email' => $email,
                'user_type' => $userType,
            ]);

            Mail::to($email)->send(new PasswordResetMail($user, $resetUrl, $userType));

            return response()->json([
                'success' => true,
                'message' => 'Password reset link has been sent to your email.'
            ]);
        } catch (\Exception $e) {
            Log::error('Password reset email failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send password reset email. Please try again later.'
            ], 500);
        }
    }

    /**
     * API: Reset password (for AJAX requests)
     */
    public function apiResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required|in:customer,staff',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('user_type', $request->user_type)
            ->first();

        if (!$tokenData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired password reset token.'
            ], 422);
        }

        // Check if token is expired
        if ($tokenData->created_at && now()->diffInMinutes($tokenData->created_at) > 60) {
            DB::table('password_resets')
                ->where('email', $request->email)
                ->where('user_type', $request->user_type)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'Password reset token has expired. Please request a new one.'
            ], 422);
        }

        // Find and update user
        $user = null;
        if ($request->user_type === 'customer') {
            $user = Customer::where('email', $request->email)->first();
        } elseif ($request->user_type === 'staff') {
            $user = Staff::where('email', $request->email)->first();
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the used token
        DB::table('password_resets')
            ->where('email', $request->email)
            ->where('user_type', $request->user_type)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your password has been reset successfully.'
        ]);
    }
}
