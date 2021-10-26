<?php

namespace App\Http\Controllers\Catalogos;

use App\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('catalogos.proveedor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalogos.proveedor.create');
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
            "nombre" => 'required',
            "correo" => 'required|email|unique:proveedor',
            "nit" => 'required|unique:proveedor',
            "telefono" => 'required|unique:proveedor',
            "direccion" => 'required',
        ];

        $this->validate($request, $rules);

        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->correo = $request->correo;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->nit = $request->nit;
        $proveedor->save();

        return redirect('/proveedores')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre","correo","nit","telefono");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $proveedores = DB::table('proveedor')
                ->select('id','nombre','correo','nit','telefono')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('proveedor')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $proveedores,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedore)
    {
        return view('catalogos.proveedor.edit',['proveedor' => $proveedore]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedore)
    {
        $rules = [
            "nombre" => 'required',
            "correo" => 'required|email|unique:proveedor,correo,'.$proveedore->id,
            "nit" => 'required|unique:proveedor,nit,'.$proveedore->id,
            "telefono" => 'required|unique:proveedor,telefono,'.$proveedore->id,
            "direccion" => 'required',
        ];

        $this->validate($request, $rules);

        $proveedore->nombre = $request->nombre;
        $proveedore->correo = $request->correo;
        $proveedore->telefono = $request->telefono;
        $proveedore->direccion = $request->direccion;
        $proveedore->nit = $request->nit;
        $proveedore->save();

        return redirect('/proveedores')->with(['mensaje' => 'Registro editado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedore)
    {
        try {
            $proveedore->delete();

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
}
