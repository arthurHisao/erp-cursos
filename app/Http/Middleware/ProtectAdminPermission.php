<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProtectAdminPermission
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
        $id = $request->segment(3);
        //condicao
        return $id === "1" ? redirect()->route('admin.dashboard') : $next($request);     
    }
}
