@extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Categoria Servicios
 @endsection
 @section('contenido')

<div class="container mt-3">

    <a href="{{ url('categoria_servicios/formulario') }}" class="btn btn-info">Agregar Categoría</a>

    <table class="table mt-3">
        <tr>
            <td>ID</td>
            <td>Nombre</td>
        </tr>

        @foreach($lista as $elemento)
        <tr>
            <td>{{ $elemento->id }}</td>
            <td>
                <a href="{{ url('categoria_servicios/formulario', $elemento->id) }}">
                    {{ $elemento->nombre }}
                </a>
            </td>
        </tr>
        @endforeach
    </table>

</div>
@endsection

