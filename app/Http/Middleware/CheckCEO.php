<?php

namespace App\Http\Middleware;

use App\Tools\Helper;
use Closure;

class CheckCEO
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Helper::CIsCEO()) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
