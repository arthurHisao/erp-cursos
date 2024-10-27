<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ValidateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $timeDiff = (time() - Session::get('created_at')) / 60;

        if($timeDiff >= 60) {
            Session::forget('created_at');
            Session::invalidate();
            return redirect()->route('user.reset');
        } 
        return $next($request);
    }
}
