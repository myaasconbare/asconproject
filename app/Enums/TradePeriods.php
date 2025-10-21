<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum TradePeriods: string
{
    use EnumValues, EnumOptions;

    case SECONDS = "seconds";
    case MINUTES = "minutes";
    case HOURS = "hours";
}
