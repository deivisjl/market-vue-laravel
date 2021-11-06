<?php

namespace App\Http\Controllers\Compra;

use App\Compra;
use App\DetalleCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compra.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compra.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'lista' => 'required',
                "fecha" => "required|date",
                "no_comprobante" => "required",
                "proveedor" => "required|numeric",
                "forma_pago" => "required|numeric",
                "total" => 'required|numeric'
            ];

            $this->validate($request, $rules);

            return DB::transaction(function() use($request){
                $tienda = $request->session()->get('tienda');

                $compra = new Compra();
                $compra->tienda_id = $tienda->id;
                $compra->proveedor_id = $request->get('proveedor');
                $compra->forma_pago_id = $request->get('forma_pago');
                $compra->no_comprobante = $request->get('no_comprobante');
                $compra->fecha_comprobante = $request->get('fecha');
                $compra->monto = $request->get('total');
                $compra->usuario_id = Auth::user()->id;
                $compra->save();

                foreach($request->get('lista') as $key => $item){
                    $detalle = new DetalleCompra();
                    $detalle->tienda_id = $tienda->id;
                    $detalle->producto_id = $item['producto']['id'];
                    $detalle->compra_id = $compra->id;
                    $detalle->cantidad = $item['cantidad'];
                    $detalle->precio_unitario = $item['precio'];
                    $detalle->save();
                }

                return response()->json(['data' => 'Compra registrada con éxito']);

            });

        } catch (\Exception $ex) {

            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $registro = session('tienda');

        $ordenadores = array("c.id","p.nombre","c.no_comprobante","c.forma_pago_id","c.monto");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $compras = DB::table('compra as c')
                ->join('proveedor as p','c.proveedor_id','p.id')
                ->join('forma_pago as fp','c.forma_pago_id','fp.id')
                ->select('c.id','p.nombre as proveedor','c.no_comprobante','fp.nombre as forma_pago','c.monto',DB::raw('date_format(c.created_at,"%d/%m/%Y") as fecha'))
                ->where('c.tienda_id',$registro->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('compra as c')
                ->join('proveedor as p','c.proveedor_id','p.id')
                ->join('forma_pago as fp','c.forma_pago_id','fp.id')
                ->where('c.tienda_id',$registro->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $compras,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }

    public function detalle($id)
    {
        $tienda = session('tienda');

        $compra = Compra::with('detalle_compra')
                        ->where('tienda_id',$tienda->id)
                        ->where('id',$id)->first();

        if($compra != null)
        {
            return view('compra.detalle',['compra' => $compra]);
        }
        else
        {
            abort(404);
        }
    }
}
