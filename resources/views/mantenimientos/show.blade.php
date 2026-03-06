@extends('layouts.app')

@section('content')

<style>
    .titulo{
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 20px;
    letter-spacing: 1px;
    text-transform: uppercase;
}
.ficha{
    max-width:800px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.item{
    margin-bottom:10px;
}

.badge{
    background:#e3f2fd;
    color:#0f4c81;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
}

.acciones{
    margin-top:20px;
    display:flex;
    gap:10px;
}

.btn-editar{
    background:#0f4c81;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
}

.btn-volver{
    background:#6b7280;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
}
</style>

<div class="ficha">

    <h1 class="titulo">Mantenimiento #{{ $mantenimiento->id }}</h1>

    <div class="item"><strong>Equipo:</strong> {{ $mantenimiento->computadora->nombre_equipo ?? 'Sin equipo' }}</div>
    <div class="item"><strong>Tipo:</strong> {{ $mantenimiento->tipo }}</div>
    <div class="item"><strong>Fecha programada:</strong> {{ $mantenimiento->fecha_programada }}</div>

    <div class="item">
        <strong>Estado:</strong> 
        <span class="badge">{{ $mantenimiento->estado }}</span>
    </div>

    <div class="item"><strong>Fecha realizada:</strong> {{ $mantenimiento->fecha_realizada ?? 'Pendiente' }}</div>
    <div class="item"><strong>Observaciones:</strong> {{ $mantenimiento->descripcion ?? 'Sin observaciones' }}</div>

    <div class="acciones">
        <button class="btn-editar"
            onclick="window.location.href='/mantenimientos/{{ $mantenimiento->id }}/edit'">
           Cerrar ticket
        </button>

        <button class="btn-volver"
            onclick="window.location.href='/mantenimientos'">
            Volver
        </button>
    </div>

</div>

@endsection