<?php

namespace App\Models;

use App\Enums\StakingInvestmentStatus;
use App\Traits\FormattedDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class StakingInvestment extends Model
{
    use FormattedDate;

    protected $guarded = [];

    protected $casts = [
        'next_interest_date' => 'datetime',
        'last_interest_date' => 'datetime',
        'expires_at' => 'datetime',
        'pasued_at' => 'datetime',
    ];

    public function profits(): HasMany
    {
        return $this->hasMany(StakingProfit::class);
    }

    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeRunning($query){
        return $query->where('status', StakingInvestmentStatus::RUNNING);
    }

    

    public function scopebyActiveUser($query){
        return $query->where('user_id', Auth::id());
    }
}
