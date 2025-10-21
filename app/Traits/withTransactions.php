<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;

trait withTransactions
{
    #[Computed]
    public function transactions(){
        return User::active()
            ->transactions()
            ->withWhereHas('transactionable')

            ->when($this->commissionType, function ($query) {
                return $query->whereHas(
                    'transactionable', 
                    fn ($query) => $query->where('type', $this->commissionType)
                );
            })
            ->useSearch([
                'transaction_id' => $this->search,
                'wallet_type' => $this->walletType,
                'source' => $this->source,
                'created_at' => $this->date ? Carbon::parse($this->date) : null
            ])
            ->latest()
            ->when($this->limit, function (Builder $query) {
                return $query->limit(10)->get();
            })
            ->when(!$this->limit, function ($query) {
                return $query->paginate()
                    ->withQueryString();
            });
    }
}
