<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum InvestmentStatus: string
{
    use EnumValues, EnumOptions;

    case ACTIVE = "active";
    case PAUSED = "paused";
    case COMPLETED = "completed";
    case ENDED = "ended";
    case TERMINATED = "terminated";
    case PENDING_TERMINATION = "pending_termination";
}
