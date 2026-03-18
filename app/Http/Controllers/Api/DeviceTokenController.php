<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeviceTokens;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'role_id' => ['required', 'in:1,2,3,4'],
            'fcm_token' => ['required', 'string'],
            'device_type' => ['nullable', 'in:android,ios,web'],
            'device_id' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        if ($request->role_id == '4') {
            $user = Customer::where('id', $request->user_id)->first();
        } else {
            $user = Staff::where('id', $request->user_id)->first();
        }

        DeviceTokens::updateOrCreate(
            ['fcm_token' => $request->fcm_token],
            [
                'user_id' => $user->id,
                'role_id' => $request->role_id,
                'device_type' => $request->device_type ?? null,
                'device_id' => $request->device_id ?? null,
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'FCM token stored successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'fcm_token' => ['required', 'string'],
        ]);

        DeviceTokens::where('fcm_token', $data['fcm_token'])
            ->where('user_id', $request->user()->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'FCM token removed successfully.',
        ]);
    }
}
