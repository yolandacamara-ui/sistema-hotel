<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Rol;


class UsuarioController extends Controller
{
    //tiene la funcion de listar todos los registros de la tabla
    function index()
    {
        $datos = array();
        //lee todos los registros ::all()
        //$lista = Jugador::all();
        $lista = Usuario::join('rol', 'usuario.idrol', '=', 'rol.id')
            ->select(
                'usuario.id',
                'usuario.email',
                'usuario.password', 
                'rol.nombre as rol'
            )

            ->get();

        $datos['lista'] = $lista;
        return view('Usuario.index')->with($datos); //si el index estuviese en una carpeta distinta, seria Jugdor.index (NombredelaCarpeta.index)
    }

    function formulario($id = 0)
    {
        $datos = array();
        $datos['roles'] = Rol::all();
        if ($id != 0) {
            //$jugador=Jugador::find($id);
            //Jugador::find($id);
            $datos['usuario'] = Usuario::find($id);
            $datos['operacion'] = 'Editar';
        } else {
            $datos['usuario'] = new Usuario();
            $datos['operacion'] = 'Agregar';
        }

        //dd($jugador);
        return view('Usuario.formulario')->with($datos);
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
                $U = new Usuario(); //Jugador.php (modelo)
                $U->email = $context['email']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                if($context['password']!='')
                     $U->password = bcrypt($context['password']);//con bcrypt se encriptara la contraseña
                $U->idrol = $context['idrol'];
                $U->save(); //guarda los cambios
                break;

            case 'Editar':
                $U = Usuario::find($context['id']); //busca el registro por la llave primaria
                $U->email = $context['email']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                 if($context['password']!='')
                $U->password = bcrypt($context['password']); //con bcrypt se encripta la contraseña
                $U->idrol = $context['idrol'];
                $U->save(); //guarda los cambios
                break;

            case 'Eliminar':
                $U = Usuario::find($context['id']);
                $U->delete();
                break;
        }

        return redirect()->route('index_usuario'); //le esta diciendo cada operacion que haga (editar, agregar o eliminar) lo va a regresar a la ruta
    }
}
