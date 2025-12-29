<?php

namespace App\Http\Controllers;

use App\Models\EcommerceOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Display the track your order page.
     */
    public function index()
    {
        return view('frontend.track-your-order');
    }

    /**
     * Search for an order by order number.
     */
    public function searchOrder(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|string|max:255',
        ]);

        $orderNumber = $request->input('order_id');

        // Search for the order with all necessary relationships
        $order = EcommerceOrder::with([
            'user',
            'orderItems.ecommerceProduct.warehouseProduct.brand',
            'orderItems.ecommerceProduct.warehouseProduct.parentCategorie',
            'orderItems.ecommerceProduct.warehouseProduct.subCategorie',
            'coupon',
        ])
            ->where('order_number', $orderNumber)
            ->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order ID not found. Please check and try again.',
            ], 404);
        }

        // Format order status for display
        $statusMap = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        // Prepare order data
        $orderData = [
            'order_id' => $order->order_number,
            'status' => $statusMap[$order->status] ?? ucfirst($order->status),
            'order_date' => $order->created_at->format('d M Y'),
            'total_amount' => $order->total_amount,
            'subtotal' => $order->subtotal,
            'shipping_charges' => $order->shipping_charges,
            'discount_amount' => $order->discount_amount,
            'payment_method' => $this->formatPaymentMethod($order->payment_method),
            'coupon_code' => $order->coupon_code,

            // Shipping details
            'shipping' => [
                'name' => $order->shipping_first_name.' '.$order->shipping_last_name,
                'phone' => $order->shipping_phone,
                'address' => $this->formatAddress([
                    'line1' => $order->shipping_address_line_1,
                    'line2' => $order->shipping_address_line_2,
                    'city' => $order->shipping_city,
                    'state' => $order->shipping_state,
                    'zipcode' => $order->shipping_zipcode,
                    'country' => $order->shipping_country,
                ]),
            ],

            // Billing details
            'billing' => [
                'same_as_shipping' => $order->billing_same_as_shipping,
                'name' => $order->billing_first_name.' '.$order->billing_last_name,
                'phone' => $order->billing_phone,
                'address' => $this->formatAddress([
                    'line1' => $order->billing_address_line_1,
                    'line2' => $order->billing_address_line_2,
                    'city' => $order->billing_city,
                    'state' => $order->billing_state,
                    'zipcode' => $order->billing_zipcode,
                    'country' => $order->billing_country,
                ]),
            ],

            // Order items
            'items' => [],
        ];

        // Process order items
        foreach ($order->orderItems as $item) {
            $product = $item->ecommerceProduct->warehouseProduct ?? null;

            $orderData['items'][] = [
                'product_name' => $item->product_name,
                'product_image' => $product ? asset('/'.$product->main_product_image) : null,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'hsn_code' => $product->hsn_code ?? 'N/A',
                'sku' => $item->product_sku ?? ($product->sku ?? 'N/A'),
                'brand' => $product->brand->brand_title ?? 'N/A',
                'model_no' => $product->model_no ?? 'N/A',
                'serial_no' => $product->serial_no ?? 'N/A',
                'category' => $product->parentCategorie->parent_categories ?? 'N/A',
                'subcategory' => $product->subCategorie->sub_categories ?? 'N/A',
                'technical_specifications' => $product->technical_specification ?? 'N/A',
                'brand_warranty' => $product->brand_warranty ?? 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'order' => $orderData,
        ]);
    }

    /**
     * Format payment method for display.
     */
    private function formatPaymentMethod($method): string
    {
        $methods = [
            'cod' => 'Cash on Delivery',
            'mastercard' => 'Credit/Debit Card',
            'paypal' => 'PayPal',
            'bank_transfer' => 'Bank Transfer',
        ];

        return $methods[$method] ?? ucfirst(str_replace('_', ' ', $method));
    }

    /**
     * Format address array into a readable string.
     */
    private function formatAddress($address): string
    {
        $parts = array_filter([
            $address['line1'],
            $address['line2'],
            $address['city'],
            $address['state'],
            $address['zipcode'],
            $address['country'],
        ]);

        return implode(', ', $parts);
    }
}
