<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiendaUsuario extends Model
{
    protected $table = 'tienda_usuario';

    protected $fillable = [
        'id','tienda_id','usuario_id','status'
    ];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }
}
