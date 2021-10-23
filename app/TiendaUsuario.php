<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiendaUsuario extends Model
{
    protected $table = 'tienda_usuario';

    protected $fillable = [
        'id','tienda_id','usuario_id','status'
    ];
}
