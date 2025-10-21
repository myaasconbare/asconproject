<?php

namespace App\Enums\Transaction;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;
use Carbon\Traits\Options;

enum Type : string
{
    use EnumOptions, EnumValues;

    case PLUS = '1';
    case MINUS = '0';
}
