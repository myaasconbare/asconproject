<?php

namespace App\Filament\Widgets;

use App\Enums\WithdrawalStatus;
use App\Models\Withdrawal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WithdrawalOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static bool $isLazy = false;


    protected function getStats(): array
    {
        $pendingWithdrawal = Withdrawal::where('status', WithdrawalStatus::PENDING);
        $approvedWithdrawal = Withdrawal::where('status', WithdrawalStatus::APPROVED);
        $declinedWithdrawal = Withdrawal::where('status', WithdrawalStatus::DECLINED);

        $pendingWithdrawalSum = '$' . number_format($pendingWithdrawal->sum('amount'), 2);
        $approvedWithdrawalSum = '$' . number_format($approvedWithdrawal->sum('amount'), 2);
        $declinedWithdrawalSum = '$' . number_format($declinedWithdrawal->sum('amount'), 2);

        $recentPendingWithdrawals = $pendingWithdrawal->latest()->take(10)->pluck('amount');
        $recentApprovedWithdrawals = $approvedWithdrawal->latest()->take(10)->pluck('amount');
        $recentDeclinedWithdrawals = $declinedWithdrawal->latest()->take(10)->pluck('amount');


        return [
            Stat::make('Pending Withdrawals', $pendingWithdrawalSum)
                ->chart($recentPendingWithdrawals->toArray())
                 ->color('success'),
            Stat::make('Approved Withdrawals', $approvedWithdrawalSum)
                ->chart($recentApprovedWithdrawals->toArray())
                 ->color('success'),
            Stat::make('Declined Withdrawals', $declinedWithdrawalSum)
                ->chart($recentDeclinedWithdrawals->toArray())
                 ->color('success'),
        ];
    }
}
