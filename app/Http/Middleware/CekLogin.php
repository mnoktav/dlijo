<?php

namespace App\Http\Middleware;

use Closure;

class CekLogin
{
	public function handle($request, Closure $next, $guard = null)
    {
        if(session()->get('login') == null){
           return redirect()->route('login.admin');
        }
        return $next($request);
    }

}