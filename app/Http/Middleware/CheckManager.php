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
        if (Helper::CCompany() == null) {
            return redirect('/');
        } else if (Helper::CIsManager()) {
            Helper::verifyEmployeeStatus();
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
