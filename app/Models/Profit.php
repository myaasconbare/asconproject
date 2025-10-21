<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

class Profit extends Model
{
    protected $guarded = [];
    
    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeToday($query){
        return $this->onDate(Carbon::today());
    }
    public function scopeOnDate($query, $date){
        return $query->whereDate('created_at', $date);
    }
}
