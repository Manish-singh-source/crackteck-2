<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('razorpay:reconcile-payments')->everyTenMinutes();

// Shared hosting does not provide a persistent Supervisor worker. This short-lived
// worker is invoked by the once-per-minute scheduler cron and drains the database
// queue without keeping the cron process alive indefinitely.
Schedule::command('queue:work --stop-when-empty --tries=3 --max-time=50')
    ->everyMinute()
    ->withoutOverlapping();
