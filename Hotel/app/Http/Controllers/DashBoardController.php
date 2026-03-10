<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Servicios\ServicioOrdenHotel;
use App\Servicios\ServicioKPI;
use App\Models\CategoriaHabitacion;
//use Faker\Factory as Faker;

class DashBoardController extends Controller
{
    function index(){
        $datos=array();
        $datos['canales']=array('WEB','APP','KIOSKO','TIENDA');
        $datos['categorias']=CategoriaHabitacion::all();
        return view('dashboard.index')->with($datos);
    }

    function total_ventas(){
        $servicio=new ServicioKPI();
        $x=new \StdClass();
        $info=$servicio->total_ventas($x);
        //dd($info); aqui vemos la informacion en array de total de ventas sin tendecias
        $y=new \StdClass();
        $y->tendencias=true;
        $info2=$servicio->total_ventas($y);
        //dd($info2); aqui vemos la informacion en array de total de ventas con tendecias
        $resultado=new \stdClass();
        $resultado->total=$info[0]->total;
        $resultado->tendencias=$info2;
        return response()->json($resultado);
    }

    function total_canal(){
        $servicio=new ServicioKPI();
        $x=new \StdClass();
        $info=$servicio->total_ventas_canal($x); // voy a llamar a total_ventas_canal que esta en servicioKPI
        $y=new \StdClass();
        $y->tendencias=true;
        $info2=$servicio->total_ventas_canal($y);
        //dd($info2);
        $resultado=new \stdClass();
        $resultado->canales=$info;
        $resultado->tendencias=$info2;
        return response()->json($resultado);
    }

    function total_categorias(){
        $servicio=new ServicioKPI();
        $x=new \StdClass();
        $info=$servicio->total_ventas_categoria($x);
        //dd($info[count($info)-1]); //aqui vemos la informacion en array de total de ventas sin tendecias
        $y=new \StdClass();
        $y->idcategoria=2;
        //$y->tendencias=true;
        $info2=$servicio->total_ventas_categoria($y);
        //dd($info2);
        $resultado=new \StdClass();
        $resultado->top=$info[0];
        $resultado->bottom=$info[count($info)-1];
        $resultado->categorias=$info;
        $resultado->tendencias=$info2;
        return response()->json($resultado);
    }

    function total_productos(){
        $servicio=new ServicioKPI();
        $x=new \StdClass();
        $info=$servicio->total_ventas_producto($x);
        //dd($info[count($info)-1]); //aqui vemos la informacion en array de total de ventas sin tendecias
        $y=new \StdClass();
        $y->idproducto=14;
        $info2=$servicio->total_ventas_producto($y);
        //dd($info2);
        $resultado=new \StdClass();
        $resultado->top=$info[0];
        $resultado->bottom=$info[count($info)-1];
        $resultado->productos=$info;
        $resultado->tendencias=$info2;
        return response()->json($resultado);
    }        

}
