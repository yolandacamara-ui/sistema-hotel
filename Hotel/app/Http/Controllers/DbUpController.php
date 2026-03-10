<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Edad;
use App\Models\Cliente;
use App\Models\FormaPago;
use App\Models\Habitacion;
use App\Models\Ocupacion;
use App\Servicios\ServicioOrdenHotel;
use Faker\Factory as Faker;

class DbUpController extends Controller
{
    var $generos=array('Hombre','Mujer','Sin definir');
    var $canales=array('WEB','APP','KIOSKO','TIENDA');
    function cliente(){
        $faker = Faker::create();
        $edades=Edad::all();
        $ocupaciones=Ocupacion::all();
        for($i=1;$i<=100;$i++){
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
        $servicio=new ServicioOrdenHotel();
        $faker = Faker::create();
        $clientes=Cliente::all();
        $formas_pago=FormaPago::all();
        $habitaciones=Habitacion::all();
        for($i=1;$i<=10;$i++){
            $x=new \stdClass();
            $x->canal=$faker->randomElement($this->canales);
            $x->fecha=$faker->dateTimeBetween($startDate='-1 year', $endDate='now');
            //$x->productos=array();
            $x->idcliente=$clientes->random()->id;
            $x->idforma_pago=$formas_pago->random()->id;
            $x->productos=array();

            //Dame un numero aleatorio que represente 
            //El numero de productos que va a tener la orden
            $num_habitacion=$faker->numberBetween(1,count($habitaciones));
            //faker que me obtenga un N habitaciones de forma aleatoria
            $lista_productos=$habitaciones->random($num_habitacion);
            foreach($lista_productos as $p1){
                $check_in = $faker->dateTimeBetween('-1 year', 'now');
                $noches   = $faker->numberBetween(1, 5);
                $check_out = (clone $check_in)->modify("+$noches days");

                $x->productos[]=[
                    "id"=>$p1->id,
                    "num_noches"=>$noches,
                    "precio"=>$p1->precio,
                    "check_in" => $check_in,
                    "check_out" => $check_out,
                    "extras"=>array()
                ];  
            }
            $servicio->registrar($x);
        }
        
    }
}
