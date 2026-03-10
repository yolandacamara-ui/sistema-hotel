@extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Habitaciones
 @endsection
 @section('contenido')


<div class="container mt-3">
    <form action="{{ url('habitacion/save') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}

        <input type="hidden" name="id" value="{{ $habitacion->id }}">

        <div class="form-group mt-2">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $habitacion->nombre }}">
        </div>

        <div class="form-group mt-2">
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="{{ $habitacion->precio }}">
        </div>

        <div class="form-group mt-2">
            <label>Tipo</label>
            
         <select name="tipo" class="form-control">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ $habitacion->tipo == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
        </select>

        </div>

        <div class="form-group mt-2">
            <label>Foto</label>
            <input type="file" class="form-control" name="foto">
        </div>

        <input type="submit" name="operacion" value="{{ $operacion }}" class="btn btn-primary mt-3">
        <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger mt-3">
    </form>
</div>

@endsection