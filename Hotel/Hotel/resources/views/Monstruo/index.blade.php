 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Monstruo
 @endsection
 @section('contenido')
 <div class="row">
     <div class="col-md-12">
         <a href="{{ action([App\Http\Controllers\MonstruoController::class, 'formulario']) }}" class="btn btn-info">Agregar</a>
     </div>
 </div>
 <div class="row">
     <div class="col-md-12">
         <table class="table">
             <tr>
                 <td>Id</td>
                 <td>Monstruo</td>
                 <td>Foto</td>
                 <td>Nivel</td>
             </tr>

             @foreach($lista as $elemento)
             <tr>
                 <td>{{$elemento->id}}</td>
                 <td><a href="{{ action([App\Http\Controllers\MonstruoController::class, 'formulario'], ['id' => $elemento->id]) }}"><!--este enlace lo va a llervar a el formulario. significa que va a usar el id del elemneto-->
                         {{$elemento->nombre}}</a>
                 </td>
                 <td>
                     @if($elemento->foto!='')
                     <img width="100" class="img-responsive img-circle" src="{{ action([App\Http\Controllers\MonstruoController::class, 'mostrar_foto'], ['archivo' => $elemento->foto]) }}" alt="">
                     @endif
                 </td>

                 <td>{{$elemento->idnivel}}</td>
             </tr>
             @endforeach

         </table>
     </div>
 </div>
 @endsection