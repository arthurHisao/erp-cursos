<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validateLesson
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
        if($request->segment(2) === "-") {
            return redirect()->route('user.student');
        }
        return $next($request);
    }
}
