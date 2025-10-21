<?php

namespace App\Models;

use App\Enums\InvestmentDeactivationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class InvestmentDeactivation extends Model
{
    protected $guarded = [];

    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function license() : BelongsTo {
        return $this->belongsTo(License::class, 'license_id');
    }
    public function scopePending($query){
        return $query->where('status', InvestmentDeactivationStatus::PENDING);
    }

    public function investment() : BelongsTo {
        return $this->belongsTo(Investment::class, 'investment_id');
    }

}
