<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait UseSearch
{
    public function scopeUseSearch($query, $fields){

        foreach($fields as $column => $value){
            $query = $query->when($value, fn(Builder $query) => $query->where($column, $value));
        }
        
        return $query;
    }
}
