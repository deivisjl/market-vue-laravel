<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';

    protected $fillable = [
        'id','tienda_id','cliente_id','forma_pago_id','usuario_id','no_factura','correlativo','fecha_factura','monto','ganancia'
    ];

    public function detalle_venta()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class);
    }
}
