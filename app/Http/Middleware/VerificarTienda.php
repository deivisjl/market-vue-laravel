<?php

namespace App\Http\Middleware;

use Closure;

class VerificarTienda
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
        if($request->session()->has('tienda') && $request->session()->get('tienda') != null)
        {
            return $next($request);
        }
        else
        {
            return redirect()->to('/seleccionar-tienda');
        }
    }
}
