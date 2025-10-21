<?php

namespace App\Enums\Transaction;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum Status: string
{
    use EnumValues;
    use EnumOptions;
        
    case PENDING = "pending";
    case APPROVED = "approved";
    case COMPLETED = "completed";
    case DECLINED = "declined";
    case PROCESSING = "processing";
    case PARTIALLY_PAID = "partially_paid";

    public static function getColor($value): string | array| null 
    {
        return match($value){
            self::APPROVED->value => 'success',
            self::COMPLETED->value => 'success',
            self::DECLINED->value => 'danger',
            self::PARTIALLY_PAID->value => 'success',
            self::PROCESSING->value, self::PENDING->value => 'warning'
        };
    }
}
