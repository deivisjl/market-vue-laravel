<?php

namespace App\Http\Controllers;

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
}
