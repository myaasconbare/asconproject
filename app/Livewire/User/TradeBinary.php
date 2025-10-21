<?php

namespace App\Livewire\User;

use App\Enums\ServerMessageTypes;
use App\Enums\TradeStatus;
use App\Enums\TradeTypes;
use App\Livewire\User\Forms\TradeForm;
use App\Models\CryptoCurrency;
use App\Models\Trade;
use App\Models\TradeDuration;
use App\Services\TradeService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class TradeBinary extends TradeLayout
{
    use ActionRateLimiter, Notify, WithPagination;
    
    public $cryptoId;

    public bool $isPractice = false;

    public TradeForm $form;

    public function mount($cryptoId){
        if(!$this->currency) return to_route('user.dashboard');

    }

    public function refreshTrades(){
        unset($this->trades);
    }

    #[Computed]
    public function currency(){
        return CryptoCurrency::where('crypto_id', $this->cryptoId)->first();
    }

    public function trade($volume = null){
       return $this->limit('executeTrade', 'limit-trade', params:$volume);
    }

    public function executeTrade($volume = null){

        try {
            
            $this->form->validate();

            $tradeService = resolve(TradeService::class);

            $tradeService->saveTrade(
                Auth::user(),
                $this->isPractice ? TradeTypes::PRACTICE->value : TradeTypes::TRADE->value,
                $this->form->amount,
                $this->form->duration,
                $this->currency,
                $volume,
            );

        } catch(ValidationException $e){
            return $this->notifyError($e->errors());
        } catch(Throwable $e) {
            return $this->notifyError($e->getMessage());
        }
        return $this->notifySuccess('Trade has been generated');
     }

     #[Computed]
     public function trades(){
        return $this->user()
                ->trades()
                ->when($this->isPractice, fn(Builder $query) => $query->practice())
                ->when(!$this->isPractice, fn(Builder $query) => $query->real())
                ->where('crypto_currency_id', $this->currency->id)
                ->latest()
                ->get();
     }

    public function render()
    {
        $tradeDurations = TradeDuration::where('is_active', true)->get();
        $trades = $this->trades;
        $commissionPercentage = 4;

        return view('livewire.user.trade-binary', compact('tradeDurations','trades', 'commissionPercentage'));
    }
}
