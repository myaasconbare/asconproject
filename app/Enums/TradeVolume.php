<?php

namespace App\Enums;

use App\Traits\EnumLabel;
use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum TradeVolume: string
{
    use EnumValues, EnumLabel;

    case HIGH = '1';
    case LOW = '0';
}
