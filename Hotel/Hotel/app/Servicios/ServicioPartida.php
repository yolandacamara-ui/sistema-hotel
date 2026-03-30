<?php

namespace App\Servicios; //se debe de poner a todos los servicios que se hagan
use App\Models\Partida;
use App\Servicios\ServicioTurno;
use App\Models\PartidaxJugador;

class ServicioPartida
{

    function detalle_partida($idpartida)
    {
        $resultado = new \stdClass();

        Partida::find($idpartida);

        $detalle_partida = PartidaxJugador::join('jugador', 'partidaxjugador.idjugador', '=', 'jugador.id')
            ->join('personaje', 'partidaxjugador.idpersonaje', '=', 'personaje.id')
            ->select(
                'jugador.nombre as jugador',
                'personaje.nombre as personaje',
                'partidaxjugador.puntos'
            )
            ->where('partidaxjugador.idpartida', $idpartida)
            ->get();

        $resultado->status = 'OK';
        $resultado->detalle_partida = $detalle_partida;

        return $resultado;
    }


    function crear_partida($nombre, $codigo, $idjugador, $idpersonaje)
    {
        $resultado = new \stdClass(); //esto es un objeto vacio que despues se regresara con los valores que se le pongan
        //1.- Insertar una partida
        $partida = new Partida();
        $partida->nombre = $nombre;
        $partida->codigo = $codigo;
        $partida->fecha = hoy(); //fecha y hora automatica
        $partida->turno = 0; //0 porque aun no se sabe el turno del jugador
        $partida->gano = 0; //0 porque no se sabe quien gano aun
        $partida->status = 0; //0 porque aun no se sabe si la partida inicio o finalizo
        $partida->save(); //guardar

        //2.- Inscribir al usuario en esa partida
        $partidaxjugador = new PartidaxJugador();
        //En la partidaxjugador agrego la referencia de la partida que acabo de crear
        $partidaxjugador->idpartida = $partida->id;
        $partidaxjugador->idjugador = $idjugador;
        $partidaxjugador->idpersonaje = $idpersonaje;
        $partidaxjugador->puntos = 0;
        $partidaxjugador->turno = 0;
        $partidaxjugador->save();

        $resultado->idpartida = $partida->id;
        $resultado->status = 'OK';
        return $resultado;
    }

    function unir_partida($codigo, $idjugador, $idpersonaje)
    {
        $resultado = new \stdClass();

        //1.-Validar si existe una partida con el codigo
        //SELECT * FROM `partidas` WHERE codigo="1234"
        $partida = Partida::where('codigo', $codigo)->first();
        if ($partida) {
            //exite
            $partidaxjugador = new PartidaxJugador();
            //En la partidaxjugador agrego la referencia de la partida que acabo de crear

            //valido si el usuario esta registrado a la partida
            //select * from partidaxjugador where idpartida = “2” and idjugador=”24”
            $pxj = PartidaxJugador::where('idpartida', $partida->id)->where('idjugador', $idjugador)->first();
            if ($pxj) {
                //existe
                $resultado->status = 'NOT OK';
                $resultado->mensaje = 'El jugador ya existe en la partida';
            } else {
                //no existe
                $partidaxjugador->idpartida = $partida->id;
                $partidaxjugador->idjugador = $idjugador;
                $partidaxjugador->puntos = 0;
                $partidaxjugador->turno = 0;
                $partida->status = 0; //0 porque aun no se sabe si la partida inicio o finalizo
                $partidaxjugador->idpersonaje = $idpersonaje;
                $partidaxjugador->save();

                $resultado->idpartida = $partida->id;
                $resultado->status = 'OK';
                $resultado->mensaje = 'Inscripcion exitosa';
            }
        } else {
            //no existe
            $resultado->status = 'NOT OK';
            $resultado->mensaje = 'No existe la partida con el codigo capturado';
        }
        return $resultado;
    }

    function inicia_partida($idpartida)
    {
        $resultado = new \stdClass();
        //1.-obtener los jugadores de la partida
        /*
        select partidaxjugador.idjugador,
        partidaxjugador.idpartida,
        partidaxjugador.turno
        from partidaxjugador
        where partidaxjugador.idpartida=4
        */

        $jugadores = PartidaxJugador::select(
            'partidaxjugador.idjugador',
            'partidaxjugador.idpartida',
            'partidaxjugador.turno'
        )
            ->where('partidaxjugador.idpartida', $idpartida)
            ->get();


        //2.-Asignar los turnos a los    
        $numero_jugadores = count($jugadores);
        $turnos = range(1, $numero_jugadores);
        shuffle($turnos);
        $indice_turno = 0;
        foreach ($jugadores as $jugador) {
            PartidaxJugador::where('idjugador', $jugador->idjugador)
                ->where('idpartida', $idpartida)
                ->update(
                    [
                        "turno" => $turnos[$indice_turno]
                    ]
                );

            $indice_turno++;
        }


        //3.-cambiar el status de la partida a 1 y asignar 1 como turno actual
        $partida = Partida::find($idpartida);
        $partida->status = 1;
        $partida->turno = 1;
        $partida->save();

        $resultado->status = 'OK';
        $resultado->mensaje = 'Partida iniciada';
        return $resultado;
    }


    public function ganador($idpartida, $idjugador)
    {
        /*
        SELECT partidaxjugador.puntos,
        partidaxjugador.idpersonaje,
        partidaxjugador.idpartida,
        partidaxjugador.idjugador,
        jugador.nombre,
        personaje.objetivo
        FROM partidaxjugador
        JOIN jugador
        ON partidaxjugador.idjugador = jugador.id
        JOIN personaje ON partidaxjugador.idpersonaje = personaje.id

        WHERE personaje.id = 2
        */
        $partida = Partida::find($idpartida);

        $ganador = PartidaxJugador::join('jugador', 'jugador.id', '=', 'partidaxjugador.idjugador')
            ->join('personaje', 'personaje.id', '=', 'partidaxjugador.idpersonaje')
            ->select(
                'partidaxjugador.puntos',
                'jugador.nombre',
                'personaje.objetivo'
            )

            ->where('partidaxjugador.idpartida', $idpartida)
            ->where('partidaxjugador.idjugador', $idjugador)
            ->first();


            if ($ganador->puntos >= $ganador->objetivo) {
               $partida->status = 2;
               $partida->gano=$idjugador;
               $partida->save();
    }
}



    function iniciar_turno($idpartida, $idjugador)
    {
        $resultado = new \stdClass();
        //1.-obtener los datos de la partida
        $partida = Partida::find($idpartida);
        //2.-obtener el turno del jugador en la partida
        $pxj = PartidaxJugador::where('idpartida', $idpartida)->where('idjugador', $idjugador)->first();
        //3.-preguntamos si el turno actual de la partida es igual al turno actual del jugador
        if ($pxj->turno == $partida->turno) {
            $resultado->status = 'OK';
            $resultado->mensaje = 'Si es tu turno';
            //3.1.- si es verdadero inicio el turno
            //$serv_turno=new ServicioTurno();
            //$resultado=$serv_turno->crear_turno($idpartida,$idjugador);

        } else {
            //3.2.-si es falso le informo al usuario que no puede porque no es su turno
            $resultado->status = 'Not ok';
            $resultado->mensaje = 'No es tu turno';
        }
        return $resultado;
    }

    function cambiar_turno($idpartida)
    {
        $partida = Partida::find($idpartida);
        $numero_jugadores = PartidaxJugador::where('idpartida', $idpartida)->count();
        if ($partida->turno < $numero_jugadores) {
            $partida->turno++;
        } else {
            $partida->turno = 1;
        }

        //$partida->turno++;
        $partida->save();
    }
}