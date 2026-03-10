 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Felicidades haz iniciado tu turno
 @endsection
 @section('contenido')
 <div class="row">
   <div class="col-md-12">
     Ahora te toca luchar contra {{$monstruo}}
     <br>
     <div class="row">
       <img class="img-responsive img-circle" alt="" src="{{ action([App\Http\Controllers\MonstruoController::class, 'mostrar_foto'], ['archivo' => $foto_monstruo]) }}">

     </div>

     <br>
     Para matarlo necesitas {{$danio}}


     <br>
     <form action="{{ action([App\Http\Controllers\PartidaController::class, 'atacar']) }}" method="POST">
       {{csrf_field()}}
       <input type="hidden" name="idturno" value="{{$idturno}}">
       <button type="submit" class="btn btn-success">Tirar dados</button>
     </form>
   </div>
 </div>

 @endsection