<?php

namespace App\Livewire\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Investments extends DashboardLayout
{
    use WithPagination;

    public ?string $search = null;
    public ?string $status = null;
    public ?string $date = null;

    public function mount()
    {
        $this->search = request()->query('search');
        $this->status = request()->query('status');
        $this->date = request()->query('date');
    }

    public function render()
    {
        $investments = $this->user
            ->investments()
            ->with(['license.portfolio'])
            ->useSearch([
                'transaction_id' => $this->search,
                'status' => $this->status,
                'created_at' => $this->date ? Carbon::parse($this->date) : null
            ])
            ->paginate()
            ->withQueryString();

        return view('livewire.user.investments', compact('investments'));
    }
}
