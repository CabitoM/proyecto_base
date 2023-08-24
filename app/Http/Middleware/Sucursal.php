<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Sucursal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('id_sucursal') < 1 ) {
            return redirect('elegir_sucursal');
        }
        return $next($request);
    }
}
