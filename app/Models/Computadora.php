<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computadora extends Model
{
    protected $table = 'computadoras';

    protected $fillable = [
        'nombre_equipo',
        'tipo',
        'marca',
        'modelo',
        'numero_serie',
        'procesador',
        'ram',
        'almacenamiento',
        'sistema_operativo',
        'fecha_compra',
        'fecha_fin_garantia',
        'vida_util',
        'estado',
        'imagen',
        'id_ubicacion'
    ];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'computadora_usuario',
            'computadora_id',
            'usuario_id'
        );
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'id_computadora');
    }

    public function historial()
    {
        return $this->hasMany(HistorialComputadora::class, 'id_computadora');
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_computadora');
    }
}