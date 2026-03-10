<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaHabitacion;
use App\Models\Habitacion;
//use App\Models\Tamanio;
use App\Models\Servicios;
use App\Models\CategoriaServicios;
use App\Servicios\ServicioOrdenHotel;
use Illuminate\Support\Facades\DB; // arriba del archivo

class HotelController extends Controller
{
   function index(){
     $datos=array();
     // $datos['tipos']=array();
     // $z1=new \StdClass();
     //$z1->id=1;
     // $z1->nombre='Espresso Drinks';
     // $datos['tipos'][]=$z1;

     // $z2=new \StdClass();
     // $z2->id=2;
     // $z2->nombre='Brewed Coffee';
     // $datos['tipos'][]=$z2;

     // $z3=new \StdClass();
     // $z3->id=3;
     // $z3->nombre='Teas';
     // $datos['tipos'][]=$z3;
     $datos['tipos']=CategoriaHabitacion::all();                 //Unicamente aqui le cambie los nombres
     $datos['extras']=Servicios::all();                                // categoria=CategoriaHabitacion
     $datos['categoria_extras']=CategoriaServicios::all();             // productos=Habitacion 
                                                                       // categoria_extras= categoria servicios
      return view('punto_venta')->with($datos);                        // extra= servicios 
   }

   function habitaciones(){
      $habitaciones=array();
      //$z1=new \StdClass();
      //$z1->id=1;
      //$z1->nombre='Cappuccino';
      //$z1->precio=86.00;
      //$z1->tipo='1';
      //$z1->descripcion='Espresso with steamed milk and a thick layer of foam. Customize';
      //$z1->foto='https://lh3.googleusercontent.com/aida-public/AB6AXuB-kx8RqRq6TTowLOLB_6hz7FmsI3vlW8ix5KmRmuQAKEc7ta8u1tC7Lkd9R6FQlibxXjfNHUdA_ZIZQy3muAmtrMJrq_u7wRrt_J0GHw7RXhkkZzQbbVPy8C5iRCGNIWJxObJ9W37bxAxDb48B1JoCLAuTCxlQuXHEK44CqlrIXC-26tO3Uxd6QWZxUj9Tr8vKCPqrtI-13LMMTXPUWtAoBYoyd_SuE_ucJ_fsTKEyo3IULYvoyA3gzIBFd3Ewa50n7jIswXT0jzQ';

      //$z2=new \StdClass();
      //$z2->id=1;
      //$z2->nombre='Americano';
      //$z2->precio=75.00;
      //$z2->tipo='2';
      //$z2->descripcion='Espresso with steamed milk and a thick layer of foam. Customize';
      //$z2->foto='https://i.pinimg.com/736x/f4/18/32/f41832c748b12857ebf05a71eed68843.jpg';
      
      //$productos[]=$z1;
      //$productos[]=$z2;
      $habitaciones=Habitacion::all();
      return response()->json($habitaciones);
         }



      //function tamanios(){
     // $tamanios=array();
      //$z1=new \StdClass();
      //$z1->id=1;
      //$z1->nombre='Mediano';
      //$z2=new \StdClass();
      //$z2->id=2;
      //$z2->nombre='Large';
      //$z3=new \StdClass();
      //$z3->id=3;
      //$z3->nombre='Venti';
      //$tamanios[]=$z1;
      //$tamanios[]=$z2;
      //$tamanios[]=$z3;
     // $tamanios=Tamanio::all();
     // return response()->json($tamanios);
   //}

    /*
    function guardar_orden(Request $r){

    $servicio = new ServicioOrden();
    $x = new \stdClass();
    $x->productos = $r->input('productos'); // Se obtiene del request el campo 'productos' y se asigna al objeto $x
    $x->canal = 'APP';  // Se agrega un valor fijo indicando que la orden proviene del canal APP
    $servicio->registrar($x); // Se llama al método registrar() del servicio y se le envía el objeto con los datos

        return response()->json($r->all());
    }
    */
    //function guardar_orden(Request $r){
    //     return response()->json($r->all());
    //  }
    function guardar_orden(Request $r){
    $context = $r->all();
    // dd($context);

    $servicio = new ServicioOrdenHotel();
    $x = new \stdClass();
    $x->productos = $context; 
    $x->canal = 'APP';
    $servicio->registrar($x);

    return response()->json(['ok'=>true]);
    }



   /*public function validarDisponibilidad(Request $request)
{
    // Validación mínima
    if ($request->check_in >= $request->check_out) {
        return response()->json([
            'disponible' => false
        ]);
    }

    // Aquí después iría la lógica real con reservas

    //simulamos que sí hay disponibilidad
    return response()->json([
        'disponible' => true
    ]);
}*/



public function validarDisponibilidad(Request $request)
{
    $request->validate([
        'habitacion_id' => 'required|integer',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
    ]);

    $idhabitacion = $request->habitacion_id;
    $checkin  = $request->check_in;
    $checkout = $request->check_out;

    $reservas = DB::table('reservacion')
        ->select(
            'reservacion.id',
            'reservacion.idhabitacion',
            'reservacion.checkin',
            'reservacion.checkout'
        )
        ->where('reservacion.idhabitacion', $idhabitacion)
        ->where('reservacion.checkin', '<', $checkout)
        ->where('reservacion.checkout', '>', $checkin)
        ->get();

    return response()->json([
        'disponible' => $reservas->isEmpty(),
        'cruces' => $reservas // opcional para debug
    ]);
}


}