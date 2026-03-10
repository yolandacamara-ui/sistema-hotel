 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Monstruo
 @endsection
 @section('contenido')
 <form action="{{ action([App\Http\Controllers\MonstruoController::class, 'save']) }}" method="POST" enctype="multipart/form-data">
     {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
     <input type="hidden" value="{{$monstruo->id}}" name="id">

     <div class="form-group">
         <label for="exampleInputEmail1">Nombre</label>
         <input type="text" class="form-control" value="{{$monstruo->nombre}}" name="nombre">
     </div>

     <div class="form-group">
         <label for="exampleInputPassword1">Foto</label>
         <input type="file" class="form-control" name="foto"> <!--type="file" es para insertar el apartado en donde se insertara la imagen-->
     </div>


     <div class="form-group">
         <label for="exampleInputPassword1">Nivel</label>
         <input type="text" class="form-control" value="{{$monstruo->nivel}}" name="nivel">
     </div>

     <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

     <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

 </form>

 @endsection