<?php

use App\Http\Controllers\LogoutController;
use App\Http\Middleware\RedirectPostRequest;
use App\Http\Middleware\TwoFactorCheck;
use App\Http\Middleware\Verified;
use App\Livewire\Guest\Partials\StakingInvestment;
use App\Livewire\User\ActiveInvestment;
use App\Livewire\User\Cashout;
use App\Livewire\User\Commissions;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Deposit;
use App\Livewire\User\DepositCommissions;
use App\Livewire\User\DepositDetails;
use App\Livewire\User\InstaPinRecharge;
use App\Livewire\User\Investment;
use App\Livewire\User\InvestmentGoalCalculator;
use App\Livewire\User\InvestmentRewards;
use App\Livewire\User\Investments;
use App\Livewire\User\Matrix;
use App\Livewire\User\ProfitStatistics;
use App\Livewire\User\ReferralRewards;
use App\Livewire\User\Referrals;
use App\Livewire\User\Settings;
use App\Livewire\User\StakingInvestments;
use App\Livewire\User\Trade;
use App\Livewire\User\TradeBinary;
use App\Livewire\User\TradePractice;
use App\Livewire\User\TradePracticeHistory;
use App\Livewire\User\Trades;
use App\Livewire\User\Transactions;
use App\Livewire\User\TwoFactorChallange;
use App\Livewire\User\WalletTopUp;
use Illuminate\Support\Facades\Route;



Route::middleware([RedirectPostRequest::class, 'auth', Verified::class, TwoFactorCheck::class])->name('user.')->prefix('user')->group(function () {
    Route::match(['get', 'post'], '/', Dashboard::class)->name('dashboard');
    Route::match(['get', 'post'], '/transactions', Transactions::class)->name('transactions');
    Route::match(['get', 'post'], '/investment-rewards', InvestmentRewards::class)->name('investment-rewards');
    Route::match(['get', 'post'], '/matrix', Matrix::class)->name('matrix');
    Route::match(['get', 'post'], '/commissions/referral-rewards', ReferralRewards::class)->name('referral-rewards');
    Route::match(['get', 'post'], '/commissions', Commissions::class)->name('commissions');
    Route::match(['get', 'post'], '/investments', Investment::class)->name('investment');
    Route::match(['get', 'post'], '/investments/active', ActiveInvestment::class)->name('active-investments');
    Route::match(['get', 'post'], '/investments/history', Investments::class)->name('investment-records');
    Route::match(['get', 'post'], '/investments/calculator', InvestmentGoalCalculator::class)->name('investment-goal-calculator');
    Route::match(['get', 'post'], '/investments/profit-statistics', ProfitStatistics::class)->name('profit-statistics');
    Route::match(['get', 'post'], '/staking-investment', StakingInvestments::class)->name('staking-investment');
    Route::match(['get', 'post'], '/trades', Trade::class)->name('trade');
    Route::match(['get', 'post'], '/trades/binary/{cryptoId}', TradeBinary::class)->name('trade-binary');
    Route::match(['get', 'post'], '/trades/practice/{cryptoId}', TradePractice::class)->name('trade-practice');
    Route::match(['get', 'post'], '/trades/logs', Trades::class)->name('trade-records');
    Route::match(['get', 'post'], '/trades/practices/logs', TradePracticeHistory::class)->name('trade-practice-history');
    Route::match(['get', 'post'], '/payment/deposits', Deposit::class)->name('deposit');
    Route::match(['get', 'post'], '/payment/deposits/{transactionId}', DepositDetails::class)->name('deposit-details');
    Route::match(['get', 'post'], '/payment/deposits-commission', DepositCommissions::class)->name('deposit-commissions');
    Route::match(['get', 'post'], '/referrals', Referrals::class)->name('referrals');
    Route::match(['get', 'post'], '/cash-out', Cashout::class)->name('cash-out');
    Route::match(['get', 'post'], '/settings', Settings::class)->name('settings');
    Route::match(['get', 'post'], '/insta-pin-recharge', InstaPinRecharge::class)->name('insta-pin-recharge');
    Route::match(['get', 'post'], '/wallet-top-up', WalletTopUp::class)->name('wallet-top-up');    

});

Route::match(['get', 'post'], '/logout', LogoutController::class)->name('user.logout');
Route::match(['get', 'post'], '/two-factor-challenge', TwoFactorChallange::class)->name('user.two-factor-challange');
