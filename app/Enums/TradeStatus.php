<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum TradeStatus: string
{
    use EnumValues, EnumOptions;

    case RUNNING = "running";
    case COMPLETE = "complete";
}
