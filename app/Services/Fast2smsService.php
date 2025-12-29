<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Fast2smsService
{
    protected $apiKey;

    protected $senderId;

    protected $templateId;

    public function __construct()
    {
        $this->apiKey = config('services.fast2sms.api_key');
        $this->senderId = config('services.fast2sms.sender_id');
        $this->templateId = config('services.fast2sms.template_id');
    }

    public function sendOtp(string $mobile, string $otp)
    {
        $url = 'https://www.fast2sms.com/dev/bulkV2';

        // Prepare DLT-compliant parameters
        $payload = [
            'route' => 'dltop',               // DLT OTP route
            'message' => '',                  // Empty because using templateId and variables
            'lang' => 'english',
            'flash' => 0,
            'numbers' => $mobile,
            'sender_id' => $this->senderId,
            'template_id' => $this->templateId,
            'variables_values' => $otp,
        ];

        $response = Http::withHeaders([
            'authorization' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($url, $payload);

        return $response->json();
    }
}
