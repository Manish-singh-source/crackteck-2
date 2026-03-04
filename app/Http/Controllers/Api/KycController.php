<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    /**
     * Get KYC status and reason
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus(Request $request)
    {
        // Validate the request - can use phone or user_id
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'role_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find KYC by phone
        $kyc = Kyc::where('phone', $request->phone)->first();

        if (!$kyc) {
            return response()->json([
                'success' => false,
                'message' => 'KYC not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'KYC status retrieved successfully',
            'data' => [
                'id' => $kyc->id,
                'name' => $kyc->name,
                'email' => $kyc->email,
                'phone' => $kyc->phone,
                'dob' => $kyc->dob,
                'document_type' => $kyc->document_type,
                'document_no' => $kyc->document_no,
                'role_id' => $kyc->role_id,
                'staff_id' => $kyc->staff_id,
                'status' => $kyc->status,
                'reason' => $kyc->reason,
                'document_file_url' => $kyc->document_file_url,
                'approved_at' => $kyc->approved_at,
                'rejected_at' => $kyc->rejected_at,
                'created_at' => $kyc->created_at,
                'updated_at' => $kyc->updated_at,
            ]
        ], 200);
    }

    /**
     * Submit KYC details
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitKyc(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'document_type' => 'required|in:aadhar,pan,driving_license,police_verification_certificate',
            'document_no' => 'required|string|max:50',
            'document_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
            'role_id' => 'nullable|integer',
            'staff_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if KYC already exists for this phone
        $kyc = Kyc::where('phone', $request->phone)->first();

        // Handle document file upload
        $documentFilePath = null;
        if ($request->hasFile('document_file')) {
            // Delete old file if exists
            if ($kyc && $kyc->document_file) {
                Storage::delete('public/' . $kyc->document_file);
            }
            
            // Store new file
            $file = $request->file('document_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $documentFilePath = $file->storeAs('kyc_documents', $filename, 'public');
        }

        if ($kyc) {
            // Update existing KYC
            $kyc->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'document_type' => $request->document_type,
                'document_no' => $request->document_no,
                'document_file' => $documentFilePath ?? $kyc->document_file,
                'role_id' => $request->role_id ?? $kyc->role_id,
                'staff_id' => $request->user_id ?? $kyc->user_id,
                'status' => Kyc::STATUS_UNDER_REVIEW,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'KYC updated successfully and submitted for review',
                'data' => [
                    'id' => $kyc->id,
                    'name' => $kyc->name,
                    'email' => $kyc->email,
                    'phone' => $kyc->phone,
                    'dob' => $kyc->dob,
                    'document_type' => $kyc->document_type,
                    'document_no' => $kyc->document_no,
                    'role_id' => $kyc->role_id,
                    'staff_id' => $kyc->user_id,
                    'status' => $kyc->status,
                    'document_file_url' => $kyc->document_file_url,
                    'created_at' => $kyc->created_at,
                    'updated_at' => $kyc->updated_at,
                ]
            ], 200);
        } else {
            // Create new KYC
            $kyc = Kyc::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'document_type' => $request->document_type,
                'document_no' => $request->document_no,
                'document_file' => $documentFilePath,
                'role_id' => $request->role_id,
                'staff_id' => $request->user_id,
                'status' => Kyc::STATUS_UNDER_REVIEW,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'KYC submitted successfully',
                'data' => [
                    'id' => $kyc->id,
                    'name' => $kyc->name,
                    'email' => $kyc->email,
                    'phone' => $kyc->phone,
                    'dob' => $kyc->dob,
                    'document_type' => $kyc->document_type,
                    'document_no' => $kyc->document_no,
                    'role_id' => $kyc->role_id,
                    'staff_id' => $kyc->staff_id,
                    'status' => $kyc->status,
                    'document_file_url' => $kyc->document_file_url,
                    'created_at' => $kyc->created_at,
                    'updated_at' => $kyc->updated_at,
                ]
            ], 201);
        }
    }

    /**
     * Update KYC status (for admin use)
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,submitted,under_review,approved,rejected,resubmit_required',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $kyc = Kyc::find($id);

        if (!$kyc) {
            return response()->json([
                'success' => false,
                'message' => 'KYC not found'
            ], 404);
        }

        $status = $request->status;
        
        switch ($status) {
            case Kyc::STATUS_APPROVED:
                $kyc->approve($request->reason);
                break;
            case Kyc::STATUS_REJECTED:
                $kyc->reject($request->reason);
                break;
            case Kyc::STATUS_RESUBMIT_REQUIRED:
                $kyc->markResubmitRequired($request->reason);
                break;
            case Kyc::STATUS_UNDER_REVIEW:
                $kyc->markUnderReview();
                break;
            default:
                $kyc->status = $status;
                $kyc->reason = $request->reason;
                $kyc->save();
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'KYC status updated successfully',
            'data' => $kyc
        ], 200);
    }

    /**
     * Get all KYC records (for admin use)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Kyc::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by document type
        if ($request->has('document_type') && $request->document_type) {
            $query->where('document_type', $request->document_type);
        }

        // Search by name, email, or phone
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $kycs = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'KYC records retrieved successfully',
            'data' => $kycs
        ], 200);
    }
}
