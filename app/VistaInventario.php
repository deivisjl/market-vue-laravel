<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VistaInventario extends Model
{
    protected $table = 'vista_inventario';

    protected $fillable = [
        'id','tienda_id','producto_id','stock','precio'
    ];
}
