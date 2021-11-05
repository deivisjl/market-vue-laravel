<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Tienda;
use Svg\Tag\Rect;
use App\TiendaUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->middleware('tienda');
        return view('home');
    }

    public function tienda()
    {
        $tiendas = TiendaUsuario::with('tienda')
            ->where('usuario_id',Auth::user()->id)
            ->get()
            ->pluck('tienda');

        return view('verificar-tienda.index',['tiendas' =>$tiendas]);
    }

    public function elegirTienda(Request $request)
    {
        $rules = [
            'tienda' => 'required|numeric|min:1',
        ];

        $this->validate($request, $rules);

        $tienda = Tienda::findOrFail($request->tienda);

        $request->session()->forget('tienda');

        $request->session()->put('tienda',$tienda);

        return redirect()->route('home');
    }

    public function aperturaCaja()
    {
        return view('caja.index');
    }

    public function registrarApertura(Request $request)
    {
        $rules = [
            'saldo' => 'required|numeric|min:1',
        ];

        $this->validate($request, $rules);

        $tienda = $request->session()->get('tienda');

        $caja = new Caja();
        $caja->tienda_id = $tienda->id;
        $caja->saldo_inicial = $request->get('saldo');
        $caja->fecha_inicio = \Carbon\Carbon::now()->format('Y-m-d');
        $caja->hora_inicio = \Carbon\Carbon::now()->format('H:i A');
        $caja->activo = 1;
        $caja->usuario_id = Auth::user()->id;
        $caja->save();

        return redirect()->route('ventas.create');
    }

    public function registrarCierre()
    {
        $tienda = session('tienda');

        $caja = Caja::where('tienda_id',$tienda->id)
                        ->where('activo',1)
                        ->first();

        $caja->fecha_cierre = \Carbon\Carbon::now()->format('Y-m-d');
        $caja->hora_cierre = \Carbon\Carbon::now()->format('H:i A');
        $caja->activo = 0;
        $caja->usuario_id = Auth::user()->id;
        $caja->save();

        return redirect()->route('home');
    }
}
