<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialComputadora extends Model
{
    protected $table = 'historial_computadora';

    protected $fillable = [
        'id_computadora',
        'accion',
        'descripcion',
        'id_usuario',
        'fecha_accion'
    ];

    protected $casts = [
        'fecha_accion' => 'datetime'
    ];

    /* =========================
        RELACIONES
    ========================= */

    public function computadora()
    {
        return $this->belongsTo(Computadora::class, 'id_computadora');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}