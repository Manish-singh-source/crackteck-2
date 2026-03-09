<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateFormat
{
    public static function formatDate($date)
    {
        return Carbon::parse($date)->format('d M Y');
    }
    public static function formatDateTime($date)
    {
        return Carbon::parse($date)->format('d M Y h:i A');
    }
}
