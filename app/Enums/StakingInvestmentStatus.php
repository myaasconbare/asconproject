<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum StakingInvestmentStatus : string
{
    use EnumValues, EnumOptions;
    
    case RUNNING = "running";
    case PAUSED = "paused";
    case COMPLETED = "completed";

    public static function getStatusColor($value){
        return match($value){
            self::RUNNING->value => "info",
            self::PAUSED->value => "primary",
            self::COMPLETED->value => "success",
        };
    }
}
