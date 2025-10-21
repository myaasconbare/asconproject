<?php

namespace App\Services;

use App\Enums\AdminNotificationTypes;
use App\Enums\CommissionType;
use App\Models\MatrixEnrollment;
use App\Models\MatrixPlan;
use App\Models\MatrixSetting;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use App\Filament\Resources\MatrixEnrollmentResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Traits\NotifyAdmin;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use PhpParser\ErrorHandler\Throwing;
use Throwable;

class MatrixService
{
    use NotifyAdmin;

    public function __construct(
        public MatrixSetting $matrixSetting,
        public MatrixEnrollment $matrix,
        public MatrixPlan $matrixPlan,
    ) {}

    public function getPlans()
    {
        return $this->matrixPlan->withActive()->get();
    }
    public function getPlanById($id)
    {
        return $this->matrixPlan->withActive()->where('id', $id)->first();
    }

    public function getLevelsById($id)
    {
        $commission = $this->getPlanById($id)->commission;
        $commssions = [];
        foreach ($commission[0] as $key => $value) {
            $level = substr($key, strlen('level') + 1);
            array_push($commssions, ['level' => $level, 'commission' => $value]);
        }
        return $commssions;
    }

    public function calculateAggregateCommission(int $id): float|int
    {
        $aggregateCommission = 0;

        $iteration = 1;
        foreach ($this->getLevelsById($id) as $key => $value) {
            $matrixCalculation = pow($this->getMatrixSettings()->width, $iteration);
            $aggregateCommission += $value['commission'] * $matrixCalculation;
            $iteration++;
        }

        return $aggregateCommission;
    }

    public function updateMatrixSettings(array $details)
    {
        try {
            DB::transaction(function () use ($details) {
                $last = $this->matrixSetting->latest()->first();
                $this->matrixSetting->updateOrCreate(['id' => $last?->id], $details);
            });
            return ['type' => 'success', 'message' => "saved successfully"];
        } catch (Throwable $e) {
            Log::error('unable to update matrix settings', ['message' => $e->getMessage()]);
            return ['type' => 'error', 'title' => "something went wrong", "message" => "Unable to update settings"];
        }
    }
    public function getMatrixSettings()
    {
        return $this->matrixSetting->first();
    }
    public function alreadyEnrolled($user = null)
    {

        return (bool) $user->matrixEnrollments()->latest()->first();
    }

    public function getCurrentScheme($user)
    {
        return $user->matrixEnrollments()->with('plan')->latest()->first();
    }

    public function validateEnrollment($user, MatrixPlan $matrixPlan)
    {

        throw_if(!$matrixPlan, 'Invalid Plan');

        throw_if($user->matrixEnrollments()?->latest()?->first(), 'You cannot buy plan twice');

        throw_if($user->deposit_wallet < $matrixPlan->amount, 'Insufficient Balance!');

        $referrerMatrixEnrollment = $user->referrer?->matrixEnrollments()?->latest()?->first();

        throw_if(
            $user->referrer && $referrerMatrixEnrollment && $referrerMatrixEnrollment->matrix_plan_id != $matrixPlan->id,
            'You have to purchase a plan which your referrer has purchased'
        );
    }

    public function enrollUser($planId, $user)
    {
        $matrixPlan = $this->getPlanById($planId);

        $this->validateEnrollment($user, $matrixPlan);

        try {
            DB::transaction(function () use (&$user, $planId, $matrixPlan) {
                $preBalance = $user->deposit_wallet;

                $user->decrement('deposit_wallet', $matrixPlan->amount);

                $matrixEnrollment = $user->matrixEnrollments()->create([
                    'amount' => $matrixPlan->amount,
                    'matrix_plan_id' => $planId,
                    'meta' => $matrixPlan->commission,
                ]);

                $matrixEnrollment->transaction()->create([
                    'user_id' => $user->id,
                    'amount' => $matrixPlan->amount,
                    'pre_balance' => $preBalance,
                    'post_balance' => $user->deposit_wallet,
                    'type' => Transaction\Type::PLUS->value,
                    'source' => Transaction\Source::INVESTMENT,
                    'wallet_type' => Transaction\WalletType::DEPOSIT_WALLET,
                    'details' => 'Enrollment in the ' . $matrixPlan->name . ' Matrix plan.',
                ]);

                if ($user->referrer) {
                    $this->distributeReferralCommission($user, $matrixEnrollment->plan);
                    $this->distributeLevelCommission($user, $matrixEnrollment);
                }

                $this->notifyAdminViaDashboard(
                    type: AdminNotificationTypes::NEW_MATRIX_ENROLLMENT->value,
                    body: AdminNotificationTypes::message(
                        AdminNotificationTypes::NEW_MATRIX_ENROLLMENT->value,
                        [
                            '%user' => $user->email,
                            '%amount' => Number::currency($matrixPlan->amount),
                        ]
                    ),
                    url: MatrixEnrollmentResource::getUrl('index', ['tableSearch' => $user->email])
                );
            });
        } catch (Throwable $e) {
            Log::error('Error enrolling the Matrix scheme', ['message' => $e->getMessage()]);
            throw new Error('Error enrolling the Matrix scheme');
        }
    }

    public function distributeReferralCommission($user, $matrixPlan)
    {
        $preBalance = $user->referrer->residual_wallet;

        $user->referrer->increment('residual_wallet', $matrixPlan->referral_reward);
        // $user->referrer->increment('matrix_referral_commission', $matrixPlan->referral_reward);
        $user->referrer->increment('referral_commission', $matrixPlan->referral_reward);

        $details = sprintf('Referral commission from %s', maskEmail($user->email));

        $this->saveTransactionRecord(
            referrer: $user->referrer,
            user: $user,
            amount: $matrixPlan->referral_reward,
            commissionType: CommissionType::REFERRAL,
            preBalance: $preBalance,
            details: $details
        );

        $this->notifyAdminViaDashboard(
            type: AdminNotificationTypes::NEW_MATRIX_REFERRAL_COMMISSION->value,
            body: AdminNotificationTypes::message(
                AdminNotificationTypes::NEW_MATRIX_REFERRAL_COMMISSION->value,
                [
                    '%user' => $user->email,
                    '%amount' => Number::currency($matrixPlan->referral_reward),
                ]
            ),
            url: UserResource::getUrl('index', ['tableSearch' => $user->referrer->email])
        );
    }

    public function distributeLevelCommission($user, $matrixEnrollment)
    {

        $meta = $matrixEnrollment->meta[0];
        $matrixLevelLimit = Arr::last(explode('_', Arr::last(array_keys($meta))));

        $level = 1;

        $referrer = $user->referrer;

        do {

            $levelCommission = Arr::get($meta, 'level_' . $level);

            $preBalance = $referrer->residual_wallet;

            $details = sprintf('Level %s commission from %s', $level, maskEmail($user->email));

            $referrer->increment('residual_wallet', $levelCommission);
            // $user->referrer->increment('matrix_level_commission', $levelCommission);
            $user->referrer->increment('level_commission', $levelCommission);

            $this->saveTransactionRecord(
                referrer: $referrer,
                user: $user,
                amount: $levelCommission,
                commissionType: CommissionType::LEVEL,
                preBalance: $preBalance,
                details: $details
            );

            $this->notifyAdminViaDashboard(
                type: AdminNotificationTypes::NEW_MATRIX_LEVEL_COMMISSION->value,
                body: AdminNotificationTypes::message(
                    AdminNotificationTypes::NEW_MATRIX_LEVEL_COMMISSION->value,
                    [
                        '%user' => $user->email,
                        '%amount' => Number::currency($levelCommission),
                    ]
                ),
                url: UserResource::getUrl('index', ['tableSearch' => $user->referrer->email])
            );



            $referrer = User::find($referrer->referrer_user_id);

            $level++;

            if ($level > $matrixLevelLimit) break;
        } while ($referrer);
    }

    public function saveTransactionRecord($referrer, $user, $amount, $commissionType, $preBalance, $details)
    {
        $commission = $referrer->commissions()->create([
            'from_user_id' => $user->id,
            'pre_balance' => $preBalance,
            'post_balance' => $referrer->residual_wallet,
            'amount' => $amount,
            'details' => $details,
            'type' => $commissionType,
        ]);

        $commission->transaction()->create([
            'user_id' => $referrer->id,
            'amount' => $amount,
            'pre_balance' => $preBalance,
            'post_balance' => $referrer->residual_wallet,
            'type' => Transaction\Type::PLUS,
            'source' => Transaction\Source::INVESTMENT,
            'details' => $details,
            'wallet_type' => WalletType::RESIDUAL_WALLET,
        ]);
    }
}
