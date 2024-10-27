<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class validateURLToken
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
        $urlToken = explode("/", URL::current());

        if(Session::has('url-token') && Session::get('url-token') === $urlToken[5]) {
            return $next($request);
        } else {
            exit('Token inválido');
        }       
    }
}
