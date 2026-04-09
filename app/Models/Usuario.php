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

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    public function computadoras()
    {
        return $this->belongsToMany(
            Computadora::class,
            'computadora_usuario',
            'usuario_id',
            'computadora_id'
        );
    }
}