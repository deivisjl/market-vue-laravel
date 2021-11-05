<?php

namespace App\Http\Controllers\Catalogos;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('catalogos.cliente.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalogos.cliente.create');
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
            "nombres" => 'required',
            "apellidos" => 'required',
            "nit" => 'required|unique:cliente',
            "telefono" => 'required|unique:cliente',
            "direccion" => 'required',
        ];

        $this->validate($request, $rules);

        $cliente = new Cliente();
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->nit = $request->nit;
        $cliente->save();

        return redirect('/clientes')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombres","nit","telefono");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $clientes = DB::table('cliente')
                ->select('id',DB::raw('CONCAT_WS("",nombres," ",apellidos) as nombre'),'nit','telefono')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('cliente')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $clientes,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view('catalogos.cliente.edit',['cliente' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $rules = [
            "nombres" => 'required',
            "apellidos" => 'required',
            "nit" => 'required|unique:cliente,nit,'.$cliente->id,
            "telefono" => 'required|unique:cliente,telefono,'.$cliente->id,
            "direccion" => 'required',
        ];

        $this->validate($request, $rules);

        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->nit = $request->nit;
        $cliente->save();

        return redirect('/clientes')->with(['mensaje' => 'Registro editado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();

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

    public function obtenerClientes(){

        $clientes = Cliente::select('id',DB::raw("CONCAT_WS(' ',nombres,' ',apellidos,'-',nit) as nombre"))->get();

        return response()->json(['data' => $clientes],200);
    }
    public function guardarNuevoCliente(Request $request)
    {
        try {
            $rules = [
                'nombre' => 'required',
                'apellido' => 'required',
                'telefono' => 'nullable|numeric',
                'nit' => 'nullable|string|unique:cliente',
                'direccion' => 'required',
            ];

            $this->validate($request, $rules);

            $cliente = new Cliente();
            $cliente->nombres = $request->nombre;
            $cliente->apellidos = $request->apellido;
            $cliente->nit = $request->nit;
            $cliente->telefono = $request->telefono;
            $cliente->direccion = $request->direccion;
            $cliente->save();

            return response()->json(['data' => 'Registro exitoso'],200);

        } catch (\Exception $ex) {

            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}
