<?php

namespace App\Enums\Transaction;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum WalletType : string
{
    use EnumOptions, EnumValues;

    case DEPOSIT_WALLET = "deposit_wallet";
    case INTEREST_WALLET = "interest_wallet";
    case RESIDUAL_WALLET = "residual_wallet";
    case TRADE_WALLET = "trade_wallet";
    case TRADE_PRACTICE_WALLET = "trade_practice_wallet";
    
    // case PRIMARY = "primary";
    // case INVESTMENT = "investment";
    // case TRADE = "trade";
    // case PRACTICE = "practice";
}
