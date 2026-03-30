 @extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Asi te fue con el monstruo
 @endsection
 @section('contenido')
 <div class="row">
     <div class="col-md-12">
         {{$mensaje}}
        <br>
     </div>
 </div>

 @endsection