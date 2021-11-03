<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra';

    protected $fillable = [
        'id','tienda_id','proveedor_id','forma_pago_id','no_comprobante','fecha_comprobante','monto','anulada','usuario_id'
    ];
}
