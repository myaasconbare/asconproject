<?php

use App\Http\Controllers\ProcessDepositController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ipn/process-deposit', ProcessDepositController::class)->name('deposit-ipn-callback');

Route::get('queue-work', function () {
    Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('schedule-run', function () {
    Artisan::call('schedule:run');
})->name('schedule.run');