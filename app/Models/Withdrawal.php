<?php

namespace App\Models;

use App\Enums\WithdrawalStatus;
use App\Traits\UseSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class Withdrawal extends Model
{
    use UseSearch;

    protected $guarded = [];

    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopebyActiveUser($query){
        return $query->where('user_id', Auth::id());
    }

    public function scopePending($query){
        return $query->where('status', WithdrawalStatus::PENDING);
    }

    public function scopeDeclined($query){
        return $query->where('status', WithdrawalStatus::DECLINED);
    }

    public function scopeApproved($query){
        return $query->where('status', WithdrawalStatus::APPROVED);
    }
}
