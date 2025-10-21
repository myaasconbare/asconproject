<?php

namespace App\Livewire\User\Partials;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{

    use WithPagination;

    public ?string $search = null;
    public ?string $walletType = null;
    public ?string $source = null;
    public ?string $date = null;
    public ?int $limit = null;

    public string $title;

    public function mount($title, $limit = null)
    {
        $this->search = request()->query('search');
        $this->walletType = request()->query('walletType');
        $this->source = request()->query('source');
        $this->date = request()->query('date');


        // dd(Trade::find(17)->transactions, Trade::find(17)->transaction);
    }



    public function render()
    {
        $transactions = User::active()
            ->transactions()
            ->withWhereHas('transactionable')
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

        return view('livewire.user.partials.transactions', [
            'transactions' => $transactions
        ]);
    }
}
