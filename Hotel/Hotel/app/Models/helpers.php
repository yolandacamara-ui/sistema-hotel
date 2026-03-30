<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jugador;

function hola()
{
    dd('hola');
}

function tirar_dados()
{
    return rand(2, 12);
}

function hoy($formato = 'Y-m-d H:i:s')
{
    // date_default_timezone_set("America/Merida");
    return date($formato);
}

function dame_usuario()
{
    return Auth::user();
}

function dame_jugador()
{
    //1.-Obtengo el usuario de la sesion
    $idusuario = Auth::user()->id;
    //obtengo al jugador a partir del idusuario
    $jugador = Jugador::where('idusuario', $idusuario)->first();
    return $jugador;
}


function registro_datos($idpartida, $turno)
{
    /*
    SELECT jugador.nombre,
    partidaxjugador.idpartida,
    partidaxjugador.idjugador,
    partidaxjugador.turno
    FROM jugador
    JOIN partidaxjugador
    on partidaxjugador.idjugador=jugador.id
    WHERE partidaxjugador.idpartida=4
    AND partidaxjugador.turno=1
    */
    


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
