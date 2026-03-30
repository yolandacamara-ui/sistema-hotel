@extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Categoria Habitacion
 @endsection
 @section('contenido')

<div class="container mt-3">

<form action="{{ url('categoria_habitacion/save') }}" method="post">
    {{ csrf_field() }}

    <input type="hidden" name="id" value="{{ $categoria->id }}">

    <div class="form-group mt-2">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}">
    </div>

    <input type="submit" name="operacion" value="{{ $operacion }}" class="btn btn-primary mt-3">
    <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger mt-3">

</form>

</div>

@endsection

