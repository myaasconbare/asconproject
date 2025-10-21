<?php

namespace App\Livewire\User\Partials;

use App\Enums\CommissionType;
use App\Traits\withTransactions;
use Livewire\Component;
use Livewire\WithPagination;

class MatrixTransactions extends Component
{
    use WithPagination, withTransactions;

    public ?string $search = null;
    public ?string $walletType = null;
    public ?string $source = null;
    public ?string $date = null;
    public ?int $limit = null;

    public string $commissionType;

    public string $title;

    public function mount($title, $commissionType, $limit = null)
    {
        $this->search = request()->query('search');
        $this->walletType = request()->query('walletType');
        $this->source = request()->query('source');
        $this->date = request()->query('date');
    }

    public function render()
    {
        $transactions = $this->transactions;

        return view('livewire.user.partials.matrix-transactions', compact('transactions'));
    }
}
