<?php

namespace App\Actions;

use App\Models\RewardBadge;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use Illuminate\Support\Number;

class RewardBadgeAction
{

    public function __construct() {}

    public function execute($user)
    {
        $computedBadge = $user->computed_reward_badge;
        
        if ($computedBadge && $user->reward_badge_id !== $computedBadge->id) {
            $this->upgradeUserBadge($user, $computedBadge);
        }
    }

    public function upgradeUserBadge($user, $computedBadge)
    {
        $previousBadgeIds = $user->rewardBadgeHistory()->pluck('reward_badge_id');
        $lastBadge = $user->rewardBadgeHistory()->latest('id')->first();

        $badges = RewardBadge::orderBy('reward')
            ->whereNotIn('id', $previousBadgeIds)
            ->get();

        $skippedBadges = $badges->filter(function ($skippedBadge) use ($lastBadge, $computedBadge) {
            return ($lastBadge ? $skippedBadge->id > $lastBadge->reward_badge_id : true) &&
                $skippedBadge->id < $computedBadge->id;
        });

        $skippedBadges->each(function ($skippedBadge) use ($user) {
            $user->rewardBadgeHistory()->updateOrcreate(
                ['reward_badge_id' => $skippedBadge->id],
                [
                    'reward_badge_id' => $skippedBadge->id,
                    'reward' => $skippedBadge->reward,
                ]
            );
        });

        $preBalance = $user->residual_wallet;

        $user->update(['reward_badge_id' => $computedBadge->id]);
        $user->increment('residual_wallet', $computedBadge->reward);

        $rewardHistory = $user->rewardBadgeHistory()->updateOrCreate(
            ['reward_badge_id' => $computedBadge->id],
            [
                'reward_badge_id' => $computedBadge->id,
                'reward' => $computedBadge->reward,
            ]
        );

        $details = sprintf("%s reward badge obtained. reward has been credited to your balance", Number::currency($computedBadge->reward));

        $rewardHistory->transaction()->create([
            'user_id' => $user->id,
            'amount' => $computedBadge->reward,
            'pre_balance' => $preBalance,
            'wallet_type' => WalletType::RESIDUAL_WALLET,
            'post_balance' => $user->residual_wallet,
            'type' => Transaction\Type::PLUS,
            'source' => Transaction\Source::INVESTMENT,
            'details' => $details,
        ]);
    }
}
