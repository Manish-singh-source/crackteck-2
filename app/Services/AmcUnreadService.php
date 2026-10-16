<?php

namespace App\Services;

use App\Models\Amc;

class AmcUnreadService
{
    public function count(): int
    {
        return Amc::whereNull('admin_viewed_at')->count();
    }

    public function markViewed(int $id): void
    {
        Amc::whereKey($id)->whereNull('admin_viewed_at')
            ->toBase()->update(['admin_viewed_at' => now()]);
    }
}
