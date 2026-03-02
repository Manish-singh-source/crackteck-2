<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class FirebaseFcmService
{
    protected string $projectId;
    protected string $credentialsPath;
    protected Client $http;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id');
        $this->credentialsPath = config('services.firebase.credentials');

        $this->http = new Client([
            'base_uri' => 'https://fcm.googleapis.com/v1/',
            'timeout'  => 5.0,
        ]);
    }

    protected function getAccessToken(): string
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $creds = new ServiceAccountCredentials(
            $scopes,
            $this->credentialsPath
        );

        $token = $creds->fetchAuthToken();

        return $token['access_token'] ?? '';
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): array
    {
        $accessToken = $this->getAccessToken();

        $url = sprintf('projects/%s/messages:send', $this->projectId);

        $payload = [
            'message' => [
                'token'        => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => $data,
            ],
        ];

        $response = $this->http->post($url, [
            'headers' => [
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type'  => 'application/json; charset=UTF-8',
            ],
            'json' => $payload,
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
