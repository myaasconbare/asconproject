<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum ProfitTypes: string
{
    use EnumValues, EnumOptions;

    case MINUTELY = "minutely";
    case DAILY = "daily";

}
