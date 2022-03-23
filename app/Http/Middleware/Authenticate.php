<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                auth()->shouldUse($guard);
                return $next($request);
            }
        }

        if ($request->ajax()) {
            // return redirect('login');
            return response('Unauthorized', 401);
        } else {
            if (config('global.json_mode')) {
                return $next($request);
            } else {
                return redirect('login');
            }
        }
    }
}
