@extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Habitaciones
 @endsection
 @section('contenido')

<div class="container mt-3">

    <a href="{{ url('habitacion/formulario') }}" class="btn btn-info">Agregar Habitación</a>

    <table class="table mt-3">
        <tr>
            <td>ID</td>
            <td>Nombre</td>
            <td>Precio</td>
            <td>Tipo</td>
            <td>Foto</td>
        </tr>

        @foreach($lista as $elemento)
        <tr>
            <td>{{ $elemento->id }}</td>
            <td>
                <a href="{{ url('habitacion/formulario', $elemento->id) }}">
                    {{ $elemento->nombre }}
                </a>
            </td>
            <td>${{ $elemento->precio }}</td>
            <td>{{ $elemento->categoria }}</td>  
            <td>
                @if($elemento->foto != '')
                    <img src="{{ url('habitacion/foto/' . $elemento->foto) }}" width="100">
                @endif
            </td>
        </tr>
        @endforeach
    </table>

</div>

@endsection
