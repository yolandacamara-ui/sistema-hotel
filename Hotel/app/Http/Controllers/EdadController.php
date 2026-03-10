<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edad;

class EdadController extends Controller
{
    function index()
    {
        $datos = array();
        //lee todos los registros ::all()
        $lista = Edad::all();
        $datos['lista'] = $lista;
        return view('Edad.index')->with($datos); //si el index estuviese en una carpeta distinta, seria Jugdor.index (NombredelaCarpeta.index)
    }

    function formulario($id = 0)
    {
        $datos = array();
        if ($id != 0) {
            //$jugador=TipoJugador::find($id);
            //TipoJugador::find($id);
            $datos['edad'] = Edad::find($id);
            $datos['operacion'] = 'Editar';
        } else {
            $datos['edad'] = new Edad();
            $datos['operacion'] = 'Agregar';
        }

        //dd($jugador);
        return view('Edad.formulario')->with($datos);
        $datos['operacion'] = '';
    }

    //como este metodo recibe datos de la peticion entonces es necesario agregarle un parametro
    function save(Request $peticion)
    { //recibe como parametro un objeto llamado $peticion, contiene todos los datos enviados por el formulario

        //agregar un registro a la base de datos
        //1.-recibir los datos de una peticion
        $context = $peticion->all(); //aqui le dice que guarde todos los datos en $context
        switch ($context['operacion']) {
            case 'Agregar':
                //2.- Inserto el registro en la base de datos usando los datos de la peticion
                $t = new Edad(); //Edad.php (modelo)
                $t->nombre = $context['edad']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $t->save(); //guarda los cambios
                break;

            case 'Editar':
                $t = Edad::find($context['id']); //busca el registro por la llave primaria
                $t->nombre = $context['edad']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $t->save(); //guarda los cambios
                break;

            case 'Eliminar':
                $t = Edad::find($context['id']);
                $t->delete();
                break;
        }

        return redirect()->route('index_edad'); //le esta diciendo cada operacion que haga (editar, agregar o eliminar) lo va a regresar a la ruta
    }
}
