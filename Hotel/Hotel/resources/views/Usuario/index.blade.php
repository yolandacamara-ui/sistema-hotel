  @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
  @section('titulo')
Usuario
  @endsection
  @section('contenido')
        <div class="row">
            <div class="col-md-12">
                <a href="{{ action([App\Http\Controllers\UsuarioController::class, 'formulario']) }}" class="btn btn-info">Agregar</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>Id</td>
                        <td>E-mail</td>
                        <td>Rol</td>
                    </tr>

                    @foreach($lista as $elemento)
                    <tr>
                        <td>{{$elemento->id}}</td>
                        <td><a href="{{ action([App\Http\Controllers\UsuarioController::class, 'formulario'], ['id' => $elemento->id]) }}"><!--este enlace lo va a llervar a el formulario. significa que va a usar el id del elemneto-->
                                {{$elemento->email}}</a>
                        </td>
                        <td>{{$elemento->rol}}</td> <!--si quiero ponerle el nombre del rol en vez del id, solo se le agrega el nombre y se le quita el id-->

                    </tr>
                    @endforeach

                </table>    
            </div>
        </div>
     @endsection