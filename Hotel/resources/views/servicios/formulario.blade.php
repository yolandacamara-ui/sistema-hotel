@extends('app.master')<!--le esta indicando donde se va a dirigir esta vista-->
 @section('titulo')
 Servicios
 @endsection
 @section('contenido')

<div class="container mt-3">

<form action="{{ url('servicios/save') }}" method="post">
    {{ csrf_field() }}

    <input type="hidden" name="id" value="{{ $servicio->id }}">

    <div class="form-group mt-2">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $servicio->nombre) }}" required>
    </div>

    <div class="form-group mt-2">
        <label>Categoría</label>
        <select name="idcategoria_servicios" class="form-control" required>
            <option value="">-- Seleccione una categoría --</option>
            @foreach($categorias as $c)
                <option value="{{ $c->id }}" {{ old('idcategoria_servicios', $servicio->idcategoria_servicios) == $c->id ? 'selected' : '' }}>
                    {{ $c->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-2">
        <label>Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $servicio->precio) }}" required>
    </div>

    <input type="submit" name="operacion" value="{{ $operacion }}" class="btn btn-primary mt-3">
    @if($servicio->id)
        <input type="submit" name="operacion" value="Eliminar" class="btn btn-danger mt-3" onclick="return confirm('¿Desea eliminar este servicio?');">
    @endif

</form>

</div>

@endsection
