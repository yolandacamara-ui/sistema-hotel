 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Jugador
 @endsection
 @section('contenido')

 <form action="{{ action([App\Http\Controllers\JugadorController::class, 'save']) }}" method="POST" enctype="multipart/form-data"><!--se le pone multipart porque son dos paquetes de informacion (se enviara texto y archivo)-->
     {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
     <input type="hidden" value="{{$jugador->id}}" name="id">

     <div class="form-group">
         <label for="exampleInputEmail1">Nombre</label>
         <input type="text" class="form-control" value="{{$jugador->nombre}}" name="nombre">
     </div>
     <div class="form-group">
         <label for="exampleInputPassword1">Puntos</label>
         <input type="text" class="form-control" value="{{$jugador->puntos}}" name="puntos">
     </div>

     <div class="form-group">
         <label for="exampleInputPassword1">Tipo</label>
         <select name="tipo" class="form-control">
             @foreach ($tipos as $tipo)
             <option value="{{$tipo->id}}">
                 {{$tipo->nombre}}
             </option>
             @endforeach
         </select>
     </div>


     <div class="form-group">
         <label for="exampleInputPassword1">Edad</label>
         <select name="edad" class="form-control">
             @foreach ($edades as $edad)
             <option value="{{$edad->id}}">{{$edad->nombre}}</option>
             @endforeach
         </select>
     </div>


     <div class="form-group">
         <label for="exampleInputPassword1">Foto</label>
         <input type="file" class="form-control" name="foto"> <!--type="file" es para insertar el apartado en donde se insertara la imagen-->
     </div>


     <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

     <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

 </form>

  @endsection('contenido')