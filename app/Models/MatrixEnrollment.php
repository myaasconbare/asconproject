<?php

namespace App\Models;

use App\Traits\FormattedDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MatrixEnrollment extends Model
{
    use FormattedDate;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];

    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan(): BelongsTo {
        return $this->belongsTo(MatrixPlan::class, 'matrix_plan_id');
    }

    public function scopebyActiveUser($query){
        return $query->where('user_id', Auth::id());
    }

    static function boot(){
        parent::boot();
        static::creating(function(Model $record) {
            $record->transaction_id = transactionId();
        });
    }
}

