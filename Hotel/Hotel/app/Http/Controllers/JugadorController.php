<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Jugador;
use App\Models\Usuario;
use App\Models\Edad;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TipoJugador; //llama al modelo TipoJugador porque es donde se va a usar para hacer el join entre las tablas de la base de datos
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;


class JugadorController extends Controller
{
    //tiene la funcion de listar todos los registros de la tabla
    function index()
    {
        $datos = array();
        //lee todos los registros ::all()
        //$lista = Jugador::all();

        $lista = Jugador::join('tipo_jugador', 'jugador.tipo', '=', 'tipo_jugador.id') //va a ir al modelo Jugador y va a hacer un join(referencia) con la tabla tipo_jugador
            //jugador.tipo es la columna de la tabla jugador que se usara como llave foranea
            //y tipo_jugador.id es la llave primaria de la tabla tipo_jugador
            ->join('edad', 'edad.id', '=', 'jugador.edad') //esto porque se hace el join con la tabla de edad en la base de datos
            //edad.id es la llave primaria de la tabla edad
            //jugador.edad es la columna que se usara para la llave foranea

            ->select( //es para atraer a las columnas que se necesitan de la tabla de la base de datos
                'jugador.nombre as nombre', //a la columna jugador.nombre se le puso el nombre 'nombre'
                'tipo_jugador.nombre as tipo', //a la columna tipo_jugador se le puso el nombre 'tipo'
                'jugador.puntos', //se usara la columna puntos de la tabla jugador
                'jugador.id', //se usara el id de la tabla jugador
                'jugador.foto', //se usara la columna foto de la tabla jugador
                'edad.nombre as edad' //esto se le agrega porque hicimos un join con la tabla edad de la base de datos jugador
            )

            ->get(); //ejecuta las consultas y devuelve todos los registros encontrados

        $datos['lista'] = $lista; //va a guardar todos los valores de $lista en lista
        return view('Jugador.index')->with($datos); //si el index estuviese en una carpeta distinta, seria Jugdor.index (NombredelaCarpeta.index)
    }

    function formulario($id = 0) //$id es igual a 0
    {
        $datos = array(); //variable compleja: arreglo, todos los elementos del arreglo se guardaran en la variable $datos
        $datos['tipos'] = TipoJugador::all(); //llama a todos los tipos de tipos que hay en la tabla tipo_jugador
        $datos['edades'] = Edad::all(); //llama a todos los tipos de edades que hay en la tabla edad (va al modelo Edad)
        //se hace este if para saber si el formulario va a editar o a agregar
        //si es 0 agregar
        //!=0 editasr
        if ($id != 0) { //si el id es diferente a 0
            //recupero la informacion del registro a partir del id
            //$jugador=Jugador::find($id);
            //Jugador::find($id);
            $datos['jugador'] = Jugador::find($id); //busca el id de la tabla jugador a traves del modelo Jugador
            $datos['operacion'] = 'Editar'; //si es diferente a 0 entonces se edita, porque ya hay un registro diferente a 0
        } else {
            //creo un modelo vacio
            $datos['jugador'] = new Jugador(); //hace uno nuevo
            $datos['operacion'] = 'Agregar'; //si no hay un registro diferente a 0 o es =0 entonces agrega uno nuevo porque no existe
        }

        //dd($jugador);
        return view('Jugador.formulario')->with($datos); //regresa a la vista de formulario con los datos que tiene la variable $datos
        $datos['operacion'] = ''; //cadena vacia para evitar errores
    }

    //como este metodo recibe datos de la peticion entonces es necesario agregarle un parametro
    //esta  informacion viene del formulario
    function save(Request $peticion)
    //llama al metodo request de laravel y a la variable $peticion
    { //recibe como parametro un objeto llamado $peticion, contiene todos los datos enviados por el formulario

        //agregar un registro a la base de datos


        //1.-recibir los datos de una peticion
        $context = $peticion->all(); //aqui le dice que guarde todos los datos en $context

        //2.-leer el archivo del paquete de archivo
        $archivo = $peticion->file('foto'); //la variable foto viene del nombre que se le dio en el formulario

        switch ($context['operacion']) {
            case 'Agregar': //se ejecutara la accion si la operacion es agregar
                //2.- Inserto el registro en la base de datos usando los datos de la peticion
                $j = new Jugador(); //Jugador.php (modelo), crea un nuevo objeto 
                $j->nombre = $context['nombre']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $j->puntos = $context['puntos']; //cada linea de nombre, puntos, tipo y edad es una propiedad del objeto $j
                $j->tipo = $context['tipo'];
                $j->edad = $context['edad'];
                $j->foto = '';
                $j->save(); //guarda los cambios y al guardarlos genera una id autoincremental

                if ($peticion->hasFile('foto')) { //aqui pregunta si hay un archivo foto en el campo foto
                    $nombre_archivo = 'foto-' . $j->id . '.' . $archivo->getClientOriginalExtension(); //la foto se guarda con el nombre de la foto.id y siempre se guardara con la ruta que el cliente tiene de la imagen (png o jpg)

                    //los archivos de imagenes se guardan en la carpeta de laravel (storage)
                    $archivo_subido = $archivo->storeAS('fotos', $nombre_archivo); //en esta linea storeAS guarda en la carpeta fotos con el nombre de $nombre_archivo
                    //llevan comas en vez de puntos porque de esa manera separa argumentos de un metodo, no es una cadena
                    $j->foto = $nombre_archivo;
                    $j->save(); //

                }

                break;

            case 'Editar':
                $j = Jugador::find($context['id']); //busca el registro por la llave primaria
                $j->nombre = $context['nombre']; //nombre y puntos se toman de $context porque alli se guardaron los datos
                $j->puntos = $context['puntos'];
                $j->tipo = $context['tipo'];
                $j->edad = $context['edad'];


                if ($peticion->hasFile('foto')) { //aqui pregunta si se subi una foto en el campo foto, si se subio entonces sigue con el proceso de la condicion, si no, entonces se salta ese paso
                    //1.-se borra la foto
                    if ($j->foto != '') { //aqui pregunta si hay una foto en el campo foto, si hay una foto en ese campo, se continua la condicion, sino, se salta
                        Storage::delete('private/fotos' . $j->foto);
                    }
                    //2.-se sube
                    $nombre_archivo = 'foto-' . $j->id . '.' . $archivo->getClientOriginalExtension(); //la foto se guarda con el nombre de la foto.id y siempre se guardara con la ruta que el cliente tiene de la imagen (png o jpg)

                    //los archivos de imagenes se guardan en la carpeta de laravel (storage)
                    $archivo_subido = $archivo->storeAS('fotos', $nombre_archivo); //en esta linea storeAS guarda en la carpeta fotos con el nombre de $nombre_archivo
                    $j->foto = $nombre_archivo;
                }
                $j->save(); //guarda los cambios

                break;

            case 'Eliminar':
                $j = Jugador::find($context['id']); //busca al jugador a traves del id con el modelo Jugador
                if ($j->foto != '') { //si la foto es diferente a la cadena vacia
                    //borro el archivo del servidor
                    Storage::delete('fotos/' . $j->foto); //borra la foto
                }
                $j->delete(); //si la foto es igual a la cadena vacia entonces borra
                break;
        }

        //redirecciona a la ruta con  NOMBRE index_jugador
        return redirect()->route('index_jugador'); //le esta diciendo cada operacion que haga (editar, agregar o eliminar) lo va a regresar a la ruta
    }

    public function mostrar_foto($archivo)
    { //public porque el metodo puede ser llamado desde cualquier parte del codigo,
        //storage_path es una funcion de laravel que devuelve
        //de la carpeta Storage
        $path = storage_path('app/private/fotos/' . $archivo); //ruta de la foto lo concatena con la variable $archivo que usamos anteriormente
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


    function home()
    {
        dd('Bienvenido Jugador');
    }

    function signup()
    {
        $datos = array(); //variable compleja: arreglo, todos los elementos del arreglo se guardaran en la variable $datos
        $datos['tipos'] = TipoJugador::all(); //llama a todos los tipos de tipos que hay en la tabla tipo_jugador
        $datos['edades'] = Edad::all(); //llama a todos los tipos de edades que hay en la tabla edad (va al modelo Edad)
        return view('auth.signup')->with($datos);
    }

    public function crear_cuenta(Request $r)
{
    // 1️⃣ Validar datos básicos del formulario
    $r->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:usuario,email',
        'password' => 'required|string|min:6',
        'edad' => 'required|integer',
        'tipo' => 'required|integer',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $context = $r->all();

    // 2️⃣ Crear usuario y encriptar contraseña
    $U = new Usuario();
    $U->email = $context['email'];
    $U->password = Hash::make($context['password']); // <- Bcrypt
    $U->idrol = 2; // Por ejemplo, rol jugador
    $U->save();

    // 3️⃣ Crear jugador
    $j = new Jugador();
    $j->nombre = $context['nombre'];
    $j->puntos = 0;
    $j->tipo = $context['tipo'];
    $j->edad = $context['edad'];
    $j->idusuario = $U->id;
    $j->foto = ''; // Inicialmente vacío
    $j->save();

    // 4️⃣ Guardar foto si se subió
    if ($r->hasFile('foto')) {
        $archivo = $r->file('foto');
        $nombre_archivo = 'foto-' . $j->id . '.' . $archivo->getClientOriginalExtension();
        $archivo->storeAs('public/fotos', $nombre_archivo);
        $j->foto = $nombre_archivo;
        $j->save();
    }

    // 5️⃣ Iniciar sesión automáticamente (opcional)
    Auth::login($U);

    // 6️⃣ Redirigir al inicio (o a la página que quieras)
    return redirect()->route('inicio')->with('success', 'Cuenta creada correctamente');
}

    function profile()
    {
        $idusuario = Auth::user()->id;
        //obtengo al jugador a partir del idusuario

        /*
        select partidas.nombre, //seleciona el nombre de la partida
        partidas.status,//selecciona el estatus de esa partida
        partidas.turno, //selecciona el turno actual de la partida
        partidaxjugador.puntos //selecciona los puntos que tiene el jugador en esa partida
        personaje.nombre as personaje
        from partida 
        join partidaxjugador on partidaxjugador.idpartida=partida.id
        join personaje on partidaxjugador.idpersonaje=personaje.id
        where partidaxjugador.idjugador=28
        */
        $jugador = Jugador::where('idusuario', $idusuario)->first();
        $partidas = DB::table('partidas')
            ->join('partidaxjugador', 'partidaxjugador.idpartida', '=', 'partidas.id')
            ->join('personaje', 'partidaxjugador.idpersonaje', '=', 'personaje.id')
            ->select(
                'partidas.nombre',
                'partidas.id',
                'partidas.status',
                'partidas.turno',
                'partidaxjugador.puntos',
                'personaje.nombre as personaje'
            )
            ->where('partidaxjugador.idjugador', $jugador->id)
            ->get();

        $datos = array();
        $datos['partidas'] = $partidas;


        return view('jugador.profile')->with($datos);
    }
}
