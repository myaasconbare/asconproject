<?php

namespace App\Services;

use App\Enums\TradeOutcome;
use App\Enums\TradeStatus;
use App\Enums\TradeTypes;
use App\Enums\TradeVolume;
use App\Models\TradeDuration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use App\Models\Trade;
use Error;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Throwable;

class TradeService
{
    /**
     * Create a new class instance.
     */

    const CHARGE = 4;

    public function __construct(
        public CoinGeckoService $coinGeckoService,
        public Trade $trade,
        public TradeDuration $tradeDuration
    ) {
        //
    }

    public function validate($user, $wallet, $amount, $volume)
    {

        throw_if($user->{$wallet[0]} < $amount, "Insufficient " . $wallet[1]);

        throw_if(!in_array($volume, ['high', 'low']), "Invalid Trade Parameter");
    }

    public function determineTradeOutcome($currentPrice, $trade)
    {
        return match (true) {
            $trade->volume == TradeVolume::HIGH->value && $currentPrice > $trade->original_price,
            $trade->volume == TradeVolume::LOW->value && $currentPrice < $trade->original_price => TradeOutcome::WIN->value,
            $trade->volume == TradeVolume::HIGH->value && $currentPrice < $trade->original_price,
            $trade->volume == TradeVolume::LOW->value && $currentPrice > $trade->original_price => TradeOutcome::LOSE->value,
            default => TradeOutcome::DRAW->value
        };
    }

    public function cron()
    {

        $this->trade->where('status', TradeStatus::RUNNING)
            ->whereTime('arrival_time', '<', now())
            ->lazyById(200)
            ->each(function ($trade) {
                if (Carbon::now()->gte(Carbon::parse($trade->arrival_time))) {
                    DB::transaction(function () use ($trade) {
                        Log::info('excecuted-trade');
                        Log::error('excecuted-trade');

                        $currentPrice = $this->coinGeckoService->getCoinRate($trade->cryptoCurrency);

                        $tradeOutcome = $this->determineTradeOutcome($currentPrice, $trade);

                        $this->handleTradeOutcome($trade, $currentPrice, $tradeOutcome);
                    });
                }
            });
        // $tr
    }

    public function calculateLoss(Trade $trade)
    {
        return ((self::CHARGE / 100) * $trade->amount) + $trade->amount;
    }

    public function calculateWin(Trade $trade)
    {
        return ((self::CHARGE / 100) * $trade->amount) + $trade->amount;
    }

    public function handleTradeOutcome($trade, $currentPrice, $tradeOutcome)
    {
        $tradeAmount = $trade->amount;

        $wallet = match ($trade->type) {
            TradeTypes::TRADE->value => ['trade_wallet', 'Trade Wallet Balance'],
            TradeTypes::PRACTICE->value => ['trade_practice_wallet', 'Trade Practice Wallet Balance'],
        };

        if ($tradeOutcome == TradeOutcome::WIN->value) {
            $tradeAmount = $this->calculateWin($trade);
        }

        $amount = $tradeOutcome == TradeOutcome::LOSE->value ? -$trade->amount : ($tradeOutcome == TradeOutcome::WIN->value ? $tradeAmount : $trade->amount);

        $preBalance = $trade->user->{$wallet[0]};

        $trade->user->{$wallet[0]} += $amount;

        $trade->user->save();

        if ($tradeOutcome == TradeOutcome::WIN->value) {
            $trade->user->increment('winning_amount', $trade->amount);

            $trade->update([
                'winning_amount' => $this->calculateWin($trade) - $trade->amount,
            ]);
        } elseif ($tradeOutcome == TradeOutcome::LOSE->value) {
            $trade->user->increment('loss_amount', $trade->amount);
        }

        $trade->update([
            'outcome' => TradeOutcome::from($tradeOutcome),
            'status' => TradeStatus::COMPLETE,
            'meta' => [
                'result_price' => $currentPrice,
            ]
        ]);

        if ($trade->type == TradeTypes::TRADE->value) {
            $details = match ($tradeOutcome) {
                TradeOutcome::WIN->value => "Trade {$trade->symbol} WIN",
                TradeOutcome::LOSE->value => "Trade {$trade->symbol} LOSE",
                TradeOutcome::DRAW->value => "Trade {$trade->symbol} Refund",
                default => [0, ''],
            };

            $trade->transaction()->create([
                'user_id' => $trade->user->id,
                // 'amount' => abs($amount),
                'amount' => $amount,
                'pre_balance' => $preBalance,
                'post_balance' => $trade->user->{$wallet[0]},
                'type' => $amount < 0 ? Transaction\Type::MINUS : Transaction\Type::PLUS,
                'source' => Transaction\Source::TRADE,
                'details' => $details,
                'wallet_type' => WalletType::TRADE_WALLET,
            ]);
        }
    }

    public function saveTrade($user, $type, $amount, $duration, $currency, $volume)
    {
        $wallet = match ($type) {
            TradeTypes::TRADE->value => ['trade_wallet', 'Trade Wallet Balance'],
            TradeTypes::PRACTICE->value => ['trade_practice_wallet', 'Trade Practice Wallet Balance'],
        };

        $this->validate($user, $wallet, $amount, $volume);

        try {
            DB::transaction(function () use (&$trade, $type, $wallet, $amount, $duration, $currency, $volume, $user) {

                $tradeDuration = TradeDuration::find($duration);

                $user->decrement($wallet[0], $amount);

                $trade = $user
                    ->trades()
                    ->create([
                        'original_price' => $this->coinGeckoService->getCoinRate($currency),
                        'crypto_currency_id' => $currency->id,
                        'amount' => $amount,
                        'duration' => $tradeDuration->duration,
                        'period' => $tradeDuration->period,
                        'arrival_time' => now()->{'add' .  $tradeDuration->period}($tradeDuration->duration),
                        'type' => TradeTypes::from($type)->value,
                        'volume' => match ($volume) {
                            'high' => '1',
                            'low' => '0',
                        },
                        'outcome' => TradeOutcome::INITIATED,
                    ]);


                if ($trade->type == TradeTypes::TRADE->value) {

                    $user->increment('total_trading', $amount);

                    $details = sprintf("Trade %s %s at %s", strtoupper($currency->symbol), ($volume), Number::currency($trade->original_price));

                    $trade->transaction()->create([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'pre_balance' => $user->deposit_wallet,
                        'post_balance' => $user->deposit_wallet,
                        'type' => Transaction\Type::MINUS,
                        'source' => Transaction\Source::TRADE,
                        'wallet_type' => WalletType::TRADE_WALLET,
                        'details' => $details,
                    ]);
                }
            });
        } catch (Throwable $e) {
            Log::error('unable to initiate trade', ['message' => $e->getMessage()]);
            throw new Error('Unable to initiate trade');
        }

        return $trade;
    }
}
