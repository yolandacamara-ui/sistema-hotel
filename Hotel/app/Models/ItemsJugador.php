<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsJugador extends Model
{
    protected $table = 'itemsxjugador';
    //le dice a que tabla de la base de datos debe de conectarse ese modelo 

    //protected $primaryKey = 'id';
    //le dice a laravel cual es la columna que funciona como llave primaria

    // Desactiva la creación automática de los campos created_at y updated_at
    public $timestamps = false;
}
