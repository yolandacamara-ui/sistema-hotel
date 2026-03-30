 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Tipo Jugador
 @endsection
 @section('contenido')
            <form action="{{ action([App\Http\Controllers\UsuarioController::class, 'save']) }}" method="POST">
                {{csrf_field()}} <!--sirve para proteger los formularios contra ataques, es un token -->
                <input type="hidden" name="operacion" value="{{ $operacion }}">
                <input type="hidden" value="{{$usuario->id}}" name="id">

                <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="text" class="form-control" value="{{$usuario->email}}" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" value="{{$usuario->password}}" name="password">
                </div>


                 <div class="form-group">
                <label for="exampleInputPassword1">Rol</label>
                <select name="idrol" class="form-control">
                    @foreach ($roles as $rol)
                    <option value="{{$rol->id}}"{{ $usuario->idrol == $rol->id ? 'selected' : '' }} >{{$rol->nombre}}</option>
                    @endforeach
                </select>
            </div>


                

                <input type="submit" name="operacion" value="{{$operacion}}" class="btn btn-primary">

                <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger">

            </form>
             @endsection