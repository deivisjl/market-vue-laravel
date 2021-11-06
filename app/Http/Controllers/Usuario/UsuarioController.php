<?php

namespace App\Http\Controllers\Usuario;

use App\Rol;
use App\User;
use App\Tienda;
use Svg\Tag\Rect;
use App\TiendaUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();

        $tiendas = Tienda::where('status',1)->get();

        return view('usuarios.create',['roles' => $roles, 'tiendas' => $tiendas]);
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
            'nombres' => 'required',
            'email'=>'required|email|unique:users',
            "password" => 'required|string|min:5|confirmed',
            'apellidos' => 'required',
            'rol' => 'required|numeric|min:1',
            'telefono' => 'required|min:1|unique:users',
            'direccion' => 'required',
            'tienda' => 'array'
        ];

        $this->validate($request, $rules);

        $usuario = new User();
        $usuario->nombres = $request->get('nombres');
        $usuario->apellidos = $request->get('apellidos');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->rol_id = $request->get('rol');
        $usuario->telefono = $request->get('telefono');
        $usuario->direccion = $request->get('direccion');
        $usuario->save();

        if($request->tienda)
        {
            foreach ($request->tienda as $key => $item)
            {
                $registro = new TiendaUsuario();
                $registro->usuario_id = $usuario->id;
                $registro->tienda_id = $item;
                $registro->save();
            }
        }

        return redirect('/usuarios')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("u.id","u.nombres");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $usuarios = DB::table('users as u')
                ->join('rol as r','u.rol_id','r.id')
                ->select('u.id',DB::raw('CONCAT_WS(" ",u.nombres," ",u.apellidos) as nombre'),'u.email as correo','u.telefono','r.nombre as rol')
                ->whereNull('u.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('users as u')
                ->join('rol as r','u.rol_id','r.id')
                ->whereNull('u.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $usuarios,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $roles = Rol::all();

        $tiendas = Tienda::where('status',1)->get();

        $usuario->tienda_usuario;

        return view('usuarios.edit',['usuario' => $usuario,'roles' => $roles,'tiendas' => $tiendas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $rules = [
            'nombres' => 'required',
            'apellidos' => 'required',
            'rol' => 'required|numeric|min:1',
            'telefono' => 'required|min:1|unique:users,telefono,'.$usuario->id,
            'direccion' => 'required',
            'tienda' => 'nullable|array'
        ];

        $this->validate($request, $rules);

        $usuario->nombres = $request->get('nombres');
        $usuario->apellidos = $request->get('apellidos');
        $usuario->rol_id = $request->get('rol');
        $usuario->telefono = $request->get('telefono');
        $usuario->direccion = $request->get('direccion');
        $usuario->save();

        $acceso = TiendaUsuario::where('usuario_id',$usuario->id)
                ->delete();

        if($request->tienda)
        {
            foreach ($request->tienda as $key => $item)
            {
                $registro = new TiendaUsuario();
                $registro->usuario_id = $usuario->id;
                $registro->tienda_id = $item;
                $registro->save();
            }
        }

        return redirect('/usuarios')->with(['mensaje' => 'Actualización exitosa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        try
        {
            if($usuario->id == Auth::user()->id )
            {
                throw new \Exception("No se puede eliminar el usuario en sesión");
            }

            $usuario->delete();

            return response()->json(['data' => 'El registro se eliminó con éxito'],200);
        }
        catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    public function miPerfil()
    {
        return view('usuarios.perfil');
    }

    public function actualizarMiPerfil(Request $request)
    {
        $rules = [
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required|min:1|unique:users,telefono,'.Auth::user()->id,
            'direccion' => 'required'
        ];

        $this->validate($request, $rules);

        $usuario = User::findOrFail(Auth::user()->id);
        $usuario->nombres = $request->get('nombres');
        $usuario->apellidos = $request->get('apellidos');
        $usuario->telefono = $request->get('telefono');
        $usuario->direccion = $request->get('direccion');
        $usuario->save();

        return redirect('/home')->with(['mensaje' => 'Actualización exitosa']);
    }

    public function actualizarMiCredencial(Request $request)
    {
        $rules = [
            "password" => 'required|string|min:5|confirmed',
        ];

        $this->validate($request, $rules);

        $usuario = User::findOrFail(Auth::user()->id);
        $usuario->password = bcrypt($request->get('password'));
        $usuario->save();

        return redirect('home')->with(['mensaje' => 'Actualización exitosa']);
    }
}
