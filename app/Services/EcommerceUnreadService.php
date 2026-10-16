<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderFeedback;

class EcommerceUnreadService
{
    public function counts(): array
    {
        return [
            'orders' => Order::whereNull('admin_viewed_at')->count(),
            'reviews' => OrderFeedback::whereNull('admin_viewed_at')->count(),
        ];
    }

    public function markOrdersViewed(array $ids): void
    {
        Order::whereIn('id', $ids)->whereNull('admin_viewed_at')
            ->toBase()->update(['admin_viewed_at' => now()]);
    }

    public function markReviewsViewed(array $ids): void
    {
        OrderFeedback::whereIn('id', $ids)->whereNull('admin_viewed_at')
            ->toBase()->update(['admin_viewed_at' => now()]);
    }
}
