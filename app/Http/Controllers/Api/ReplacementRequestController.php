<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReplacementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplacementRequestController extends Controller
{
    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
        ][$roleId] ?? null;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $roleName = $this->getRoleId($request->role_id);
        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $requests = ReplacementRequest::with([
            'order.customer',
            'orderItem',
            'originalProduct',
            'replacementProduct.warehouseProduct',
        ])
            ->where('assigned_person_type', $roleName)
            ->where('assigned_person_id', $request->user_id)
            ->latest()
            ->get();

        return response()->json(['replacement_requests' => $requests], 200);
    }

    public function show(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:1,2',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $roleName = $this->getRoleId($request->role_id);
        if (! $roleName) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        $replacementRequest = ReplacementRequest::with([
            'order.customer',
            'orderItem',
            'originalProduct',
            'replacementProduct.warehouseProduct',
            'assignedPerson',
        ])
            ->where('id', $id)
            ->where('assigned_person_type', $roleName)
            ->where('assigned_person_id', $request->user_id)
            ->first();

        if (! $replacementRequest) {
            return response()->json(['success' => false, 'message' => 'Replacement request not found.'], 404);
        }

        return response()->json(['replacement_request' => $replacementRequest], 200);
    }
}
