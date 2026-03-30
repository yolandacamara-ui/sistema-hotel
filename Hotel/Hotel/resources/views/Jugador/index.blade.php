  @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
  @section('titulo')
  Jugador
  @endsection
  @section('contenido')

  <div class="row">
      <div class="col-md-12">
          <a href="{{ action([App\Http\Controllers\JugadorController::class, 'formulario']) }}" class="btn btn-info">Agregar</a>
      </div>
  </div>


  <div class="row">
      <div class="col-md-12">
          <table class="table">
              <tr>
                  <td>Id</td>
                  <td>Nombre</td>
                  <td>Puntos</td>
                  <td>Tipo</td>
                  <td>Edad</td>
                  <td>Foto</td>
              </tr>

              @foreach($lista as $elemento)
              <tr>
                  <td>{{$elemento->id}}</td>
                  <td><a href="{{ action([App\Http\Controllers\JugadorController::class, 'formulario'], ['id' => $elemento->id]) }}"><!--este enlace lo va a llervar a el formulario. significa que va a usar el id del elemneto-->
                          {{$elemento->nombre}}</a>
                  </td>
                  <td>{{$elemento->puntos}}</td>
                  <td>{{$elemento->tipo}}</td>
                  <td>{{$elemento->edad}}</td>
                  <td>
                      @if($elemento->foto!='')
                      <img width="100" class="img-responsive img-circle" src="{{ action([App\Http\Controllers\JugadorController::class, 'mostrar_foto'], ['archivo' => $elemento->foto]) }}" alt="">
                      @endif
                  </td>


              </tr>
              @endforeach

          </table>
      </div>
  </div>
  @endsection('contenido')