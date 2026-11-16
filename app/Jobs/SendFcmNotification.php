<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\DeviceTokens;
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
        private readonly array $recipientIds,
        private readonly string $title,
        private readonly string $body,
        private readonly array $data = [],
        private readonly ?string $recipientType = null,
    ) {
    }

    public function handle(FirebaseFcmService $fcm): void
    {
        $query = DeviceTokens::query()->whereIn('user_id', $this->recipientIds);

        if ($this->recipientType === Customer::class || $this->recipientType === 'customer') {
            $query->where(function ($q) {
                $q->where('owner_type', Customer::class)
                    ->orWhere(function ($legacy) {
                        $legacy->whereNull('owner_type')->where('role_id', 4);
                    });
            });
        } elseif ($this->recipientType === Staff::class || $this->recipientType === 'staff') {
            $query->where(function ($q) {
                $q->where('owner_type', Staff::class)
                    ->orWhere(function ($legacy) {
                        $legacy->whereNull('owner_type')->whereIn('role_id', [1, 2, 3]);
                    });
            });
        } else {
            $query->where(function ($q) {
                $q->whereNotNull('owner_type')
                    ->orWhereNotNull('role_id');
            });
        }

        $query->pluck('fcm_token')
            ->unique()
            ->each(function (string $token) use ($fcm): void {
                try {
                    $fcm->sendToToken($token, $this->title, $this->body, $this->data);
                } catch (\Throwable $exception) {
                    Log::warning('FCM notification was not delivered.', [
                        'token_suffix' => substr($token, -12),
                        'error' => $exception->getMessage(),
                    ]);
                }
            });
    }
}
