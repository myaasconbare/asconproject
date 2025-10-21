<?php

namespace App\Enums;

use App\Traits\EnumLabel;
use App\Traits\EnumOptions;

enum AdminNotificationTypes: string
{
    use EnumLabel, EnumOptions;

    case NEW_USER = "new_user";
    case NEW_LOGIN = "new_login";
    case NEW_DEPOSIT = "new_deposit";
    case NEW_INVESTMENT = "new_investment";
    case NEW_STAKE_INVESTMENT = "new_stake_investment";
    case NEW_TRADE = "new_trade";
    case NEW_TEAM_REWARD = "new_team_reward";
    case NEW_MATRIX_ENROLLMENT = "new_matrix_enrollment";
    case NEW_MATRIX_LEVEL_COMMISSION = "new_matrix_level_commission";
    case NEW_MATRIX_REFERRAL_COMMISSION = "new_matrix_referral_commission";


    public static function title($type)
    {
        return match ($type) {
            self::NEW_LOGIN->value => "Login Alert",
            self::NEW_USER->value => "New User Alert",
            self::NEW_DEPOSIT->value => "A deposit was approved successfully",
            self::NEW_STAKE_INVESTMENT->value => "Stake Investment Alert",
            self::NEW_INVESTMENT->value => "New Investment Alert",
            self::NEW_TRADE->value => "New Trade Alert",
            self::NEW_TEAM_REWARD->value => "New Team Reward",
            self::NEW_MATRIX_ENROLLMENT->value => "New Matrix Scheme Enrollment",
            self::NEW_MATRIX_LEVEL_COMMISSION->value => "New Matrix Level Commission",
            self::NEW_MATRIX_REFERRAL_COMMISSION->value => "New Matrix Referral Commission",
        };
    }

    public static function message($type, $args)
    {
        return match ($type) {
            self::NEW_LOGIN->value => strtr("A user %user just Logged in", $args),
            self::NEW_USER->value => strtr("New member %user registered! Welcome to our community. We're excited to have you on board!", $args),
            self::NEW_DEPOSIT->value => strtr("%user deposit request of %amount has been automatically approved", $args),
            self::NEW_INVESTMENT->value => strtr("A user %s just invested %s", $args),
            self::NEW_TRADE->value => strtr("A user %user just initiated a new trade", $args),
            self::NEW_TEAM_REWARD->value => strtr("A user %user received %amount team reward for their %level (%teamVolumeAtLevel) team volume milestone", $args),
            self::NEW_MATRIX_ENROLLMENT->value => strtr("A user %user just enrolled in to the matrix scheme with %amount", $args),
            self::NEW_MATRIX_LEVEL_COMMISSION->value => strtr("A user %user received %amount for their matrix level commission", $args),
            self::NEW_MATRIX_REFERRAL_COMMISSION->value => strtr("A user %user received %amount for their matrix referral commission", $args),
        };
    }
}
