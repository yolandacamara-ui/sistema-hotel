@extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Servicios
 @endsection
 @section('contenido')

<div class="container mt-3">

    <a href="{{ url('servicios/formulario') }}" class="btn btn-info">Agregar Servicio</a>

    <table class="table mt-3">
        <tr>
            <td>ID</td>
            <td>Nombre</td>
            <td>Categoría</td>
            <td>Precio</td>
        </tr>

        @foreach($lista as $elemento)
        <tr>
            <td>{{ $elemento->id }}</td>
            <td>
                <a href="{{ url('servicios/formulario', $elemento->id) }}">
                    {{ $elemento->nombre }}
                </a>
            </td>
            <td>{{ $elemento->categoria->nombre ?? '' }}</td>
            <td>${{ $elemento->precio }}</td>
        </tr>
        @endforeach
    </table>

</div>

@endsection

