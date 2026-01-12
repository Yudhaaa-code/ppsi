<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule pending order checks every 5 minutes for development
// This will automatically update orders when Midtrans webhooks can't reach localhost
Schedule::command('orders:check-pending')->name('check-pending-orders')->everyFiveMinutes()->withoutOverlapping();
