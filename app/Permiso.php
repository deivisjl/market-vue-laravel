<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permiso';

    protected $fillable = [
        'id','menu_titulo_id','titulo','ruta_cliente','visibilidad','orden'
    ];
}
