<?php

namespace App\Http\Controllers\Reportes;

use App\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\VistaInventario;

class ReporteController extends Controller
{
    private $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
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
                        ->join('vista_inventario as vi', 'p.id','vi.producto_id')
                        ->select('p.id','p.nombre','vi.stock as cantidad','p.stock_minimo')
                        ->whereRaw('vi.stock <= p.stock_minimo')
                        ->where('vi.tienda_id','=' ,$tienda->id)
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

    public function pdfGananciasDiarias(Request $request)
    {
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
                            ->join('tienda as t','v.tienda_id','t.id')
                            ->select('t.nombre',DB::raw('date_format(v.created_at,"%d-%m-%Y") as fecha'),DB::raw('SUM(v.ganancia) as ganancia'))
                            ->where('v.tienda_id',$tienda->id)
                            ->whereBetween('v.created_at',[$desde,$hasta])
                            ->groupBy('t.nombre',DB::raw('date_format(v.created_at,"%d-%m-%Y")'))
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-ganancias-diarias',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function pdfGananciasMensuales(Request $request)
    {
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
                            ->join('tienda as t','v.tienda_id','t.id')
                            ->select('t.nombre',DB::raw('date_format(v.created_at,"%m-%Y") as mes'),DB::raw('SUM(v.ganancia) as ganancia'))
                            ->where('v.tienda_id',$tienda->id)
                            ->whereBetween('v.created_at',[$desde,$hasta])
                            ->groupBy('t.nombre',DB::raw('date_format(v.created_at,"%m-%Y")'))
                            ->orderBy(DB::raw('date_format(created_at,"%m-%Y")'),'desc')
                            ->get();

            $ganancias = $this->parsearMeses($registros);

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-ganancias-mensuales',['registros' => $ganancias, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function pdfVentasGenerales(Request $request)
    {
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
                            ->join('tienda as t','v.tienda_id','t.id')
                            ->select('t.nombre',DB::raw('date_format(v.created_at,"%d-%m-%Y") as fecha'),DB::raw('SUM(v.monto) as monto'))
                            ->where('v.tienda_id',$tienda->id)
                            ->whereBetween('v.created_at',[$desde,$hasta])
                            ->groupBy('t.nombre',DB::raw('date_format(v.created_at,"%d-%m-%Y")'))
                            ->orderBy(DB::raw('date_format(created_at,"%d-%m-%Y")'),'desc')
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-ventas-generales',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function pdfProductosVendidos(Request $request)
    {
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
                            ->join('tienda as t','v.tienda_id','t.id')
                            ->select('t.nombre as tienda','p.nombre as producto',DB::raw('SUM(dv.cantidad) as cantidad'))
                            ->whereBetween('v.created_at',[$desde,$hasta])
                            ->where('v.tienda_id',$tienda->id)
                            ->groupBy('t.nombre','p.nombre')
                            ->orderBy(DB::raw('SUM(dv.cantidad)'),'desc')
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-productos-vendidos',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function pdfStockPorCategorias()
    {
        try
        {
            $tienda = session('tienda');

            $registros = DB::table('vista_inventario as vi')
                            ->join('producto as p','vi.producto_id','p.id')
                            ->join('categoria as c','p.categoria_id','c.id')
                            ->join('tienda as t','vi.tienda_id','t.id')
                            ->select('t.nombre as tienda','c.nombre as categoria',DB::raw('SUM(vi.stock) as stock'))
                            ->where('vi.tienda_id',$tienda->id)
                            ->groupBy('t.nombre','c.nombre')
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-stock-categoria',['registros' => $registros])->setPaper('letter','portrait');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
    public function pdfStockProductos()
    {
        try
        {
            $tienda = session('tienda');

            $registros = DB::table('vista_inventario as vi')
                            ->join('producto as p','vi.producto_id','p.id')
                            ->join('tienda as t','vi.tienda_id','t.id')
                            ->select('p.id','t.nombre as tienda','p.nombre as producto',DB::raw('SUM(vi.stock) as stock'))
                            ->where('vi.tienda_id',$tienda->id)
                            ->groupBy('p.id','t.nombre','p.nombre')
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-stock-producto',['registros' => $registros])->setPaper('letter','portrait');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function pdfTransferenciaStock(Request $request)
    {
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

            $envios = DB::table('transferencia as t')
                        ->join('producto as p','t.producto_id','p.id')
                        ->join('tienda as td','t.tienda_origen_id','td.id')
                        ->join('tienda as td2','t.tienda_destino_id','td2.id')
                        ->select('td.nombre as envia','td2.nombre as recibe','p.nombre as producto','t.cantidad','t.precio','t.boleta_referencia as boleta',DB::raw('date_format(t.created_at,"%d-%m-%Y") as fecha'))
                        ->where('td.id',$tienda->id)
                        ->whereBetween('t.created_at',[$desde,$hasta])
                        ->get();

            $ingresos = DB::table('transferencia as t')
                        ->join('producto as p','t.producto_id','p.id')
                        ->join('tienda as td','t.tienda_origen_id','td.id')
                        ->join('tienda as td2','t.tienda_destino_id','td2.id')
                        ->select('td.nombre as envia','td2.nombre as recibe','p.nombre as producto','t.cantidad','t.precio','t.boleta_referencia as boleta',DB::raw('date_format(t.created_at,"%d-%m-%Y") as fecha'))
                        ->where('td2.id',$tienda->id)
                        ->whereBetween('t.created_at',[$desde,$hasta])
                        ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-transferencia-productos',['envios' => $envios,'ingresos' => $ingresos, 'desde' => $desde, 'hasta' => $hasta])->setPaper('legal','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function pdfBitacoraUsuarios(Request $request)
    {
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

            $registros = DB::table('bitacora as b')
                        ->join('users as u','b.usuario_id','u.id')
                        ->select('u.id',DB::raw('CONCAT_WS(" ",u.nombres," ",u.apellidos) as usuario'),DB::raw('date_format(b.fecha,"%d-%m-%Y") as fecha'),'b.hora')
                        ->whereBetween('b.created_at',[$desde,$hasta])
                        ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5/ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-bitacora-usuarios',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function parsearMeses($data)
    {
        $respuesta = array();

        foreach ($data as $key => $item)
        {
            $fecha = $item->mes;

            $numero = explode("-",$fecha);

            if($numero[0] < 10)
            {
                $numero2 = explode("0",$numero[0]);
            }
            else
            {
                $numero2[1] = $numero[0];
            }

            $respuesta[$key] = array('mes' => $this->meses[$numero2[1]].' '.$numero[1], 'ganancia' => (float)$item->ganancia, 'tienda' => $item->nombre);
        }

        return $respuesta;
    }
}
