@extends('frontend/layout/master')

@section('main-content')

    <!-- Breakcrumbs -->
    <div class="tf-sp-3 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li>
                    <a href="{{ route('website') }}" class="body-small link">
                        Home
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small"> Order Detail</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Check Out Cart -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="checkout-status tf-sp-2 pt-0">
                <div class="checkout-wrap">
                    <span class="checkout-bar end"></span>
                    <div class="step-payment ">
                        <span class="icon">
                            <i class="icon-shop-cart-1"></i>
                        </span>
                        <a href="" class="link-secondary body-text-3">Shopping Cart</a>
                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-2"></i>
                        </span>
                        <a href="" class="link-secondary body-text-3">Shopping & Checkout</a>

                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-3"></i>
                        </span>
                        <a href="" class="text-secondary body-text-3">Confirmation</a>
                    </div>
                </div>
            </div>
            <div class="tf-order-detail">
                <div class="order-notice">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#ffffff"
                            viewBox="0 0 256 256">
                            <path
                                d="M225.86,102.82c-3.77-3.94-7.67-8-9.14-11.57-1.36-3.27-1.44-8.69-1.52-13.94-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52-3.56-1.47-7.63-5.37-11.57-9.14C146.28,23.51,138.44,16,128,16s-18.27,7.51-25.18,14.14c-3.94,3.77-8,7.67-11.57,9.14C88,40.64,82.56,40.72,77.31,40.8c-9.76.15-20.82.31-28.51,8S41,67.55,40.8,77.31c-.08,5.25-.16,10.67-1.52,13.94-1.47,3.56-5.37,7.63-9.14,11.57C23.51,109.72,16,117.56,16,128s7.51,18.27,14.14,25.18c3.77,3.94,7.67,8,9.14,11.57,1.36,3.27,1.44,8.69,1.52,13.94.15,9.76.31,20.82,8,28.51s18.75,7.85,28.51,8c5.25.08,10.67.16,13.94,1.52,3.56,1.47,7.63,5.37,11.57,9.14C109.72,232.49,117.56,240,128,240s18.27-7.51,25.18-14.14c3.94-3.77,8-7.67,11.57-9.14,3.27-1.36,8.69-1.44,13.94-1.52,9.76-.15,20.82-.31,28.51-8s7.85-18.75,8-28.51c.08-5.25.16-10.67,1.52-13.94,1.47-3.56,5.37-7.63,9.14-11.57C232.49,146.28,240,138.44,240,128S232.49,109.73,225.86,102.82Zm-11.55,39.29c-4.79,5-9.75,10.17-12.38,16.52-2.52,6.1-2.63,13.07-2.73,19.82-.1,7-.21,14.33-3.32,17.43s-10.39,3.22-17.43,3.32c-6.75.1-13.72.21-19.82,2.73-6.35,2.63-11.52,7.59-16.52,12.38S132,224,128,224s-9.15-4.92-14.11-9.69-10.17-9.75-16.52-12.38c-6.1-2.52-13.07-2.63-19.82-2.73-7-.1-14.33-.21-17.43-3.32s-3.22-10.39-3.32-17.43c-.1-6.75-.21-13.72-2.73-19.82-2.63-6.35-7.59-11.52-12.38-16.52S32,132,32,128s4.92-9.15,9.69-14.11,9.75-10.17,12.38-16.52c2.52-6.1,2.63-13.07,2.73-19.82.1-7,.21-14.33,3.32-17.43S70.51,56.9,77.55,56.8c6.75-.1,13.72-.21,19.82-2.73,6.35-2.63,11.52-7.59,16.52-12.38S124,32,128,32s9.15,4.92,14.11,9.69,10.17,9.75,16.52,12.38c6.1,2.52,13.07,2.63,19.82,2.73,7,.1,14.33.21,17.43,3.32s3.22,10.39,3.32,17.43c.1,6.75.21,13.72,2.73,19.82,2.63,6.35,7.59,11.52,12.38,16.52S224,124,224,128,219.08,137.15,214.31,142.11ZM173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34Z">
                            </path>
                        </svg>
                    </span>
                    <p>Thank you. Your order has been received.</p>
                </div>
                <ul class="order-overview-list">
                    <li>Order number: <strong>{{ $order->order_number }}</strong></li>
                    <li>Date: <strong>{{ $order->created_at->format('F j, Y') }}</strong></li>
                    <li>Total:
                        <strong>{{ number_format($order->orderItems->sum('line_total') + $totals['shipping_charges'], 2) }}</strong>
                    </li>
                    <li>Payment method:
                        <strong>{{ $order->payment_method === 'mastercard' ? 'Credit Card' : 'Cash on Delivery' }}</strong>
                    </li>
                    @php
                        $status = [
                            'pending' => 'Confirm',
                            'admin_approved' => 'Confirm',
                            'assigned_delivery_man' => 'Confirm',
                            'order_accepted' => 'Shipping',
                            'product_taken' => 'On the Way',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                            'returned' => 'Returned',
                        ];
                    @endphp
                    <li>Order Status: <strong>{{ $status[$order->status] }}</strong></li>
                    <li>Expected Delivery Date:
                        <strong>{{ \App\Helpers\DateFormat::formatDate($order->expected_delivery_date) ?? 'Order will Delivery within a 7 days'}}</strong>
                    </li>
                </ul>
                <div class="order-detail-wrap">
                    <h5 class="fw-bold">Order details</h5>
                    <div class="tf-order_history-table">
                        <table class="table_def">
                            <thead class="table-light text-start">
                                <tr>
                                    <th style="width: 50px;">S.No</th>
                                    <th style="width: 300px;">Item Description</th>
                                    <th style="width: 100px;">HSN/SAC</th>
                                    <th style="width: 100px;">QTY</th>
                                    <th style="width: 100px;">Price</th>
                                    <th style="width: 100px;">Taxable Value</th>
                                    <th style="width: 100px;">IGST</th>
                                    <th style="width: 100px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="text-start">
                                @foreach ($order->orderItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->hsn_code }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ number_format($item->tax_per_unit, 2) }} %</td>
                                        <td>₹{{ number_format($item->igst_amount, 2) }}</td>
                                        <td>₹{{ number_format($item->line_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-start">
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td><strong>{{ $order->orderItems->sum('quantity') }}</strong></td>
                                    <td><strong>₹{{ number_format($order->orderItems->sum('unit_price'), 2) }} </strong>
                                    </td>
                                    <td><strong>{{ number_format($order->orderItems->avg('tax_per_unit'), 2) }} %</strong>
                                    </td>
                                    <td><strong>₹{{ number_format($totals['total_tax'], 2) }}</strong></td>
                                    <td><strong>₹{{ number_format($order->orderItems->sum('line_total'), 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row mt-2 mb-3" style="max-width: 1420px;">
                        <div class="col-md-5">
                            <h6 class="fw-bold mb-3">Payment Mode</h6>
                            @if ($order->payment_method === 'mastercard')
                                <div class="d-flex">
                                    <p class="me-2">Payment Method : </p>
                                    <p class="text-dark fw-medium">Credit Card</p>
                                </div>
                                <div class="d-flex">
                                    <p class="me-2">Name on Card : </p>
                                    <p class="text-dark fw-medium">{{ $order->card_name }}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="me-2">Card Number : </p>
                                    <p class="text-dark fw-medium">xxxx xxxx xxxx {{ $order->card_last_four }}</p>
                                </div>
                            @else
                                <div class="d-flex">
                                    <p class="me-2">Payment Method : </p>
                                    <p class="text-dark fw-medium">Cash on Delivery</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-5 mt-2 mb-3 ms-auto mb-3">
                            <h6 class="fw-bold mb-3">Total Price</h6>
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                <p class="mb-0">Total Taxable Value</p>
                                {{-- <p class="text-dark fw-medium mb-2">₹{{ number_format($totals['subtotal'], 2) }}</p> --}}
                                <p class="text-dark fw-medium mb-2">
                                    {{ number_format($order->orderItems->avg('tax_per_unit'), 2) }} %</p>
                            </div>
                            {{-- <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                <p class="mb-0">Total Tax Amount</p>
                                <p class="text-dark fw-medium mb-2">₹{{ number_format($totals['total_tax'], 2) }}</p>
                            </div> --}}
                            @if ($totals['shipping_charges'] > 0)
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                    <p class="mb-0">Shipping Charges</p>
                                    <p class="text-dark fw-medium mb-2">
                                        ₹{{ number_format($totals['shipping_charges'], 2) }}</p>
                                </div>
                            @endif
                            @if ($order->coupon_code)
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                    <p class="mb-0">
                                        <span class="text-success">Coupon Discount ({{ $order->coupon_code }})</span>
                                    </p>
                                    <p class="text-success fw-medium mb-2">
                                        -₹{{ number_format($order->discount_amount, 2) }}</p>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                <p class="mb-0">Rounded Off</p>
                                {{-- <p class="text-dark fw-medium mb-2">{{ $totals['rounding_off'] >= 0 ? '+' : '' }}{{ number_format($totals['rounding_off'], 2) }}</p> --}}
                                <p class="text-dark fw-medium mb-2">
                                    {{ $totals['rounding_off'] >= 0 ? '+' : '' }}{{ number_format($totals['rounding_off'], 2) }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                <p class="mb-0">Total Value (in figure)</p>
                                <p class="text-dark fw-medium mb-2">
                                    ₹{{ number_format($order->total_amount + $totals['rounding_off'], 2) }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                <p class="mb-0">Total Value (in Word)</p>
                                <p class="text-dark fw-medium mb-2 w-50">{{ $totals['total_in_words'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gap-30 gap-sm-0">
                    <div class="col-sm-6 col-12">
                        <div class="order-detail-wrap">
                            <h5 class="fw-bold">Billing Address</h5>
                            <div class="billing-info">
                                @if ($order->billing_same_as_shipping)
                                    {{-- If billing is same as shipping, show shipping address --}}
                                    @if ($order->shippingAddress)
                                        <p>{{ $order->shippingAddress->branch_name }}</p>
                                        <p>{{ $order->shippingAddress->address1 }}</p>
                                        @if ($order->shippingAddress->address2)
                                            <p>{{ $order->shippingAddress->address2 }}</p>
                                        @endif
                                        <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                                        <p>{{ $order->shippingAddress->country }} - {{ $order->shippingAddress->pincode }}
                                        </p>
                                    @else
                                        <p>No address available</p>
                                    @endif
                                @else
                                    {{-- If billing is different, show primary address --}}
                                    @if ($order->customer->primaryAddress)
                                        <p>{{ $order->customer->primaryAddress->branch_name }}</p>
                                        <p>{{ $order->customer->primaryAddress->address1 }}</p>
                                        @if ($order->customer->primaryAddress->address2)
                                            <p>{{ $order->customer->primaryAddress->address2 }}</p>
                                        @endif
                                        <p>{{ $order->customer->primaryAddress->city }},
                                            {{ $order->customer->primaryAddress->state }}</p>
                                        <p>{{ $order->customer->primaryAddress->country }} -
                                            {{ $order->customer->primaryAddress->pincode }}</p>
                                    @else
                                        <p>No primary address available</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="order-detail-wrap">
                            <h5 class="fw-bold">Shipping Address</h5>
                            <div class="billing-info">
                                @if ($order->shippingAddress)
                                    <p>{{ $order->shippingAddress->branch_name }}</p>
                                    <p>{{ $order->shippingAddress->address1 }}</p>
                                    @if ($order->shippingAddress->address2)
                                        <p>{{ $order->shippingAddress->address2 }}</p>
                                    @endif
                                    <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                                    <p>{{ $order->shippingAddress->country }} - {{ $order->shippingAddress->pincode }}</p>
                                @else
                                    <p>No address available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                                {{-- Customer Actions --}}
                @php
                    $returnRequests = \App\Models\ReturnOrder::where('order_number', $order->order_number)->get()->keyBy('order_item_id');
                    $replacementRequests = \App\Models\ReplacementRequest::where('order_id', $order->id)->get()->keyBy('order_item_id');
                    $cancellableStatuses = ['pending', 'admin_approved', 'assigned_delivery_man'];
                    $canCancel = in_array($order->status, $cancellableStatuses, true) && ! $order->shipped_at;
                    $isDelivered = $order->status === 'delivered';
                    $returnWindowOpen = $isDelivered && $order->is_returnable && $order->delivered_at && now()->lessThanOrEqualTo($order->delivered_at->copy()->addDays($order->return_days ?? 30));

                    $returnableItems = $order->orderItems->filter(function ($item) use ($returnRequests) {
                        return ! $returnRequests->has($item->id);
                    });

                    $replaceableItems = $order->orderItems->filter(function ($item) use ($replacementRequests) {
                        $request = $replacementRequests->get($item->id);
                        return ! $request || in_array($request->status, ['rejected', 'completed'], true);
                    });

                    $reward = null;
                    if (Auth::guard('customer_web')->check()) {
                        $reward = \App\Models\Reward::where('order_id', $order->id)
                            ->where('customer_id', Auth::guard('customer_web')->id())
                            ->first();
                    }
                    $hasReward = $reward !== null;
                    $canClaimReward = $isDelivered && ! $hasReward;
                @endphp

                @if ($canCancel || $isDelivered || $canClaimReward || $hasReward)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="order-action-buttons d-flex gap-3 flex-wrap align-items-center">
                                @if ($canCancel)
                                    <button type="button" class="btn btn-danger" id="cancelOrderBtn" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                        <i class="icon icon-close"></i> Cancel Order
                                    </button>
                                @endif

                                @if ($isDelivered)
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#returnOrderModal" {{ $returnWindowOpen && $returnableItems->isNotEmpty() ? '' : 'disabled' }}>
                                        <i class="icon icon-refresh"></i> Return Product
                                    </button>
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#replaceOrderModal" {{ $replaceableItems->isNotEmpty() ? '' : 'disabled' }}>
                                        <i class="icon icon-repeat"></i> Replace Product
                                    </button>
                                @endif

                                @if ($canClaimReward)
                                    <button type="button" class="btn btn-success" id="rewardBtn" data-bs-toggle="modal" data-bs-target="#rewardModal">
                                        <i class="icon icon-gift"></i> Claim Reward
                                    </button>
                                @endif

                                @if ($isDelivered)
                                    @php
                                        // Get existing feedback for this order and customer
                                        $existingFeedbacks = \App\Models\OrderFeedback::where('order_id', $order->id)
                                            ->where('customer_id', Auth::guard('customer_web')->id())
                                            ->pluck('product_id')
                                            ->toArray();
                                        
                                        // Filter order items to only show products without feedback
                                        $feedbackableItems = $order->orderItems->filter(function ($item) use ($existingFeedbacks) {
                                            // Get ecommerce product id for this order item
                                            $ecommerceProduct = \App\Models\EcommerceProduct::where('product_id', $item->product_id)->first();
                                            return $ecommerceProduct && !in_array($ecommerceProduct->id, $existingFeedbacks);
                                        });
                                    @endphp
                                    
                                    @if ($feedbackableItems->isNotEmpty())
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                                            <i class="icon icon-star"></i> Submit Feedback
                                        </button>
                                    @endif
                                @endif
                            </div>

                            @if ($isDelivered && ! $returnWindowOpen)
                                <p class="text-muted mt-2 mb-0"><small>The return window for this order has expired.</small></p>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($returnRequests->isNotEmpty() || $replacementRequests->isNotEmpty())
                    <div class="row mt-4 g-3">
                        @if ($returnRequests->isNotEmpty())
                            <div class="col-lg-6">
                                <div class="order-detail-wrap">
                                    <h6 class="fw-bold mb-3">Return Requests</h6>
                                    @foreach ($returnRequests as $request)
                                        <div class="border rounded p-3 mb-2">
                                            <div class="fw-medium">{{ optional($request->orderItem)->product_name ?? 'Product' }}</div>
                                            <div class="text-muted small">Status: {{ ucfirst($request->status) }} | Refund: {{ ucfirst($request->refund_status) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($replacementRequests->isNotEmpty())
                            <div class="col-lg-6">
                                <div class="order-detail-wrap">
                                    <h6 class="fw-bold mb-3">Replacement Requests</h6>
                                    @foreach ($replacementRequests as $request)
                                        <div class="border rounded p-3 mb-2">
                                            <div class="fw-medium">{{ optional($request->orderItem)->product_name ?? 'Product' }}</div>
                                            <div class="text-muted small">Status: {{ ucfirst($request->status) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($hasReward && $reward)
                    @php
                        $reward->syncStatusWithCouponUsage();
                        $coupon = $reward->coupon;
                    @endphp
                    @include('frontend.components.reward-details', ['reward' => $reward, 'coupon' => $coupon])
                @endif
            </div>
        </div>
    </section>

    @if ($canClaimReward || $hasReward)
        @include('frontend.components.reward-modal')
    @endif

    @if ($canCancel)
        <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cancel Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Order Number: <strong>{{ $order->order_number }}</strong></p>
                        <label for="cancelReason" class="form-label">Cancellation reason</label>
                        <textarea class="form-control" id="cancelReason" rows="3" placeholder="Tell us why you want to cancel this order"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmCancelOrder">Cancel Order</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="returnOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select product</label>
                        <select class="form-select" id="returnOrderItemId">
                            <option value="">Choose a delivered product</option>
                            @foreach ($returnableItems as $item)
                                <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for return</label>
                        <input type="text" class="form-control" id="returnReason" placeholder="Example: wrong item, damaged, no longer needed">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="returnDescription" rows="3" placeholder="Add any extra details for the admin team"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Images (optional)</label>
                        <input type="file" class="form-control" id="returnImages" multiple accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="confirmReturnOrder">Submit Return Request</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="replaceOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Replace Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select product</label>
                        <select class="form-select" id="replaceOrderItemId">
                            <option value="">Choose a delivered product</option>
                            @foreach ($replaceableItems as $item)
                                <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for replacement</label>
                        <input type="text" class="form-control" id="replaceReason" placeholder="Example: defective item, want another model">
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="replaceDescription" rows="3" placeholder="Add any context for the admin review"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" id="confirmReplaceOrder">Choose Replacement Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <style>
        .star-rating-input {
            display: flex;
            gap: 5px;
            justify-content: flex-start;
        }
        .star-rating-input .star-label {
            cursor: pointer;
            font-size: 24px;
            color: #ddd;
            transition: color 0.2s;
        }
        .star-rating-input .star-label:hover,
        .star-rating-input .star-label.hover {
            color: #ffc107;
        }
        .star-rating-input .star-label.active {
            color: #ffc107;
        }
        .star-rating-input .star-label i {
            font-style: normal;
        }
    </style>
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="feedbackForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Select Product <span class="text-danger">*</span></label>
                            <select class="form-select" id="feedbackProductId" name="product_id" required>
                                <option value="">Choose a product from this order</option>
                                @if(isset($feedbackableItems))
                                    @foreach ($feedbackableItems as $item)
                                        @php
                                            $ecommerceProduct = \App\Models\EcommerceProduct::where('product_id', $item->product_id)->first();
                                        @endphp
                                        @if ($ecommerceProduct)
                                            <option value="{{ $ecommerceProduct->id }}" data-product-name="{{ $item->product_name }}">
                                                {{ $item->product_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Star Rating <span class="text-danger">*</span></label>
                            <div class="star-rating-input">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="star" value="{{ $i }}" id="star{{ $i }}" class="d-none">
                                    <label for="star{{ $i }}" class="star-label" data-rating="{{ $i }}">
                                        <i class="icon-star"></i>
                                    </label>
                                @endfor
                            </div>
                            <input type="hidden" id="feedbackStar" name="star" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Your Review</label>
                            <textarea class="form-control" id="feedbackText" name="feedback" rows="4" placeholder="Share your experience with this product..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Images (Optional)</label>
                            <input type="file" class="form-control" id="feedbackImages" name="images[]" multiple accept="image/*">
                            <small class="text-muted">Max 5 images, 2MB each. Accepted formats: JPEG, PNG, JPG, GIF, WEBP</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Videos (Optional)</label>
                            <input type="file" class="form-control" id="feedbackVideos" name="videos[]" multiple accept="video/*">
                            <small class="text-muted">Max 3 videos, 10MB each. Accepted formats: MP4, MOV, AVI, WMV</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="feedbackForm" class="btn btn-primary" id="submitFeedbackBtn">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

@section('script')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showOrderActionAlert(message) {
            alert(message);
        }

        const cancelOrderBtn = document.getElementById('confirmCancelOrder');
        if (cancelOrderBtn) {
            cancelOrderBtn.addEventListener('click', async function () {
                const reason = document.getElementById('cancelReason').value.trim();
                if (!reason) {
                    showOrderActionAlert('Please enter a cancellation reason.');
                    return;
                }

                cancelOrderBtn.disabled = true;
                cancelOrderBtn.textContent = 'Processing...';

                const response = await fetch('{{ route('order.cancel') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        order_number: '{{ $order->order_number }}',
                        customer_notes: reason,
                    }),
                });
                const data = await response.json();
                if (data.success) {
                    showOrderActionAlert(data.message);
                    window.location.reload();
                    return;
                }
                cancelOrderBtn.disabled = false;
                cancelOrderBtn.textContent = 'Cancel Order';
                showOrderActionAlert(data.message || 'Unable to cancel the order.');
            });
        }

        const returnOrderBtn = document.getElementById('confirmReturnOrder');
        if (returnOrderBtn) {
            returnOrderBtn.addEventListener('click', async function () {
                const orderItemId = document.getElementById('returnOrderItemId').value;
                const reason = document.getElementById('returnReason').value.trim();
                const description = document.getElementById('returnDescription').value.trim();
                const images = document.getElementById('returnImages').files;

                if (!orderItemId || !reason) {
                    showOrderActionAlert('Please choose a product and return reason.');
                    return;
                }

                returnOrderBtn.disabled = true;
                returnOrderBtn.textContent = 'Submitting...';

                const formData = new FormData();
                formData.append('order_number', '{{ $order->order_number }}');
                formData.append('order_item_id', orderItemId);
                formData.append('return_reason', reason);
                formData.append('return_description', description);
                for (let i = 0; i < images.length; i++) {
                    formData.append('return_images[]', images[i]);
                }

                const response = await fetch('{{ route('order.return') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });
                const data = await response.json();
                if (data.success) {
                    showOrderActionAlert(data.message);
                    window.location.reload();
                    return;
                }
                returnOrderBtn.disabled = false;
                returnOrderBtn.textContent = 'Submit Return Request';
                showOrderActionAlert(data.message || 'Unable to create the return request.');
            });
        }

        const replaceOrderBtn = document.getElementById('confirmReplaceOrder');
        if (replaceOrderBtn) {
            replaceOrderBtn.addEventListener('click', async function () {
                const orderItemId = document.getElementById('replaceOrderItemId').value;
                const reason = document.getElementById('replaceReason').value.trim();
                const description = document.getElementById('replaceDescription').value.trim();

                if (!orderItemId || !reason) {
                    showOrderActionAlert('Please choose a product and replacement reason.');
                    return;
                }

                replaceOrderBtn.disabled = true;
                replaceOrderBtn.textContent = 'Redirecting...';

                const response = await fetch('{{ route('order.replacement.start') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        order_number: '{{ $order->order_number }}',
                        order_item_id: orderItemId,
                        reason: reason,
                        description: description,
                    }),
                });
                const data = await response.json();
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }
                replaceOrderBtn.disabled = false;
                replaceOrderBtn.textContent = 'Choose Replacement Product';
                showOrderActionAlert(data.message || 'Unable to start the replacement flow.');
            });
        }

        // Feedback Modal JavaScript
        const feedbackModal = document.getElementById('feedbackModal');
        if (feedbackModal) {
            // Star rating functionality
            const starLabels = feedbackModal.querySelectorAll('.star-label');
            const feedbackStarInput = document.getElementById('feedbackStar');

            starLabels.forEach(label => {
                label.addEventListener('click', function() {
                    const rating = this.dataset.rating;
                    feedbackStarInput.value = rating;

                    // Update visual state
                    starLabels.forEach(l => {
                        const starRating = l.dataset.rating;
                        if (starRating <= rating) {
                            l.classList.add('active');
                        } else {
                            l.classList.remove('active');
                        }
                    });
                });

                label.addEventListener('mouseenter', function() {
                    const rating = this.dataset.rating;
                    starLabels.forEach(l => {
                        const starRating = l.dataset.rating;
                        if (starRating <= rating) {
                            l.classList.add('hover');
                        } else {
                            l.classList.remove('hover');
                        }
                    });
                });

                label.addEventListener('mouseleave', function() {
                    starLabels.forEach(l => l.classList.remove('hover'));
                });
            });

            // Submit feedback
            const feedbackForm = document.getElementById('feedbackForm');
            const submitFeedbackBtn = document.getElementById('submitFeedbackBtn');
            
            console.log('Feedback form found:', feedbackForm);
            console.log('Submit button found:', submitFeedbackBtn);
            
            if (feedbackForm && submitFeedbackBtn) {
                // Handle form submission
                feedbackForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    console.log('Form submit event triggered');
                    
                    const productId = document.getElementById('feedbackProductId').value;
                    const star = feedbackStarInput.value;
                    const feedbackText = document.getElementById('feedbackText').value.trim();
                    const images = document.getElementById('feedbackImages').files;
                    const videos = document.getElementById('feedbackVideos').files;

                    console.log('Form data:', { productId, star, feedbackText, images: images.length, videos: videos.length });

                    // Validation
                    if (!productId) {
                        showOrderActionAlert('Please select a product.');
                        return;
                    }

                    if (!star) {
                        showOrderActionAlert('Please select a star rating.');
                        return;
                    }

                    // Prepare form data
                    const formData = new FormData();
                    formData.append('order_id', {{ $order->id }});
                    formData.append('product_id', productId);
                    formData.append('star', star);
                    formData.append('feedback', feedbackText);

                    // Add images
                    for (let i = 0; i < images.length; i++) {
                        formData.append('images[]', images[i]);
                    }

                    // Add videos
                    for (let i = 0; i < videos.length; i++) {
                        formData.append('videos[]', videos[i]);
                    }

                    submitFeedbackBtn.disabled = true;
                    submitFeedbackBtn.textContent = 'Submitting...';

                    try {
                        const response = await fetch('{{ route('order-feedback.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: formData,
                        });

                        const data = await response.json();

                        if (data.success) {
                            showOrderActionAlert(data.message);
                            // Close modal and reload page
                            const modal = bootstrap.Modal.getInstance(feedbackModal);
                            modal.hide();
                            window.location.reload();
                        } else {
                            // Show validation errors
                            if (data.errors) {
                                let errorMessages = Object.values(data.errors).flat().join('\n');
                                showOrderActionAlert(errorMessages);
                            } else {
                                showOrderActionAlert(data.message || 'Failed to submit feedback.');
                            }
                        }
                    } catch (error) {
                        showOrderActionAlert('An error occurred while submitting feedback.');
                    } finally {
                        submitFeedbackBtn.disabled = false;
                        submitFeedbackBtn.textContent = 'Submit Feedback';
                    }
                });
            }
        }
    </script>

    {{-- Reward System JavaScript --}}
    <script>
        // Set global variables for reward system
        window.orderId = {{ $order->id }};
        window.rewardType = 'order';
        window.rewardClaimed = false;
    </script>
    <script src="{{ asset('frontend/js/reward.js') }}"></script>
@endsection

@endsection

{{-- @/crackteck-backend/resources/views/frontend/order-details.blade.php 

1. check karo ki us order ka kya status hai agar order ka status 
pending, admin_approved, assigned_delivery_man, order_accepted, product_taken ho to 
mujhe ye page par button chahiye cancelled order

aur agar order ka status delivered, hai to mujhe return product ka button chahiye 
aur agar order ka status cancelled, returned ho to koi button nahi chahiye 

Billing Address aur Shipping Address 
section ke niche chahiye
cancelled order button / return product

jaise hi cancelled order par click karega tab ek pop aaye jisem mujhe are you sure to cancelled order then ok then 
form submit hojaye ki customer me order cancelled kar diya hai ( orders table me status cancelled ho jaye )

2. check karo ki jo product customer ne order kiya hai wo return able hai ki nahi 
agar is_returnable hai to check karo ki delivered_at ka jo date hai wo mere return_days date se jaydad na ho agar jyada hoga to return button display na ho

agar within a data hoga to return button display ho

jaise hi return order par click karega tab ek pop aaye jisem mujhe are you sure to return product karna hai ki nahi then ok then 
form submit hojaye 

ek new table create karo return_order table 
id	
return_order_id	
order_number
customer_id	
return_person_id	
return_assigned_at	
return_accepted_at	
otp	
otp_verified_at	
return_completed_at		
status (pending, assigned, accepted, picked, received)
created_at	
updated_at	
deleted_at	

aur agar return product ke button par click kare to return_order table me data add ho jaye ki koi product return karna hai
id	
return_order_number	( new unique number )
order_number ( jise order ke liye return aaya hai )
customer_id
status (pending)
created_at --}}


