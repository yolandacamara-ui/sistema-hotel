 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Personajes
 @endsection
 @section('contenido')
 <form action="{{ action([App\Http\Controllers\PersonajesController::class, 'save']) }}" method="POST" enctype="multipart/form-data">
     {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
     <input type="hidden" value="{{$personaje->id}}" name="id">

     <div class="form-group">
         <label for="exampleInputEmail1">Nombre</label>
         <input type="text" class="form-control" value="{{$personaje->nombre}}" name="nombre">
     </div>

     <div class="form-group">
         <label for="exampleInputPassword1">Foto</label>
         <input type="file" class="form-control" name="foto"> <!--type="file" es para insertar el apartado en donde se insertara la imagen-->
     </div>


     <div class="form-group">
         <label for="exampleInputPassword1">Objetivo</label>
         <input type="text" class="form-control" value="{{$personaje->nivel}}" name="objetivo">
     </div>

     <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

     <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

 </form>

 @endsection