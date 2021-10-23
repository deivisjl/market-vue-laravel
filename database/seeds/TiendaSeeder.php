<?php

use App\Tienda;
use App\User;
use App\TiendaUsuario;
use Illuminate\Database\Seeder;

class TiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tienda = Tienda::create([
            'nombre'=> 'Central',
            'direccion' => 'Ciudad',
            'gerente' => 'Jairo Melgar',
            'telefono' => 59283247
        ]);

        $usuario = User::first();

        TiendaUsuario::create([
            'tienda_id' => $tienda->id,
            'usuario_id' => $usuario->id
        ]);
    }
}
