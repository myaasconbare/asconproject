<?php

namespace App\Livewire\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;


class ProfitStatistics extends DashboardLayout
{
    use WithPagination;

    public function mount(){
        
    }

    public function refreshProfits(){
        unset($this->profits);
    }

    #[Computed()]
    public function profits(){
        return $this->user
        ->profits()
        ->where(fn(Builder $query) => $query->today())
        ->latest()
        ->paginate()
        ->withQueryString();
    }

    public function render()
    { 
        return view('livewire.user.profit-statistics', ['profits' => $this->profits]);
    }
}
