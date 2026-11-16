<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseFcmService;
use Illuminate\Http\Request;
use Throwable;

class FcmTestController extends Controller
{
    public function send(Request $request, FirebaseFcmService $fcm)
    {
        $data = $request->validate([
            'token' => ['nullable', 'string'],
            'fcm_token' => ['nullable', 'string'],
            'user_id' => ['nullable', 'integer'],
            'role_id' => ['nullable', 'in:1,2,3,4'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);

        $token = $data['token'] ?? $data['fcm_token'] ?? null;

        if (! $token && ! empty($data['user_id']) && ! empty($data['role_id'])) {
            $device = \App\Models\DeviceTokens::where('user_id', $data['user_id'])
                ->where(function ($q) use ($data) {
                    if ($data['role_id'] == '4') {
                        $q->where('owner_type', \App\Models\Customer::class)->orWhere('role_id', 4);
                    } else {
                        $q->where('owner_type', \App\Models\Staff::class)->orWhereIn('role_id', [1, 2, 3]);
                    }
                })
                ->latest('last_used_at')
                ->first();

            $token = $device?->fcm_token;
            if (! $token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No active FCM device token found for user_id '.$data['user_id'].' in database.',
                ], 404);
            }
        }

        if (! $token) {
            return response()->json([
                'status' => 'error',
                'message' => 'FCM device token (or valid user_id and role_id) is required.',
            ], 422);
        }

        try {
            $result = $fcm->sendToToken(
                $token,
                $data['title'],
                $data['body'],
                ['screen' => 'home']
            );
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'sent',
            'fcm_response' => $result,
        ]);
    }
}
