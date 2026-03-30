 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
Hubo un problema al iniciar tu turno
@endsection
 @section('contenido')
      <div class="row">
        <div class="col-md-12">
            {{$mensaje}}
        </div>
      </div>

     @endsection