<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Edad;
use App\Models\Cliente;
use App\Models\FormaPago;
use App\Models\Habitacion;
use App\Models\Ocupacion;
use App\Models\Servicios;
use App\Models\CategoriaServicios;
use App\Models\Reservacion;
use App\Servicios\ServicioOrdenHotel;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DbUpController extends Controller
{ 
    var $generos=array('Hombre','Mujer','Sin definir');
    var $canales=array('WEB','APP','KIOSKO','TIENDA');

    function cliente(){
        $faker = Faker::create();
        $edades=Edad::all();
        $ocupaciones=Ocupacion::all();
        for($i=1;$i<=10;$i++){
            $usuario=new Usuario();
            $usuario->idrol=2;
            $usuario->password=bcrypt('123456');
            $usuario->email=$faker->email;
            $usuario->save();

            $nombre=$faker->name;
            $apellido=$faker->lastname;

            $cliente=new Cliente();
            $cliente->idusuario=$usuario->id;
            $cliente->nombre=$nombre.' '.$apellido;
            $cliente->genero=$faker->randomElement($this->generos);
            $cliente->idedad=$edades->random()->id;
            $cliente->idocupacion=$ocupaciones->random()->id;
            $cliente->save();
        }
        
    }
    function orden(){
        $servicio = new ServicioOrdenHotel();
        $faker = Faker::create();
        $clientes = Cliente::all();
        $formas_pago = FormaPago::all();
        $habitaciones = Habitacion::all();
        $extras = Servicios::all(); // tabla de servicios/extras
        for($i=1; $i<=10; $i++){
            $x = new \stdClass();
            $x->canal = $faker->randomElement($this->canales);
            $x->fecha = $faker->dateTimeBetween('-1 year', 'now');
            $x->idcliente = $clientes->random()->id;
            $x->idforma_pago = $formas_pago->random()->id;
            $x->productos = array();

            //Dame un numero aleatorio que represente 
            //El numero de productos que va a tener la orden
            $num_habitacion = $faker->numberBetween(1, count($habitaciones));
            $lista_productos = $habitaciones->random($num_habitacion);
            //faker que me obtenga un N habitaciones de forma aleatoria
            foreach($lista_productos as $p1){
                $check_in = $faker->dateTimeBetween('-1 year', 'now');
                $noches = $faker->numberBetween(1,5);
                $check_out = (clone $check_in)->modify("+$noches days");

                $extra = [];
                // número aleatorio de extras para esta habitación
                $num_extras = $faker->numberBetween(0,3);
                if($num_extras > 0){
                    $lista_extra = $extras->random($num_extras);
                    foreach($lista_extra as $ext){
                        $cant_extra = $faker->numberBetween(1,3);
                        $extra[] = [
                        "id" => $ext->id,
                        "cantidad" => $cant_extra,
                        "precio" => $ext->precio * $cant_extra
                        ];
                    }
                }

                $x->productos[] = [
                    "id" => $p1->id,
                    "num_noches" => $noches,
                    "precio" => $p1->precio,
                    "check_in" => $check_in,
                    "check_out" => $check_out,
                    "extras" => $extra
                ];
            }

            $servicio->registrar($x);
        }
    }

    
}
