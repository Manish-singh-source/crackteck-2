<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    //
    public function getNotifications(Request $request)
    {
        //
        $validated = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'role_id' => ['required', 'in:1,2,3,4'],
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        if ($request->role_id == '4') {
            $user = Customer::where('id', $request->user_id)->first();
        } else {
            $user = Staff::where('id', $request->user_id)->first();
        }

        return response()->json([
            'success' => true,
            'notifications' => $user->notifications,
        ]);
    }
}
