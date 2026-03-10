<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaServicios;

class CategoriaServiciosController extends Controller
{
    public function index()
    {
        $lista = CategoriaServicios::select('id','nombre')->get();
        return view('categoria_servicios.index', compact('lista'));
    }

    public function formulario($id = 0)
    {
        if ($id != 0) {
            $categoria = CategoriaServicios::find($id);
            $operacion = 'Editar';
        } else {
            $categoria = new CategoriaServicios();
            $operacion = 'Agregar';
        }

        return view('categoria_servicios.formulario', compact('categoria','operacion'));
    }

    public function save(Request $r)
    {
        $context = $r->all();

        switch ($context['operacion']) {

            case 'Agregar':
                $c = new CategoriaServicios();
                $c->nombre = $context['nombre'];
                $c->save();
            break;

            case 'Editar':
                $c = CategoriaServicios::find($context['id']);
                $c->nombre = $context['nombre'];
                $c->save();
            break;

            case 'Eliminar':
                $c = CategoriaServicios::find($context['id']);
                $c->delete();
            break;
        }

        return redirect()->route('index_categoria_servicios');
    }
}
