 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
Roles
 @endsection
 @section('contenido')

        <form action="{{ action([App\Http\Controllers\RolesController::class, 'save']) }}" method="POST">
             {{csrf_field()}}  <!--sirve para proteger los formularios contra ataques, es un token -->
            <input type="hidden" value="{{$rol->id}}" name="id">
            
             <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" value="{{$rol->nombre}}" name="rol">
            </div>

            <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

            <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">
            
        </form>

     @endsection