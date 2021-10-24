<?php

use App\Rol;
use App\User;
use App\UsuarioRol;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = Rol::first();

        $usuario = User::create([
            'nombres' => 'Jairo',
            'apellidos' => 'Melgar',
            'telefono' => 59283247,
            'direccion' => 'Ciudad',
            'email' => 'jairo@gmail.com',
            'password' => bcrypt('12345'),
            'rol_id' => $rol->id
        ]);
    }
}
