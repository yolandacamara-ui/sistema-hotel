 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Bienvenido
 @endsection
 @section('contenido')
 <!--boton de crear partida-->
 <div class="row">
     <div class="col-md-4">
         <a href="{{ action([App\Http\Controllers\PartidaController::class, 'formulario']) }}" class="btn btn-info">Crear partida</a>
     </div>



     <!--boton de unir partida-->

     <div class="col-md-4">
         <a href="{{ action([App\Http\Controllers\PartidaController::class, 'formulario_unir']) }}" class="btn btn-default">Unir partida</a>
     </div>
 </div>

 <div class="row">
     <div class="col-md-12">
         <table class="table">
             <tr>
                 <td>Partida</td>
                 <td>Personaje</td>
                 <td>Puntos</td>
                 <td>Turno actual</td>
                 <td>Jugador</td>
                 <td>Foto</td>
                 <td>Status</td>
                 <td>Detalles</td>
             </tr>
             @foreach($partidas as $elemento)
             <tr>
                 <td>{{$elemento->nombre}}</td>
                 <td>{{$elemento->personaje}}</td>
                 <td>{{$elemento->puntos}}</td>
                 <td>{{$elemento->turno}}</td>

                 <td>
                     @php
                     $jugador_turno = registro_datos($elemento->id, $elemento->turno);
                     @endphp

                     @if($elemento->turno == 0)
                     No se han asignado turnos
                     @elseif($jugador_turno)
                     {{ $jugador_turno->jugador }}
                     @endif
                 </td>

                 <td>
                     @if($elemento->turno == 0)
                     Vacío
                     @elseif($jugador_turno && $jugador_turno->foto)
                     <img src="{{ action([App\Http\Controllers\JugadorController::class, 'mostrar_foto'], ['archivo' => $jugador_turno->foto]) }}"
                         alt="Foto" width="150">
                     @else
                     No hay foto
                     @endif
                 </td>

                 <td>
                     @if($elemento->status==0)
                     <form action="{{ action([App\Http\Controllers\PartidaController::class, 'iniciar_partida']) }}" method="POST">
                         {{csrf_field()}}
                         <input type="hidden" name="idpartida" value="{{$elemento->id}}">
                         <button type="submit" class="btn btn-warning">Iniciar partida</button>
                     </form>
                     @else
                     @if($elemento->status==1)
                     <form action="{{ action([App\Http\Controllers\PartidaController::class, 'iniciar_turno']) }}" method="POST">
                         {{csrf_field()}}
                         <input type="hidden" name="idpartida" value="{{$elemento->id}}">
                         <button type="submit" class="btn btn-success">Iniciar turno</button>
                     </form>
                     @else
                     Ya termino

                     @endif
                     @endif
                 </td>
                 
                 <td>
                     <form action="{{ action([App\Http\Controllers\PartidaController::class, 'detalle_partida']) }}" method="POST">
                         {{csrf_field()}}
                         <input type="hidden" name="idpartida" value="{{$elemento->id}}">
                         <button type="submit" class="btn btn-info">Detalles</button>
                     </form>
                     

                 </td>
             </tr>
             @endforeach
         </table>
     </div>
 </div>
 @endsection('contenido')