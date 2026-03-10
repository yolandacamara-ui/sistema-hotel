<?php
namespace App\Servicios;

use App\Models\Orden;
use App\Models\Reservacion;
use App\Models\ServicioOrden;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServicioKPI
{
    /*
    K key
    P performance
    I Indicador
     */

    /*
    Consulta base es

    SELECT SUM(orden.total)
    FROM orden
    WHERE fecha>=DATE_SUB(now(), INTERVAL 3 MONTH) 
    ORDER by fecha DESC
     */
    function total_ventas($objeto){
        if(!isset($objeto->tendencias)){
            $objeto->tendencias=false;
        }
        //1. definir la consulta base
        $consulta=DB::table('orden')
                ->select(
                    DB::RAW("SUM(orden.total) as total")
                )
                ->whereRaw("fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)");
        //2. Configurar la consulta base
        if($objeto->tendencias){
            $consulta->addSelect(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y') as fecha"))
                    ->groupBy(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y')"))
                    ->orderByRaw("DATE_FORMAT(orden.fecha, '%m-%Y')");
        }
        //3, Obtener la informacion
        return $consulta->get(); // quiero obtener todo
    }

    //--------------------CANAL
    /*
    CONSULTA BASE
    select sum(orden.total) as total, orden.canal   
    from orden
    where orden.fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)
    GROUP by orden.canal
    ORDER by sum(orden.total);
     */
    function total_ventas_canal($objeto){
        if(!isset($objeto->tendencias)){
            $objeto->tendencias=false;
        }
        //1. definir la consulta base
        $consulta=DB::table('orden')
                ->select(
                    DB::RAW("SUM(orden.total) as total")
                    ,"orden.canal"
                )
                ->whereRaw("fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)")
                ->groupBy("orden.canal")
                ->orderByRaw("sum(orden.total)");

        //2. Configurar la consulta base
        if($objeto->tendencias){
            $consulta->addSelect(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y') as fecha"))
                    ->groupBy(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y')"))
                    ->orderByRaw("DATE_FORMAT(orden.fecha, '%m-%Y')");
        }
        //3. obtener la informacion
        return $consulta->get();
    }

    /*
    select sum(reservacion.precio*reservacion.num_noches) as total, categoria_habitacion.nombre
        from orden
        JOIN reservacion on reservacion.idorden = orden.id
        JOIN habitacion on reservacion.idhabitacion = habitacion.id
        JOIN categoria_habitacion on habitacion.tipo = categoria_habitacion.id
        where orden.fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)
        GROUP by categoria_habitacion.id
        ORDER by sum(reservacion.precio*reservacion.num_noches);
     */

    //function total_ventas_categoria_habitacion
    function total_ventas_categoria($objeto){
        if(!isset($objeto->idcategoria))//{
            $objeto->idcategoria=0;
            $consulta=DB::table('orden')
                        ->join('reservacion','reservacion.idorden','=','orden.id')
                        ->join('habitacion','reservacion.idhabitacion','=','habitacion.id')
                        ->join('categoria_habitacion','habitacion.tipo','=','categoria_habitacion.id')
                        ->whereRaw("orden.fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)")
                        ->groupBy("categoria_habitacion.id","categoria_habitacion.nombre")
                        ->select(
                            "categoria_habitacion.nombre",
                            "categoria_habitacion.id"
                            ,DB::RAW("sum(reservacion.precio*reservacion.num_noches) as total")
                        )
                        ->orderByRaw("sum(reservacion.precio*reservacion.num_noches) desc");
            if($objeto->idcategoria!=0){
                $consulta->addSelect(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y') as fecha"))
                ->groupBy(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y')"))
                //->where("categoria_habitacion.id",$objeto->idcategoria)
                ->orderByRaw("DATE_FORMAT(orden.fecha, '%m-%Y')");
            }
            return $consulta->get();
        }
    //}
    /*
    select sum(reservacion.precio*reservacion.num_noches) as total, habitacion.nombre
        from orden
        JOIN reservacion on reservacion.idorden = orden.id
        JOIN habitacion on reservacion.idhabitacion = habitacion.id
        where orden.fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)
        GROUP by habitacion.id
        ORDER by sum(reservacion.precio*reservacion.num_noches);
     */
    //function total_ventas_categoria_habitacion
    function total_ventas_producto($objeto){
        if(!isset($objeto->idproducto))//{
            $objeto->idproducto=0;
            $consulta=DB::table('orden')
                        ->join('reservacion','reservacion.idorden','=','orden.id')
                        ->join('habitacion','reservacion.idhabitacion','=','habitacion.id')
                        ->whereRaw("orden.fecha>=DATE_SUB(now(), INTERVAL 3 MONTH)")
                        ->groupBy("habitacion.id","habitacion.nombre")
                        ->select(
                            "habitacion.nombre"
                            ,DB::RAW("sum(reservacion.precio*reservacion.num_noches) as total")
                        )
                        ->orderByRaw("sum(reservacion.precio*reservacion.num_noches) desc");
            if($objeto->idproducto!=0){
                $consulta->addSelect(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y') as fecha"))
                ->groupBy(DB::RAW("DATE_FORMAT(orden.fecha, '%m-%Y')"))
                ->where("habitacion.id",$objeto->idproducto)
                ->orderByRaw("DATE_FORMAT(orden.fecha, '%m-%Y')");
            }
            return $consulta->get();
        }




}