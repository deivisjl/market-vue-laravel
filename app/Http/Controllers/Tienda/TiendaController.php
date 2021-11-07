<?php

namespace App\Http\Controllers\Tienda;

use App\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Session\Session;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tienda.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tienda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'gerente' => 'required',
            'telefono' => 'required|numeric|unique:tienda',
            'direccion' => 'required',
        ];

        $this->validate($request, $rules);

        $tienda = new Tienda();
        $tienda->nombre = $request->nombre;
        $tienda->direccion = $request->direccion;
        $tienda->gerente = $request->gerente;
        $tienda->telefono = $request->telefono;
        $tienda->save();

        return redirect('/tiendas')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre","gerente","telefono");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $tiendas = DB::table('tienda')
                ->select('id','nombre','gerente','telefono','status')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('tienda')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $tiendas,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function edit(Tienda $tienda)
    {
        return view('tienda.edit',['tienda' => $tienda]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tienda $tienda)
    {
        $rules = [
            'nombre' => 'required',
            'gerente' => 'required',
            'telefono' => 'required|numeric|unique:tienda,telefono,'.$tienda->id,
            'direccion' => 'required',
        ];

        $this->validate($request, $rules);

        $tienda->nombre = $request->nombre;
        $tienda->direccion = $request->direccion;
        $tienda->gerente = $request->gerente;
        $tienda->telefono = $request->telefono;
        $tienda->save();

        return redirect('/tiendas')->with(['mensaje' => 'Registro editado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tienda $tienda)
    {
        try {
            $registro = session('tienda');

            if($tienda->id == $registro->id)
            {
                throw new \Exception("No se puede eliminar la tienda en sesión", 1);
            }

            $tienda->delete();

            return response()->json(['data' => 'Registro eliminado con éxito'],200);

        } catch (\Exception $e) {

            if ($e instanceof QueryException) {
                $codigo = $e->errorInfo[1];

                if ($codigo == 1451) {
                    return response()->json(['error' => 'No se puede eliminar porque tiene registros asociados'],423);
                }
            }

            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    public function deshabilitar($id)
    {
        try {
            $tienda = Tienda::findOrFail($id);

            $registro = session('tienda');

            if($tienda->status ==  0)
            {
                $tienda->status = 1;
                $tienda->save();
                return response()->json(['data' => 'Registro habilitado con éxito'],200);
            }
            else if($tienda->id === $registro->id)
            {
                throw new \Exception("No se puede deshabilitar la tienda en sesión", 1);
            }

            $tienda->status = 0;
            $tienda->save();
            return response()->json(['data' => 'Registro deshabilitado con éxito'],200);

        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    public function listarTiendas()
    {
        try
        {
            $tienda = session('tienda');

            $tiendas = Tienda::where('status',1)
                        ->whereNotIn('id',[$tienda->id])
                        ->get();

            return response()->json(['data' => $tiendas],200);
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function cambiarTienda(Request $request)
    {
        $request->session()->forget('tienda');

        return redirect()->route('home');
    }
}
