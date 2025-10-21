<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum DepositStatus : string
{
    
   
        use EnumValues;
        use EnumOptions;
        
        case PENDING = "pending";
        case APPROVED = "approved";
        case DECLINED = "declined";
        case PROCESSING = "processing";
        case COMPLETED = "completed";
        case CANCELLED = "cancelled";

        public static function getColor($value): string | array| null 
        {
            return match($value){
                self::APPROVED->value => 'success',
                self::DECLINED->value, self::CANCELLED->value => 'danger',
                self::PROCESSING->value, self::PENDING->value => 'warning'
            };
        }
}
