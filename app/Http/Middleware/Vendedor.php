<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Vendedor
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
        if(Auth::user()->esVendedor() || Auth::user()->esAdministrador() || Auth::user()->esGerente())
        {
            return $next($request);
        }
        else
        {
            return redirect()->to('/');
        }
    }
}
