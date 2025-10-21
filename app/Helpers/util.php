<?php

// <span><i class="bi bi-wallet-fill"></i></span>

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

function routePattern($route)
{
    return  ltrim(route($route, absolute: false), '/');
}

function routeName($route)
{
    return $route;
}

function random_float($min, $max): float
{
    return random_int($min * 1000, $max * 1000) / 1000;
}

function money($number, $symbol = "$"): string
{
    // retu;

    return $symbol . format_number($number);
}


function format_number($number): string
{

    $numberStr = (string) $number;

    if (preg_match('/^0\.0[0-9]{3,}$/', $numberStr)) {
        return $numberStr;
    } else {
        return number_format((float) $number, 2);
    }
}

function maskCharacter($character, $length = 4)
{
    $characterLen = strlen($character);
    $codeArr = str_split($character);

    return join("", array_map(function ($e, $idx) use ($characterLen, $length) {
        if ($idx < $length) return $e;
        // if($characterLen - $idx > 4) return '*'; 
        // return $e;            
        return '*';
    }, $codeArr, array_keys($codeArr)));
}

function maskEmail($email)
{
    $emailParts = explode('@', $email);
    return maskCharacter($emailParts[0], 3) . '@' . $emailParts[1];
}

function referralLevel(){
    return Setting::latest()->first()?->referral_level ?? 9;
}
function transactionId($length = 12){
    return strtoupper(Str::random($length));
}
function referenceId(){
    return 'REF-' . transactionId();
}

function formatDate($dateColum, $format = 'Y-m-d h:i A'){
    if(Auth::guest()) return $dateColum?->format($format);

    $date = Carbon::parse($dateColum);

    if(Auth::user()->timezone) {
        return $date->timezone(Auth::user()->timezone)->format($format);
    }

    return $date->format($format);
}
function activeUser(){
    /**
     * @var \App\Models\User
     */
    $user = Auth::user();

    return $user;
}