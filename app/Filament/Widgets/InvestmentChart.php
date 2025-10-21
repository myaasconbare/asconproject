<?php

namespace App\Filament\Widgets;

use App\Models\Investment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InvestmentChart extends ChartWidget
{
    // protected static ?string $heading = 'Chart';

    protected static ?string $heading = 'Current Month\'s Daily Investment';
    protected static ?int $sort = 3;
   protected static bool $isLazy = false;
//    protected int | string | array $columnSpan = "full";



    protected function getData(): array
    {
        $data = Trend::query(Investment::query())
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->sum('amount');
 
        return [
            'datasets' => [
                [
                    'label' => 'Investment',
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
