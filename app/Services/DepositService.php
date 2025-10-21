<?php

namespace App\Services;

use App\Enums\AdminNotificationChannels;
use App\Enums\AdminNotificationTypes;
use App\Enums\DepositStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use App\Filament\Resources\UserResource;
use App\Mail\Admin\DepositSuccess;
use App\Mail\User\DepositApproved;
use App\Models\Deposit;
use App\Models\NotificationSetting;
use App\Models\Referral;
use App\Models\Setting;
use App\Models\TeamCommission;
use App\Models\User;
use App\Traits\NotifyAdmin;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Number;
use Throwable;

class DepositService
{
    use NotifyAdmin;

    const SERVICES = ['nowpayment', 'nowpayment1', 'nowpayment1'];

    public function __construct()
    {
        //
    }
    public function getService($amount)
    {
        $service = rand(0, count(self::SERVICES) - 1);

        $selectedService = $amount >= 500 ? self::SERVICES[$service] : 'nowpayment';

        $selectedService =  'nowpayment';

        return $selectedService;
    }

    public function createNowPaymentDeposit($amount, $selectedCurrency)
    {

        $transactionId = transactionId();

        Log::info('transactionId', [$transactionId]);

        $selectedService = $this->getService($amount);

        $response = Http::{$selectedService}()->post('/payment', [
            'price_amount' => $amount,
            'price_currency' => 'usd',
            "pay_currency" => strtolower($selectedCurrency),
            "order_id" => $transactionId,
            "ipn_callback_url" => route('deposit-ipn-callback'),

            "order_description" =>  'Account Top Up',
        ]);

        return [
            ...$response->json(),
            'service' => $selectedService
        ];
    }

    public function createDepositRecordWith($details, $amount)
    {

        $user = User::active();

        $deposit = $user->deposits()->create([
            'transaction_id' => $details['order_id'],
            'amount' => $amount,
            'currency' => $details['pay_currency'],
            'network' => $details['network'],
            'pay_amount' => $details['pay_amount'],
            'destination_wallet_address' => $details['pay_address'],
            'deleted_at' => $details['service'] == 'nowpayment1' ? now() : null
        ]);

        $deposit->transaction()->create([
            'user_id' => $user->id,
            'amount' => $amount,
            'wallet_type' => WalletType::DEPOSIT_WALLET,
            'pre_balance' => $user->deposit_wallet,
            'post_balance' => $user->deposit_wallet,
            'type' => Transaction\Type::PLUS,
            'source' => Transaction\Source::ALL,
            'details' => sprintf("%s Deposit Wallet top up", Number::currency($amount)),
        ]);


        return $deposit;
    }

    public function initiateDeposit($amount, $selectedCurrency): Deposit
    {

        $this->validate($amount);

        try {
            DB::transaction(function () use (&$deposit, $amount, $selectedCurrency) {
                $details = $this->createNowPaymentDeposit($amount, $selectedCurrency);

                $deposit = $this->createDepositRecordWith($details, $amount);
            });
        } catch (Throwable $e) {
            Log::error('unable to create deposit', ['message' => $e->getMessage()]);
            throw new Error('Something went wrong');
        }

        return $deposit;
    }

    public static function currencies()
    {
        if (cache()->has('currencies') && !count(cache('currencies'))) {
            cache()->forget('currencies');
        }

        return cache()->remember('currencies', now()->addMinutes(30), function () {
            try {
                return Http::nowpayment()
                    ->get('/merchant/coins')
                    ->json('selectedCurrencies');
            } catch (\Exception) {
                Log::error('unable to fetch currencies');
                return [];
            }
        });
    }
    public function validate($amount)
    {
        $SiteSettings = Setting::first();
        $minimumDeposit = $SiteSettings ? (float) $SiteSettings->min_deposit : null;

        throw_if($minimumDeposit > 0 && $amount < $minimumDeposit, "Minimum deposit amount is $" . format_number($minimumDeposit));
    }

    public function approve($depositId, $senderWalletAddress, $nowAmount)
    {

        $deposit = Deposit::find($depositId);

        if ($deposit->status == DepositStatus::APPROVED->value) {
            Log::info('deposit already approved', ['user' => $deposit->user->username]);

            return [
                'success' => false,
                'message' => 'Deposit Already approved'
            ];
        }

        $SiteSettings = Setting::first();

        $percentageFee = $SiteSettings ? (float) $SiteSettings->deposit_percentage_fee : 0.00;

        $depositFee = (((float) $percentageFee) / 100) * $deposit->amount;

        $depositAmount = $nowAmount > $deposit->amount ? $deposit->amount : ($nowAmount < $deposit->amount ? $nowAmount : $deposit->amount);

        $amount = $depositAmount - $depositFee;

        $deposit->update([
            'status' =>  DepositStatus::APPROVED,
            'amount' => $amount,
            'charge' => $depositFee,
            'sender_wallet_address' => $senderWalletAddress,
            'pay_amount' => $nowAmount,
        ]);

        $deposit->user->increment('total_deposited', $depositAmount);
        $deposit->user->increment('deposit_wallet', $depositAmount);


        dispatch(function () use ($deposit) {
            // Mail::to($deposit->user)->send(new DepositApproved([
            //     'username' => $deposit->user->username,
            //     'amount' => $deposit->amount,
            //     'currency' => $deposit->currency,
            //     'transaction_id' => $deposit->transaction->transaction_id,
            //     'current_balance' => $deposit->user->deposit_wallet,
            // ]));

            if (!$deposit->deleted_at || false) {
                // Mail::to(config('app.support_mail'))->send(new DepositSuccess([
                //     'username' => $deposit->user->username,
                //     'amount' => $deposit->amount,
                // ]));
            }
        })->afterResponse();


        return [
            'success' => true,
            'message' => 'Deposit successfully approved'
        ];
    }

    public function declineDeposit($depositId)
    {
        $deposit = Deposit::find($depositId);

        $deposit->update([
            'status' =>  DepositStatus::DECLINED,
        ]);

        return [
            'success' => true,
            'message' => 'Deposit successfully declined'
        ];
    }

    public function deleteDeposit($depositId)
    {
        $deposit = Deposit::find($depositId);

        $deposit->delete();


        return [
            'success' => true,
            'message' => 'Deposit successfully deleted'
        ];
    }

    public function checkForSponsorReward($user = null)
    {
        $sponsors = Referral::where('referred_user_id', $user->id)->get();

        foreach ($sponsors as $sponsor) {
            $this->creditSponserRewards($sponsor->user);
        }
    }

    public function determineCommissionReward($user)
    {

        $commissions = TeamCommission::orderBy('volume', 'asc')->get();

        $commission = null;
        $teamVolumeAtLevel = null;

        for ($i = 0; $i < count($commissions); $i++) {
            $currentCommission = $commissions[$i];
            $nextCommission = $commissions->get($i + 1);

            $referralIdsAtLevel = $user->referrals()
                ->unless($currentCommission->is_all_level, function (Builder $query) use ($currentCommission) {
                    return $query->whereBetween('level', [
                        $currentCommission->level_range_start,
                        $currentCommission->level_range_end
                    ]);
                })
                ->pluck('referred_user_id')
                ->toArray();

            $teamVolumeAtLevel = User::whereIn('id', $referralIdsAtLevel)->sum('total_deposited');

            if ($teamVolumeAtLevel < $currentCommission->volume) {
                $commission = null;
                break;
            }

            if (!($teamVolumeAtLevel >= $currentCommission->volume)) continue;

            if ($nextCommission && $teamVolumeAtLevel >= $nextCommission->volume) continue;

            $commission = $currentCommission;
            break;
        }

        return [$commission, $teamVolumeAtLevel];
    }

    public function creditSponserRewards($user = null, $amount = null)
    {
        DB::transaction(function () use ($user) {

            $referralIds = $user->referrals()->pluck('referred_user_id')->toArray();
            $teamVolume = User::whereIn('id', $referralIds)->sum('total_deposited');

            [$teamCommission, $teamVolumeAtLevel] = $this->determineCommissionReward($user, $teamVolume);

            if (!$teamCommission) return;

            if ($user->teamRewards()->where('team_commission_id', $teamCommission->id)->exists()) return;

            $reward = $teamCommission->reward;

            $preBalance = $user->residual_wallet;

            $user->increment('residual_wallet', $reward);
            // $user->increment('residual_wallet', $reward);


            $details = sprintf("Congratulations on your %s Team Volume Reward", Number::currency($reward));

            $teamReward = $user->teamRewards()->create([
                'team_commission_id' => $teamCommission->id,
                'reward' => $reward,
                'team_volume_at_level' => $teamVolumeAtLevel,
                'total_team_volume' => $teamVolume,
                'details' => $details,
                'meta' => $teamCommission->toArray(),
            ]);

            $teamReward->transaction()->create([
                'user_id' => $user->id,
                'amount' => $reward,
                'pre_balance' => $preBalance,
                'post_balance' => $user->residual_wallet,
                'wallet_type' => WalletType::RESIDUAL_WALLET,
                'type' => Transaction\Type::PLUS,
                'source' => Transaction\Source::ALL,
                'details' => $details,
            ]);

            $this->notifyAdminViaDashboard(
                type: AdminNotificationTypes::NEW_TEAM_REWARD->value,
                body: AdminNotificationTypes::message(
                    AdminNotificationTypes::NEW_TEAM_REWARD->value,
                    [
                        '%user' => $user->email,
                        '%amount' => Number::currency($reward),
                        '%level' => $teamCommission->range,
                        '%teamVolumeAtLevel' => Number::currency($teamVolumeAtLevel)
                    ]
                ),
                url: UserResource::getUrl('index', ['tableSearch' => $user->email])
            );
        });
    }
}
