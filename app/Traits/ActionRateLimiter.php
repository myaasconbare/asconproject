<?php

namespace App\Traits;

use App\Enums\ServerMessageTypes;
use Illuminate\Support\Facades\RateLimiter;

trait ActionRateLimiter
{
    use Notify;

    public function limit(string $callback, $name, $perMinute = 10, $params = []){
        $params = is_array($params) ? $params : [$params];
        if (RateLimiter::tooManyAttempts($name . ':'.request()->ip(), $perMinute)) {
            $seconds = RateLimiter::availableIn($name . ':'.request()->ip());

            return $this->notifyError('Too many requests.. You may try again in ' . $seconds . ' seconds.');
        }
         
        RateLimiter::increment($name . ':'.request()->ip());

        return $this->{$callback}(...$params);
    }
}
