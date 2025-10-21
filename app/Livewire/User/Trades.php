<?php

namespace App\Livewire\User;

use App\Enums\DepositStatus;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class Trades extends DashboardLayout
{
    use WithPagination, ActionRateLimiter, Notify;

    public ?string $outcome = null;
    public ?string $volume = null;
    public ?string $date = null;

    #[Validate(['required', 'numeric'])]
    public string $amount;

    public function mount()
    {
        $this->outcome = request()->query('outcome');
        $this->volume = request()->query('volume');
        $this->date = request()->query('date');
    }

    public function topUpSubmit()
    {
        return $this->limit('topup', 'topup-limit');
    }

    public function topup()
    {
        try {
            $amount = $this->amount;
            $this->validate();

            resolve(UserService::class)->topUp(Auth::user(), 'trade_practice_wallet', $amount);

            $this->reset('amount');

            Auth::user()->refresh();
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            return $this->notifyError('Something went wrong');
        }

        return $this->notifySuccess('Practice successfully topped up with ' . Number::currency($amount));
    }

    public function tradedAmount($date)
    {
        return $this->user
            ->trades()
            ->onDate($date)
            ->sum('amount');
    }


    #[Computed]
    public function tradeDailyStats()
    {
        $currentDate = now();
        $days = [];
        $tradedAmounts = [];
        $withdrawalAmounts = [];

        for ($i = 0; $i < 90; $i++) {
            $currentDate = $currentDate->subDay();
            $day = $currentDate->format('Y-m-d');

            array_push($tradedAmounts, $this->tradedAmount($currentDate));

            array_push($days, $day);
        }

        return compact('days', 'tradedAmounts');
    }


    public function render()
    {

        $totalTradeAmount = Number::currency($this->user->trades()->sum('amount'));
        $todayTrading = Number::currency($this->user->trades()->today()->sum('amount'));
        $winningAmount = Number::currency($this->user->trades()->winRecords()->sum('amount'));
        $lossAmount = Number::currency($this->user->trades()->lossRecords()->sum('amount'));
        $drawAmount = Number::currency($this->user->trades()->drawRecords()->sum('amount'));
        $highAmount = Number::currency($this->user->trades()->highRecords()->sum('amount'));
        $lowAmount = Number::currency($this->user->trades()->lowRecords()->sum('amount'));

        $trades = $this->user->trades()
            ->real()
            ->useSearch([
                'outcome' => $this->outcome,
                'volume' => !$this->volume && is_null($this->volume) ? null : $this->volume,
                'created_at' => $this->date ? Carbon::parse($this->date) : null
            ])
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('livewire.user.trades', compact(
            'trades',
            'totalTradeAmount',
            'todayTrading',
            'winningAmount',
            'lossAmount',
            'drawAmount',
            'highAmount',
            'lowAmount',
        ));
    }
}
