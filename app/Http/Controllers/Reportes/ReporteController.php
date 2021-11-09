<?php

namespace App\Http\Controllers\Reportes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grafico()
    {
        return view('reportes.grafico');
    }
    public function pdf()
    {
        return view('reportes.pdf');
    }

    public function graficoProductoMasVendido(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $this->validate($request, $rules);

        try
        {
            $desde = Carbon::parse($request->get('desde'));
            $hasta = Carbon::parse($request->get('hasta'));

            if($desde >= $hasta)
            {
                throw new \Exception("Debe seleccionar un rango válido", 1);
            }

            $diferencia = $hasta->diffInDays($desde);

            if($diferencia > 365)
            {
                throw new \Exception("El rango no debe ser mayor a un año", 1);
            }

            $tienda = session('tienda');

            $registros = DB::table('venta as v')
                        ->join('detalle_venta as dv','v.id','dv.venta_id')
                        ->join('producto as p','dv.producto_id','p.id')
                        ->select('p.id','p.nombre',DB::raw('SUM(dv.cantidad) as cantidad'))
                        ->where('v.tienda_id',$tienda->id)
                        ->whereBetween('v.created_at', [$desde, $hasta])
                        ->orderBy(DB::raw('SUM(dv.cantidad)'),'desc')
                        ->groupBy('p.id','p.nombre')
                        ->take(10)
                        ->get();

            $series = array();
            $etiquetas = array();

            foreach ($registros as $key => $item)
            {
                $series[$key] = (int)$item->cantidad;
                $etiquetas[$key] = $item->nombre;
            }

            $respuesta = array('series' => $series, 'etiquetas' => $etiquetas);

            return response()->json(['data' => $respuesta]);
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function graficoProductoPorAgotarse(Request $request)
    {
        try
        {
            $tienda = session('tienda');

            $registros = DB::table('producto as p')
                        ->join('vista_inventario as vi','vi.producto_id','p.id')
                        ->select('p.id','p.nombre','vi.stock as cantidad')
                        ->where('vi.stock','<=','p.stock_minimo')
                        ->where('vi.tienda_id', $tienda->id)
                        ->get();

            $series = array();
            $etiquetas = array();

            foreach ($registros as $key => $item)
            {
                $series[$key] = (int)$item->cantidad;
                $etiquetas[$key] = $item->nombre;
            }

            $respuesta = array('series' => $series, 'etiquetas' => $etiquetas);

            return response()->json(['data' => $respuesta]);
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}
