<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Habitacion;
use App\Models\CategoriaHabitacion; 

class HabitacionController extends Controller
{
    public function index()
    {
        /*
        CONSULTA SQL EQUIVALENTE:

        SELECT 
            habitacion.id,
            habitacion.nombre,
            habitacion.precio,
            habitacion.foto,
            categoria_habitacion.nombre AS categoria
        FROM habitacion
        INNER JOIN categoria_habitacion
            ON categoria_habitacion.id = habitacion.tipo;
        */

        $lista = Habitacion::join(
                        'categoria_habitacion',
                        'categoria_habitacion.id',
                        '=',
                        'habitacion.tipo'
                    )
                    ->select(
                        'habitacion.id',
                        'habitacion.nombre',
                        'habitacion.precio',
                        'habitacion.foto',
                        'categoria_habitacion.nombre as categoria'
                    )
                    ->get();

        return view('habitacion.index', compact('lista'));
    }

    public function formulario($id = 0)
    {
        if ($id != 0) {
            $habitacion = Habitacion::find($id);
            $operacion = 'Editar';
        } else {
            $habitacion = new Habitacion();
            $operacion = 'Agregar';
        }

        //  TRAER CATEGORÍAS DESDE LA BD
        $categorias = CategoriaHabitacion::all();

        return view('habitacion.formulario', compact('habitacion','operacion','categorias'));
    }

    public function save(Request $r)
    {
        $context = $r->all();
        $archivo = $r->file('foto');

        switch ($context['operacion']) {

            case 'Agregar':
                $h = new Habitacion();
                $h->nombre = $context['nombre'];
                $h->precio = $context['precio'];

                
                $h->tipo = $context['tipo'];

                $h->foto = '';
                $h->save();

                if ($archivo) {
                    $nombre = "habitacion-" . $h->id . "." . $archivo->getClientOriginalExtension();
                    $archivo->storeAs('habitaciones', $nombre);
                    $h->foto = $nombre;
                    $h->save();
                }
            break;

            case 'Editar':
                $h = Habitacion::find($context['id']);
                $h->nombre = $context['nombre'];
                $h->precio = $context['precio'];

                
                $h->tipo = $context['tipo'];

                if ($archivo) {
                    if ($h->foto != '') {
                        Storage::delete('habitaciones/'.$h->foto);
                    }
                    $nombre = "habitacion-" . $h->id . "." . $archivo->getClientOriginalExtension();
                    $archivo->storeAs('habitaciones', $nombre);
                    $h->foto = $nombre;
                }

                $h->save();
            break;

            case 'Eliminar':
                $h = Habitacion::find($context['id']);
                if ($h && $h->foto != '') {
                    Storage::delete('habitaciones/'.$h->foto);
                }
                $h->delete();
            break;
        }

        return redirect()->route('index_habitacion');
    }

    public function mostrar_foto($archivo)
    {
        $path = storage_path('app/private/habitaciones/' . $archivo);
        if (!file_exists($path)) abort(404);
        return response()->file($path);
    }
}
