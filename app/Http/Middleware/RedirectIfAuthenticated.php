<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if ($guard == "gas") {
                    //user was authenticated with gas guard.
                    return redirect()->route('gas.index');
                } elseif ($guard == "icecream") {
                    //user was authenticated with icecream guard.
                    return redirect()->route('icecream.index');
                } elseif ($guard == "watercom") {
                    //user was authenticated with watercom guard.
                    return redirect()->route('watercom.index');
                } else {
                    //default guard.
                    return redirect()->route('home');
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
