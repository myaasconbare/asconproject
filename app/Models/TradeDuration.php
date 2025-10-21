<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeDuration extends Model
{
    protected $guarded = [];

    public function getPeriodLabelAttribute(){
        // $periodSingular = substr($this->period, 0, strlen($this->period) - 1);
        // return ucfirst($periodSingular) . "(s)";
        $this->period = ucfirst($this->period);
        
        if($this->duration > 1) return $this->period;
        
       return  substr($this->period, 0, strlen($this->period) - 1);
    }

    
}
