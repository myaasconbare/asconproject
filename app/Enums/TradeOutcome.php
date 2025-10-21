<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum TradeOutcome : string
{
    use EnumValues, EnumOptions;
    
    case INITIATED = "initiated";
    case WIN = "win";
    case LOSE = "lose";
    case DRAW = "draw";
}
