<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Habitacion2Controller extends Controller
{
    public function obtenerHabitaciones()
    {
        $habitaciones = DB::table('habitacion')
            ->select(
                'id as id_item',
                'nombre',
                'precio',
                'tipo',
                'foto as imagen'
            )
            ->get();

        return response()->json([
            'item' => $habitaciones
        ]);
    }
}
