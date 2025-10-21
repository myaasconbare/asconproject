<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum Periods : string
{
    use EnumValues, EnumOptions;

    case HOURS = 'hours';
    case DAYS = 'days';
}
