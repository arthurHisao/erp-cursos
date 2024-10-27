<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ValidateRoute
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
        if(Auth::check() || Session::has('id')) {
            return redirect()->route('user.student');
        } else if (Auth::guard('userAdmin')->check()) {
            return redirect()->route('admin.list.users');
        }
        return $next($request);
    }
}
