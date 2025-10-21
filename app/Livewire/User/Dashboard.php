<?php

namespace App\Livewire\User;

use App\Actions\RewardBadgeAction;
use App\Enums\DepositStatus;
use App\Enums\TradeStatus;
use App\Enums\WithdrawalStatus;
use App\Models\Trade;
use App\Services\DepositService;
use App\Services\InvestmentService;
use App\Services\TradeService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends DashboardLayout
{
    public function mount(){
        

        $tradeService = resolve(DepositService::class);

        // DB::beginTransaction();

        // (new RewardBadgeAction(auth()->user()))->execute();

        // dd(
        //     auth()->user()->computed_reward_badge?->toArray(), 

        // );

        // // dd($tradeService->stakingCron());
        // $time_start = microtime(true);

        // $tradeService->checkForSponsorReward(auth()->user(), 500);

        // $time_end = microtime(true);

        // dd(($time_end - $time_start) / 60);


       

    }

    public function getMonthDepositSum($date){
        return $this->user
            ->getMonthRecord('deposits', $date, DepositStatus::APPROVED)
            ->sum('amount');
    }

    public function getMonthWithdrawalSum($date){
        return $this->user
            ->getMonthRecord('withdrawals', $date, WithdrawalStatus::APPROVED)
            ->sum('amount');
    }

    #[Computed]
    public function transactionMonthlyStats(){
        $currentDate = now();
        $months = [];
        $depositAmounts = [];
        $withdrawalAmounts = [];

        for($i = 0; $i < 12; $i++){
            $currentDate = $currentDate->subMonth();
            $month = $currentDate->format('F') . '-' . $currentDate->format('Y'); 
          
            array_push($depositAmounts, $this->getMonthDepositSum($currentDate));

            array_push($withdrawalAmounts, $this->getMonthWithdrawalSum($currentDate));

            array_push($months, $month);
        }

        return compact('months', 'depositAmounts', 'withdrawalAmounts');
    }


    public function render()
    {
        $totalRunningStakeInvestments = $this->user->stakingInvestments()->running()->sum('amount');
        $totalRunningLicenses = $this->user->investments()->active()->sum('amount');

        $runningInvestments = $totalRunningStakeInvestments + $totalRunningLicenses;
        $pendingWithdrawal = $this->user->withdrawals()->pending()->sum('amount');
        $declinedWithdrawal = $this->user->withdrawals()->declined()->sum('amount');
        $withdrawCharge = $this->user->withdrawals()->approved()->sum('charge');;

        return view('livewire.user.dashboard', compact(
            'runningInvestments',
            'pendingWithdrawal',
            'declinedWithdrawal',
            'withdrawCharge',
        ));
    }
}
