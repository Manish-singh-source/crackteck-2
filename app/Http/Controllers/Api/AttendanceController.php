<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $validated = request()->validate([
            // validation rules if any
            'user_id' => 'required',
        ]);

        if (! $validated['user_id']) {
            return response()->json(['message' => 'User ID is required'], 400);
        }

        $attendance = Attendance::where('user_id', $validated['user_id'])
            ->where('date', date('Y-m-d'))
            ->get();

        $totalWorkingHours = Attendance::where('user_id', $validated['user_id'])->sum('working_hours');

        return response()->json(['attendance' => $attendance, 'total_working_hours' => $totalWorkingHours], 200);
    }

    public function store(Request $request)
    {

        // user_id	date	check_in	check_out	total_hours	working_hours	status	remarks	image
        $validated = request()->validate([
            // validation rules if any
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $attendance = new Attendance;
        $attendance->user_id = $request->user_id;
        $attendance->date = date('Y-m-d');
        $attendance->check_in = date('H:i:s');
        $attendance->save();

        return response()->json(['attendance' => $attendance], 200);
    }

    public function logout(Request $request)
    {
        $validated = request()->validate([
            // validation rules if any
            'role_id' => 'required|in:2',
            'user_id' => 'required',
        ]);

        $attendance = Attendance::where('user_id', $validated['user_id'])->where('check_out', null)->first();

        if (! $attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        $currentTime = date('H:i:s');

        $attendance->check_out = date('H:i:s');
        $checkIn = strtotime($attendance->check_in);
        $checkOut = strtotime($attendance->check_out);
        $totalHours = ($checkOut - $checkIn) / 3600; // convert seconds to hours
        $attendance->total_hours = round($totalHours, 2);
        if ($currentTime > '13:30') {
            $attendance->working_hours = round($totalHours, 2); //
        } else {
            $attendance->working_hours = round($totalHours - 1, 2); //
        }
        $attendance->save();

        return response()->json(['attendance' => $attendance], 200);
    }
}
