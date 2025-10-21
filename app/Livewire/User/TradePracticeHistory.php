<?php

namespace App\Livewire\User;

use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TradePracticeHistory extends DashboardLayout
{
    public ?string $outcome = null;
    public ?string $volume = null;
    public ?string $date = null;

    public function mount()
    {
        $this->outcome = request()->query('outcome');
        $this->volume = request()->query('volume');
        $this->date = request()->query('date');
    }

    public function render()
    {
        $trades = $this->user->trades()
            ->practice()
            ->useSearch([
                'outcome' => $this->outcome,
                'volume' => !$this->volume && is_null($this->volume) ? null : $this->volume,
                'created_at' => $this->date ? Carbon::parse($this->date) : null
            ])
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('livewire.user.trade-practice-history', ['trades' => $trades]);
    }
}
