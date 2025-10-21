<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum TradeTypes : string
{
    use EnumValues, EnumOptions;

    case PRACTICE = "practice";
    case TRADE = "trade";
}
