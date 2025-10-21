<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum InvestmentDeactivationStatus: string
{
    use EnumValues;
    use EnumOptions;
    
    case PENDING = "pending";
    case APPROVED = "approved";
    case DECLINED = "declined";
    case CANCELLED = "cancelled";

    public static function getColor($value): string | array| null 
        {
            return match($value){
                self::APPROVED->value => 'success',
                self::DECLINED->value, self::CANCELLED->value => 'danger',
                self::PENDING->value => 'warning'
            };
        }
}
