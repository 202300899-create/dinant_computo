<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'id_computadora',
        'id_usuario',
        'fecha_asignacion',
        'fecha_devolucion',
        'estado'
    ];
    
    //  RELACIONES

    public function computadora()
    {
        return $this->belongsTo(Computadora::class, 'id_computadora');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}