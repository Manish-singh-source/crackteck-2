<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderFeedback;
use App\Helpers\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OrderFeedbackController extends Controller
{
    /**
     * Display a listing of all order feedback.
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = OrderFeedback::with(['order', 'product', 'customer']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by star rating
        if ($request->has('star') && $request->star !== '') {
            $query->where('star', $request->star);
        }

        // Search by customer name or order number
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($cq) use ($search) {
                    $cq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('order', function ($oq) use ($search) {
                    $oq->where('order_number', 'like', "%{$search}%");
                })
                ->orWhereHas('product.warehouseProduct', function ($pq) use ($search) {
                    $pq->where('product_name', 'like', "%{$search}%");
                });
            });
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('e-commerce.order-feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for editing the specified feedback.
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $feedback = OrderFeedback::with(['order', 'product', 'customer'])->findOrFail($id);

        return view('e-commerce.order-feedback.edit', compact('feedback'));
    }

    /**
     * Update the specified feedback in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $feedback = OrderFeedback::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,inactive',
            'feedback' => 'nullable|string|max:5000',
        ], [
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either active or inactive.',
            'feedback.max' => 'Feedback cannot exceed 5000 characters.',
        ]);

        $feedback->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('order-feedback.index')
            ->with('success', 'Feedback updated successfully.');
    }

    /**
     * Remove the specified feedback from storage (soft delete).
     * 
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $feedback = OrderFeedback::findOrFail($id);

        // Delete associated media files
        $media = $feedback->media ?? [];
        foreach ($media as $mediaItem) {
            FileUpload::deleteFile($mediaItem['file_path']);
        }

        $feedback->delete();

        return redirect()->route('order-feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }

    /**
     * Toggle feedback status (activate/deactivate).
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function toggleStatus(int $id): JsonResponse
    {
        try {
            $feedback = OrderFeedback::findOrFail($id);

            $newStatus = $feedback->status === OrderFeedback::STATUS_ACTIVE 
                ? OrderFeedback::STATUS_INACTIVE 
                : OrderFeedback::STATUS_ACTIVE;

            $feedback->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Feedback status updated successfully.',
                'status' => $newStatus,
                'status_display' => $newStatus === OrderFeedback::STATUS_ACTIVE ? 'Active' : 'Inactive',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating feedback status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a specific media file from feedback.
     * 
     * @param int $feedbackId
     * @param int $mediaIndex
     * @return JsonResponse
     */
    public function deleteMedia(int $feedbackId, int $mediaIndex): JsonResponse
    {
        try {
            $feedback = OrderFeedback::findOrFail($feedbackId);
            $media = $feedback->media ?? [];

            if (!isset($media[$mediaIndex])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Media file not found.',
                ], 404);
            }

            // Delete the file from storage
            FileUpload::deleteFile($media[$mediaIndex]['file_path']);

            // Remove the media item from array
            unset($media[$mediaIndex]);
            $media = array_values($media); // Re-index array

            // Update feedback with new media array
            $feedback->update(['media' => $media]);

            return response()->json([
                'success' => true,
                'message' => 'Media file deleted successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting media file.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get feedback statistics.
     * 
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $totalFeedback = OrderFeedback::count();
            $activeFeedback = OrderFeedback::where('status', OrderFeedback::STATUS_ACTIVE)->count();
            $inactiveFeedback = OrderFeedback::where('status', OrderFeedback::STATUS_INACTIVE)->count();
            $averageRating = OrderFeedback::avg('star');

            $ratingBreakdown = [];
            for ($i = 1; $i <= 5; $i++) {
                $count = OrderFeedback::where('star', $i)->count();
                $ratingBreakdown[$i] = [
                    'count' => $count,
                    'percentage' => $totalFeedback > 0 ? round(($count / $totalFeedback) * 100) : 0,
                ];
            }

            return response()->json([
                'success' => true,
                'statistics' => [
                    'total' => $totalFeedback,
                    'active' => $activeFeedback,
                    'inactive' => $inactiveFeedback,
                    'average_rating' => round($averageRating, 1),
                    'rating_breakdown' => $ratingBreakdown,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
