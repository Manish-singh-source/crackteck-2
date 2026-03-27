<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderFeedback;
use App\Models\OrderItem;
use App\Models\EcommerceProduct;
use App\Helpers\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderFeedbackController extends Controller
{
    /**
     * Store a new feedback for an order product.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'product_id' => 'required|exists:ecommerce_products,id',
                'star' => 'required|integer|min:1|max:5',
                'feedback' => 'nullable|string|max:5000',
                'images' => 'nullable|array|max:5',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'videos' => 'nullable|array|max:3',
                'videos.*' => 'mimes:mp4,mov,avi,wmv|max:10240',
            ], [
                'order_id.required' => 'Order ID is required.',
                'order_id.exists' => 'Invalid order selected.',
                'product_id.required' => 'Product ID is required.',
                'product_id.exists' => 'Invalid product selected.',
                'star.required' => 'Star rating is required.',
                'star.integer' => 'Star rating must be a number.',
                'star.min' => 'Star rating must be at least 1.',
                'star.max' => 'Star rating cannot exceed 5.',
                'feedback.max' => 'Feedback cannot exceed 5000 characters.',
                'images.max' => 'You can upload a maximum of 5 images.',
                'images.*.image' => 'All files must be images.',
                'images.*.mimes' => 'Images must be in JPEG, PNG, JPG, GIF, or WEBP format.',
                'images.*.max' => 'Each image must not exceed 2MB.',
                'videos.max' => 'You can upload a maximum of 3 videos.',
                'videos.*.mimes' => 'Videos must be in MP4, MOV, AVI, or WMV format.',
                'videos.*.max' => 'Each video must not exceed 10MB.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Get authenticated customer
            $customer = Auth::guard('customer_web')->user();
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to submit feedback.',
                ], 401);
            }

            $orderId = $request->input('order_id');
            $ecommerceProductId = $request->input('product_id');

            // Check if order exists and belongs to the customer
            $order = Order::where('id', $orderId)
                ->where('customer_id', $customer->id)
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found or does not belong to you.',
                ], 404);
            }

            // Check if order is delivered
            if ($order->status !== Order::STATUS_DELIVERED) {
                return response()->json([
                    'success' => false,
                    'message' => 'Feedback can only be submitted for delivered orders.',
                ], 400);
            }

            // Get the ecommerce product
            $ecommerceProduct = EcommerceProduct::find($ecommerceProductId);
            if (!$ecommerceProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product selected.',
                ], 404);
            }

            // Check if the product exists in the order (using warehouse product id)
            $orderItem = OrderItem::where('order_id', $orderId)
                ->where('product_id', $ecommerceProduct->product_id)
                ->first();

            if (!$orderItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in this order.',
                ], 404);
            }

            // Check if feedback already exists for this order/product/customer
            $existingFeedback = OrderFeedback::where('order_id', $orderId)
                ->where('product_id', $ecommerceProductId)
                ->where('customer_id', $customer->id)
                ->first();

            if ($existingFeedback) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted feedback for this product.',
                ], 400);
            }

            // Collect media files
            $media = [];

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $originalName = $image->getClientOriginalName();
                    $fileSize = $image->getSize();
                    $path = FileUpload::fileUpload($image, 'uploads/feedback/images/');

                    $media[] = [
                        'file_path' => $path,
                        'file_type' => 'image',
                        'original_name' => $originalName,
                        'file_size' => $fileSize,
                    ];
                }
            }

            // Handle video uploads
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $originalName = $video->getClientOriginalName();
                    $fileSize = $video->getSize();
                    $path = FileUpload::fileUpload($video, 'uploads/feedback/videos/');

                    $media[] = [
                        'file_path' => $path,
                        'file_type' => 'video',
                        'original_name' => $originalName,
                        'file_size' => $fileSize,
                    ];
                }
            }

            $feedback = DB::transaction(function () use ($orderId, $ecommerceProductId, $customer, $request, $media) {
                return OrderFeedback::create([
                    'order_id' => $orderId,
                    'product_id' => $ecommerceProductId,
                    'customer_id' => $customer->id,
                    'feedback' => $request->input('feedback'),
                    'star' => $request->input('star'),
                    'status' => OrderFeedback::STATUS_INACTIVE,
                    'media' => $media,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Feedback submitted successfully. It will be visible after admin approval.',
                'data' => $feedback,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Order feedback submission failed.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'customer_id' => Auth::guard('customer_web')->id(),
                'order_id' => $request->input('order_id'),
                'product_id' => $request->input('product_id'),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting feedback.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check if feedback exists for a specific order/product/customer.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function checkFeedbackExists(Request $request): JsonResponse
    {
        try {
            $customer = Auth::guard('customer_web')->user();
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to check feedback status.',
                ], 401);
            }

            $orderId = $request->input('order_id');
            $productId = $request->input('product_id');

            $feedback = OrderFeedback::where('order_id', $orderId)
                ->where('product_id', $productId)
                ->where('customer_id', $customer->id)
                ->first();

            return response()->json([
                'success' => true,
                'exists' => $feedback !== null,
                'feedback' => $feedback,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking feedback status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get feedback for a specific product (for product detail page).
     * 
     * @param int $productId
     * @return JsonResponse
     */
    public function getProductFeedback(int $productId): JsonResponse
    {
        try {
            $feedback = OrderFeedback::with(['customer'])
                ->where('product_id', $productId)
                ->where('status', OrderFeedback::STATUS_ACTIVE)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // Calculate rating statistics
            $totalFeedback = OrderFeedback::where('product_id', $productId)
                ->where('status', OrderFeedback::STATUS_ACTIVE)
                ->count();

            $averageRating = OrderFeedback::where('product_id', $productId)
                ->where('status', OrderFeedback::STATUS_ACTIVE)
                ->avg('star');

            $ratingBreakdown = [];
            for ($i = 1; $i <= 5; $i++) {
                $count = OrderFeedback::where('product_id', $productId)
                    ->where('status', OrderFeedback::STATUS_ACTIVE)
                    ->where('star', $i)
                    ->count();
                $ratingBreakdown[$i] = [
                    'count' => $count,
                    'percentage' => $totalFeedback > 0 ? round(($count / $totalFeedback) * 100) : 0,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $feedback,
                'statistics' => [
                    'total' => $totalFeedback,
                    'average' => round($averageRating, 1),
                    'breakdown' => $ratingBreakdown,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching feedback.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
