<?php

namespace App\Jobs;

use App\Models\DeviceTokens;
use App\Models\Customer;
use App\Models\Staff;
use App\Services\FirebaseFcmService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendFcmNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        private readonly array $staffRecipientIds,
        private readonly string $title,
        private readonly string $body,
        private readonly array $data = [],
        private readonly array $customerRecipientIds = [],
    ) {
    }

    public function handle(FirebaseFcmService $fcm): void
    {
        DeviceTokens::query()
            ->where('firebase_project_id', config('services.firebase.project_id'))
            ->where(function ($query) {
                $query->where(function ($staff) {
                    $staff->whereIn('user_id', $this->staffRecipientIds)
                        ->where(function ($owner) {
                            $owner->where('owner_type', Staff::class)
                                ->orWhere(function ($legacy) {
                                    $legacy->whereNull('owner_type')->whereIn('role_id', [1, 2, 3]);
                                });
                        });
                })->orWhere(function ($customer) {
                    $customer->whereIn('user_id', $this->customerRecipientIds)
                        ->where(function ($owner) {
                            $owner->where('owner_type', Customer::class)
                                ->orWhere(function ($legacy) {
                                    $legacy->whereNull('owner_type')->where('role_id', 4);
                                });
                        });
                });
            })
            ->pluck('fcm_token')
            ->each(function (string $token) use ($fcm): void {
                try {
                    $fcm->sendToToken($token, $this->title, $this->body, $this->data);
                } catch (\Throwable $exception) {
                    Log::warning('CRM FCM notification was not delivered.', [
                        'token_suffix' => substr($token, -12),
                        'error' => $exception->getMessage(),
                    ]);
                }
            });
    }
}
