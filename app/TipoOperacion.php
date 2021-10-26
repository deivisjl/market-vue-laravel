<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model
{
    protected $table = 'tipo_operacion';

    protected $fillable = [
        'id','nombre'
    ];
}
