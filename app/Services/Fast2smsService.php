<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Fast2smsService
{
    protected $apiKey;

    protected $senderId;

    protected $templateId;

    protected $entityId;

    public function __construct()
    {
        $this->apiKey = config('services.fast2sms.api_key');
        $this->senderId = config('services.fast2sms.sender_id');
        $this->templateId = config('services.fast2sms.template_id');
        $this->entityId = config('services.fast2sms.entity_id');
    }

    public function sendOtp(string $mobile, string $otp): array
    {
        $url = 'https://www.fast2sms.com/dev/bulkV2';

        $payload = [
            'route' => 'dlt',
            'lang' => 'english',
            'flash' => 0,
            'numbers' => $mobile,
            'sender_id' => $this->senderId,
            'message' => $this->templateId,
            'variables_values' => $otp,
        ];

        if (! empty($this->entityId)) {
            $payload['entity_id'] = $this->entityId;
        }

        $response = Http::withHeaders([
            'authorization' => $this->apiKey,
            'accept' => 'application/json',
        ])->asForm()->post($url, $payload);

        $responseData = $response->json() ?? [];

        Log::info('Fast2SMS Response', [
            'status' => $response->status(),
            'body' => $response->body(),
            'payload' => $payload,
        ]);

        return [
            'success' => $response->successful() && (($responseData['return'] ?? false) === true),
            'status' => $response->status(),
            'message' => $responseData['message'] ?? 'SMS request failed.',
            'data' => $responseData,
        ];
    }
}
