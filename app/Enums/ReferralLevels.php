<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum ReferralLevels: string {
    use EnumValues, EnumOptions;

    case LEVEL_ONE = "1";
    case LEVEL_TWO = "2";
    case LEVEL_THREE = "3";
    case LEVEL_FOUR = "4";
    case LEVEL_FIVE = "5";
    case LEVEL_SIX = "6";
    case LEVEL_SEVEN = "7";
    case LEVEL_EIGHT = "8";
    case LEVEL_NINE = "9";
}