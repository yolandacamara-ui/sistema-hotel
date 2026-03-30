<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarritoController extends Controller
{
    public function recibirCarrito(Request $request)
    {
        $pedido = $request->json()->all();

        if(isset($pedido['productos'])){
            
            Storage::put('carrito_temporal.json', json_encode($pedido));

            return response("1",200);
        }

        return response("0",400);
    }

    public function verCarrito()
    {
        $carrito = [];
        $total = 0;

        if(Storage::exists('carrito_temporal.json')){
            $json = Storage::get('carrito_temporal.json');
            $pedido = json_decode($json,true);

            if(isset($pedido['productos'])){
                $carrito = $pedido['productos'];
            }
        }

        return view('carrito', compact('carrito','total'));
    }
} 