<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const USUARIO_ADMINISTRADOR = 'ADMINISTRADOR';

    const USUARIO_GERENTE = 'GERENTE';

    const USUARIO_VENDEDOR = 'VENDEDOR';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombres','apellidos','direccion','telefono','email', 'password','deleted_at','rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function tienda_usuario()
    {
        return $this->hasMany(TiendaUsuario::class,'usuario_id');
    }

    public function esAdministrador()
    {
        return strtoupper($this->rol->nombre) == User::USUARIO_ADMINISTRADOR;
    }

    public function esGerente()
    {
        return strtoupper($this->rol->nombre) == User::USUARIO_GERENTE;
    }

    public function esVendedor()
    {
        return strtoupper($this->rol->nombre) == User::USUARIO_VENDEDOR;
    }
}
