  @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
  @section('titulo')
  Tipo Jugador
  @endsection
  @section('contenido')
  <div class="row">
      <div class="col-md-12">
          <a href="{{ action([App\Http\Controllers\Tipo_JugadorController::class, 'formulario']) }}" class="btn btn-info">Agregar</a>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12">
          <table class="table">
              <tr>
                  <td>Id</td>
                  <td>Nombre</td>
              </tr>

              @foreach($lista as $elemento)
              <tr>
                  <td>{{$elemento->id}}</td>
                  <td><a href="{{ action([App\Http\Controllers\Tipo_JugadorController::class, 'formulario'], ['id' => $elemento->id]) }}"><!--este enlace lo va a llervar a el formulario. significa que va a usar el id del elemneto-->
                          {{$elemento->nombre}}</a>
                  </td>
              </tr>
              @endforeach

          </table>
      </div>
  </div>
  @endsection('contenido')