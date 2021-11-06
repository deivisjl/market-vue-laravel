<?php

namespace App\Http\Controllers\Venta;

use App\Caja;
use App\Venta;
use App\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('venta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('venta.create');
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
                "lista" => 'required',
                "cliente" => "required|numeric",
                "forma_pago" => "required|numeric",
                "total" => 'required|numeric'
            ];

            $this->validate($request, $rules);

            return DB::transaction(function() use($request){

                $tienda = $request->session()->get('tienda');

                $factura = $this->obtenerNoFactura();

                $venta = new Venta();
                $venta->tienda_id = $tienda->id;
                $venta->cliente_id = $request->get('cliente');
                $venta->forma_pago_id = $request->get('forma_pago');
                $venta->usuario_id = Auth::user()->id;
                $venta->no_factura = $factura['factura'];
                $venta->correlativo = $factura['correlativo'];
                $venta->fecha_factura = \Carbon\Carbon::now()->format('Y-m-d');
                $venta->monto = $request->get('total');
                $venta->save();

                $compra = 0;

                $caja = Caja::where('tienda_id',$tienda->id)
                                ->where('activo',1)
                                ->first();

                $caja->ingresos = $caja->ingresos + $venta->monto;
                $caja->save();

                foreach ($request->get('lista') as $key => $item) {
                    $detalle = new DetalleVenta();
                    $detalle->producto_id = $item['producto']['id'];
                    $detalle->venta_id = $venta->id;
                    $detalle->cantidad = $item['cantidad'];
                    $detalle->precio_unitario = $item['precio'];
                    $detalle->tienda_id = $tienda->id;
                    $detalle->save();

                    $compra = $compra + $item['compra'];
                }

                $venta->ganancia = ($venta->monto - $compra);
                $venta->save();

                return response()->json(['data' => 'Venta registrada con éxito','venta' => $venta->id]);
            });
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $registro = session('tienda');

        $ordenadores = array("v.id","c.nombres","v.no_factura","v.monto");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $ventas = DB::table('venta as v')
                ->join('cliente as c','v.cliente_id','c.id')
                ->select('v.id',DB::raw('CONCAT_WS(" ",nombres," ",apellidos) as cliente'),'v.no_factura','v.monto',DB::raw('date_format(v.created_at,"%d-%m-%Y") as fecha'))
                ->where('v.tienda_id',$registro->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('venta as v')
                ->join('cliente as c','v.cliente_id','c.id')
                ->where('v.tienda_id',$registro->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $ventas,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }

    public function obtenerNoFactura()
    {
        $respuesta = array();

        $factura = DB::table('venta')
                            ->select(DB::raw('MAX(correlativo) as ultima'))
                            ->first();

        if($factura && $factura->ultima > 0)
        {
            $respuesta['correlativo'] = $factura->ultima + 1;
            $respuesta['factura'] = str_pad($respuesta['correlativo'], 7, '0', STR_PAD_LEFT);
        }
        else
        {
            $respuesta['correlativo'] = 1;
            $respuesta['factura'] = str_pad($respuesta['correlativo'], 7, '0', STR_PAD_LEFT);
        }

        return $respuesta;
    }

    public function detalle($id)
    {
        $tienda = session('tienda');

        $venta = Venta::with('detalle_venta')
                    ->where('id',$id)
                    ->where('tienda_id',$tienda->id)
                    ->first();

        if($venta != null)
        {
            return view('venta.detalle',['venta' => $venta]);
        }
        else
        {
            abort(404);
        }
    }
}
