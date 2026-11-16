<?php

namespace App\Jobs;

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
    ) {
    }

    public function handle(FirebaseFcmService $fcm): void
    {
        DeviceTokens::query()
            ->whereIn('user_id', $this->recipientIds)
            ->where(function ($query) {
                $query->where('owner_type', Staff::class)
                    // Existing mobile tokens predate owner_type. Keep them working.
                    ->orWhere(function ($legacy) {
                        $legacy->whereNull('owner_type')->whereIn('role_id', [1, 2, 3]);
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
