<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    protected $fillable = [
        'id_computadora',
        'tipo',
        'descripcion',
        'fecha_programada',
        'fecha_realizada',
        'id_tecnico',
        'estado',
        'observaciones'
    ];
 // RELACIÓN

    public function computadora()
    {
        return $this->belongsTo(Computadora::class, 'id_computadora');
    }
}