<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardBadge extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeWithActive($query){
        return $query->where('is_active', 1);
    }
}
