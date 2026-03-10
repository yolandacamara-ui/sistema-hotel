<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaHabitacion;

class CategoriaHabitacionController extends Controller
{
    public function index()
    {
        $lista = CategoriaHabitacion::all();
        return view('categoria_habitacion.index', compact('lista'));
    }

    public function formulario($id = 0)
    {
        $categoria = $id ? CategoriaHabitacion::find($id) : new CategoriaHabitacion();
        $operacion = $id ? 'Editar' : 'Agregar';

        return view('categoria_habitacion.formulario', compact('categoria','operacion'));
    }

    public function save(Request $r)
    {
        $c = $r->id ? CategoriaHabitacion::find($r->id) : new CategoriaHabitacion();
        $c->nombre = $r->nombre;
        $c->save();

        if($r->operacion == 'Eliminar') $c->delete();

        return redirect()->route('index_categoria_habitacion');
    }
}
