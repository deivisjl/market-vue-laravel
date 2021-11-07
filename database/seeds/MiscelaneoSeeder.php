<?php

use App\Categoria;
use App\FormaPago;
use App\UnidadMedida;
use App\TipoOperacion;
use Illuminate\Database\Seeder;

class MiscelaneoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Gaseosas'
        ]);

        TipoOperacion::create([
            'nombre' => 'Compra'
        ]);

        TipoOperacion::create([
            'nombre' => 'Venta'
        ]);

        TipoOperacion::create([
            'nombre' => 'Ingreso traslado'
        ]);

        TipoOperacion::create([
            'nombre' => 'Salida traslado'
        ]);

        FormaPago::create([
            'nombre' => 'Efectivo'
        ]);

        FormaPago::create([
            'nombre' => 'Tarjeta de débito'
        ]);

        FormaPago::create([
            'nombre' => 'Tarjeta de crédito'
        ]);

        UnidadMedida::create([
            'nombre'=>'Unidades',
            'cantidad' => 1
        ]);

        UnidadMedida::create([
            'nombre' => 'Docena',
            'cantidad' => 12
        ]);

        UnidadMedida::create([
            'nombre' => 'Libra',
            'cantidad' => 1
        ]);

        UnidadMedida::create([
            'nombre' => 'Arroba',
            'cantidad' => 25
        ]);

        UnidadMedida::create([
            'nombre' => 'Quintal',
            'cantidad' => 100
        ]);
    }
}
