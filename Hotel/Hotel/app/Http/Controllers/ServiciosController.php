<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;
use App\Models\CategoriaServicios;

class ServiciosController extends Controller
{
    public function index()
    {
            /*
        CONSULTA SQL EQUIVALENTE:

        SELECT 
            servicios.id,
            servicios.nombre,
            servicios.precio,
            categoria_servicios.nombre AS categoria
        FROM servicios
        INNER JOIN categoria_servicios
            ON categoria_servicios.id = servicios.idcategoria_servicios;
        */

        $lista = Servicios::join(
                        'categoria_servicios',
                        'categoria_servicios.id',
                        '=',
                        'servicios.idcategoria_servicios'
                    )
                    ->select(
                        'servicios.id',
                        'servicios.nombre',
                        'servicios.precio',
                        'categoria_servicios.nombre as categoria'
                    )
                    ->get();

        return view('servicios.index', compact('lista'));
    }

    public function formulario($id = 0)
    {
        if ($id != 0) {
            $servicio = Servicios::find($id);
            $operacion = 'Editar';
        } else {
            $servicio = new Servicios();
            $operacion = 'Agregar';
        }

        $categorias = CategoriaServicios::all();

        return view('servicios.formulario', compact('servicio','categorias','operacion'));
    }

    public function save(Request $r)
    {
        // Validación
        $r->validate([
            'nombre' => 'required|string|max:255',
            'idcategoria_servicios' => 'required|exists:categoria_servicios,id',
            'precio' => 'required|numeric|min:0',
            'operacion' => 'required|string',
        ]);

        switch ($r->input('operacion')) {
            case 'Agregar':
                $s = new Servicios();
                $s->nombre = $r->input('nombre');
                $s->idcategoria_servicios = $r->input('idcategoria_servicios');
                $s->precio = $r->input('precio');
                $s->save();
            break;

            case 'Editar':
                $s = Servicios::find($r->input('id'));
                $s->nombre = $r->input('nombre');
                $s->idcategoria_servicios = $r->input('idcategoria_servicios');
                $s->precio = $r->input('precio');
                $s->save();
            break;

            case 'Eliminar':
                $s = Servicios::find($r->input('id'));
                if($s) $s->delete();
            break;
        }

        return redirect()->route('index_servicios');
    }
}
