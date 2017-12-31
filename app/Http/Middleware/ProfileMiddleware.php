<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProfileMiddleware
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
        if (substr($request->url(),strpos($request->url(),'profile/') + 8,strlen(Auth::user()->slug)) == Auth::user()->slug) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
