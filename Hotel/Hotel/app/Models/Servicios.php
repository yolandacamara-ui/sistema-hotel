<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(CategoriaServicios::class, 'idcategoria_servicios');
    }
}
