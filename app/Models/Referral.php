<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function referred(): BelongsTo{
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    public function scopeLevel($query, $level){
        return $query->where('level', $level);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
