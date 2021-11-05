<?php

namespace App\Http\Middleware;

use Closure;
use App\Caja;

class CajaMiddleware
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
        $tienda = $request->session()->get('tienda');

        $aperturado = Caja::where('activo',1)
                            ->where('tienda_id',$tienda->id)
                            ->first();

        if($aperturado)
        {
            return $next($request);
        }
        else
        {
            return redirect()->to('/aperturar-caja');
        }
    }
}
