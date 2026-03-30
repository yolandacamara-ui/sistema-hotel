<?php
namespace App\Servicios;

use App\Models\Orden;
use App\Models\Reservacion;
use App\Models\ServicioOrden;
use Carbon\Carbon;

class ServicioOrdenHotel
{
    /*
    El objeto va a tener 
    fecha(opcional) con valor default hoy()
    canal(opcional) con valor default WEB
    productos la lista de habitaciones con fechas y servicios
    */
    function registrar($objeto){
        $orden = new Orden();

        if(isset($objeto->fecha))
            $orden->fecha = $objeto->fecha;
        else
            $orden->fecha = hoy();

        $orden->status = 1;
        $orden->total = 0;
        $orden->num_habitacion = 0;

        if(isset($objeto->canal))
            $orden->canal = $objeto->canal;
        else
            $orden->canal = 'WEB';

        if(isset($objeto->idcanal))
            $orden->idcanal = $objeto->idcanal;
        else
            $orden->idcanal = 0;

        if(isset($objeto->idcliente))
            $orden->idcliente = $objeto->idcliente;
        else
            $orden->idcliente = 0;

        if(isset($objeto->idvendedor))
            $orden->idvendedor = $objeto->idvendedor;
        else
            $orden->idvendedor = 0;

        if(isset($objeto->idforma_pago))
            $orden->idforma_pago = $objeto->idforma_pago;
        else
            $orden->idforma_pago = 2;

        $orden->save();

        $total = 0;
        $num_habitacion = 0;

        // Insertar en la tabla reservacion
        foreach($objeto->productos as $elemento){

            //Tomo el texto de la fecha de check_in y check_out
            //Lo convierto a un objeto de fecha usando Carbon para poder restar fechas
            $checkin  = Carbon::parse($elemento['check_in']);
            $checkout = Carbon::parse($elemento['check_out']);
            //Calcula cuántos noches hay entre la fecha de entrada y la fecha de salida.
            //Y guarda ese número en la variable $noches.
            $noches = $checkin->diffInDays($checkout);

            $detalle = new Reservacion();
            $detalle->idorden = $orden->id;
            $detalle->idhabitacion = $elemento['id']; //Guardo qué habitación se está reservando
            $detalle->num_noches = $noches; //Guardo cuántas noches se va a quedar
            $detalle->precio = $elemento['precio']; //Guardo el precio por noche de la habitación
            $detalle->checkin = $elemento['check_in']; //Guardo la fecha de entrada
            $detalle->checkout = $elemento['check_out']; //Guardo la fecha de salida

            if(isset($elemento['iddescuento'])) //Si esta habitación tiene descuento
                $detalle->iddescuento=$elemento['iddescuento']; //Guardo el descuento que venga
            else
                $detalle->iddescuento=0; //Si no trae descuento, pongo 0
            $detalle->save();

            // Total por habitación
            //Sumo al total el costo de esta habitación, Multiplico
            //precio por noche × número de noches y lo agrego al total general.
            $total = $total + ($detalle->precio * $detalle->num_noches);
            //No importa cuántas noches tenga, cada vuelta del foreach cuenta como una habitación más.
            $num_habitacion = $num_habitacion + 1;


            // Insertar servicios extra por habitación
            if(isset($elemento['extras'])){ ////Primero reviso si existe la lista de extras, si no hay extras, me salto todo este bloque.
                foreach($elemento['extras'] as $extra){ //Recorro uno por uno los extras
                    $extra_o = new ServicioOrden();
                    $extra_o->idreservacion = $detalle->id; //Relaciono este servicio extra con la reservación de la habitación
                    $extra_o->idservicio = $extra['id']; //Guardo qué servicio es

                    if(isset($extra['cantidad'])) //Si el servicio extra trae cantidad. Ej: 2 desayunos, 3 accesos al spa
                        $extra_o->cantidad = $extra['cantidad']; //Guardo esa cantidad
                    else
                        $extra_o->cantidad = 1; //Si no viene cantidad, asumo que es 1 por defecto. Ej: 1 desayuno, 1 transporte, etc

                    $extra_o->precio = $extra['precio']; //Guardo el precio del servicio extra (por unidad)
                    $extra_o->save();

                    /*Sumo el costo de este servicio extra al total general. Multiplico
                    precio del servicio × cantidad y lo agrego al total de la orden. */
                    $total = $total + ($extra_o->precio * $extra_o->cantidad);
                }
            }
        }

        $orden->total = $total; //Guardo el total final de la orden (habitaciones + extras).
        $orden->num_habitacion = $num_habitacion; //Guardo cuántas habitaciones se reservaron en total
        $orden->save(); //Guardo la orden ya completa en la base de datos

        return $orden;
    }
}
