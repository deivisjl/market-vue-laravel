<?php

namespace App\Http\Controllers\Inventario;

use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("i.id","p.nombre","i.cantidad","i.precio_promedio");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $tienda = $request->session()->get('tienda');

        $existencias = DB::table('vista_inventario as i')
                ->join('producto as p','i.producto_id','p.id')
                ->select('i.id','p.nombre as producto','i.stock',DB::raw('ROUND((((i.precio * p.porcentaje_ganancia)/100)+ i.precio),2) as precio'),'p.stock_minimo')
                ->where('i.tienda_id',$tienda->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('vista_inventario as i')
                ->join('producto as p','i.producto_id','p.id')
                ->select('i.id','p.nombre as producto','i.stock',DB::raw('ROUND((((i.precio * p.porcentaje_ganancia)/100)+ i.precio),2) as precio'),'p.stock_minimo')
                ->where('i.tienda_id',$tienda->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $existencias,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        //
    }
}
