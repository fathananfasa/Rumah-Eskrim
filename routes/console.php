<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // ✅ penting untuk scheduler

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ✅ Jalankan snapshot stok setiap hari pukul 23:59
Schedule::command('stok:snapshot')->dailyAt('22:00');
