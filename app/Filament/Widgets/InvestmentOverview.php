<?php

namespace App\Filament\Widgets;

use App\Enums\InvestmentStatus;
use App\Models\Investment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InvestmentOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 1;


    protected function getStats(): array
    {
        $activeInvestment = Investment::where('status', InvestmentStatus::ACTIVE);
        $pausedInvestment = Investment::where('status', InvestmentStatus::PAUSED);
        $completedInvestment = Investment::where('status', InvestmentStatus::COMPLETED);
        $terminatedInvestment = Investment::where('status', InvestmentStatus::TERMINATED);
        $pendingTerminationInvestment = Investment::where('status', InvestmentStatus::PENDING_TERMINATION);



        $activeInvestmentSum = '$' . number_format($activeInvestment->sum('amount'), 2);
        $pausedInvestmentSum = '$' . number_format($pausedInvestment->sum('amount'), 2);
        $completedInvestmentSum = '$' . number_format($completedInvestment->sum('amount'), 2);
        $terminatedInvestmentSum = '$' . number_format($terminatedInvestment->sum('amount'), 2);
        $pendingTerminationInvestmentSum = '$' . number_format($pendingTerminationInvestment->sum('amount'), 2);



        $recentActiveInvestments = $activeInvestment->latest()->take(10)->pluck('amount');
        $recentPausedInvestments = $pausedInvestment->latest()->take(10)->pluck('amount');
        $recentCompletedInvestments = $completedInvestment->latest()->take(10)->pluck('amount');
        $recentTerminatedInvestments = $terminatedInvestment->latest()->take(10)->pluck('amount');
        $recentPendingInvestments = $pendingTerminationInvestment->latest()->take(10)->pluck('amount');



        return [
            
            Stat::make('Active Investments', $activeInvestmentSum)
                ->chart($recentActiveInvestments->toArray())
                ->color('success')
                ->description($activeInvestment->count() . ' Record(s)'),
            Stat::make('Completed Investments', $completedInvestmentSum)
                ->chart($recentCompletedInvestments->toArray())
                ->color('success')
                ->description($completedInvestment->count() . ' Record(s)'),
            Stat::make('Terminated Investments', $terminatedInvestmentSum)
                ->chart($recentTerminatedInvestments->toArray())
                ->color('success')
                ->description($terminatedInvestment->count() . ' Record(s)'),
            Stat::make('Pending Termination Investments', $pendingTerminationInvestmentSum)
                ->chart($recentPendingInvestments->toArray())
                ->color('success')
                ->description($pendingTerminationInvestment->count() . ' Record(s)'),
            // Stat::make('Paused Investment', $pausedInvestmentSum)
            //     ->chart($recentPausedInvestments->toArray())
            //     ->color('success'),
            // Stat::make('Unique views', '192.1k')
            //     ->description('32k increase')
            //     ->descriptionIcon('heroicon-m-arrow-trending-up')
            //     ->chart([7, 2, 10, 3, 15, 4, 17])
            //     ->color('success'),
            // ...
        ];
    
    }
}
