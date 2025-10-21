<?php

namespace App\Livewire\User;

use App\Enums\ServerMessageTypes;
use App\Livewire\User\Forms\WithdrawalForm;
use App\Models\WithdrawalCurrency;
use App\Services\WithdrawalService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class Cashout extends DashboardLayout
{
    use ActionRateLimiter, Notify, WithPagination;

    public WithdrawalForm $form;

    public ?string $search = null;
    public ?string $status = null;
    public ?string $date = null;

    public function mount()
    {
        $this->search = request()->query('search');
        $this->status = request()->query('status');
        $this->date = request()->query('date');
    }

    #[Computed]
    public function currencies()
    {
        return WithdrawalCurrency::where('is_active', true)->get();
    }


    public function submit()
    {
        return $this->limit('validateForm', 'deposit-limit');
    }

    public function validateForm()
    {

        try {
            $this->form->validate();

            $withdrawalService = resolve(WithdrawalService::class);

            $withdrawalService->initiateWithdrawal($this->form->all());

        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            return $this->notifyError($e->getMessage());
        }

        return $this->notifySuccess('Payout request successfully submitted. wait for confirmation');
    }


  

    public function render()
    {
        $withdrawals = $this->user->withdrawals()
            ->useSearch([
                'transaction_id' => $this->search,
                'status' => $this->status,
                'created_at' => $this->date ? Carbon::parse($this->date) : null
            ])
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('livewire.user.cashout', compact('withdrawals'));
    }
}
