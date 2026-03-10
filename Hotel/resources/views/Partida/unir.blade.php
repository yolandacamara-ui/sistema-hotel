 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
Unir a la partida
 @endsection
 @section('contenido')
        <form action="{{ action([App\Http\Controllers\PartidaController::class, 'unir_partida']) }}" method="POST">
             {{csrf_field()}}  <!--sirve para proteger los formularios contra ataques, es un token -->
    
            <div class="form-group">
                <label for="exampleInputEmail1">Personaje</label>
                <select name="idpersonaje" class="form-control" id="">
                    @foreach($personajes as $personaje)
                    <option value="{{$personaje->id}}">{{$personaje->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Codigo</label>
                <input type="text" class="form-control" value="" name="codigo">
            </div>

            <input type="submit" name="operacion" value="Unir" class="btn btn-primary">
            
        </form>

     @endsection