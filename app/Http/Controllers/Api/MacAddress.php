<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MacAddress extends Controller
{
    //
    public function getMacAddress(Request $request)
    {

        // 
        $mac_address_url = asset('assets/files/MAC Address Instructions.pdf');

        return response()->json([
            'success' => true,
            'mac_address_url' => $mac_address_url,
        ]);
    }
}
