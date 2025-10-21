<?php

namespace App\Enums\Transaction;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum Source: string
{
    use EnumOptions, EnumValues;

    case ALL = "all";
    case MATRIX = "MATRIX";
    case INVESTMENT = "INVESTMENT";
    case TRADE = "TRADE";
}
