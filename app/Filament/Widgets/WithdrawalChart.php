<?php

namespace App\Filament\Widgets;

use App\Models\Withdrawal;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WithdrawalChart extends ChartWidget
{
    protected static ?string $heading = 'Current Month\'s Daily Withdrawal';
     protected static ?int $sort = 3;
    protected static bool $isLazy = false;
    // protected int | string | array $columnSpan = "full";
 
 
 
     protected function getData(): array
     {
         $data = Trend::query(Withdrawal::query())
         ->between(
             start: now()->startOfMonth(),
             end: now()->endOfMonth(),
         )
         ->perDay()
         ->sum('amount');
  
         return [
             'datasets' => [
                 [
                     'label' => 'Payout',
                     'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                 ],
             ],
             'labels' => $data->map(fn (TrendValue $value) => $value->date),
         ];
     }


    protected function getType(): string
    {
        return 'line';
    }
}
