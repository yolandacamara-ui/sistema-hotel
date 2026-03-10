@extends('app.master')
@section('titulo')
Detalles de la partida
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-12">

        <table class="table">
            <tr>
                <td>Jugador</td>
                <td>Personajes</td>
                <td>Puntos</td>
            </tr>

            @foreach($detalle_partida as $elemento)
            <tr>
                <td>{{$elemento->jugador}}</td>
                <td>{{$elemento->personaje}}</td>
                <td>{{$elemento->puntos}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection