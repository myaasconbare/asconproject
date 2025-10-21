<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum CommissionType : string
{
    use EnumValues, EnumOptions;

    case LEVEL = "level";
    case REFERRAL = "referral";
    case INVESTMENT = "investment";
    case DEPOSIT = "deposit";
}
