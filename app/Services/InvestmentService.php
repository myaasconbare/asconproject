<?php

namespace App\Services;

use App\Actions\RewardBadgeAction;
use App\Enums\CommissionType;
use App\Enums\InvestmentDeactivationStatus;
use App\Enums\InvestmentStatus;
use App\Enums\Periods;
use App\Enums\ProfitTypes;
use App\Enums\StakingInvestmentStatus;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use App\Models\BatchCommission;
use App\Models\Investment;
use App\Models\InvestmentDeactivation;
use App\Models\License;
use App\Models\Portfolio;
use App\Models\ReferralCommission;
use App\Models\RewardBadge;
use App\Models\StakingInvestment;
use App\Models\StakingPlan;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Throwable;

class InvestmentService
{
    const DAILY_MINUTES = 1440;

    public function __construct(
        public StakingInvestment $stakingInvestment,
        public StakingPlan $stakingPlan,
        public Investment $investment,
        public License $license,
        public Portfolio $portfolio,
        public InvestmentDeactivation $investmentDeactivation,

    ) {}

    public function redeemLicense($user)
    {

        $completedLicenseQuery  =  $this->investment
            ->byActiveUser()
            ->completed();

        $licenseAmount = $completedLicenseQuery->sum('amount');

        throw_if(!$completedLicenseQuery->count(), "You don't have any package eligible for redeemption");

        throw_if($user->deposit_wallet < $licenseAmount, sprintf("You need %s to redeem license", Number::currency($licenseAmount)));

        $totalLicensesAffected = 0;

        try {
            DB::transaction(function () use ($user, $completedLicenseQuery, &$totalLicensesAffected) {

                $packages = $completedLicenseQuery->get();

                $totalLicensesAffected = $packages->count();

                foreach ($packages as $package) {
                    // DB::beginTransaction();
                    // DB::transaction(function() use($package, $user) {
                    $license = $package->license;

                    $endTime = $license->getEndTime()->addMinute();
                    $minutesTillEndTime = intval(now()->diffInMinutes($endTime, absolute: true));
                    $preBalance = $user->deposit_wallet;

                    $user->decrement('deposit_wallet', $package->amount);

                    $package->update([
                        'total_minutes' => $minutesTillEndTime,
                        'minutes_remaining' => $minutesTillEndTime,
                        'upcoming_payment' =>  now()->addMinute(),
                    ]);

                    $details = "redeemed license for package " . $package->transaction_id;

                    $tr = $package->transaction()->create([
                        'user_id' => $user->id,
                        'amount' => $package->amount,
                        'pre_balance' => $preBalance,
                        'post_balance' => $user->deposit_wallet,
                        'type' => Transaction\Type::MINUS,
                        'source' => Transaction\Source::INVESTMENT,
                        'details' => $details,
                        'wallet_type' => WalletType::DEPOSIT_WALLET,
                    ]);

                    $user->refresh();
                }
            });

            return $totalLicensesAffected;
        } catch (Throwable $e) {
            Log::error('unable to redeem license', ['message' => $e->getMessage()]);
            throw new Error("Unable to redeem License");
        }
    }

    public function autoCoumpound($user)
    {
        $investment = $this->investment
            ->byActiveUser()
            ->withWhereHas('license')
            ->active()
            ->latest('id')
            ->first();

        throw_if(!$investment, "No Active License");
        throw_if($user->interest_wallet <= 0, "Your Interest Wallet is insufficient for this transaction");
        throw_if($investment->status == InvestmentStatus::PENDING_TERMINATION->value, "Your active package is pending termination");
        throw_if($investment->status == InvestmentStatus::TERMINATED->value, 'cannot compound on a deactivated package');

        // $interestToCompound = $investment->interests_received;

        try {
            DB::transaction(function () use ($user, $investment) {

                $interestToCompound = $user->interest_wallet + $user->residual_wallet;

                $newInvestmentAmount =  $investment->amount + $interestToCompound;
                $preBalance = $user->deposit_wallet;

                // $user->decrement('deposit_wallet', $interestToCompound);

                $user->decrement('interest_wallet', $user->interest_wallet);
                $user->decrement('residual_wallet', $user->residual_wallet);

                $investment->update([
                    'license_id' => $this->determineLicense($newInvestmentAmount)->id,
                    'amount' => $newInvestmentAmount
                ]);

                $details = sprintf("%s compounded to Active Batch Package", Number::currency($newInvestmentAmount));

                $investment->transaction()->create([
                    'user_id' => $user->id,
                    'amount' => $newInvestmentAmount,
                    'pre_balance' => $preBalance,
                    'post_balance' => $$investment->user->deposit_wallet,
                    'wallet_type' => WalletType::INTEREST_WALLET,
                    'type' => Transaction\Type::MINUS,
                    'source' => Transaction\Source::INVESTMENT,
                    'details' => $details,
                ]);
            });
        } catch (Throwable $e) {
            Log::error('unable to autocompound', ['messsage' => $e->getMessage()]);
            throw new Error("Something went wrong");
        }
    }

    public function validateEndLicense($investment)
    {
        throw_if(!$investment, "Investment Not Found!");

        throw_if($investment->status == InvestmentStatus::TERMINATED->value, "Investment Already Ended");

        throw_if($investment->deactivations()->pending()->first(), "You have a pending deactivation");
    }

    public function requestEndLicense($user, $investmentId)
    {
        $investment = $user->investments()->find($investmentId);

        $this->validateEndLicense($investment);

        $investment->update(['status' => InvestmentStatus::PENDING_TERMINATION]);

        $this->investmentDeactivation->create([
            'user_id' => $user->id,
            'transaction_id' => transactionId(),
            'investment_id' => $investment->id,
            'amount' => $investment->amount,
        ]);
    }
    public function cancelTermination($user, $investmentId)
    {

        $investment = $user->investments()->find($investmentId);
        throw_if(!$investment, "Investment Not Found!");

        try {
            DB::transaction(function () use ($user, $investment) {

                $lostMinutes = $investment->minutes_remaining - ($investment->last_payment ?? $investment->created_at)->diffInMinutes(now());
                $minutesRemaining = $investment->minutes_remaining - $lostMinutes;

                $user->investmentDeactivations()
                    ->where('investment_id', $investment->id)
                    ->latest()
                    ->first()
                    ->update(['status' => InvestmentDeactivationStatus::CANCELLED]);

                if ($minutesRemaining <= 0) {
                    $investment->update([
                        'status' => InvestmentStatus::COMPLETED,
                    ]);
                } else {

                    $investment->update([
                        'status' => InvestmentStatus::ACTIVE,
                        'last_payment' => now(),
                        'upcoming_payment' => now()->addMinute(),
                        'minutes_remaining' => $minutesRemaining,
                    ]);
                }
            });
        } catch (Throwable $e) {
            Log::error('error cancelling license termination', ['message' => $e->getMessage()]);
            throw new Error("error cancelling license termination");
        }
    }


    public function validateInvest($user, $amount, $portfolio, $license)
    {
        throw_if(!$portfolio, "Invalid Portfolio!");
        throw_if($user->deposit_wallet < $amount, "Your Deposit Wallet Is Insufficient For This Transaction!");

        // dd($amount > $portfolio->max_plan->maximum_amount, $amount, $portfolio->max_plan->maximum_amount);

        throw_if(
            $amount < $portfolio->least_plan->minimum_amount || $amount > $portfolio->max_plan->maximum_amount && !$portfolio->max_plan->is_unlimited,
            sprintf(
                "The investment amount should be between %s and %s",
                Number::currency($portfolio->least_plan->minimum_amount),
                $portfolio->max_plan->maximum_amount_format,
            )
        );

        throw_if(!$license, "Invalid License!");
    }

    public function invest($amount, $portfolioId)
    {
        $user = activeUser();
        $portfolio = $this->portfolio->find($portfolioId);


        // $license = $this->license->find($licenseId);
        $license = $this->determineLicense($amount);

        $this->validateInvest($user, $amount, $portfolio, $license);


        try {

            DB::transaction(function () use ($user, $amount, $license) {
                $preBalance = $user->deposit_wallet;

                $user->decrement('deposit_wallet', $amount);

                $endTime = $license->getEndTime()->addMinute();
                $minutesTillEndTime = intval(now()->diffInMinutes($endTime, absolute: true));

                // dd(intval(now()->diffInDays($endTime, absolute:true)), $license->portfolio->period, $license->portfolio->duration);

                $investment = $this->investment->create([
                    'user_id' => $user->id,
                    'total_minutes' => $minutesTillEndTime,
                    'minutes_remaining' => $minutesTillEndTime,
                    'license_id' => $license->id,
                    'transaction_id' => transactionId(),
                    'amount' => $amount,
                    'reference_id' => 'REF-' . transactionId(),
                    'upcoming_payment' =>  now()->addMinute(),

                    // 'upcoming_payment' =>  $license->upcoming_payment,
                ]);

                $details = sprintf(
                    "bought %s %s license for a duration of %s %s",
                    Number::currency($amount),
                    $license->portfolio->name,
                    $license->portfolio->duration,
                    $license->portfolio->period_label
                );

                $investment->transaction()->create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'pre_balance' => $preBalance,
                    'post_balance' => $user->deposit_wallet,
                    'wallet_type' => WalletType::DEPOSIT_WALLET,
                    'type' => Transaction\Type::MINUS,
                    'source' => Transaction\Source::INVESTMENT,
                    'details' => $details,
                ]);

                if ($investment->user->referrer) {
                    $this->distributeReferralProfits(
                        ReferralCommission::class,
                        $investment->user,
                        $investment->amount,
                        "$%s commission from %s License"
                    );
                }

                $user->increment('total_invested', $amount);

                (new RewardBadgeAction)->execute($user);
            });
        } catch (Throwable $e) {
            Log::error('unable to create investment', ['message' => $e->getMessage()]);
            throw new Error('Error creating investment');
        }
    }

    public function distributeReferralProfits($model, $user, $profit, $detail)
    {

        $level = 1;

        $referrer = $user->referrer;

        $referrer->increment('direct_team_volume', $profit);

        do {
            Log::info(['referrer' => $referrer->name]);

            $modelCommission = $model::where('level', $level)->first();

            if (!$modelCommission) break;

            $percentageProfit = ($modelCommission->percentage / 100) * $profit;

            $preBalance = $referrer->residual_wallet;

            if ($level == 1) {
                $referrer->increment('referral_commission', $percentageProfit);
            }

            $referrer->increment('level_commission', $percentageProfit);

            $referrer->increment('residual_wallet', $percentageProfit);
            $referrer->increment('total_team_volume', $percentageProfit);



            // $referrer->increment('deposit_wallet', $percentageProfit);


            $details = sprintf($detail, $percentageProfit, maskEmail($user->email));

            $commission = $referrer->commissions()->create([
                'from_user_id' => $user->id,
                'transaction_id' => transactionId(),
                'pre_balance' => $preBalance,
                'post_balance' => $referrer->residual_wallet,
                'amount' => $percentageProfit,
                'details' => $details,
                'type' => CommissionType::INVESTMENT

            ]);

            // $commission->transaction()->create([
            //     'user_id' => $referrer->id,
            //     'amount' => $percentageProfit,
            //     'pre_balance' => $preBalance,
            //     'wallet_type' => WalletType::RESIDUAL_WALLET,
            //     'post_balance' => $user->residual_wallet,
            //     'type' => Transaction\Type::PLUS,
            //     'source' => Transaction\Source::INVESTMENT,
            //     'details' => $details,
            // ]);

            $referrer = User::find($referrer->referrer_user_id);

            $level++;
        } while ($referrer);
    }

    public function distributeMinutelyProfit($investment)
    {

        if (now()->isBefore($investment->upcoming_payment)) return;

        DB::transaction(function () use ($investment) {
            $dailyProfit = ($investment->license->rate / 100) * $investment->amount;
            $minutelyProfit = $dailyProfit / self::DAILY_MINUTES;

            // $investment->user->increment('deposit_wallet', $minutelyProfit);
            $investment->user->increment('interest_wallet', $minutelyProfit);

            $investment->increment('run_times');

            $investment->decrement('minutes_remaining');
            $investment->increment('interests_received', $minutelyProfit);
            $investment->user->increment('total_profits', $minutelyProfit);


            $investment->update([
                'last_payment' => $investment->getLastPayment(),
                'upcoming_payment' => $investment->getNextPayment(),
            ]);

            $investment->profits()->create([
                'transaction_id' => transactionId(),
                'details' => sprintf(
                    "$%s profit on your %s %s license purchase",
                    $minutelyProfit,
                    Number::currency($investment->amount),
                    $investment->license->portfolio->name
                ),
                'user_id' => $investment->user_id,
                'investment_id' => $investment->id,
                'license_id' => $investment->license_id,
                'portfolio_id' => $investment->license->portfolio_id,
                'amount' => $minutelyProfit,
                'type' => ProfitTypes::MINUTELY,
            ]);

            if ($investment->user->referrer) {
                $this->distributeReferralProfits(
                    BatchCommission::class,
                    $investment->user,
                    $minutelyProfit,
                    "$%s commission from %s active package"
                );
            }

            if ($investment->minutes_remaining == 0) {
                $investment->update([
                    'status' => InvestmentStatus::COMPLETED
                ]);
            }
        });
    }

    public function handleStakingCron($stakedInvestment)
    {

        if (now()->isBefore($stakedInvestment->next_interest_date)) return;

        DB::transaction(function () use ($stakedInvestment) {

            $profit = ($stakedInvestment->interest / 100) * $stakedInvestment->amount;

            $preBalance = $stakedInvestment->user->interest_wallet;

            // $stakedInvestment->user->increment('deposit_wallet', $profit);
            $stakedInvestment->user->increment('interest_wallet', $profit);
            $stakedInvestment->user->increment('total_profits', $profit);

            $stakedInvestment->last_interest_date = $stakedInvestment->next_interest_date;

            if ($stakedInvestment->last_interest_date->eq($stakedInvestment->expires_at)) {
                $stakedInvestment->status = StakingInvestmentStatus::COMPLETED;
                $stakedInvestment->completed_at = $stakedInvestment->last_interest_date;
            } else {
                $stakedInvestment->next_interest_date = $stakedInvestment->next_interest_date->copy()->addDay();
            }

            $stakedInvestment->save();

            $details = sprintf(
                "$%s profit on your %s staking Investment",
                $profit,
                Number::currency($stakedInvestment->amount)
            );

            $profitRecord = $stakedInvestment->profits()->create([
                'transaction_id' => transactionId(),
                'details' => $details,
                'user_id' => $stakedInvestment->user_id,
                'staking_investment_id' => $stakedInvestment->id,
                'amount' => $profit,
                'type' => ProfitTypes::DAILY,
            ]);

            $profitRecord->transaction()->create([
                'user_id' => $stakedInvestment->user_id,
                'amount' => $profit,
                'pre_balance' => $preBalance,
                'post_balance' => $stakedInvestment->user->interest_wallet,
                'type' => Transaction\Type::PLUS,
                'source' => Transaction\Source::INVESTMENT,
                'details' => $details,
                'wallet_type' => WalletType::INTEREST_WALLET,
            ]);

            if ($stakedInvestment->user->referrer) {
                $this->distributeReferralProfits(
                    BatchCommission::class,
                    $stakedInvestment->user,
                    $profit,
                    "$%s commission from %s staking profits"
                );
            }
        });
    }



    public function stakingCron()
    {
        $this->stakingInvestment
            ->where('status', StakingInvestmentStatus::RUNNING)
            // ->whereTime('next_interest_date', '<', now())
            ->lazyById(200)
            ->each(fn($investment) => $this->handleStakingCron($investment));
    }

    public function investCron()
    {
        $this->investment->with(['license.portfolio'])
            ->active()
            ->lazyById(200)
            ->each(fn($investment) => $this->distributeMinutelyProfit($investment));
    }


    public function validateStaking($plan, $amount, $user)
    {
        throw_if($user->deposit_wallet < $amount, 'Your account balance is insufficient for this investment.');

        throw_if(!$plan, "Invalid Plan");

        throw_if(
            $amount < $plan->minimum_amount || $amount > $plan->maximum_amount,
            sprintf('The investment amount should be between %s and %s', money($plan->minimum_amount), money($plan->maximum_amount))
        );
    }


    public function stake($planId, $amount, $user)
    {
        $plan = $this->stakingPlan->find($planId);

        $this->validateStaking($plan, $amount, $user);

        try {
            DB::transaction(function () use (&$user, $amount, $plan) {
                $profit = ($plan->interest_rate / 100) * $amount;
                $totalReturn = $profit + $amount;
                $expiresOn = now()->{'add' . ucfirst($plan->period)}(intval($plan->duration));
                $nextInterestDate = null;


                if ($plan->period != Periods::HOURS->value) {
                    $nextInterestDate = now()->addDay();
                } else {
                    $nextInterestDate = $expiresOn;
                }

                $preBalance = $user->deposit_wallet;

                $preBalance = $user->decrement('deposit_wallet', $amount);

                $details = sprintf('%s staking invested for a duration of %s', Number::currency($amount), $plan->duration_label);

                $stakingInvestment = $this->stakingInvestment->create([
                    'user_id' => $user->id,
                    'staking_plan_id' => $plan->id,
                    'amount' => $amount,
                    'interest' => $plan->interest_rate,
                    'total_return' => $totalReturn,
                    'expires_at' => $expiresOn,
                    'next_interest_date' => $nextInterestDate,
                ]);

                $stakingInvestment->transaction()->create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'pre_balance' => $preBalance,
                    'post_balance' => $user->deposit_wallet,
                    'type' => Transaction\Type::MINUS,
                    'source' => Transaction\Source::INVESTMENT,
                    'details' => $details,
                    'wallet_type' => WalletType::DEPOSIT_WALLET,
                ]);

                $user->increment('total_invested', $amount);
            });
        } catch (Throwable $e) {
            Log::error('unable to  stake investment', ['message' => $e->getMessage()]);
            throw new Error('Error staking Investment');
        }
    }

    public function determineLicense($amount = null)
    {

        $licenses = License::orderBy('minimum_amount')->get();

        $license = null;

        for ($i = 0; $i < count($licenses); $i++) {
            $currentLicense = $licenses[$i];
            $nextLicense = $licenses->get($i + 1);

            if (!($amount >= $currentLicense->minimum_amount)) continue;

            if ($nextLicense && $amount >= $nextLicense->minimum_amount) continue;

            $license = $currentLicense;
            break;
        }

        return $license;
    }

    public function declineDeactivation($deactivationId)
    {

        $investmentDeactivation = InvestmentDeactivation::find($deactivationId);
        $investment = $investmentDeactivation->investment;

        $lostMinutes = $investment->minutes_remaining - ($investment->last_payment ?? $investment->created_at)->diffInMinutes(now());
        $minutesRemaining = $investment->minutes_remaining - $lostMinutes;

        $investmentDeactivation->update(['status' => InvestmentDeactivationStatus::DECLINED]);

        if ($minutesRemaining <= 0) {
            $investment->update([
                'status' => InvestmentStatus::COMPLETED,
            ]);
        } else {
            $investment->update([
                'status' => InvestmentStatus::ACTIVE,
                'last_payment' => now(),
                'upcoming_payment' => now()->addMinute(),
                'minutes_remaining' => $minutesRemaining,
            ]);
        }


        return [
            'success' => true,
            'message' => 'Investment deactivation declined successfuly'
        ];
    }



    public function completeInvestment($investmentId)
    {
        $investment = Investment::find($investmentId);

        $investment->update([
            'state' =>  InvestmentStatus::COMPLETED,
        ]);

        return [
            'success' => true,
            'message' => 'Investment has been marked as completed'
        ];
    }



    public function approveDeactivation($deactivationId)
    {
        $investmentDeactivation = InvestmentDeactivation::find($deactivationId);
        $investment = $investmentDeactivation->investment;

        $investment->update([
            'status' =>  InvestmentStatus::TERMINATED,
        ]);

        $investmentDeactivation->update(['status' => InvestmentDeactivationStatus::APPROVED]);

        $preBalance =  $investment->user->interest_wallet;

        $investment->user->increment('interest_wallet', $investment->amount);

        $reference = $investment->reference_id;

        $investmentDeactivation->transaction()->create([
            'user_id' => $investment->user->id,
            'amount' => $investment->amount,
            'pre_balance' => $preBalance,
            'post_balance' => $investment->user->interest_wallet,
            'type' => Transaction\Type::PLUS,
            'source' => Transaction\Source::INVESTMENT,
            'wallet_type' => WalletType::INTEREST_WALLET,
            'details' => "\${$investment->amount} Capital from {$reference} License Termination",
        ]);


        return [
            'success' => true,
            'message' => 'Investment has been terminated'
        ];
    }


    public function deleteInvestment($investmentId)
    {
        $investment = Investment::find($investmentId);

        $investment->transaction->delete();

        $investment->delete();

        return [
            'success' => true,
            'message' => 'Investment deleted successfuly'
        ];
    }
}
