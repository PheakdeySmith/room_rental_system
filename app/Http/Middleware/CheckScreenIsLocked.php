<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckScreenIsLocked
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && session('locked') === true) {
            if (
                !$request->routeIs('lockscreen.show') &&
                !$request->routeIs('lockscreen.unlock') &&
                !$request->routeIs('lockscreen.logout')
            ) {
                return redirect()->route('lockscreen.show');
            }
        }

        return $next($request);
    }
}