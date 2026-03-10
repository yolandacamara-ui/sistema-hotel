<?php

namespace App\Servicios; //se debe de poner a todos los servicios que se hagan
use App\Models\Partida;
use App\Models\ItemsJugador;
use App\Servicios\ServicioPartida;
use App\Models\Turno;
use App\Models\Monstruo;
use App\Models\Personaje;
use App\Models\Item;
use App\Models\Danio;
use App\Models\Jugador;
use App\Models\PartidaxJugador;

class ServicioTurno
{

    function dame_mounstruo($nivel){
        // Si $nivel es 0, significa dame un monstruo de cualquier nivel
        if($nivel==="0"){
            return Monstruo::inRandomOrder() // mezcla todos los monstruos
                        ->limit(1) // solo toma uno
                        ->first(); // devuelve ese monstruo.
        }
        else{
            // Si el nivel NO es 0
            return Monstruo::where('idnivel',$nivel) //filtra monstruos del nivel solicitado
                        ->inRandomOrder() // Esto revuelve el orden de los resultados.
                        ->limit(1) // De todos los monstruos revueltos, solo dame 1
                        ->first(); // devuelve ese monstruo.
        }
    
    }

    function dame_item($nivel)
    {
        return Item::where('idnivel', $nivel)
            ->inRandomOrder()
            ->limit(1)
            ->first();
    }
    /*
    Turno va a tener varios status
    0 activo
    1 inactivo
     */
    function crear_turno($idpartida, $idjugador)
    {
        $resultado = new \stdClass();
        $turno = new Turno();
        $turno->idpartida = $idpartida;
        $turno->idjugador = $idjugador;
        $turno->status = 0;
        $turno->save(); //guardar
        $resultado->status = 'OK';
        $resultado->mensaje = 'Turno creado con exito';
        return $resultado;
    }
    //El objetivo es crear un registro en la tabla turno
    //Turno (idpartida, idjugador, idmounstruo,status)
    function crear_turno_nivel($idpartida, $idjugador, $idnivel)
    {
        $resultado = new \stdClass();
        //1.- seleccionar los mounstruos de ese nivel, revolverlos y tomar el primero 
        $m1 = $this->dame_mounstruo($idnivel);
        //2.-crear turno en la base de datos
        $turno = new Turno();
        $turno->idpartida = $idpartida;
        $turno->idjugador = $idjugador;
        $turno->status = 0;
        $turno->idmounstruo = $m1->id;
        $turno->save(); //guardar

        //3.-obtener el danio del mounstruo seleccionado
        /*
        select *
        from partidaxjugador
        where idjugador=3
        and idpartida=4
        */
        $pxj = PartidaxJugador::where('idjugador', $idjugador)
            ->where('idpartida', $idpartida)
            ->first();

        /*
            select *
            from danio
            where idpersonaje=1
            and idmonstruo=2
            */

        $danio = Danio::where('idpersonaje', $pxj->idpersonaje)
            ->where('idmonstruo', $m1->id)
            ->first();


        //4.-generar el objeto resultado del proceso
        $resultado->status = 'OK';
        $resultado->mensaje = 'Turno creado con exito';
        $resultado->idturno = $turno->id;
        $resultado->idmonstruo = $m1->id;
        $resultado->nommonstruo = $m1->nombre;
        $resultado->danio = $danio->valor;
        $resultado->foto_monstruo = $m1->foto;
        return $resultado;
    }

    function valida_turno_activo($idpartida, $idjugador)
    {
        $resultado = new \stdClass();
        /*
        select *
        from turno
        where idpartida=1
        and idjugador=2
        */

        $turno = Turno::where('idpartida', $idpartida)
            ->where('idjugador', $idjugador)
            ->where('status', 0)
            ->first();

        if ($turno) {
            //el jugador tiene un turno activo
            $resultado->status = 'OK';
            $resultado->idmonstruo = $turno->idmounstruo;
            $resultado->idturno = $turno->id;

            $monstruo = Monstruo::find($turno->idmounstruo);
            $pxj = PartidaxJugador::where('idjugador', $idjugador)
                ->where('idpartida', $idpartida)
                ->first();
            $danio = Danio::where('idpersonaje', $pxj->idpersonaje)
                ->where('idmonstruo', $monstruo->id)
                ->first();

            $resultado->nommonstruo = $monstruo->nombre;
            $resultado->danio = $danio->valor;
            $resultado->foto_monstruo=$monstruo->foto;
        } else {
            //el jugador no tiene un turno activo
            $resultado->status = 'Not OK';
            $resultado->mensaje = 'No tienes un turno';
        }

        return $resultado;
    }

    function atacar_monstruo($idturno)
    {
        $resultado = new \stdClass();
        $turno = Turno::find($idturno);

        $idpartida = $turno->idpartida;
        $idjugador = $turno->idjugador;
        $jugador = Jugador::find($idjugador); //-------------------------------------------------


        $pxj = PartidaxJugador::where('idjugador', $turno->idjugador)
            ->where('idpartida', $turno->idpartida)
            ->first();
        $personaje = Personaje::find($pxj->idpersonaje); //--------------------------
        //1.- Tirar los dados
        //$dados = tirar_dados();
        $dados = 12;


        //2.-obtener el danio del monstruo y el personaje
        $danio = Danio::where('idmonstruo', $turno->idmounstruo)
            ->where('idpersonaje', $pxj->idpersonaje)
            ->first();
        //3.- Comparar el resultado de los dados con el danio del enemigo
        if ($dados >= $danio->valor) {
            //gano
            //1.-darle un item del monstruo que mato
            $monstruo = Monstruo::find($turno->idmounstruo);
            $item = $this->dame_item($monstruo->idnivel);
            //2.-sumar los puntos del item al jugador
            //update partidaxjugador set puntos=20 where idpartida=12 and idjugador=2
            PartidaxJugador::where('idjugador', $turno->idjugador)
                ->where('idpartida', $turno->idpartida)
                ->update(
                    ['puntos' => $pxj->puntos + $item->valor]
                );

            $servicio_partida = new ServicioPartida();
            $servicio_partida->ganador($turno->idpartida, $turno->idjugador);

            //3.-finalizar el turno
            $turno->status = 1;
            $turno->save();
            //4.-registrar el item al jugador en la partida
            $itemsjugador = new ItemsJugador();
            $itemsjugador->iditem = $item->id;
            $itemsjugador->idjugador = $turno->idjugador;
            $itemsjugador->idpartida = $turno->idpartida;
            $itemsjugador->puntos = $item->valor;
            $itemsjugador->save();
            //5.-decirle a la partida que sume al turno actual
            $servicio_partida = new ServicioPartida();
            $servicio_partida->cambiar_turno($turno->idpartida);
            //informar que sucedio
            $resultado->status = 'OK';
            $resultado->nombre_item = $item->nombre;
            $resultado->puntos = $item->valor;
            $resultado->foto_item = $item->foto;
        } else {
            //perdi
            $resultado->status = 'Not OK';
            $resultado->mensaje = 'Fallaste al atacar al monstruo';
        }
        /*
        select *
        from danio
        where idmonstruo=1
        and idpersonaje=1
        */
        //si es mayor
        //no sea mayor
        return $resultado;
    }

    function ataque_monstruo($idturno)
    {
        $resultado = new \stdClass();
        // $dados = tirar_dados($idturno);
        $dados = 2;
        switch ($dados) {
            case 2:
                $turno = Turno::find($idturno);
                //Muere
                //1.-cambiar el status del partidaxjugador
                //2.-cambiar los puntos de partidaxjugador en 0
                /*
                update partidaxjugador set puntos=0,
                status puntos=0, status=0
                where idjugador=3 and idpartida=10
                */
                PartidaxJugador::where('idjugador', $turno->idjugador)
                    ->where('idpartida', $turno->idpartida)
                    ->update(
                        [
                            'puntos' => 0,
                            'status' => 0
                        ]
                    );


                //3.-Eliminar los items del jugador en la partida
                ItemsJugador::where('idjugador', $turno->idjugador)
                    ->where('idpartida', $turno->idpartida)
                    ->delete();
                //delete from itemxjugador where idjugador=12 and idpartida=12
                //4.-terminar el turno
                $turno->status = 1;
                $turno->save();
                //5.-  que la partida pase al siguiente jugador
                $servicio_partida = new ServicioPartida();
                $servicio_partida->cambiar_turno($turno->idpartida);
                $resultado->mensaje = 'Haz muerto y haz perdido todo!!';

                break;

            case 7:
                //te salvaste
                $turno = Turno::find($idturno);
                $turno->status = 1;
                $turno->save();
                $servicio_partida = new ServicioPartida();
                $servicio_partida->cambiar_turno($turno->idpartida);
                $resultado->mensaje = 'Te salvaste!!';
                break;


            case 8:
                //Herido
                $turno = Turno::find($idturno);
                $turno->status = 1;
                $turno->save();
                //mis puntos ahora son 0
                PartidaxJugador::where('idjugador', $turno->idjugador)
                    ->where('idpartida', $turno->idpartida)
                    ->update(
                        [
                            'puntos' => 0,
                        ]
                    );
                //pierdo mis items
                ItemsJugador::where('idjugador', $turno->idjugador)
                    ->where('idpartida', $turno->idpartida)
                    ->delete();
                $servicio_partida = new ServicioPartida();
                $servicio_partida->cambiar_turno($turno->idpartida);
                $resultado->mensaje = 'Herido haz perdido todos tus items!!';
                break;
        }

        return $resultado;
    }
}
