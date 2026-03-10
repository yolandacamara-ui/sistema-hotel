 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Hubo un error al unirte a la partida @endsection
 @section('contenido')
 <div class="row">
   <div class="col-md-12">
     {{$mensaje}}
   </div>
 </div>

 @endsection