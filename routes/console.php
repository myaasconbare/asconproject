<?php

use App\Services\CryptoCurrencyService;
use App\Services\InvestmentService;
use App\Services\TradeService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

$tradeService = resolve(TradeService::class);
$investmentService = resolve(InvestmentService::class);
$cryptoCurrencyService = resolve(CryptoCurrencyService::class);


Schedule::call(fn() => $cryptoCurrencyService->cryptoSave())
    ->name('update-market-prices')
    ->daily()
    ->onOneServer();

Schedule::call(fn() => $tradeService->cron())
    ->name('execute-users-trade')
    ->everySecond()
    ->onOneServer();

Schedule::call(fn() => $investmentService->investCron())
    ->name('execute-users-investrment')
    ->everySecond()
    ->onOneServer();

Schedule::call(fn() => $investmentService->stakingCron())
    ->name('execute-staking-investrment')
    ->everySecond()
    ->onOneServer();