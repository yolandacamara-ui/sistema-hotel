 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Felicidades ganaste
 @endsection
 @section('contenido')
 <div class="row">
     <div class="col-md-12">
         Haz ganado {{$item}}
         <br>
         Este vale {{$puntos}}
         <div class="row">
             <img class="img-responsive img-circle" alt="" src="{{ action([App\Http\Controllers\ItemController::class, 'mostrar_foto'], ['archivo' => $foto_item]) }}">
         </div>
     </div>
 </div>

 @endsection