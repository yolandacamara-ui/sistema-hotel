 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Crear partida
 @endsection
 @section('contenido')
 <form action="{{ action([App\Http\Controllers\PartidaController::class, 'crear_partida']) }}" method="POST">
     {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
     <input type="hidden" value="{{$partida->id}}" name="id">

     <div class="form-group">
         <label for="exampleInputEmail1">Nombre</label>
         <input type="text" class="form-control" value="{{$partida->nombre}}" name="nombre">
     </div>

     <div class="form-group">
         <label for="exampleInputPassword1">Personaje</label>
         <select name="idpersonaje" class="form-control">
             @foreach($personajes as $personaje)
             <option value="{{$personaje->id}}">{{$personaje->nombre}}</option>
             @endforeach
         </select>
     </div>

     <div class="form-group">
         <label for="exampleInputEmail1">Codigo</label>
         <input type="text" class="form-control" value="{{$partida->codigo}}" name="codigo">
     </div>

     <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

     <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

 </form>

 @endsection