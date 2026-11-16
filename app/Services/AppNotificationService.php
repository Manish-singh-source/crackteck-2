<?php

namespace App\Services;

use App\Jobs\SendFcmNotification;
use App\Models\Customer;
use App\Models\Staff;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Log;

class AppNotificationService
{
    /**
     * Send both In-App and Push notification to a Customer.
     */
    public function notifyCustomer(int|Customer $customer, string $title, string $message, array $data = []): void
    {
        $customerModel = is_numeric($customer) ? Customer::find($customer) : $customer;
        if (! $customerModel) {
            return;
        }

        // 1. In-App Notification (Database)
        try {
            $customerModel->notify(new AppNotification($title, $message, $data));
        } catch (\Throwable $e) {
            Log::warning('Customer in-app notification failed: '.$e->getMessage());
        }

        // 2. Push Notification (FCM)
        SendFcmNotification::dispatch(
            [$customerModel->id],
            $title,
            $message,
            $data,
            Customer::class
        );
    }

    /**
     * Send both In-App and Push notification to a Staff / Field Engineer.
     */
    public function notifyStaff(int|Staff $staff, string $title, string $message, array $data = []): void
    {
        $staffModel = is_numeric($staff) ? Staff::find($staff) : $staff;
        if (! $staffModel) {
            return;
        }

        // 1. In-App Notification (Database)
        try {
            $staffModel->notify(new AppNotification($title, $message, $data));
        } catch (\Throwable $e) {
            Log::warning('Staff in-app notification failed: '.$e->getMessage());
        }

        // 2. Push Notification (FCM)
        SendFcmNotification::dispatch(
            [$staffModel->id],
            $title,
            $message,
            $data,
            Staff::class
        );
    }

    /**
     * Send to multiple Staff members (e.g. technicians, admins).
     */
    public function notifyMultipleStaff(array $staffIds, string $title, string $message, array $data = []): void
    {
        if (empty($staffIds)) {
            return;
        }

        $staffList = Staff::whereIn('id', $staffIds)->get();
        foreach ($staffList as $staff) {
            try {
                $staff->notify(new AppNotification($title, $message, $data));
            } catch (\Throwable $e) {
                // ignore
            }
        }

        SendFcmNotification::dispatch(
            $staffIds,
            $title,
            $message,
            $data,
            Staff::class
        );
    }

    /**
     * Send directly to a specific FCM device token.
     */
    public function sendRawFcm(string $fcmToken, string $title, string $message, array $data = []): array
    {
        return app(FirebaseFcmService::class)->sendToToken($fcmToken, $title, $message, $data);
    }
}
