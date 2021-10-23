<?php

use App\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Usuario que posee permisos de inserción, actualización y consulta a
            algunos reportes y la totalidad de los catálogos principales'
        ]);

        Rol::create([
            'nombre' => 'Gerente',
            'descripcion' => 'Usuario que posee todos los permisos de inserción, actualización, eliminación y
            consulta a reportes'
        ]);

        Rol::create([
            'nombre' => 'Vendedor',
            'descripcion' => 'Este usuario únicamente puede efectuar el proceso de venta'
        ]);
    }
}
