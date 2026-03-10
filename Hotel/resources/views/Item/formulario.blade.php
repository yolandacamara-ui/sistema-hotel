 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Item
 @endsection
 @section('contenido')
 <form action="{{ action([App\Http\Controllers\ItemController::class, 'save']) }}" method="POST" enctype="multipart/form-data">
     {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
     <input type="hidden" value="{{$item->id}}" name="id">

     <div class="form-group">
         <label for="exampleInputEmail1">Nombre</label>
         <input type="text" class="form-control" value="{{$item->nombre}}" name="item">
     </div>

     <div class="form-group">
         <label for="exampleInputPassword1">Foto</label>
         <input type="file" class="form-control" name="foto"> <!--type="file" es para insertar el apartado en donde se insertara la imagen-->
     </div>

     <div class="form-group">
         <label for="exampleInputPassword1">Nivel</label>
         <input type="text" class="form-control" value="{{$item->nivel}}" name="nivel">
     </div>
     
     <div class="form-group">
         <label for="exampleInputPassword1">Valor</label>
         <input type="text" class="form-control" value="{{$item->valor}}" name="valor">
     </div>

     <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

     <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

 </form>

 @endsection