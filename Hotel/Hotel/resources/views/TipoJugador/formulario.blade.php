 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Tipo Jugador
 @endsection
 @section('contenido')

 <form action="{{ action([App\Http\Controllers\Tipo_JugadorController::class, 'save']) }}" method="POST">
     {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
     <input type="hidden" value="{{$tipo_jugador->id}}" name="id">

     <div class="form-group">
         <label for="exampleInputEmail1">Nombre</label>
         <input type="text" class="form-control" value="{{$tipo_jugador->nombre}}" name="nombre">
     </div>

     <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

     <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

 </form>
 @endsection('contenido')