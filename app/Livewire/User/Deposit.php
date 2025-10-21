<?php

namespace App\Livewire\User;

use App\Enums\ServerMessageTypes;
use App\Livewire\User\Forms\DepositForm;
use App\Models\Setting;
use App\Services\DepositService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Throwable;

class Deposit extends DashboardLayout
{
    use ActionRateLimiter, Notify, WithPagination;

    public DepositForm $form;

    public ?string $search = null;
    public ?string $status = null;
    public ?string $date = null;


    public function mount()
    {
        $this->search = request()->query('search');
        $this->status = request()->query('status');
        $this->date = request()->query('date');
    }


    public function submit()
    {
        return $this->limit('validateForm', 'deposit-limit');
    }

    public function validateForm()
    {

        try {
            $this->form->validate();

            $depositService = resolve(DepositService::class);

            $deposit = $depositService->initiateDeposit(
                $this->form->amount,
                $this->form->selectedCurrency
            );

            return to_route('user.deposit-details', ['transactionId' => $deposit->transaction_id]);
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            return $this->notifyError($e->getMessage());
        }
    }

    #[Computed()]
    public function currencies()
    {
        return DepositService::currencies() ?? [];
    }

    public function render()
    {
        $SiteSettings = Setting::first();
        $minimumDeposit = $SiteSettings ? (float) $SiteSettings->min_deposit : null;

        $deposits = $this->user->deposits()
            ->useSearch([
                'transaction_id' => $this->search,
                'status' => $this->status,
                'created_at' => $this->date ? Carbon::parse($this->date) : null
            ])
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('livewire.user.deposit', compact('minimumDeposit', 'deposits'));
    }
}
