<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jugador;

function hola(){
    dd('hola');
}

function tirar_dados(){
    return rand(2,12);
}

function hoy($formato='Y-m-d H:i:s'){
    return date($formato); 
}

function dame_usuario(){
    return Auth::user();
}

function dame_jugador(){
    $idusuario = Auth::user()->id;
    return Jugador::where('idusuario', $idusuario)->first();
}


function jugadorTurnoActual($idpartida)
{
    $turno = DB::table('partidaxjugador')
        ->where('idpartida', $idpartida)
        ->where('turno', 1) // ← este es el jugador con el turno
        ->first();

    if (!$turno) return null;

    return Jugador::find($turno->idjugador);
}


function foto_jugador($jugador)
{
    if (!$jugador) return asset('images/default.png');

    if ($jugador->jugador_foto) {
        return asset('storage/' . $jugador->jugador_foto);
    }

    return asset('images/default.png');
}

function registro_datos($idpartida, $turno)
{
    


    $pxj = DB::table('partidaxjugador')
    ->join('jugador', 'jugador.id', '=', 'partidaxjugador.idjugador')
    ->select(
        'partidaxjugador.idpartida',
        'partidaxjugador.idjugador',
        'partidaxjugador.turno',
        'jugador.nombre as jugador',
        'jugador.foto'
    )
    ->where('partidaxjugador.turno', $turno)
    ->where('partidaxjugador.idpartida', $idpartida)
    ->first();

    return $pxj;

}
