<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class TeamReward extends Model
{
    protected $guarded = [];
    protected $casts = [
        'meta' => 'json'
    ];

    
    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable')
        // ->where('id', 8)
        ;
    }

    public function transactions(): MorphMany {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
