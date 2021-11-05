<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';

    protected $fillable = [
        'id','tienda_id','fecha_inicio','hora_inicio','fecha_cierre','hora_cierre','saldo_inicial','ingresos','activo','usuario_id'
    ];
}
