<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $table = 'transferencia';

    protected $fillable = [
        'id','boleta_referencia','tienda_origen_id','tienda_destino_id','producto_id','cantidad','precio','quien_solicito_traslado','quien_autorizo_traslado','motivo','fecha','usuario_id'
    ];
}
