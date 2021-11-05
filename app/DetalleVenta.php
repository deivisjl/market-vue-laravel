<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';

    protected $fillable = [
        'id','venta_id','producto_id','cantiad','precio_unitario','tienda_id'
    ];
}
