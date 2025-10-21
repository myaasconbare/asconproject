<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'commission' => 'array'
    ];

    public function scopeWithActive($query){
        return $query->where('is_active', 1);
    }
}
