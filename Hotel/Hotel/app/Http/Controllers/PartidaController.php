<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Personaje;
use App\Models\Jugador;
use App\Servicios\ServicioPartida;
use App\Servicios\ServicioTurno;
use Illuminate\Support\Facades\Auth;

class PartidaController extends Controller
{
    function index()
    {
        $datos = array(); //indica que la variable datos es un arreglo
        $partidas = Partida::all(); //lee todos los registros de la tabla en la base de datos ::all()
        $datos['partidas'] = $partidas; //esto indica que la variable $lista se va a guardar en lista

        return view('Partida.index')->with($datos); //si el index estuviese en una carpeta distinta, seria Jugdor.index (NombredelaCarpeta.index)
    }

    function formulario($id = 0) //el valor por defecto es 0 si no se recibe el id
    {
        $datos = array(); //$datos es una variable de tipo compleja (arreglo)
        $datos['personajes'] = Personaje::all();
        if ($id != 0) { //en caso de que el valor de id sea diferente a 0, entonces se ejecuta la condicion
            //$jugador=TipoJugador::find($id);
            //TipoJugador::find($id);
            $datos['partida'] = Partida::find($id); //aqui buscara el valor de id igual del id
            //$datos en este caso es un elemento del arreglo
            //Partida es el nombre del modelo en donde esta la tabla partidas, le esta diciendo que entre al modelo y busque la id

            //la operacion que se hace es editar ya que como el id es diferente de 0 entonces se edita porque como es diferente ya se agrego, y como ya se agrego no se puede volver a agregar, entonces se edita
            $datos['operacion'] = 'Editar'; //dentro del arreglo $datos guardara el valor editar en la posicion operacion
        } else { //sino
            //se realiza la operacion agregar porque es diferente de 0 entonces como no existe se agrega
            $datos['partida'] = new Partida(); //se crea un nuevo registro en la tabla de partida
            $datos['operacion'] = 'Agregar';
        }

        //dd($jugador);
        return view('Partida.formulario')->with($datos); //regresa a la vista de formulario que esta en la carpeta partida con los datos (con los datos que se pidieron)
        $datos['operacion'] = ''; //se deja con cadena vacia, se le pone cadena vacia para evitar errores 
    }

    //como este metodo recibe datos de la peticion entonces es necesario agregarle un parametro
    /* function save(Request $peticion)
    { //recibe como parametro un objeto llamado $peticion, contiene todos los datos enviados por el formulario

        //agregar un registro a la base de datos
        //1.-recibir los datos de una peticion
        $context = $peticion->all(); //aqui le dice que guarde todos los datos en $context
        switch ($context['operacion']) { //en operacion estan los valores que le dimos en la funcion del formulario, y dependiendo que operacion se haga, el switch hara procedimientos
            case 'Agregar':
                //2.- Inserto el registro en la base de datos usando los datos de la peticion
                $t = new Partida(); //Partida.php (modelo)
                $t->nombre = $context['partida']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $t->fecha = $context['fecha'];
                $t->codigo = $context['codigo'];
                $t->save(); //guarda los cambios
                break;

            case 'Editar':
                $t = Partida::find($context['id']); //busca el registro por la llave primaria
                $t->nombre = $context['partida']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $t->fecha = $context['fecha'];
                $t->codigo = $context['codigo'];
                $t->save(); //guarda los cambios
                break;

            case 'Eliminar':
                $t = Partida::find($context['id']);
                $t->delete();
                break;
        }

        return redirect()->route('index_partida'); //le esta diciendo cada operacion que haga (editar, agregar o eliminar) lo va a regresar a la ruta
    } */

    function crear_partida(Request $r)
    {
        $context = $r->all();
        $servicio = new ServicioPartida;
        //$nombre,$codigo,$idusuario
        //1.-Obtengo el usuario de la sesion
        //$idusuario = Auth::user()->id;
        //obtengo al jugador a partir del idusuario

        //$jugador = Jugador::where('idusuario', $idusuario)->first();
        $jugador = dame_jugador();
        $servicio->crear_partida($context['nombre'], $context['codigo'], $jugador->id, $context['idpersonaje']);
        }

    function formulario_unir()
    {
        $datos = array();
        $datos['personajes'] = Personaje::all();
        return view('partida.unir')->with($datos);
    }


    function unir_partida(Request $r)
    {
        $context = $r->all();
        $servicio = new ServicioPartida(); //recibe el codigo de serviciopartida
        $jugador = dame_jugador();


        $r1 = $servicio->unir_partida($context['codigo'], $jugador->id, $context['idpersonaje']);
        if ($r1->status == 'OK') {
            return view('partida.unir_exitoso');
        } else {
            $datos = array();
            $datos['mensaje'] = $r1->mensaje;
            return view('partida.unir_noexitoso')->with($datos);
        }
        dd($r1);
    }

    function iniciar_partida(Request $r)
    {
        $context = $r->all();
        $servicio = new ServicioPartida;
        $r1 = $servicio->inicia_partida($context['idpartida']);
        if ($r1->status == 'OK') {
            return view('partida.iniciar_exitoso');
        } else {
            $datos = array();
            $datos['mensaje'] = $r1->mensaje;
            return view('partida.iniciar_noexitoso')->with($datos);
        }
    }

    function iniciar_turno(Request $r)
    {
        $context = $r->all();
        $servicio = new ServicioPartida();
        $jugador = dame_jugador();
        $r3 = $servicio->iniciar_turno($context['idpartida'], $jugador->id);
        if ($r3->status == 'OK') {
            $servicio_turno = new ServicioTurno();
            $r4 = $servicio_turno->valida_turno_activo($context['idpartida'], $jugador->id);
            if ($r4->status == 'OK') {
                $datos = array();
                $datos['monstruo'] = $r4->nommonstruo;
                $datos['danio'] = $r4->danio;
                $datos['idturno'] = $r4->idturno;
                $datos['foto_monstruo'] = $r4->foto_monstruo;
                return view('turno.iniciar_turno')->with($datos);
            } else {
                $datos = array();
                $datos['idpartida'] = $context['idpartida'];
                return view('turno.seleccionar_nivel')->with($datos);
            }
        } else {
            $datos = array();
            $datos['mensaje'] = $r3->mensaje;
            return view('turno.unir_noexitoso')->with($datos);
        }
    }

    function iniciar_turno_nivel(Request $r)
    {
        $context = $r->all();
        $jugador = dame_jugador();
        $servicio = new ServicioTurno();
        $r5 = $servicio->crear_turno_nivel($context['idpartida'], $jugador->id, $context['idnivel']);
        if ($r5->status == 'OK') {
            $datos = array();
            $datos['monstruo'] = $r5->nommonstruo;
            $datos['danio'] = $r5->danio;
            $datos['idturno'] = $r5->idturno;
            $datos['foto_monstruo'] = $r5->foto_monstruo;
            return view('turno.iniciar_turno')->with($datos);
        }
    }

    function atacar(Request $r)
    {
        $context = $r->all();
        $servicio = new ServicioTurno();
        $r1 = $servicio->atacar_monstruo($context['idturno']);
        if ($r1->status == 'OK') {
            $datos = array();
            $datos['item'] = $r1->nombre_item;
            $datos['puntos'] = $r1->puntos;
            $datos['foto_item'] = $r1->foto_item;
            return view('turno.gano')->with($datos);
        } else {
            $datos = array();
            $datos['idturno'] = $context['idturno'];
            return view('turno.nogano')->with($datos);
        }
    }

    function ataque_monstruo(Request $r)
    {
        $context = $r->all();
        $servicio = new ServicioTurno();
        $r4 = $servicio->ataque_monstruo($context['idturno']);
        $datos = array();
        $datos['mensaje'] = $r4->mensaje;
        return view('turno.ataque_monstruo')->with($datos);
    }

    function detalle_partida(Request $r){
        $context = $r->all();

        $servicio = new ServicioPartida();
        $r1 = $servicio->detalle_partida($context['idpartida']);

        $datos = array();
        $datos['detalle_partida'] = $r1->detalle_partida;

        return view('Partida.detalle')->with($datos);
    }
}
