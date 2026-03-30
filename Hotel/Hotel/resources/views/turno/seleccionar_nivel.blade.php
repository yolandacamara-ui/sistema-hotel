 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Selecciona el nivel del mounstruo
 @endsection
 @section('contenido')
 <div class="row">
     <div class="col-md-12">
         <form action="{{ action([App\Http\Controllers\PartidaController::class, 'iniciar_turno_nivel']) }}" method="POST">
             {{csrf_field()}}
             <input type="hidden" name="idpartida" value="{{$idpartida}}"> 
             <select name="idnivel" class="form-control" id="">
                 <option value="1">1</option>
                 <option value="2">2</option>
                 <option value="3">3</option>
                 <option value="4">4</option>
                 <option value="5">5</option>
                 <option value="6">6</option>
                 <option value="0">Cualquier nivel</option>
             </select>
             <button class="btn btn-info">Iniciar turno</button>
        </form>
     </div>
 </div>

 @endsection