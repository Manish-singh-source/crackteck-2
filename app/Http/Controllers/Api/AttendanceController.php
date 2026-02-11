<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
        ]);

        $user = Staff::findOrFail($validated['user_id']);

        // Get all authentication logs for the user
        $authLogs = AuthenticationLog::forUser($user)
            ->whereNotNull('login_at')
            ->orderBy('login_at', 'desc')
            ->get();

        // Calculate total working hours from login_at and logout_at
        $totalWorkingSeconds = 0;
        $todayWorkingSeconds = 0;
        $today = date('Y-m-d');

        foreach ($authLogs as $log) {
            if ($log->login_at && $log->logout_at) {
                $loginTime = strtotime($log->login_at);
                $logoutTime = strtotime($log->logout_at);
                $sessionSeconds = ($logoutTime - $loginTime);
                $totalWorkingSeconds += $sessionSeconds;

                // Calculate today's working hours
                if (date('Y-m-d', $loginTime) == $today) {
                    $todayWorkingSeconds += $sessionSeconds;
                }
            }
        }

        $totalWorkingHours = round($totalWorkingSeconds / 3600, 2);
        $todayWorkingHours = round($todayWorkingSeconds / 3600, 2);

        return response()->json([
            'logs' => $authLogs,
            'total_working_hours' => $totalWorkingHours,
            'today_working_hours' => $todayWorkingHours,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'role_id' => 'required|in:1,2,3,4',
        ]);

        $user = Staff::findOrFail($validated['user_id']);

        // Create a new authentication log entry manually
        $authLog = new AuthenticationLog();
        $authLog->authenticatable()->associate($user);
        $authLog->ip_address = $request->ip();
        $authLog->user_agent = $request->userAgent();
        $authLog->login_at = now();
        $authLog->login_successful = true;
        $authLog->save();

        // // Login the user via JWT
        // $token = auth('staff')->login($user);

        return response()->json([
            'message' => 'Login successful',
            'auth_log' => $authLog,
            // 'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'role_id' => 'required|in:1,2,3,4',
        ]);

        $user = Staff::findOrFail($validated['user_id']);

        // Find the latest authentication log entry where logout_at is null
        $authLog = AuthenticationLog::forUser($user)
            ->whereNull('logout_at')
            ->orderBy('login_at', 'desc')
            ->first();

        if (! $authLog) {
            return response()->json(['message' => 'No active session found'], 404);
        }

        // Update logout_at
        $authLog->logout_at = now();
        $authLog->save();

        // Calculate working hours
        $loginTime = strtotime($authLog->login_at);
        $logoutTime = strtotime($authLog->logout_at);
        $totalHours = ($logoutTime - $loginTime) / 3600;
        $workingHours = round($totalHours, 2);

        // Logout the user via JWT
        // auth('staff')->logout();

        return response()->json([
            'message' => 'Logout successful',
            'auth_log' => $authLog,
            'working_hours' => $workingHours,
        ], 200);
    }
}
