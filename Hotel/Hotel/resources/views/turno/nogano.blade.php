 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Fallaste
 @endsection
 @section('contenido')
 <div class="row">
     <div class="col-md-12">
      Ahora te va a atacar el enemigo
      <form action="{{ action([App\Http\Controllers\PartidaController::class, 'ataque_monstruo']) }}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="idturno" value="{{$idturno}}">
        <button class="btn btn-danger">Ataque del monstruo</button>
        
      </form>
     </div>
 </div>

 @endsection