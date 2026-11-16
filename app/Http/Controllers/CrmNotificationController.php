<?php

namespace App\Http\Controllers;

use App\Models\DeviceTokens;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CrmNotificationController extends Controller
{
    private function staff(): mixed
    {
        abort_unless(auth('staff_web')->check(), 401);

        return auth('staff_web')->user();
    }

    public function index(): JsonResponse
    {
        $staff = $this->staff();

        return response()->json([
            'notifications' => $staff->notifications()->latest()->limit(15)->get(),
            'unread_count' => $staff->unreadNotifications()->count(),
        ]);
    }

    public function read(Request $request, string $notification): JsonResponse
    {
        $item = $this->staff()->notifications()->whereKey($notification)->firstOrFail();
        $item->markAsRead();

        return response()->json(['success' => true]);
    }

    public function readAll(): JsonResponse
    {
        $this->staff()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function destroyAll(): JsonResponse
    {
        $this->staff()->notifications()->delete();

        return response()->json(['success' => true]);
    }

    public function storeDeviceToken(Request $request): JsonResponse
    {
        $data = $request->validate([
            'fcm_token' => ['required', 'string', 'max:4096'],
            'device_id' => ['nullable', 'string', 'max:255'],
        ]);
        $staff = $this->staff();

        DeviceTokens::updateOrCreate(
            ['fcm_token' => $data['fcm_token']],
            [
                'user_id' => $staff->id,
                'owner_type' => get_class($staff),
                'role_id' => (int) ($staff->staff_role ?? 1),
                'device_type' => 'web',
                'device_id' => $data['device_id'] ?? null,
                'firebase_project_id' => config('services.firebase.project_id'),
                'last_used_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }
}
