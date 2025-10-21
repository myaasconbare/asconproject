<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Commission extends Model
{  
    protected $guarded = [];

    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromUser(): BelongsTo {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function scopebyActiveUser($query){
        return $query->where('user_id', Auth::id());
    }

    public static function boot(){
        parent::boot();

        static::creating(function(Model $record){
            $transaction_id = transactionId();
            $record->transaction_id = $transaction_id;
        });
    }
}
