<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personaje;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PersonajesController extends Controller
{
    function index()
    {
        $datos = array();
        //lee todos los registros ::all()
        $lista = Personaje::all();
        $datos['lista'] = $lista;
        return view('Personajes.index')->with($datos); //si el index estuviese en una carpeta distinta, seria Jugdor.index (NombredelaCarpeta.index)
    }

    function formulario($id = 0)
    {
        $datos = array();
        if ($id != 0) {
            //$jugador=TipoJugador::find($id);
            //TipoJugador::find($id);
            $datos['personaje'] = Personaje::find($id);
            $datos['operacion'] = 'Editar';
        } else {
            $datos['personaje'] = new Personaje();
            $datos['operacion'] = 'Agregar';
        }

        //dd($jugador);
        return view('Personajes.formulario')->with($datos);
        $datos['operacion'] = '';
    }



    public function mostrar_foto($archivo)
    { //public porque el metodo puede ser llamado desde cualquier parte del codigo,
        //storage_path es una funcion de laravel que devuelve
        //de la carpeta Storage
        $path = storage_path('app/private/personajes/' . $archivo); //ruta de la foto lo concatena con la variable $archivo que usamos anteriormente
        if (!File::exists($path)) { //si no hay la foto dentro entonces
            abort(404); //muestra error en la pantalla
        }

        //recupera el contenido del archivo
        $file = File::get($path); //esta leyendo el archivo que esta en la variable $path y lo guarda en la variable $file
        //recupero el tipo del archivo
        $type = File::mimeType($path); //guarda el tipo de archivo en la variable $type
        //devuelvo el archivo
        $response = Response::make($file, 200); //significa que fue exitoso
        $response->header("Content-Type", $type); //le dice que tipo de archivo esta guardando para que se respete ejemplo un pdf o una imagen etc.
        return $response; //devuelve la imagen
    }

    //como este metodo recibe datos de la peticion entonces es necesario agregarle un parametro
    function save(Request $peticion)
    { //recibe como parametro un objeto llamado $peticion, contiene todos los datos enviados por el formulario

        //agregar un registro a la base de datos
        //1.-recibir los datos de una peticion
        $context = $peticion->all(); //aqui le dice que guarde todos los datos en $context
        $archivo = $peticion->file('foto');
        // dd($archivo);


        switch ($context['operacion']) {
            case 'Agregar':
                //2.- Inserto el registro en la base de datos usando los datos de la peticion
                $t = new Personaje(); //Monstruo.php (modelo)
                $t->nombre = $context['nombre']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $t->foto = '';
                $t->objetivo = $context['objetivo'];
                $t->save(); //guarda los cambios

                if ($peticion->hasFile('foto')) { //aqui pregunta si hay un archivo foto en el campo foto
                    $nombre_archivo = 'foto-' . $t->id . '.' . $archivo->getClientOriginalExtension(); //la foto se guarda con el nombre de la foto.id y siempre se guardara con la ruta que el cliente tiene de la imagen (png o tpg)

                    //los archivos de imagenes se guardan en la carpeta de laravel (storage)
                    $archivo_subido = $archivo->storeAS('personajes/', $nombre_archivo); //en esta linea storeAS guarda en la carpeta fotos con el nombre de $nombre_archivo
                    //llevan comas en vez de puntos porque de esa manera separa argumentos de un metodo, no es una cadena
                    $t->foto = $nombre_archivo;
                    $t->save(); //

                }
                break;

            case 'Editar':
                $t = Personaje::find($context['id']); //busca el registro por la llave primaria
                $t->nombre = $context['nombre']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $t->objetivo = $context['objetivo'];
                $t->foto = '';
                $t->save(); //guarda los cambios

                if ($peticion->hasFile('foto')) { //aqui pregunta si se subi una foto en el campo foto, si se subio entonces sigue con el proceso de la condicion, si no, entonces se salta ese paso
                    //1.-se borra la foto
                    if ($t->foto != '') { //aqui pregunta si hay una foto en el campo foto, si hay una foto en ese campo, se continua la condicion, sino, se salta
                        Storage::delete('personajes/' . $t->foto);
                    }
                    //2.-se sube
                    $nombre_archivo = 'foto-' . $t->id . '.' . $archivo->getClientOriginalExtension(); //la foto se guarda con el nombre de la foto.id y siempre se guardara con la ruta que el cliente tiene de la imagen (png o jpg)

                    //los archivos de imagenes se guardan en la carpeta de laravel (storage)
                    $archivo_subido = $archivo->storeAS('personajes', $nombre_archivo); //en esta linea storeAS guarda en la carpeta fotos con el nombre de $nombre_archivo
                    $t->foto = $nombre_archivo;
                    $t->save();
                }
                break;

            case 'Eliminar':
                $t = Personaje::find($context['id']);
                if ($t->foto != '') { //si la foto es diferente a la cadena vacia
                    //borro el archivo del servidor
                    Storage::delete('personajes/' . $t->foto); //borra la foto
                }
                $t->delete();
                break;
        }

        return redirect()->route('index_personaje'); //le esta diciendo cada operacion que haga (editar, agregar o eliminar) lo va a regresar a la ruta
    }
}
