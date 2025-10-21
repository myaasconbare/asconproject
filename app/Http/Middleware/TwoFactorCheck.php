<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(session()->has('view_details')) return $next($request);

        if (Auth::user()->is_2fa_enabled && !session('two_factor_verified')) {
            return to_route('user.two-factor-challange');
        }

        if (Auth::viaRemember()) {
            session(['two_factor_verified' => true]);
            return $next($request);
        }

        return $next($request);
    }
}
