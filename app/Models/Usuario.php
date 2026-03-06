<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'rol',
        'estado',
        'id_ubicacion'
    ];

    /* ================= RELACIONES ================= */

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class,'id_ubicacion');
    }

    public function computadoras()
    {
        return $this->hasMany(Computadora::class,'id_usuario_asignado');
    }

}