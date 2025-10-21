<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoCurrency extends Model
{
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTopGainers($query)
    {
        return $query->whereNotNull('top_gainer');
    }

    public function scopeTopLosers($query)
    {
        return $query->whereNotNull('top_loser');
    }
}
