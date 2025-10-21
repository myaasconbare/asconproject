<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $guarded = [];

    public function licenses(): HasMany {
        return $this->hasMany(License::class, 'portfolio_id');
    }
    
    public function getLeastPlanAttribute(){
        return $this->licenses()->orderBy('minimum_amount', 'asc')->first();
    }

    public function getMaxPlanAttribute(){
        return $this->licenses()->orderBy('minimum_amount', 'desc')->first();
    }

    public function getPeriodLabelAttribute(){
        $this->period = ucfirst($this->period);
        
        if($this->duration > 1) return $this->period;
        
       return  substr($this->period, 0, strlen($this->period) - 1);
    }

    public function getMinimumAmountAttribute(){
       return $this->least_plan->minimum_amount;
    }

    public function getMaximumAmountAttribute(){
        return $this->max_plan->maximum_amount;
     }
}
