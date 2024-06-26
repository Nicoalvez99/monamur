<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function() {
    DB::table('charts')->delete();
})->wednesdays()->at('17:46');

Artisan::command('schedule:run', function () {
    DB::table('charts')->delete();
})->wednesdays()->at('17:46');
