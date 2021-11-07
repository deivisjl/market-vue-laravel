<?php

namespace App\Http\Controllers\Inventario;

use App\Producto;
use App\Inventario;
use App\Transferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $ordenadores = array("i.producto_id","p.nombre","i.cantidad","i.precio_promedio");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $tienda = $request->session()->get('tienda');

        $existencias = DB::table('vista_inventario as i')
                ->join('producto as p','i.producto_id','p.id')
                ->select('i.producto_id as id','p.nombre as producto','i.stock',DB::raw('ROUND((((i.precio * p.porcentaje_ganancia)/100)+ i.precio),2) as precio'),'p.stock_minimo')
                ->where('i.tienda_id',$tienda->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('vista_inventario as i')
                ->join('producto as p','i.producto_id','p.id')
                ->select('i.producto_id','p.nombre as producto','i.stock',DB::raw('ROUND((((i.precio * p.porcentaje_ganancia)/100)+ i.precio),2) as precio'),'p.stock_minimo')
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

    public function detalle($id)
    {
        $tienda = session('tienda');

        $producto = Producto::where('id',$id)
                        ->first();

        if($producto != null)
        {
            return view('inventario.detalle',['producto' => $producto]);
        }
        else
        {
            abort(404);
        }
    }

    public function detalleProducto(Request $request)
    {
        $ordenadores = array("p.id","to.nombre");

        $columna = $request['order'][0]["column"];

        $registro = $request['buscar'][0]['registro'];

        $tienda = $request->session()->get('tienda');

        $historial = DB::table('producto as p')
                    ->join('inventario as i','i.producto_id','p.id')
                    ->join('tipo_operacion as to','i.tipo_operacion_id','to.id')
                    ->select('i.id','to.nombre','i.precio','i.cantidad','i.precio_promedio',DB::raw("date_format(i.created_at,'%d-%m-%Y') as fecha"))
                    ->where('p.id',$registro)
                    ->where('i.tienda_id',$tienda->id)
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

        $count = DB::table('producto as p')
                ->join('inventario as i','i.producto_id','p.id')
                ->join('tipo_operacion as to','i.tipo_operacion_id','to.id')
                ->where('p.id',$registro)
                ->where('i.tienda_id',$tienda->id)
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $historial,
        );

        return response()->json($data, 200);
    }

    public function transferencia()
    {
        $tienda = session('tienda');

        return view('inventario.transferencia',['tienda'=>$tienda]);
    }

    public function crearTransferencia(Request $request)
    {
        try
        {
            $rules = [
                "boleta_referencia" => 'required',
                "autorizo_traslado" => 'required',
                "fecha" => 'required|date',
                "motivo" => 'required',
                "solicito_traslado" => 'required',
                "tienda_destino_id" => 'required',
                "tienda_origen_id" => 'required',
                "lista" => 'required|array'
            ];

            $this->validate($request, $rules);

            return DB::transaction(function() use($request){
                foreach ($request->lista as $key => $item)
                {
                    $registro = new Transferencia();
                    $registro->boleta_referencia = $request->get('boleta_referencia');
                    $registro->tienda_origen_id = $request->get('tienda_origen_id');
                    $registro->tienda_destino_id = $request->get('tienda_destino_id');
                    $registro->producto_id = $item['producto']['id'];
                    $registro->cantidad = $item['cantidad'];
                    $registro->precio = $item['precio'];
                    $registro->quien_solicito_traslado = $request->get('solicito_traslado');
                    $registro->quien_autorizo_traslado = $request->get('autorizo_traslado');
                    $registro->motivo = $request->get('motivo');
                    $registro->fecha = $request->get('fecha');
                    $registro->usuario_id = Auth::user()->id;
                    $registro->save();
                }

                return response()->json(['data' => 'Transferencia registrada con éxito']);
            });
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
