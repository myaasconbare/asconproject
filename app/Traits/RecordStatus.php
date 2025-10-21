<?php

namespace App\Traits;

use App\Enums\ApprovedInvestmentState;
use App\Enums\TransactionStatus;
use Illuminate\Support\Carbon;

trait RecordStatus
{
    public function approved()
    {
        return $this->where('status', TransactionStatus::APPROVED);
    }

    public function pending()
    {
        return $this->where('status', TransactionStatus::PENDING);
    }

    public function declined()
    {
        return $this->where('status', TransactionStatus::DECLINED);
    }

    public function ongoing()
    {
        return $this->where('state', ApprovedInvestmentState::ONGOING);
    }

    public function active()
    {
        return $this->where('state', ApprovedInvestmentState::ACTIVE);
    }

    

    public function paused()
    {
        return $this->where('state', ApprovedInvestmentState::PAUSED);
    }

    public function deactivated()
    {
        return $this->where('state', ApprovedInvestmentState::DEACTIVATED);
    }

    public function pendingDeactivation()
    {
        return $this->where('state', ApprovedInvestmentState::PENDING_DEACTIVATION);
    }

    public function completed()
    {
        return $this->where('state', ApprovedInvestmentState::COMPLETED);
    }

    public function today(){
        return $this->whereDate('created_at', Carbon::today());
    }
   


}
