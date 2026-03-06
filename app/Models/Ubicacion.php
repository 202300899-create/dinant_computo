<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';

    protected $fillable = [
        'pais',
        'departamento',
        'municipio',
        'ciudad',
        'area_empresa'
    ];
    
  //  RELACIONES

    public function computadoras()
    {
        return $this->hasMany(Computadora::class, 'id_ubicacion');
    }
}