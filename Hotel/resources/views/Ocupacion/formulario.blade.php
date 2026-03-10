 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
Ocupacion
 @endsection
 @section('contenido')
        <form action="{{ action([App\Http\Controllers\OcupacionController::class, 'save']) }}" method="POST">
             {{csrf_field()}}  <!--sirve para proteger los formularios contra ataques, es un token -->
            <input type="hidden" value="{{$ocupacion->id}}" name="id">
            
             <div class="form-group">
                <label for="exampleInputEmail1">Ocupacion</label>
                <input type="text" class="form-control" value="{{$ocupacion->nombre}}" name="ocupacion">
            </div>

            <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

            <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">
            
        </form>

    @endsection