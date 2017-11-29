<?php

namespace App\Http\Middleware;

use App\Tools\Helper;
use Closure;

class CheckManager
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
        if (Helper::CIsManager()) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
