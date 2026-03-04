<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseFcmService;
use Illuminate\Http\Request;

class FcmTestController extends Controller
{
    public function send(Request $request, FirebaseFcmService $fcm)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);

        $result = $fcm->sendToToken(
            $data['token'],
            $data['title'],
            $data['body'],
            ['screen' => 'home']
        );

        return response()->json([
            'status' => 'sent',
            'fcm_response' => $result,
        ]);
    }
}
