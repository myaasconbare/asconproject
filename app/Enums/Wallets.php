<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum Wallets : string
{
    use EnumValues, EnumOptions;

    case DEPOSIT = "deposit_wallet";
    case INTEREST = "interest_wallet";
    case RESIDUAL = "residual_wallet";
}
