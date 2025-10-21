<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakingPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDurationLabelAttribute(){
        return $this->duration . ' ' . $this->period_label;
    }

    public function getPeriodLabelAttribute(){
        $this->period = ucfirst($this->period);
        
        if($this->duration > 1) return $this->period;
        
       return  substr($this->period, 0, strlen($this->period) - 1);
    }
}
